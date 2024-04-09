<?php

use App\Http\Api\Modules\Users\Controllers\AdminController;
use App\Http\Api\Modules\Users\Controllers\AdminLoginController;
use App\Http\Api\Modules\Users\Controllers\AdminRegisterController;
use App\Http\Api\Modules\Users\Controllers\UserRegisterController;
use App\Http\Api\Modules\Users\Controllers\UserLoginController;
use App\Http\Api\Modules\Users\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::name('user.')->prefix('v1/user')->group(function () {

    /********************* Authentication Routes *********************/
    Route::post('/register', [UserRegisterController::class, 'register']);
    Route::middleware('throttle:10,60')->group(function () {
        Route::post('/login', [UserLoginController::class, 'login'])->name('login');
    });

    /********************* User  Routes *********************/
    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', [UserLoginController::class, 'logout']);
        Route::get('/{model}', [UserController::class, 'getById']);
        Route::delete('/{model}', [UserController::class, 'delete']);

    });
});

Route::name('admin.')->prefix('v1/admin')->group(function () {

    /********************* Authentication Routes *********************/
    Route::post('/register', [AdminRegisterController::class, 'register']);
    Route::middleware('throttle:10,60')->group(function () {
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
    });

    /********************* User  Routes *********************/
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout', [AdminLoginController::class, 'logout']);

    });
});
