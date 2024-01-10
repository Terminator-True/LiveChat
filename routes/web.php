<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/form',[AuthController::class, 'show_form'])->name('web.form');

Route::post('/register',[AuthController::class, 'register'])->name('user.register');
Route::post('/login',[AuthController::class, 'login'])->name('user.login');

Route::middleware(['auth'])->group(function (){

    //User Routes
    Route::post('/logout',[AuthController::class, 'logout'])->name('user.logout');
    Route::get('/home',[HomeController::class, 'index'])->name('web.home');

    //Admin Routes
});

Route::get('/', function () {
    return view('welcome');
});
