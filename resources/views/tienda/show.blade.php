@extends('layouts.app')

{{-- Usamos el nombre del producto como título de la página --}}
@section('title', $product->name) 

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="md:flex">
            {{-- Columna de la Imagen --}}
            <div class="md:w-1/2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-auto object-cover md:max-h-[500px]">
            </div>

            {{-- Columna de Detalles y Compra --}}
            <div class="md:w-1/2 p-8 flex flex-col justify-between">
                <div>
                    {{-- Categoría y Nombre --}}
                    <p class="text-sm text-gray-500 mb-2">{{ $product->category->name ?? 'Sin categoría' }}</p>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    {{-- Descripción --}}
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        {{ $product->description ?? 'No hay descripción disponible para este producto.' }}
                    </p>

                    {{-- Precios --}}
                    <div class="mb-6">
                        @if($product->discount > 0)
                            <div class="flex items-baseline gap-3">
                                <p class="text-4xl font-bold text-red-600">
                                    ${{ number_format($product->price * (1 - $product->discount / 100), 2) }}
                                </p>
                                <p class="text-xl text-gray-400 line-through">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                                <span class="bg-red-100 text-red-700 text-sm font-semibold px-2.5 py-0.5 rounded">
                                    {{ number_format($product->discount, 0) }}% OFF
                                </span>
                            </div>
                        @else
                            <p class="text-4xl font-bold text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Botón Agregar al Carrito --}}
                <div class="mt-auto">
                    <form action="{{ route('carrito.agregar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        {{-- Selector de Cantidad (Opcional) --}}
                        <div class="mb-4 flex items-center">
                            <label for="quantity" class="mr-3 text-gray-700 font-medium">Cantidad:</label>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="1" 
                                min="1" 
                                class="w-20 border border-gray-300 rounded-lg p-2 text-center focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Agregar al carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Puedes agregar aquí una sección de productos relacionados si quieres --}}

</div>
@endsection