<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ForgotResetPasswordController;



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
Route::post('login', [LoginController::class, 'login']);

//api need logged in
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/show/{id}', 'UserController@show');
        Route::post('/store', 'UserController@store');
        Route::put('/update/{user}', 'UserController@update');
        Route::delete('/delete/{user}', 'UserController@destroy');
    });
});
