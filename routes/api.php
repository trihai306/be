<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', \App\Http\Controllers\Restify\Auth\RegisterController::class)
    ->name('restify.register');

Route::post('login', \App\Http\Controllers\Restify\Auth\LoginController::class)
    ->middleware('throttle:6,1')
    ->name('restify.login');

Route::post('verify/{id}/{hash}', \App\Http\Controllers\Restify\Auth\VerifyController::class)
    ->middleware('throttle:6,1')
    ->name('restify.verify');

Route::post('forgotPassword', \App\Http\Controllers\Restify\Auth\ForgotPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.forgotPassword');

Route::post('resetPassword', \App\Http\Controllers\Restify\Auth\ResetPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.resetPassword');

Route::get('user', \App\Http\Controllers\Restify\Auth\UserController::class)
    ->middleware('auth:sanctum')
    ->name('restify.user');
