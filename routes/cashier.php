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
      });
      Route::middleware(['cashier_auth'])->group(function () {
        Route::prefix('products')->group(function () {
            Route::post('/', [Api\ProductController::class, 'index']);
        });
        Route::prefix('orders')->controller(OrderController::class)->group(function () {
            // Route::post('/', [OrderController::class, 'index']);
            Route::post('/', 'index');
            Route::get('/{order}/pdf', 'downloadInvoice');
            Route::delete('/{order}', 'destroy');
            Route::get('status','getOrderStatus');
            Route::put('{id}','update');
            Route::get('{id}','show');
            Route::post('summary','getSummary');
        });
      });
});
