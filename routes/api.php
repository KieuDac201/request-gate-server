<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ForgotResetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;

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

//api not need logged in
Route::post('forgot-password', [ForgotResetPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [ForgotResetPasswordController::class, 'resetPassword']);
Route::post('login', [LoginController::class, 'loginApi']);

//api need logged in
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [LoginController::class, 'logoutApi']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class,'index']);
        Route::get('/show/{id}', [UserController::class,'show']);
        Route::post('/store', [UserController::class,'store']);
        Route::put('/update/{user}', [UserController::class,'update']);
        Route::delete('/delete/{user}', [UserController::class,'destroy']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index']);
    });
});
