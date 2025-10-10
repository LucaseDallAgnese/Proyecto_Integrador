<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Muestra la lista de productos, priorizando los que tienen descuento.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Aplicar filtro de búsqueda
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Aplicar filtro de categoría
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $isFiltered = $request->filled('search') || $request->filled('category_id');

        if ($isFiltered) {
            // Si hay filtros, ordena primero por descuento y luego por más nuevos
            $products = $query->orderByRaw('discount > 0 DESC')->latest()->paginate(20);
            $pageTitle = "Resultados de la Búsqueda";
        } else {
            // Si no hay filtros, muestra los más vendidos, priorizando descuentos
            $products = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderByRaw('discount > 0 DESC') // <-- ORDENA POR DESCUENTO
                ->orderByDesc('total_sold')
                ->paginate(20);

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
     * Muestra la página de detalle de un producto específico.
     */
    public function show(Product $product)
    {
        return view('tienda.show', compact('product'));
    }
}