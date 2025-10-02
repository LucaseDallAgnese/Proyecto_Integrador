<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Muestra la página principal de la tienda.
     * Muestra productos destacados o resultados filtrados.
     */
    public function index(Request $request)
    {
        // Iniciar la consulta base de productos
        $query = Product::query();

        // Si hay un término de búsqueda, aplicamos el filtro
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Si hay una categoría seleccionada, aplicamos el filtro
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Comprobar si se aplicó algún filtro
        $isFiltered = $request->has('search') || $request->has('category_id');

        if ($isFiltered) {
            // Si hay filtros, obtenemos los productos que coinciden y los paginamos
            $products = $query->paginate(20);
            $pageTitle = "Resultados de la Búsqueda";
        } else {
            // Si NO hay filtros, mostramos los 20 más vendidos
            $products = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->take(20)
                ->get();
            $pageTitle = "Productos Destacados";
        }
        
        // Obtenemos todas las categorías para el dropdown de filtros
        $categories = Category::all();

        // Enviamos los productos, categorías y el título a la vista
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