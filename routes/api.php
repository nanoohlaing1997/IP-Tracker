<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::controller(AuthController::class)->group(function () {
//     Route::post('register', 'register');
//     Route::put('password/reset', 'resetPassword');
//     Route::get('check/otp', 'checkOTP');
// });

// Route::middleware(JWTAuth::class)->group(function () {
//     Route::controller(AuthController::class)->group(function () {
//         Route::post('login', 'login');
//         Route::get('user', 'getUserDetail');
//         Route::get('logout', 'logout');
//     });
// });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/user', [AuthController::class, 'getUserDetail']);
    Route::put('password/reset', [AuthController::class, 'resetPassword']);
});
