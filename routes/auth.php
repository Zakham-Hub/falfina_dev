<?php

use App\Http\Controllers\Auth\Admin;
use App\Http\Controllers\Auth\Manager;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('login', [Admin\AdminAuthenticatedSessionController::class, 'create'])->name('admin.login');
        Route::post('login', [Admin\AdminAuthenticatedSessionController::class, 'store'])->name('admin.post.login');
        Route::get('forgot/password', [Admin\AdminAuthenticatedSessionController::class, 'forgot_password'])->name('admin.forgot.password');
        Route::post('forgot/password', [Admin\AdminAuthenticatedSessionController::class, 'forgot_password_post'])->name('admin.post.forgot.password');
        Route::get('reset/password/{token}', [Admin\AdminAuthenticatedSessionController::class, 'reset_password'])->name('admin.reset.password');
        Route::post('reset/password/{token}', [Admin\AdminAuthenticatedSessionController::class, 'do_reset_password'])->name('admin.do.reset.password');
    });
    
    Route::prefix('manager')->group(function () {
        Route::get('login', [Manager\ManagerAuthenticatedSessionController::class, 'create'])->name('manager.login');
        Route::post('login', [Manager\ManagerAuthenticatedSessionController::class, 'store'])->name('manager.post.login');
        Route::get('forgot/password', [Manager\ManagerAuthenticatedSessionController::class, 'forgot_password'])->name('manager.forgot.password');
        Route::post('forgot/password', [Manager\ManagerAuthenticatedSessionController::class, 'forgot_password_post'])->name('manager.post.forgot.password');
        Route::get('reset/password/{token}', [Manager\ManagerAuthenticatedSessionController::class, 'reset_password'])->name('manager.reset.password');
        Route::post('reset/password/{token}', [Manager\ManagerAuthenticatedSessionController::class, 'do_reset_password'])->name('manager.do.reset.password');
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('logout', [Admin\AdminAuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    });
});

Route::middleware('auth:manager')->group(function () {
    Route::prefix('manager')->group(function () {
        Route::post('logout', [Manager\ManagerAuthenticatedSessionController::class, 'destroy'])->name('manager.logout');
    });
});
