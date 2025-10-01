@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Productos Destacados</h1>

        {{-- SOLUCIÓN: Iterar sobre la colección $products --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                {{-- Ahora la variable $product existe dentro del bucle --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <a href="{{ route('products.show', $product) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" alt="Sin imagen" class="w-full h-48 object-cover">
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-gray-600 mt-2">${{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('carrito.add', $product) }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if ($product->stock > 0)
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Agregar al Carrito
                                </button>
                            @else
                                <button type="button" class="w-full bg-gray-400 text-white py-2 rounded-lg font-semibold cursor-not-allowed" disabled>
                                    No disponible
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection