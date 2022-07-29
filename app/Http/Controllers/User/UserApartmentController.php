<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = $user->apartments()->orderBy('created_at', 'desc')->paginate(2);
        return response()->json($apartments, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $apartment = new Apartment();
        $apartment->name = $request->name;

        $path = $request->file('image')->store('apartments_images');
        $apartment->image = $path;

        $user = Auth::user();
        $apartment->user_id = $user->id;

        if ($apartment->save()) {
            return response()->json($apartment, 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try again!',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return JsonResponse
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $apartment->name = $request->name;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png',
            ]);

            Storage::delete($apartment->image);

            $path = $request->file('image')->store('apartments_images');
            $apartment->image = $path;
        }

        if ($apartment->save()) {
            return response()->json($apartment, 200);
        } else {
            Storage::delete($path);
            return response()->json([
                'message' => 'Some error occurred on update, please try again!',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return JsonResponse
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->delete()) {
            Storage::delete($apartment->image);

            return response()->json([
                'message' => 'Apartment deleted successfully!',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try again!',
                'status_code' => 500
            ], 500);
        }
    }
}
