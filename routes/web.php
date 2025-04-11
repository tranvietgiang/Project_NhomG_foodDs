<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PTTTController;
use App\Http\Controllers\ViewController;
use App\Http\Middleware\checkLogin;
use App\Models\login;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LastActivity;
use App\Models\district;
use App\Models\ward;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

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
Route::get('/form-otp', [LoginController::class, 'showOtpForm'])->name('otp.form') /*->middleware(checkLogin::class)*/;
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp')/*->middleware(checkLogin::class)*/;
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp')/*->middleware(checkLogin::class)*/;


/** forgot-email-otp*/
Route::get('otpForgot', [LoginController::class, 'formOtpForgot'])->name('form.otp');
// form confirm otp email
Route::post('/verify-otp-forgot', [LoginController::class, 'verifyOtpForgot'])->name('verifyOTP.otpForgot')/*->middleware(checkLogin::class)*/;






/** show form */
Route::get('/showVnPay', [AdminController::class, 'showVnPayCheckout'])->name('showVnPayCheckout') /*->middleware(checkLogin::class)*/;

/** checkout toán vnpay */
Route::post('/vnpay_payment', [PTTTController::class, 'vnpay_payment'])->name('vnpay.payment')/*->middleware(checkLogin::class)*/;

/* result success or failed */
Route::get('/vnpay_return', [PTTTController::class, 'vnpay_return'])->name('vnpay.return')/*->middleware(checkLogin::class)*/;


/** show ra địa chỉ vn */
Route::post('/get-districts', [LoginController::class, 'getDistricts']);
Route::post('/get-wards', [LoginController::class, 'getWards']);


/** show form information client */
Route::get('/information-client', [LoginController::class, 'show_information'])->middleware(checkLogin::class);
Route::post('/update-client', [AdminController::class, 'update_client'])->middleware(checkLogin::class)->name('update_client');
Route::post('/client-avatar-image-update', [AdminController::class, 'client_avatar_update'])->middleware(checkLogin::class);

/** login vs google */
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);


/** cart and review */
Route::get('/cart/{product_id}', [ViewController::class, 'show_cart'])->name('show_cart');
Route::get('/review/cart', [ProductController::class, 'review'])->name('review');
Route::get('/delete/client_comment/{review_id}', [ProductController::class, 'delete_review'])->name('client.comment.delete');
