@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Título y Filtros --}}
<div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

    {{-- 1. Mantenemos un formulario SÓLO para la búsqueda por nombre --}}
    <form action="{{ route('tienda.index') }}" method="GET" class="flex items-center gap-4">
        <input
            type="text"
            name="search"
            placeholder="Buscar producto..."
            class="shadow-sm border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto"
            value="{{ request('search') }}"
        >
        {{-- Puedes agregar un botón si quieres, o dejar que funcione con "Enter" --}}
        {{-- <button type="submit" class="bg-blue-600 text-white ...">Buscar</button> --}}
    </form>

    {{-- 2. El select de categorías ahora funciona con JavaScript --}}
    <select
        id="category_filter" {{-- Le damos un ID --}}
        class="shadow-sm border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto"
    >
        <option value="">Todas las categorías</option>
        @foreach($categories as $category)
            {{-- El 'value' ahora es la URL completa a la nueva página de categoría --}}
            <option value="{{ route('categoria.show', $category->id) }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    {{-- 3. El botón "Limpiar" ahora solo se muestra si hay una búsqueda de texto --}}
    @if(request('search'))
        <a href="{{ route('tienda.index') }}" class="text-center bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
            Limpiar búsqueda
        </a>
    @endif
</div>

    {{-- Listado de Productos --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Bucle para cada producto --}}
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 group flex flex-col">
                    <a href="{{ route('tienda.show', $product) }}" class="relative block">
                        {{-- Etiqueta de Descuento (solo si existe) --}}
                        @if($product->discount > 0)
                            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
                                -{{ number_format($product->discount, 0) }}%
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-56 object-cover group-hover:opacity-90 transition-opacity">
                    </a>

                    <div class="p-4 flex flex-col flex-grow">
                        {{-- Categoría del Producto --}}
                        <p class="text-sm text-gray-500 mb-1">{{ $product->category->name ?? 'Sin categoría' }}</p>
                        {{-- Nombre del Producto --}}
                        <h3 class="text-lg font-bold text-gray-800 mb-3 truncate flex-grow" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>

                        {{-- Precios --}}
                        <div class="mb-4">
                            @if($product->discount > 0)
                                {{-- Si hay descuento, muestra ambos precios --}}
                                <div class="flex items-baseline gap-2">
                                    <p class="text-2xl font-bold text-red-600">
                                        ${{ number_format($product->price * (1 - $product->discount / 100), 2) }}
                                    </p>
                                    <p class="text-md text-gray-400 line-through">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                            @else
                                {{-- Si no hay descuento, muestra solo el precio normal --}}
                                <p class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                            @endif
                        </div>

                        {{-- Botón para agregar al carrito --}}
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
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        {{-- Mensaje si no se encuentran productos --}}
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">No se encontraron productos</h2>
            <p class="text-gray-500 mt-2">Intenta modificar tu búsqueda o limpiar los filtros.</p>
            <a href="{{ route('tienda.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Ver todos los productos
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Espera a que la página cargue
    document.addEventListener('DOMContentLoaded', function() {
        
        // Busca el <select> por su ID
        const categoryFilter = document.getElementById('category_filter');
        categoryFilter.addEventListener('change', function() {
            
            if (this.value) { 
                // Si el valor no está vacío 
                // Redirige el navegador 
                window.location.href = this.value;
            } else {
                window.location.href = "{{ route('tienda.index') }}";
            }
        });
    });
</script>
@endpush

@endsection