<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AuthController;

// 🔓 Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔐 Users
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 🛒 Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // ❤️ Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    // 🧾 Orders
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});

// 👑 Admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::apiResource('categories', CategoryController::class);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
});