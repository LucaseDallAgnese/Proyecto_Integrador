@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container mx-auto mt-8 p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Producto: {{ $product->name }}</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">Por favor, corrige los siguientes problemas.</span>
            </div>
        @endif

        <form action="{{ route('admin.productos.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border @error('name') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border @error('description') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" name="price" id="price" class="shadow appearance-none border @error('price') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" name="stock" id="stock" class="shadow appearance-none border @error('stock') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                <select name="category_id" id="category_id" class="shadow appearance-none border @error('category_id') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Imagen Actual</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded mb-4">
                @else
                    <p class="text-sm text-gray-500">No hay imagen cargada.</p>
                @endif
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Cambiar Imagen (opcional)</label>
                <input type="file" name="image" id="image" class="shadow appearance-none border @error('image') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('image')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6 gap-4">
                <a href="{{ route('admin.productos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection