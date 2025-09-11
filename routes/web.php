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
Route::get('/tienda', [ProductoController::class, 'index'])->name('tienda.index');
Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('tienda.show');

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
    // Dashboard principal del admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para gestionar Productos (Crear, Leer, Actualizar, Borrar)
    Route::resource('productos', AdminProductoController::class);
    
    // Rutas para gestionar Categorías
    Route::resource('categorias', CategoriaController::class);

    // Ruta para la página de inicio que muestra los productos
    Route::get('/', [HomeController::class, 'index'])->name('home');
});