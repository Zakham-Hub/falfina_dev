<?php

use App\Http\Controllers\Dashboard\General;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| General Orders Routes can admin and manager access
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'multi_auth']], function () {
    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
        //Route::get('view-order/{id}', [General\OrderController::class, 'viewPdf'])->name('orders.viewPdf');
        Route::get('view-order/{order}/pdf', [General\OrderController::class, 'downloadInvoice'])->name('orders.viewPdf');
        Route::resource('orders', General\OrderController::class);
        Route::post('orders/{order}/update-status', [General\OrderController::class, 'updateStatus'])->name('orders.updateStatus');;
    });
});
