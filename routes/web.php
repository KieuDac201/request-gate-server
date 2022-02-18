<?php
use App\Http\Controllers\auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', [LoginController::class, 'checkLogin'])->name('login');
// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/home', function () {
//     return view('home');
// })->name('home');
