<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\AdminProductController;

// Auth
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home
Route::get('/', DashboardController::class)->middleware('auth')->name('home');

// Vendor product management
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductWebController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductWebController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductWebController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductWebController::class, 'destroy'])->name('products.destroy');
});

// Admin product approval
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products/{product}/approve', [AdminProductController::class, 'approve'])->name('admin.products.approve');
    Route::post('/products/{product}/reject', [AdminProductController::class, 'reject'])->name('admin.products.reject');
});
