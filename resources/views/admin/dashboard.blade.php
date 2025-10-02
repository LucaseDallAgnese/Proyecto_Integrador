@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container">
    <h1 class="my-4">Panel de Administración</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $usersCount }}</h5>
                    <p class="card-text">Usuarios registrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Productos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productsCount }}</h5>
                    <p class="card-text">Productos en la tienda</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Órdenes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $ordersCount }}</h5>
                    <p class="card-text">Órdenes realizadas</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5">Últimas 5 Órdenes</h3>
    <div class="list-group">
        @forelse ($latestOrders as $order)
            <a href="#" class="list-group-item list-group-item-action">
                Orden #{{ $order->id }} - {{ $order->user->name }} - ${{ $order->total }}
            </a>
        @empty
            <p>No hay órdenes recientes.</p>
        @endforelse
    </div>

    <h3 class="mt-5">Gestión</h3>
    <div class="list-group">
        <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
            Gestionar Productos
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            Gestionar Categorías
        </a>
    </div>
</div>
@endsection