<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\LoginController;

// =================== RUTAS PÚBLICAS (Accesibles para todos) ===================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tienda', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');

// =================== RUTAS DE AUTENTICACIÓN (Accesibles para todos) ===================
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =================== RUTAS DE USUARIO LOGUEADO (auth) ===================
Route::middleware(['auth'])->group(function () {
    // Carrito de Compras
    Route::get('/carrito', [CartController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('carrito.add');
    Route::delete('/carrito/remover/{product}', [CartController::class, 'remove'])->name('carrito.remove');

    // Proceso de Compra (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pedido-confirmado/{transaccion}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Perfil del Usuario
    Route::get('/mi-cuenta', [PerfilController::class, 'index'])->name('perfil.index');
    Route::get('/mi-cuenta/pedidos', [PerfilController::class, 'pedidos'])->name('perfil.pedidos');
});

// =================== RUTAS DE ADMINISTRADOR (auth + rol admin) ===================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('productos', AdminProductController::class);
    Route::resource('categorias', CategoriaController::class);
});
