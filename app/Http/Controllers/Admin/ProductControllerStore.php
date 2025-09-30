<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Suport\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Reuqests\ProductUpdateRequest;

class ProductController extends Controller
{
        public function store(ProductStoreRequest $request) // [MODIFICAR AQUÍ]
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productos', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function update(ProductUpdateRequest $request, Product $product) // [MODIFICAR AQUÍ]
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('productos', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }
}