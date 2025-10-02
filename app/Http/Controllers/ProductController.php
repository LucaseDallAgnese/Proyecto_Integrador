<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // ... (tu código de filtros se queda igual) ...
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $isFiltered = $request->filled('search') || $request->filled('category_id');

        if ($isFiltered) {
            // Esto ya estaba correcto
            $products = $query->paginate(20);
            $pageTitle = "Resultados de la Búsqueda";
        } else {
            //
            // AQUÍ ESTÁ EL CAMBIO
            // En lugar de get(), usamos paginate() para que siempre sea un objeto paginable.
            //
            $products = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->paginate(20); // <-- CAMBIA ->take(20)->get() POR ->paginate(20)
            
            $pageTitle = "Productos Destacados";
        }
        
        $categories = Category::all();

        return view('tienda.index', [
            'products' => $products,
            'categories' => $categories,
            'pageTitle' => $pageTitle
        ]);
    }

    /**
     * Muestra los detalles de un producto específico.
     */
    public function show(Product $product)
    {
        return view('tienda.show', compact('product'));
    }
}