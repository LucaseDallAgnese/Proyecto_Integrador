<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        $products = Product::all();
        return view('admin.productos.index', compact('products'));
    }

    // Mostrar el formulario para crear un nuevo producto
    public function create()
    {
        return view('admin.productos.create');
    }

    // Guardar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Cambiado a tipo archivo imagen
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productos', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar un producto específico
    public function show(Product $product)
    {
        return view('admin.productos.show', compact('product'));
    }

    // Mostrar el formulario para editar un producto
    public function edit(Product $product)
    {
        return view('admin.productos.edit', compact('product'));
    }

    // Actualizar un producto
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Cambiado a tipo archivo imagen
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productos', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar un producto
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}