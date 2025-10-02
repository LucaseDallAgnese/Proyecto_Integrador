@extends('layouts.admin')

@section('title', 'Gestionar Productos')
@section('page-title', 'Productos')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Lista de Productos</h2>
            <a href="{{ route('admin.productos.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Agregar Producto
            </a>
        </div>

        <form action="{{ route('admin.productos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar por nombre..." 
                class="w-full px-4 py-2 border rounded-lg"
                value="{{ request('search') }}"
            >
            <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                <option value="">Filtrar por categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Filtrar</button>
                <a href="{{ route('admin.productos.index') }}" class="w-full text-center bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-400">Limpiar</a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">ID</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Precio</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Stock</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Categoría</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($products as $product)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $product->id }}</td>
                            <td class="py-3 px-4">{{ $product->name }}</td>
                            <td class="py-3 px-4">${{ number_format($product->price, 2) }}</td>
                            <td class="py-3 px-4">{{ $product->stock }}</td>
                            <td class="py-3 px-4">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 flex gap-2">
                                <a href="{{ route('admin.productos.edit', $product) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                <form action="{{ route('admin.productos.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No se encontraron productos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection