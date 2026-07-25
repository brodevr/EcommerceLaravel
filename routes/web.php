<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categorias/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
Route::get('/cuenta', [PageController::class, 'cuenta'])->name('cuenta');
Route::get('/contacto', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

// Carrito (sesión — funciona sin login)
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

/*
|--------------------------------------------------------------------------
| Rutas de cliente autenticado
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (Breeze)
    Route::get('/dashboard', fn () => redirect()->route('home'))
        ->name('dashboard');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Pedidos
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Reseñas
    Route::post('/productos/{product}/resenas', [ReviewController::class, 'store'])->name('reviews.store');

    // Direcciones
    Route::resource('direcciones', AddressController::class)->except(['show'])->parameters(['direcciones' => 'address']);
});

/*
|--------------------------------------------------------------------------
| Rutas de administración
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('productos', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categorias', \App\Http\Controllers\Admin\CategoryController::class);
    Route::get('/pedidos', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{order}/estado', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('pedidos.updateStatus');
});

require __DIR__.'/auth.php';
