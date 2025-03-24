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
    // Route::post('/register', [LoginController::class, 'register'])->name('register');
    // Route::post('/delete/{id}', [LoginController::class, 'destroy'])->name('destroy');
    // Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot');
    // Route::get('/forgot_form', [LoginController::class, 'forgot_form'])->name('forgot_form');
    // Route::post('/update_pw', [LoginController::class, 'update_pw'])->name('update_pw');
});

/**
 * role access form admin and employees  
 */

Route::prefix('/role/access')->group(function () {
    Route::get('/admin', [LoginController::class, 'showAdmin'])->name('manager');
    Route::get('/employees', [LoginController::class, 'showEmployees'])->name('employees');
    /** show list employees */
    Route::get('/list_employees', [AdminController::class, 'index'])->name('list_employees');
});


// /** đăng nhập trc khi */
Route::middleware([checkLogin::class])->group(function () {});
