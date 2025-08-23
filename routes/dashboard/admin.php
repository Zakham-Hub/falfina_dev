<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\MediaController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/admin/reset/password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/admin/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/media/{folder}/{filename}', [MediaController::class, 'showMedia'])->where('file_name', '.*');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('admins', Dashboard\AdminController::class);
        Route::get('/link-password', [Dashboard\AdminController::class, 'showForm'])->name('link_password.form');
        Route::post('/link-password', [Dashboard\AdminController::class, 'verify'])->name('link_password.verify');
        Route::middleware(['linkPasswordProtected'])->controller(Dashboard\MainSettingsController::class)->prefix('mainSettings')->as('mainSettings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('histories', 'history')->name('histories');
        });
        Route::resource('categories', Dashboard\CategoryController::class);
        Route::resource('sizes', Dashboard\SizeController::class);
        Route::resource('products', Dashboard\ProductController::class);
        Route::resource('branches', Dashboard\BranchController::class);
        Route::resource('extras', Dashboard\ExtraController::class);
        Route::resource('managers', Dashboard\ManagerController::class);
        Route::resource('sliders', Dashboard\SliderController::class);
        Route::resource('types', Dashboard\TypeController::class);
        Route::resource('coupons', Dashboard\CouponController::class);
        Route::resource('users', Dashboard\UserController::class)->names('user');
        Route::resource('packages', Dashboard\PackageController::class)->names('packages');
        Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
            Route::resource('orders', Dashboard\General\OrderController::class);
        });
        Route::get('dashboard', Dashboard\DashboardController::class)->name('dashboard');

        Route::get('/deploy', function () {
            $output = [];
            $resultCode = null;

            // Define the path to your script
            $scriptPath = '/home/u466710613/domains/falafina-test.shop/public_html/production.sh';

            // Run the script
            exec("bash $scriptPath 2>&1", $output, $resultCode);

            if ($resultCode === 0) {
                return response()->json(['message' => 'Deployment successful', 'output' => implode("\n", $output)]);
            } else {
                return response()->json(['message' => 'Deployment failed', 'output' => implode("\n", $output), 'error_code' => $resultCode], 500);
            }
        });

        /*Route::get('test-pdf', function(){
            $data = [
                'invoice' => '1234'
            ];
            $pdf = PDF::loadView('dashboard.layouts.invoice', $data);
            return $pdf->stream('document.pdf');
        });*/
    });
});
