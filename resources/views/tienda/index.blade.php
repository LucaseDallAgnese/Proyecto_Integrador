@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4">
    
    {{-- ... (Sección de Hero y Filtro de Categorías sin cambios) ... --}}

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">{{ $pageTitle ?? 'Nuestros Productos' }}</h1>

        @auth
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.productos.create') }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
                    &#43; Crear Producto
                </a>
            @endif
        @endauth
    </div>


    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                    <a href="{{ route('tienda.show', $product) }}">
                        <td><img src="{{ asset('storage/' . $product->image) }}" ...></td>
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

                            @auth
                                @if(Auth::user()->role == 'admin')
                                    <div class="flex justify-around mt-2 pt-2 border-t">
                                        <a href="{{ route('admin.productos.edit', $product->id) }}" class="text-yellow-500 hover:text-yellow-700 font-semibold">Editar</a>
                                        <form action="{{ route('admin.productos.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Eliminar</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-10">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        {{-- ... (Mensaje de "No se encontraron productos" sin cambios) ... --}}
    @endif
</div>
@endsection