<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', fn() => redirect()->route('products.index'));

Route::resource('products', ProductController::class);
Route::post('/products/{product}/toggle', [ProductController::class, 'toggleStatus'])->name('products.toggle');
Route::post('/products/toggle-status/{id}', [ProductController::class, 'toggleStatus']);
