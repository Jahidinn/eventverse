<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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


Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'autenticate']);

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeRegister']);

Route::post('/logout', [AuthController::class, 'logout']);

//email verification handle
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'searchEvent']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/myevent', [DashboardController::class, 'myEvent'])->middleware('auth');
Route::get('/dashboard/manajemen-event', [DashboardController::class, 'manajemenEvent'])->middleware('auth');

Route::get('/get-cities/{code}', [EventController::class, 'getCities']);
Route::get('/check-url', [EventController::class, 'cekUrl']);

Route::get('/get-ticket', [EventController::class, 'getTicket']);
Route::get('/get-formulir', [EventController::class, 'getFormulir']);

Route::post('/add-ticket', [EventController::class, 'addTicket']);
Route::post('/add-formulir', [EventController::class, 'addFormulir']);

Route::post('/edit-ticket', [EventController::class, 'editTicket']);
Route::post('/edit-formulir', [EventController::class, 'editFormulir']);

Route::post('/delete-ticket', [EventController::class, 'deleteTicket']);
Route::post('/delete-formulir', [EventController::class, 'deleteFormulir']);

Route::post('/event-edit-image', [EventController::class, 'editImage']);

//detail event
Route::resource('/event', EventController::class, ['except' => ['show']])->middleware('auth');

//Checkout
Route::get('/event/checkout', [TransactionController::class, 'checkoutPreview']);
Route::get('/event/invoice/{id}', [TransactionController::class, 'invoice']);
Route::post('/event/checkout-proccess', [TransactionController::class, 'transaction']);
Route::post('/event/transaction-delete', [TransactionController::class, 'deleteTransaction']);

Route::get('/{event}', [EventController::class, 'show']);
Route::get('/event/{event}', [EventController::class, 'show']);



//Resend email
Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//forgot password
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordView'])->middleware('guest')->name('password.request');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->middleware('guest')->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
