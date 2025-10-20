@extends('layouts.app')

{{-- 1. Usamos el título dinámico que pasa el controlador --}}
@section('title', $pageTitle ?? 'Categoría')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- 2. Mostramos el título de la categoría actual --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $pageTitle }}</h1>

    {{-- 3. Verificamos si la variable $products tiene productos --}}
    @if($products->count() > 0)
        {{-- 4. Si hay productos, los recorremos con @foreach --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            @foreach ($products as $product)
                {{-- (Este es el HTML de la tarjeta de producto, copiado de tienda/index.blade.php) --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 group flex flex-col">
                    <a href="{{ route('tienda.show', $product) }}" class="relative block">
                        @if($product->discount > 0)
                            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
                                -{{ number_format($product->discount, 0) }}%
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-56 object-cover group-hover:opacity-90 transition-opacity">
                    </a>

                    <div class="p-4 flex flex-col flex-grow">
                        <p class="text-sm text-gray-500 mb-1">{{ $product->category->name ?? 'Sin categoría' }}</p>
                        <h3 class="text-lg font-bold text-gray-800 mb-3 truncate flex-grow" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>

                        <div class="mb-4">
                            @if($product->discount > 0)
                                <div class="flex items-baseline gap-2">
                                    <p class="text-2xl font-bold text-red-600">
                                        ${{ number_format($product->price * (1 - $product->discount / 100), 2) }}
                                    </p>
                                    <p class="text-md text-gray-400 line-through">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                            @else
                                <p class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                                    Agregar al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- (Fin de la tarjeta de producto) --}}
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        {{-- 5. Si $products->count() es 0, mostramos este mensaje --}}
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">No se encontraron productos</h2>
            <p class="text-gray-500 mt-2">No hay productos que coincidan con esta categoría actualmente.</p>
            <a href="{{ route('tienda.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Ver todos los productos
            </a>
        </div>
    @endif
</div>
@endsection