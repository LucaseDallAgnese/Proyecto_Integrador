@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="pt-24"> {{-- Añadido padding top para que el contenido no quede debajo del header --}}
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg">
                    @else
                        <img src="https://via.placeholder.com/600x400?text=Sin+Imagen" alt="Sin imagen" class="w-full h-auto object-cover rounded-lg">
                    @endif
                </div>
                <div>
                    {{-- MIGA DE PAN (BREADCRUMB) --}}
                    <nav class="text-sm mb-4" aria-label="Breadcrumb">
                        <ol class="list-none p-0 inline-flex">
                            <li class="flex items-center">
                                {{-- ✨ LÍNEA CORREGIDA ✨ --}}
                                <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Inicio</a>
                                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                            </li>
                            <li class="flex items-center">
                                <span class="text-gray-500">{{ $product->name }}</span>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $product->category->name ?? 'Sin categoría' }}</p>

                    <p class="text-gray-700 text-base mb-4">{{ $product->description }}</p>
                    <p class="text-3xl font-bold text-gray-900 mb-4">${{ number_format($product->price, 2) }}</p>
                    <p class="text-gray-600 mb-4">Stock disponible: <span class="font-bold">{{ $product->stock }}</span> unidades</p>
                    
                    <form action="{{ route('carrito.add') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center">
                            <label for="quantity" class="mr-4">Cantidad:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 px-2 py-1 border border-gray-300 rounded-lg">
                        </div>

                        @if ($product->stock > 0)
                            <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Agregar al Carrito
                            </button>
                        @else
                            <button type="button" class="mt-6 w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed" disabled>
                                No disponible
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection