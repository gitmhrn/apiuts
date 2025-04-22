<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ProductController;

// Route untuk registrasi API Key
Route::post('/register', [ApiKeyController::class, 'register']);

// Route untuk login API Key
Route::post('/login', [ApiKeyController::class, 'login']);

// Route untuk mendapatkan rekomendasi skincare
Route::get('/skincare-recommendations', [RecommendationController::class, 'get']);

// Route untuk mendapatkan daftar produk
Route::get('/products', [ProductController::class, 'index']);

// Membutuhkan autentikasi API key
Route::middleware('auth:api')->group(function () {
    Route::get('/products/{id}', [ProductController::class, 'show']);
});
