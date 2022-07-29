<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserApartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminApartmentController;
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

Route::resource('/apartments', ApartmentController::class)->only([
    'index', 'show'
]);

Route::group(['prefix' => 'auth'], function () {
   Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

   Route::post('reset-password-request', [AuthController::class, 'resetPasswordRequest']);
   Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function () {

    Route::group(['middleware' => 'scope:user'], function () {

        Route::resource('/apartments', UserApartmentController::class);

    });

});

Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {

    Route::group(['middleware' => 'scope:admin'], function () {

        Route::resource('/apartments', AdminApartmentController::class);

    });

});
