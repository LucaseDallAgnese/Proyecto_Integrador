@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        
        
        <nav class="text-sm mb-4" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li class="flex items-center">
                    
                    <a href="{{ route('tienda.index') }}" class="text-blue-600 hover:underline">Productos</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-500">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>
        

        <div class="grid md:grid-cols-2 gap-8">
            
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg object-cover">
            </div>

            
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                <span class="text-3xl font-bold text-gray-900 mb-4">${{ number_format($product->price, 2) }}</span>
                
                
                <form action="{{ route('carrito.add', $product) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex items-center">
                        <label for="quantity" class="mr-4 font-semibold">Cantidad:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 p-2 border rounded-md">
                    </div>
                    @if ($product->stock > 0)
                        <p class="text-green-600 mt-2">En stock ({{ $product->stock }} disponibles)</p>
                        <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Agregar al Carrito
                        </button>
                    @else
                        <p class="text-red-600 mt-2 font-semibold">Sin stock</p>
                        <button type="button" class="mt-4 w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed" disabled>
                            No disponible
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection