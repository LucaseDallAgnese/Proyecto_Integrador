@extends('layouts.admin')

@section('title', 'Gestión de Productos')
@section('page-title', 'Productos')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">

    {{-- Encabezado y Botón de Crear --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Listado de Productos</h2>
        <a href="{{ route('admin.productos.create') }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
            &#43; Crear Nuevo Producto
        </a>
    </div>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    {{-- TODO: Agregar filtros de búsqueda aquí si lo deseas --}}

    {{-- Tabla de Productos --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Imagen</th>
                    <th class="py-2 px-4 border-b text-left">Nombre</th>
                    <th class="py-2 px-4 border-b text-left">Categoría</th>
                    <th class="py-2 px-4 border-b text-right">Precio</th>
                    <th class="py-2 px-4 border-b text-center">Stock</th>
                    <th class="py-2 px-4 border-b text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="py-2 px-4 border-b font-medium">{{ $product->name }}</td>
                        <td class="py-2 px-4 border-b text-gray-600">{{ $product->category->name ?? 'Sin categoría' }}</td>
                        <td class="py-2 px-4 border-b text-right">${{ number_format($product->price, 2) }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $product->stock }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="flex justify-center items-center space-x-4">
                                <a href="{{ route('admin.productos.edit', $product) }}" class="text-yellow-500 hover:text-yellow-700 font-semibold">Editar</a>
                                <form action="{{ route('admin.productos.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">No hay productos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection