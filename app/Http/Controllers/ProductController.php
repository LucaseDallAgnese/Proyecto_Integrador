<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Listar productos
    public function index()
    {
        $latestProducts = Product::latest()->take(8)->get();
        
        return view('tienda.index', ['products' => $latestProducts]);
    }

    public function shop()
    {
        
        return view('tienda.shop', compact('products'));
    }

    // Mostrar detalles de un producto
    public function show(Product $product)
    {
        
        return view('tienda.show', compact('product'));
        dd($product);
    }
}