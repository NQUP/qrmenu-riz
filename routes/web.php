<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckSiteMaintenance;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckSiteMaintenance::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('front.home');
    Route::get('/pesan', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/pesan', [OrderController::class, 'store'])->name('orders.store');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::post('products/bulk', [ProductController::class, 'bulk'])->name('products.bulk');

    Route::resource('categories', ProductCategoryController::class);

    Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::patch('orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('orders/{order}/complete', [AdminOrderController::class, 'complete'])->name('orders.complete');
});
