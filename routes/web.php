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
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LoginController;

// RUTAS PÚBLICAS
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tienda', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// RUTAS PRIVADAS (Solo para usuarios que han iniciado sesión) 
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

    // Cerrar sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// RUTAS DE ADMINISTRADOR (Protegidas)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('productos', AdminProductController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');