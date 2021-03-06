<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ForgotResetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HistoryController;

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
Route::post('login-gmail', [UserController::class, 'loginGmail']);

//api need logged in
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [LoginController::class, 'logoutApi']);
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class,'index']);
            Route::put('/change_password/{user}', [UserController::class, 'changePassword']);
            Route::group(['middleware' => 'role:admin'], function () {
                Route::post('/store', [UserController::class,'store']);
                Route::put('/update/{user}', [UserController::class,'update']);
                Route::post('/deactive/{user}', [UserController::class,'destroy']);
            });
        });
        Route::group(['prefix' => 'departments'], function () {
            Route::get('/', [DepartmentController::class,'index']);
            Route::group(['middleware' => 'role:admin'], function () {
                Route::post('/store', [DepartmentController::class,'store']);
                Route::put('/update/{department}', [DepartmentController::class,'update']);
            });
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index']);
        });
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/get-list-pic/{category}',[CategoryController::class,'getListPersonInCharge']);
            Route::get('/',[CategoryController::class,'index']);
            Route::group(['middleware' => 'role:admin'], function () {
                Route::post('/store',[CategoryController::class,'store']);
                Route::put('/update/{category}',[CategoryController::class,'update']);
            });
        });
        Route::group(['prefix' => 'requests'], function () {
            Route::get('/', [RequestController::class,'index']);
            Route::post('/store', [RequestController::class,'store']);
            Route::put('/update/{request}', [RequestController::class,'update']);
            Route::get('/detail/{request}', [RequestController::class, 'detail']);
            Route::group(['middleware' => 'role:manager'], function () {
                Route::post('/action/{id}', [RequestController::class,'action']);
            });
            Route::delete('/delete/{request}', [RequestController::class, 'destroy']);
        });
        Route::group(['prefix' => 'histories'], function () {
            Route::get('/{id}',[HistoryController::class,'index']);
            Route::get('/', [HistoryController::class, 'getList']);
            Route::post('/post-comment', [HistoryController::class, 'addComment']);
        });
});
