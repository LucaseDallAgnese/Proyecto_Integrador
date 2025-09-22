@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container mx-auto mt-8 p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Panel de Administración</h1>
    <p class="text-gray-600 mb-8">Bienvenido, <span class="font-semibold">{{ Auth::user()->name }}</span>. Desde aquí puedes gestionar todo tu sitio web.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tarjeta para gestionar productos -->
        <a href="{{ route('admin.productos.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Gestionar Productos</h2>
            <p class="text-gray-600">Agregar, editar o eliminar productos de la tienda.</p>
        </a>
        
        <!-- Tarjeta para ver la tienda como cliente -->
        <a href="{{ route('products.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" target="_blank">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Ver la Tienda</h2>
            <p class="text-gray-600">Ver la página como un cliente para ver cómo se ven los cambios.</p>
        </a>

        <!-- Tarjeta para gestionar categorías -->
        <a href="{{ route('admin.categorias.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Gestionar Categorías</h2>
            <p class="text-gray-600">Organizar y administrar las categorías de los productos.</p>
        </a>
    </div>
</div>
@endsection
