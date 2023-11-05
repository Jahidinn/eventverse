<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/get-cities/{code}', [EventController::class, 'getCities']);
Route::resource('/event', EventController::class)->middleware('auth');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'autenticate']);

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeRegister']);

Route::post('/logout', [AuthController::class, 'logout']);

//email verification handle
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->middleware(['auth', 'signed'])->name('verification.verify');


//Resend email
Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//forgot password 
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordView'])->middleware('guest')->name('password.request');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->middleware('guest')->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
