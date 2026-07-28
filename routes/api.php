<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Estos endpoints devuelven JSON. La autenticación reutiliza la sesión web
| (no se usa Sanctum ni tokens). Los endpoints públicos funcionan sin login.
*/

// Catálogo — público
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Pedidos — requiere sesión iniciada
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
});
