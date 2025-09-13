<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $productosDestacados = Product::orderBy('created_at', 'desc')->take(6)->get();
        return view('home', compact('productosDestacados'));
    }
}