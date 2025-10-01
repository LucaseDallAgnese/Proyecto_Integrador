{{-- filepath: resources/views/tienda/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
        <div class="flex flex-col items-center">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mb-4" width="200">
            @else
                <img src="https://via.placeholder.com/200x150?text=Sin+Imagen" alt="Sin imagen" class="mb-4">
            @endif
            <h2 class="text-2xl font-bold mb-2">{{ $product->name }}</h2>
            <p class="mb-2">{{ $product->description }}</p>
            <p class="mb-2"><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
            <p class="mb-4"><strong>Stock:</strong> {{ $product->stock }}</p>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Volver</a>
        </div>
    </div>
</div>
@endsection