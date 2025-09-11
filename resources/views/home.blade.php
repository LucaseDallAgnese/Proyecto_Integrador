@extends('layouts.app')

@section('title', 'Bienvenido a TeraStore')

@section('content')
    <div class="container">

        {{-- Banner principal --}}
        <div class="mb-5">
            <img src="/images/banner.jpg" class="img-fluid w-100" alt="Promoción principal">
        </div>

        {{-- Ventajas de la tienda --}}
        <div class="row text-center mb-5">
            <div class="col-md-4">
                <h5>Envío gratis</h5>
                <p>En compras superiores a $10.000</p>
            </div>
            <div class="col-md-4">
                <h5>Soporte 24/7</h5>
                <p>Atención personalizada todo el año</p>
            </div>
            <div class="col-md-4">
                <h5>Pagá como quieras</h5>
                <p>Tarjeta, débito, efectivo y más</p>
            </div>
        </div>

        {{-- Productos destacados --}}
        <h2 class="mb-4">Productos destacados</h2>
        <div class="row">
            @forelse ($productosDestacados as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" class="card-img-top" alt="{{ $producto->nombre }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>
                            <p class="card-text"><strong>${{ number_format($producto->precio, 2) }}</strong></p>
                            <a href="{{ route('tienda.show', $producto) }}" class="btn btn-primary">Ver producto</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No hay productos destacados por el momento.</p>
                </div>
            @endforelse
        </div>

        {{-- Newsletter --}}
        <div class="mt-5 p-4 bg-light rounded">
            <h4>¡Suscribite a nuestro newsletter!</h4>
            <form>
                <div class="row">
                    <div class="col-md-8">
                        <input type="email" class="form-control" placeholder="Tu email">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success w-100">Suscribirme</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection