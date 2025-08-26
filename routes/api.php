<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::middleware(['auth:sanctum', 'role:vendor'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'adminIndex']);
    Route::post('/products/{product}/approve', [ProductController::class, 'approve']);
    Route::post('/products/{product}/reject', [ProductController::class, 'reject']);
});
