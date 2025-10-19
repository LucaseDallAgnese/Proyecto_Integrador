{{-- resources/views/categoria/show.blade.php --}}
@extends('layouts.app')

{{-- Usamos el título que pasamos desde el controlador --}}
@section('title', $pageTitle) 

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Título de la Categoría --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        {{ $currentCategory->name }}
    </h1>

    {{-- Aquí va el MISMO código de bucle de productos de tienda/index.blade.php --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                {{-- (Pega aquí tu tarjeta de producto) --}}
                <div class="bg-white rounded-lg shadow-md ...">
                    {{-- ... (toda la lógica de la tarjeta) ... --}}
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        {{-- Mensaje si no hay productos --}}
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">No hay productos en esta categoría</h2>
            <p class="text-gray-500 mt-2">Intenta explorar otras categorías.</p>
            <a href="{{ route('tienda.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Ver todos los productos
            </a>
        </div>
    @endif
</div>
@endsection