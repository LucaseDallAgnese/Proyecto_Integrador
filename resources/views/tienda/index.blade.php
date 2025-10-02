@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Nuestros Productos</h1>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                    <a href="{{ route('tienda.show', $product) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2 truncate">{{ $product->name }}</h3>
                        <p class="text-gray-800 font-bold text-xl mb-4">${{ number_format($product->price, 2) }}</p>
                        
                        <div class="flex flex-col space-y-2">
                             <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Agregar al carrito
                                </button>
                            </form>
                            
                            <a href="{{ route('tienda.show', $product) }}" class="w-full bg-gray-200 text-gray-800 text-center py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center bg-white p-10 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">No se encontraron productos</h2>
            <p class="text-gray-600">Intenta con otra búsqueda o revisa nuestros productos más tarde.</p>
        </div>
    @endif
</div>
@endsection