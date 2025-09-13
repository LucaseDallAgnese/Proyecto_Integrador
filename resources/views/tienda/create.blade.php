@extends('layouts.app')

@section('title', isset($product) ? 'Editar Producto' : 'Crear Producto')

@section('content')
<h1>{{ isset($product) ? 'Editar Producto' : 'Crear Producto' }}</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST">
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif

    <div>
        <label>Nombre:</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    </div>
    <div>
        <label>Descripción:</label>
        <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div>
        <label>Precio:</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div>
        <label>Stock:</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
    </div>
    <div>
        <label>Imagen (ruta):</label>
        <input type="text" name="image" value="{{ old('image', $product->image ?? '') }}">
    </div>
    <div>
        <label>Categoría:</label>
        <input type="number" name="category_id" value="{{ old('category_id', $product->category_id ?? '') }}">
    </div>
    <button type="submit">{{ isset($product) ? 'Actualizar' : 'Crear' }}</button>
</form>
@endsection