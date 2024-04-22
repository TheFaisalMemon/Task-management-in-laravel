<?php
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'],function (){
    Route::get('/', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'Authenticate'])->name('authenticate');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::post('/registerProcess',[AuthController::class,'registerProcess'])->name('registerProcess');
});

Route::group(['middleware' => 'auth'],function (){
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('pages.dashboard');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});
