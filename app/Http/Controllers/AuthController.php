<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|unique:users', add after testing
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $random = rand(11111, 99999);
        $user->email_verification_code = $random;

        if ($user->save()) {
            $userData = [
                'email' => $user->email,
                'name' => $user->name,
                'random' => $random,
            ];

            Mail::send('emails.confirm_email', $userData, function($message) use ($userData) {
                $message->from('no-reply@test-project', 'Tony');
                $message->to($userData['email'], $userData['name']);
                $message->subject('Confirm Mail Request');
            });

            if (Mail::failures()) {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!',
                    'status_code' => 500
                ], 500);
            } else {
                return response()->json([
                    'message' => 'User created successfully! Please confirm your email address.',
                    'status_code' => 201
                ], 201);
            }
        } else {
            return response()->json([
                'message' => 'Some error occurred, Please try again!',
                'status_code' => 500
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid email/password',
                'status_code' => 401
            ], 401);
        }

        $user = $request->user();

        if ($user->role == 'admin') {
            $tokenData = $user->createToken('Admin Token', ['admin']);
        } else {
            $tokenData = $user->createToken('User Token', ['user']);
        }

        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        if ($token->save()) {
            return response()->json([
               'user' => $user,
               'access_token' => $tokenData->accessToken,
               'token_type' => 'Bearer',
               'token_scope' => $tokenData->token->scopes[0],
               'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateString(),
               'message' => 'Authorized!',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, Please try again!',
                'status_code' => 500
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout successfully!',
            'status_code' => 200
        ], 200);
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json($request->user(), 200);
        }

        return response()->json([
            'message' => 'Not logged in',
            'status_code' => 500
        ], 500);
    }

    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'We have sent a verification code to your email address.',
                'status_code' => 200
            ], 200);
        } else {
            $random = rand(11111, 99999);
            $user->verification_code = $random;

            if ($user->save()) {
                $userData = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'random' => $random,
                ];

                Mail::send('emails.reset_password', $userData, function($message) use ($userData) {
                    $message->from('no-reply@test-project', 'Tony');
                    $message->to($userData['email'], $userData['name']);
                    $message->subject('Reset Password Request');
                });

                if (Mail::failures()) {
                    return response()->json([
                        'message' => 'Some error occurred, Please try again!',
                        'status_code' => 500
                    ], 500);
                } else {
                    return response()->json([
                        'message' => 'We have sent a verification code to your email address.',
                        'status_code' => 200
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!',
                    'status_code' => 500
                ], 500);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|integer',
            'password' => 'required|confirmed|min:4',
        ]);

        $user = User::where('email', $request->email)->where('verification_code', $request->verification_code)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found/Invalid code',
                'status_code' => 401
            ], 401);
        } else {
            $user->password = bcrypt(trim($request->password));

            $user->verification_code = null;

            if ($user->save()) {
                return response()->json([
                    'message' => 'Password updated successfully.',
                    'status_code' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!',
                    'status_code' => 500
                ], 500);
            }
        }
    }

    public function emailConfirm(Request $request)
    {
        $request->validate([
            'email_verification_code' => 'required|integer',
        ]);

        $user = Auth::user();

        if ($user->email_verification_code == $request->email_verification_code) {

            $user->email_verified = 1;
            if ($user->save()) {
                return response()->json([
                    'message' => 'Email confirmed successfully.',
                    'status_code' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!',
                    'status_code' => 500
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Invalid code',
                'status_code' => 401
            ], 401);
        }
    }

    public function resendEmailConfirm()
    {
        $user = Auth::user();

        $random = rand(11111, 99999);
        $user->email_verification_code = $random;

        if ($user->save()) {
            $userData = [
                'email' => $user->email,
                'name' => $user->name,
                'random' => $random,
            ];

            Mail::send('emails.confirm_email', $userData, function($message) use ($userData) {
                $message->from('no-reply@test-project', 'Tony');
                $message->to($userData['email'], $userData['name']);
                $message->subject('Confirm Mail Request');
            });

            if (Mail::failures()) {
                return response()->json([
                    'message' => 'Some error occurred, Please try again!',
                    'status_code' => 500
                ], 500);
            } else {
                return response()->json([
                    'message' => 'Email resend successfully.',
                    'status_code' => 200
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Some error occurred, Please try again!',
                'status_code' => 500
            ], 500);
        }
    }
}
