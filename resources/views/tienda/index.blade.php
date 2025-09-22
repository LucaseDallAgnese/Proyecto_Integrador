@extends('layouts.app')

@section('title', 'Listado de Productos')

@section('content')
<h1>Listado de Productos</h1>

<a href="{{ route('products.create') }}">Crear Nuevo Producto</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('products.show', $product) }}">Ver</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No hay productos.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection