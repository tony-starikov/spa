<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
   Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function () {

    Route::group(['middleware' => 'scope:user'], function () {

        Route::get('user-page', function () {
            return response()->json([
                'message' => 'User access',
                'status_code' => 200
            ], 200);
        });

    });

    Route::group(['middleware' => 'scope:admin'], function () {

        Route::get('admin-page', function () {
            return response()->json([
                'message' => 'Admin access',
                'status_code' => 200
            ], 200);
        });

    });

});

Route::resource('/apartments', ApartmentController::class);
