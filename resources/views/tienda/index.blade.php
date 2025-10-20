@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- 1. Título Principal (Centrado) --}}
    <div class="text-center mr-20 ">
        <h1 class="text-4xl font-bold text-gray-800">
            {{-- Usa el título dinámico si existe, si no, usa 'Nuestros Productos' --}}
            {{ $pageTitle ?? 'Nuestros Productos' }}
        </h1>
    </div>

    {{-- 2. Contenedor de Filtros (Centrado y en Fila en pantallas grandes) --}}
    <div class="flex flex-col sm:flex-row items-center -translate-y-11 justify-end gap-4 "> 
        
        {{-- Formulario para Búsqueda por Nombre --}}
        <form action="{{ route('tienda.index') }}" method="GET" class="w-full sm:w-auto">
            <input
                type="text"
                name="search"
                placeholder="Buscar producto..."
                class="shadow-sm border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:min-w-[250px]"
                value="{{ request('search') }}"
            >
            {{-- No es necesario un botón de submit explícito, "Enter" funciona --}}
        </form>

        {{-- Select para Categorías --}}
        <select
            id="category_filter" {{-- ID para el JavaScript --}}
            class="shadow-sm border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto sm:min-w-[200px]"
        >
            <option value="">Todas las categorías</option>
            @foreach($categories as $category)
                {{-- El 'value' es la URL a la página de esa categoría --}}
                <option value="{{ route('categoria.show', $category->id) }}"> 
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Botón para Limpiar la Búsqueda --}}
        @if(request('search'))
            <a href="{{ route('tienda.index') }}" class="text-center bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
                Limpiar
            </a>
        @endif
    </div>

    {{-- 3. Título "Productos Destacados" (Centrado) --}}
    {{--    Este título se muestra siempre, independientemente de los filtros --}}
    <div class="text-center my-8"> 
        <h2 class="text-3xl font-semibold text-gray-700">
        </h2>
    </div>

    {{-- Verifica si hay productos para mostrar --}}
    @if($products->count() > 0)
        {{-- Cuadrícula de productos --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Bucle para mostrar cada producto --}}
            @foreach ($products as $product)
                {{-- (Inicio de la tarjeta de producto) --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 group flex flex-col">
                    <a href="{{ route('tienda.show', $product) }}" class="relative block">
                        {{-- Etiqueta de Descuento (si aplica) --}}
                        @if($product->discount > 0)
                            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
                                -{{ number_format($product->discount, 0) }}%
                            </div>
                        @endif
                        {{-- Imagen del Producto --}}
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-56 object-cover group-hover:opacity-90 transition-opacity">
                    </a>

                    {{-- Detalles del Producto --}}
                    <div class="p-4 flex flex-col flex-grow">
                        {{-- Categoría --}}
                        <p class="text-sm text-gray-500 mb-1">{{ $product->category->name ?? 'Sin categoría' }}</p>
                        {{-- Nombre --}}
                        <h3 class="text-lg font-bold text-gray-800 mb-3 truncate flex-grow" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>

                        {{-- Precios (con lógica de descuento) --}}
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

                        {{-- Botón Agregar al Carrito --}}
                        <div class="mt-auto"> {{-- Empuja el botón hacia abajo --}}
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1"> {{-- Cantidad por defecto --}}
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                                    Agregar al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- (Fin de la tarjeta de producto) --}}
            @endforeach
        </div>

        {{-- Enlaces de Paginación --}}
        <div class="mt-12">
            {{-- Mantiene los parámetros de búsqueda/categoría al cambiar de página --}}
            {{ $products->appends(request()->query())->links() }} 
        </div>
    @else
        {{-- Mensaje si no se encontraron productos --}}
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">No se encontraron productos</h2>
            <p class="text-gray-500 mt-2">Intenta modificar tu búsqueda o explorar otras categorías.</p>
            <a href="{{ route('tienda.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Ver todos los productos
            </a>
        </div>
    @endif

</div> {{-- Cierre del div container --}}

@push('scripts')
<script>
    // Espera a que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        // Obtiene el elemento <select> por su ID
        const categoryFilter = document.getElementById('category_filter');

        // Añade un "oyente" para el evento 'change' (cuando el usuario selecciona algo)
        categoryFilter.addEventListener('change', function() {
            // 'this.value' contiene la URL de la categoría seleccionada (o "" si es "Todas")
            if (this.value) { 
                // Si se seleccionó una categoría, redirige a esa URL
                window.location.href = this.value;
            } else {
                // Si se seleccionó "Todas las categorías", redirige a la tienda principal
                window.location.href = "{{ route('tienda.index') }}";
            }
        });
    });
</script>
@endpush

@endsection