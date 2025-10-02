@extends('layouts.admin')

@section('title', 'Modificar Producto')
@section('page-title', 'Modificar Producto: ' . $product->name)

@section('content')
<form action="{{ route('admin.productos.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Columna Principal (Izquierda) --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Nombre y Descripción</h3>
                
                {{-- Nombre del Producto --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $product->name) }}" required>
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <textarea name="description" id="description" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Columna Lateral (Derecha) --}}
        <div>
            {{-- Sección de Precios y Stock --}}
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Precio y Stock</h3>

                {{-- Precio --}}
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" value="{{ old('price', $product->price) }}" required>
                </div>

                {{-- Precio de Descuento (Campo nuevo del diseño) --}}
                {{-- Nota: Para que funcione, necesitas agregar la columna a tu tabla 'products' y lógica en el controlador --}}
                <div class="mb-4">
                    <label for="discount_price" class="block text-gray-700 text-sm font-bold mb-2">Precio de Descuento (Opcional)</label>
                    <input type="number" name="discount_price" id="discount_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" value="{{ old('discount_price', $product->discount_price ?? '') }}">
                </div>
                
                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" name="stock" id="stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            {{-- Sección de Imagen --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Imagen del Producto</h3>
                
                {{-- Imagen Actual --}}
                @if ($product->image)
                    <div class="mb-4">
                        <p class="block text-gray-700 text-sm font-bold mb-2">Imagen Actual:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-auto rounded-lg">
                    </div>
                @endif
                
                {{-- Cambiar Imagen --}}
                <div>
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Cambiar Imagen</label>
                    <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>
        </div>
    </div>

    {{-- Botón de Actualizar --}}
    <div class="mt-8 flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition-colors duration-300">
            Actualizar Producto
        </button>
    </div>
</form>
@endsection