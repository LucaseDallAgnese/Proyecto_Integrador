@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Carrito de Compras</h1>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
    @php $total = 0; @endphp

    @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Lista de Productos --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Tus Productos</h2>
                        <form action="{{ route('carrito.vaciar') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Vaciar carrito</button>
                        </form>
                    </div>
                    <hr class="mb-4">

                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <div class="flex items-center justify-between py-4 border-b">
                            {{-- Info del Producto --}}
                            <div class="flex items-center w-2/5">
                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-20 h-20 object-cover rounded-md mr-4">
                                <div>
                                    <p class="font-bold">{{ $details['name'] }}</p>
                                    <p class="text-gray-600">${{ number_format($details['price'], 2) }}</p>
                                </div>
                            </div>

                            {{-- Cantidad --}}
                            <div class="w-1/5">
                                <form action="{{ route('carrito.actualizar') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="w-16 text-center border rounded-md mx-2" min="1">
                                    <button type="submit" class="text-blue-500 hover:underline text-sm">Actualizar</button>
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <div class="w-1/5 text-right">
                                <p class="font-semibold">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                            </div>

                             {{-- Eliminar --}}
                            <div class="w-1/5 text-right">
                                <form action="{{ route('carrito.eliminar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="text-gray-500 hover:text-red-600">&times; Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Resumen de la Compra --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Resumen de la compra</h2>
                    <hr class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span>Envío</span>
                        <span class="text-green-500">Gratis</span>
                    </div>
                    <hr class="mb-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="mt-6 block w-full text-center bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Iniciar Compra
                    </a>
                </div>
            </div>

        </div>
    @else
        <div class="text-center bg-white p-10 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Tu carrito está vacío</h2>
            <p class="text-gray-600 mb-6">Parece que todavía no has agregado ningún producto.</p>
            <a href="{{ route('tienda.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Volver a la tienda
            </a>
        </div>
    @endif
</div>
@endsection