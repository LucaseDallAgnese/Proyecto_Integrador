@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="container mx-auto text-center py-20">
        <h1 class="text-4xl font-bold mb-4">Bienvenido a TeraStore</h1>
        <p class="text-lg text-gray-600 mb-8">Tu tienda de componentes de PC de confianza.</p>
        <a href="{{ route('tienda.index') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
            Ir a la Tienda
        </a>
    </div>
@endsection