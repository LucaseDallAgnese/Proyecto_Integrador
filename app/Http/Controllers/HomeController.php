<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {

         $productos = Producto::all();
        // Obtén los productos destacados (puedes cambiar la lógica según tu necesidad)
        $productosDestacados = Product::orderBy('created_at', 'desc')->take(6)->get();

        return view('home', compact('productosDestacados'));
    }
}