<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

    /**
     * Muestra la lista de productos con filtros y paginación.
     */
    public function index(Request $request)
    {
        // Inicia la consulta con la relación de categoría precargada
        $query = Product::with('category');

        // Aplica el filtro de búsqueda si existe
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Aplica el filtro de categoría si existe
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pagina los resultados y los ordena por el más reciente
        $products = $query->latest()->paginate(20); 
        
        // Obtiene todas las categorías para el dropdown del filtro
        $categories = Category::all();

        // Retorna la vista con los productos y las categorías
        return view('admin.productos.index', compact('products', 'categories'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.productos.create', compact('categories'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
 public function store(StoreProductRequest $request)
    {
        $data = $request->validated(); // Obtenemos solo los datos validados

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }
    
    // El método edit ya estaba correcto
    public function edit(Product $producto)
    {
        $categories = Category::all();
        return view('admin.productos.edit', [
            'product' => $producto,
            'categories' => $categories
        ]);
    }


    public function update(UpdateProductRequest $request, Product $producto)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Opcional: Eliminar la imagen anterior del almacenamiento
            // Storage::disk('public')->delete($producto->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(Product $producto) // <-- Y aquí también
    {
        // Opcional: Eliminar la imagen del almacenamiento al borrar el producto
        // if ($producto->image) {
        //     Storage::disk('public')->delete($producto->image);
        // }
        
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}