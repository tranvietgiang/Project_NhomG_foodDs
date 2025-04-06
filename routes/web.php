<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\checkLogin;
use App\Models\login;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LastActivity;
use App\Models\district;
use App\Models\ward;
use Illuminate\Http\Request;

/**
 * tên domain default website
 */
Route::get('/food_ds.com', [LoginController::class, 'showIndex'])->middleware(checkLogin::class)->name('website-main');




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





/** checkout toán vnpay */
Route::post('/vnpay_payment', [AdminController::class, 'vnpay_payment'])->name('vnpay.payment');

/** show form */
Route::get('/showVnPay', [AdminController::class, 'showVnPayCheckout'])->name('showVnPayCheckout');

/* result success or failed */
Route::get('/vnpay_return', [AdminController::class, 'vnpay_return'])->name('vnpay.return');

/** show form information client */
Route::get('/information-client', [LoginController::class, 'show_information'])->middleware(checkLogin::class);

/** show ra địa chỉ vn */
Route::post('/get-districts', [LoginController::class, 'getDistricts']);
Route::post('/get-wards', [LoginController::class, 'getWards']);

Route::post('/update-client', [AdminController::class, 'update_client'])->name('update_client');



/** login vs google */
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
