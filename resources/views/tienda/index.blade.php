@extends('layouts.app')

@section('title', 'Tienda - TeraStore')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Explora nuestros productos</h2>
            <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Buscar producto..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ request('search') }}"
                    >
                </div>
                <div class="md:col-span-1">
                    <select 
                        name="category_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1 flex items-center gap-2">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Filtrar
                    </button>
                    <a href="{{ route('products.index') }}" class="w-full text-center bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <hr class="my-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">{{ $pageTitle }}</h1>

        @if($products->isEmpty())
            <p class="text-center text-gray-500">No se encontraron productos que coincidan con tu búsqueda.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <a href="{{ route('products.show', $product) }}">
                            @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" alt="Sin imagen" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                            </div>
                        </a>
                        <div class="px-4 pb-4">
                            <p class="text-gray-700 font-bold text-xl">${{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('carrito.add') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                @if ($product->stock > 0)
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">Agregar</button>
                                @else
                                    <button type="button" class="w-full bg-gray-400 text-white py-2 rounded-lg font-semibold cursor-not-allowed" disabled>No disponible</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{-- Verifica si la variable es una instancia de Paginator antes de renderizar --}}
                @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $products->appends(request()->query())->links() }}
                @endif
            </div>
        @endif
    </div>
</div>
@endsection