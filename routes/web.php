<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// == RUTAS PÚBLICAS (Cualquier visitante puede verlas) ==
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tienda', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');

// == RUTAS DE AUTENTICACIÓN (Login, Registro, etc.) ==
// require __DIR__.'/auth.php'; // Descomenta si usas Breeze o Jetstream

// == RUTAS PRIVADAS (Solo para usuarios que han iniciado sesión) ==
Route::middleware(['auth'])->group(function () {
    // Carrito de Compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'add'])->name('carrito.add');
    Route::delete('/carrito/remover/{producto}', [CarritoController::class, 'remove'])->name('carrito.remove');

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

// == RUTAS DE ADMINISTRADOR (Protegidas) ==
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('productos', AdminProductController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');
});