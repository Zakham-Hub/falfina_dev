<?php

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Cashier\AuthController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Cashier\NotificationController;
/*
|--------------------------------------------------------------------------
| Cashier Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Cashier routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "Cashier" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('admin/login', 'adminLogin');
        Route::post('manager/login' ,'managerLogin');
        Route::post('logout' ,'logout')->middleware(['cashier_auth']);

        // FCM Token management
        Route::post('admin/fcm-token', 'updateAdminFcmToken')->middleware(['cashier_auth', 'auth:admin-api']);
        Route::post('manager/fcm-token', 'updateManagerFcmToken')->middleware(['cashier_auth', 'auth:manager-api']);
    });
    Route::middleware(['cashier_auth'])->group(function () {
        Route::prefix('products')->group(function () {
            Route::post('/', [Api\ProductController::class, 'index']);
        });
        Route::prefix('orders')->controller(\App\Http\Controllers\Cashier\OrderController::class)->group(function () {
            Route::get('status','getOrderStatus');
            Route::post('summary','getSummary');
            Route::get('/',  'index');
            // Route::get('/{id}/invoice',  'downloadInvoice');
            Route::get('/{order}/pdf', 'downloadInvoice');
            Route::get('/{id}',  'show');
            Route::put('/{id}',  'update');
            Route::delete('/{id}',  'destroy');
            Route::delete('/{order}', 'destroy');
        });
      });

    // Notification routes
    Route::prefix('notifications')->middleware(['cashier_auth'])->group(function () {
        Route::get('admin', [\App\Http\Controllers\Cashier\NotificationController::class, 'getAdminNotifications'])->middleware('auth:admin-api');
        Route::get('manager', [\App\Http\Controllers\Cashier\NotificationController::class, 'getManagerNotifications'])->middleware('auth:manager-api');
        Route::post('mark-read/{id}', [\App\Http\Controllers\Cashier\NotificationController::class, 'markAsRead']);
    });
});
