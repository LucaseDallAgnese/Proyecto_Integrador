<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración principal.
     */
    public function index()
    {
        $usersCount = User::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();

        // ultimas 5 ordenes
        $latestOrders = Order::with('user', 'items.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Pasar la variable a las vistas
        return view('admin.dashboard', compact(
            'usersCount',
            'productsCount',
            'ordersCount',
            'latestOrders'
        ));
    }
}