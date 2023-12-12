<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});



Route::get('home',[AuthController::class,'home'])->name('user.home');
Route::get('adminhome',[AuthController::class,'adminhome'])->name('admin.home');



Route::post('registration',[AuthController::class,'registration'])->name('registration');
Route::get('login',[AuthController::class,'login'])->name('login');
Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('loginpost',[AuthController::class,'loginpost'])->name('loginpost');
// Route::get('home',[AuthController::class,'home'])->name('home');
Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

Route::get('logout',[AuthController::class,'logout'])->name('logout');
