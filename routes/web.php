<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\checkLogin;
use App\Models\login;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LastActivity;



/**
 * tên domain default website
 */
Route::get('/food_ds.com', [LoginController::class, 'showIndex'])->name('website-main');



/** 
 * đường đi cua các form login
 */
Route::get('/role/{page}', [LoginController::class, 'index'])
    ->where('page', 'login|register|forgot|')
    ->name('wayLogin');

/**
 * check login
 */
Route::prefix('/login')->group(function () {
    Route::post('/check', [LoginController::class, 'login'])->name('check');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot');
    Route::get('/forgot_form', [LoginController::class, 'forgot_form'])->name('forgot_form');
    Route::post('/update_pw', [LoginController::class, 'update_pw'])->name('update_pw');
});

/**
 * show data role access form admin and employees and client 
 */
Route::prefix('/role/admin')->group(function () {
    Route::get('/client', [AdminController::class, 'listClient'])->name('manager');
    Route::get('/search_client', [AdminController::class, 'search_client'])->name('search_client');
    Route::get('/employees', [AdminController::class, 'showEmployees'])->name('employees');
});



/**email form register */
Route::get('/form-otp', [LoginController::class, 'showOtpForm'])->name('otp.form');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');


/** forgot-email-otp*/
Route::get('otpForgot', [LoginController::class, 'formOtpForgot'])->name('form.otp');
// form confirm otp email
Route::post('/verify-otp-forgot', [LoginController::class, 'verifyOtpForgot'])->name('verifyOTP.otpForgot');


/**
 * kiểm tra đang ở form để mà gửi lại mã otp
 * cái index 0 là form forgot 1 là register => chưa sử dụng
 */
Route::get('{page}', [LoginController::class, 'wayOTP'])
    ->where('page', 'form.otp|otp.form')
    ->name('wayOTP');