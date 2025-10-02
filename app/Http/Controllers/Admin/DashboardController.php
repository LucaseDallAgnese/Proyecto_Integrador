<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order; // Asegúrate de importar el modelo Order

class DashboardController extends Controller
{
    public function index()
    {
        // Volvemos a cargar los datos que la vista necesita
        $usersCount = User::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $latestOrders = Order::with('user', 'items.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Usamos compact() para pasar todas las variables a la vista
        return view('admin.dashboard', compact('usersCount', 'productsCount', 'ordersCount', 'latestOrders'));
    }
}