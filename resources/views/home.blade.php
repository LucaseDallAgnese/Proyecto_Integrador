<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con los productos destacados.
     */
    public function index()
    {
        // Obtenemos los 10 productos más recientes de la base de datos
        $products = Product::latest()->take(10)->get();

        // Pasamos la variable $products a la vista 'home'
        return view('home', compact('products'));
    }
}