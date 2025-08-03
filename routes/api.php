<?php

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/reset-password', [Auth\PasswordResetController::class, 'resetPassword']);
        Route::post('/forgot-password', [Auth\PasswordResetController::class, 'forgotPassword']);
        Route::post('login', [Auth\AuthController::class, 'login']);
        Route::post('register', [Auth\AuthController::class, 'register']);
        Route::post('register-verify-otp', [Auth\OtpController::class, 'registerVerifyOtp']);
        // Route::post('send-otp', [Auth\OtpController::class, 'sendOtp']);
        // Route::post('verify-otp', [Auth\OtpController::class, 'verifyOtp']);
        // Route::post('resend-otp', [Auth\OtpController::class, 'resendOtp']);
        Route::middleware(['auth:user-api'])->group(function () {
            Route::post('logout', [Auth\AuthController::class, 'logout']);
            Route::post('me', [Auth\AuthController::class, 'me']);
            Route::put('profile/update', [Auth\AuthController::class, 'updateProfile']);
        });

    });
    Route::middleware(['auth:user-api'])->prefix('orders')->group(function () {
        Route::post('create', [Api\OrderController::class, 'store']);
        Route::post('show', [Api\OrderController::class, 'show']);
        Route::get('user/{id}', [Api\OrderController::class, 'getUserOrders']);
    });
    Route::delete('user/delete/{id}', [Api\UserController::class, 'destroy'])->middleware('auth:user-api');
    Route::get('user/{id}', [Api\OrderController::class, 'getUserOrders']);

    Route::prefix('settings')->group(function () {
        Route::post('/', [Api\MainSettingController::class, 'index']);
    });
    Route::prefix('sliders')->group(function () {
        Route::post('/', [Api\SliderController::class, 'index']);
    });
    Route::prefix('extras')->group(function () {
        Route::post('/', [Api\ExtraController::class, 'index']);
    });
    Route::prefix('categories')->group(function () {
        Route::post('/', [Api\CategoryController::class, 'index']);
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [Api\ProductController::class, 'index']);
    });

    Route::prefix('sizes')->group(function () {
        Route::post('/', [Api\SizeController::class, 'index']);
    });

    Route::prefix('branches')->group(function () {
        Route::post('/', [Api\BranchController::class, 'index']);
    });

    Route::prefix('types')->group(function () {
        Route::post('/', [Api\TypeController::class, 'index']);
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/{id}', [Api\CouponController::class, 'index']);
        Route::post('/', [Api\CouponController::class, 'getAll']);
    });

    Route::prefix('auth')->group(function () {
        // Password reset routes
        Route::post('password/forgot', [Api\Auth\PasswordResetController::class, 'forgotPassword']);
        Route::post('password/reset', [Api\Auth\PasswordResetController::class, 'resetPassword']);
    });
});