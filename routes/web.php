<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductController as TiendaProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Rutas del Carrito de Compras
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('carrito.add');
Route::post('/carrito/eliminar', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');

// Ruta Principal
Route::get('/', [ProductController::class, 'index'])->name('home');
//para ver el detalle de un producto
Route::get('/tienda/{product}', [ProductController::class, 'show'])->name('tienda.show');
//Ruta para busqueda y filtros
Route::get('/tienda', [ProductController::class, 'index'])->name('tienda.index');

// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'do_login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/registro', [RegisterController::class, 'create'])->name('register');
Route::post('/registro', [RegisterController::class, 'store'])->name('register.store');

//Rutas de Recuperación de Contraseña
Route::get('olvide-mi-contrasena', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('olvide-mi-contrasena', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('restablecer-contrasena/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('restablecer-contrasena', [ResetPasswordController::class, 'reset'])->name('password.update');

// Rutas del Carrito de Compras
Route::prefix('carrito')->name('carrito.')->group(function () {
    Route::get('/', [CartController::class, 'showCart'])->name('detalle');
    Route::post('/agregar', [CartController::class, 'agregar'])->name('agregar');
    Route::post('/eliminar', [CartController::class, 'eliminar'])->name('eliminar');
    Route::post('/actualizar', [CartController::class, 'actualizar'])->name('actualizar');
    Route::post('/vaciar', [CartController::class, 'vaciar'])->name('vaciar');
});

//Rutas de compra (solo los usuarios logueados pueden comprar)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Rutas del Panel de Administración (Protegidas)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Usamos un controlador de recursos para los productos
    Route::resource('productos', \App\Http\Controllers\Admin\ProductController::class);
});