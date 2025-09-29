@extends('layouts.app')

@section('title', 'Listado de Productos')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Listado de Productos</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded shadow p-4 flex flex-col items-center">
                <a href="{{ route('products.show', $product) }}">
                    @if($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="mb-2" width="120">
                    @else
                        <img src="https://via.placeholder.com/120x90?text=Sin+Imagen" alt="Sin imagen" class="mb-2">
                    @endif
                </a>
                <div class="text-lg font-semibold mb-1">{{ $product->name }}</div>
                <div class="text-gray-600 mb-1">${{ number_format($product->price, 2) }}</div>
                <div class="text-gray-500 mb-2">Stock: {{ $product->stock }}</div>
                <a href="{{ route('products.show', $product) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Ver</a>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">No hay productos.</div>
        @endforelse
    </div>
</div>
@endsection