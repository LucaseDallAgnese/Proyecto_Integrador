<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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
        $products = $query->latest()->paginate(10); 
        
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Product $producto) // <-- Laravel inyecta el producto automáticamente
    {
        $categories = Category::all();
        
        // La clave está aquí: pasamos el producto encontrado a la vista.
        // La variable en la vista se llamará 'product'.
        return view('admin.productos.edit', [
            'product' => $producto, 
            'categories' => $categories
        ]);
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Product $producto) // <-- También se inyecta aquí
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Opcional: Eliminar imagen anterior si existe
            // Storage::disk('public')->delete($producto->image);
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
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