<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de tener tu modelo Product
use Illuminate\Support\Facades\Session; // Para mensajes flash, similar a with('success', ...)

class ProductController extends Controller
{
    /**
     * Muestra un listado de todos los productos.
     */
    public function index()
    {
        // Obtiene todos los productos de la base de datos [4, 5]
        $products = Product::all();

        // Devuelve la vista 'products.index' y le pasa los productos
        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        // Devuelve la vista 'products.create' que contendrá el formulario [6]
        return view('products.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos de la petición [7]
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        // 2. Crear el producto en la base de datos [8-10]
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        // 3. Redirigir a una ruta con un mensaje de éxito [11, 12]
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra los detalles de un producto específico.
     */
    public function show(Product $product) // Laravel inyecta el modelo automáticamente (Route Model Binding)
    {
        // El modelo $product ya está disponible gracias al Route Model Binding
        // Si no usáramos Route Model Binding, sería: $product = Product::find($id); [4, 9]

        // Devuelve la vista 'products.show' y le pasa el producto
        return view('products.show', compact('product'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Product $product) // Route Model Binding
    {
        // El modelo $product ya está disponible
        // Devuelve la vista 'products.edit' con el producto a editar [6]
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Product $product) // Route Model Binding
    {
        // 1. Validar los datos de la petición [7]
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        // 2. Actualizar el producto en la base de datos [13]
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        // 3. Redirigir a una ruta con un mensaje de éxito [11, 12]
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(Product $product) // Route Model Binding
    {
        // 1. Eliminar el producto de la base de datos [14, 15]
        $product->delete(); // Si usas softDeletes, esto "ocultará" el registro [16-18]
                            // Si quieres eliminarlo definitivamente con softDeletes, usa $product->forceDelete(); [19]

        // 2. Redirigir a una ruta con un mensaje de éxito [11, 12]
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

