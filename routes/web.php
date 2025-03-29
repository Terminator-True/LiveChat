<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConfigController;
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


Route::get('/register_form',[AuthController::class, 'register_form'])->name('web.register');
Route::get('/login_form',[AuthController::class, 'login_form'])->name('web.login');

Route::post('/register',[AuthController::class, 'register'])->name('user.register');
Route::post('/login',[AuthController::class, 'login'])->name('user.login');
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function (){

    //User Routes
    Route::post('/logout',[AuthController::class, 'logout'])->name('user.logout');
    Route::get('/home',[HomeController::class, 'index'])->name('web.home');
    Route::get('/config',[ConfigController::class, 'index'])->name('user.config');
    Route::post('/update',[ConfigController::class, 'update'])->name('user.update');
    Route::post('/updatePassword',[ConfigController::class, 'update_password'])->name('user.password.update');

    //Char Routes
    Route::get('/chat/{chat_id}',[ChatController::class,'index'])->name('web.chat');
    Route::post('/enviar',[ChatController::class,'enviar'])->name('chat.enviar');
    Route::post('/recibir',[ChatController::class,'recibir'])->name('user.recibir');
    // Route::post('/add_image',[ChatController::class,'add_image'])->name('message.image');
    Route::get('/get_image/{message_id}',[ChatController::class,'get_image'])->name('message.get_image');

    //Admin Routes
    Route::post('/eliminarChat',[AdminController::class,'eliminar_chat'])->name('admin.eliminar.chat');
    Route::post('/CrearChat',[AdminController::class,'crear_chat'])->name('admin.crear.chat');

});
