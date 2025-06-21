<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth:sanctum')->group(function () {
    // Export route
    Route::get('/products/export', [ProductExportController::class, 'export'])->name('products.export');
    // Product management routes
    Route::resource('products', ProductController::class);
});
