@foreach($cartItems as $item) {{-- Suponiendo que $cartItems es una colección de productos en el carrito --}}
    <div>
        <span>{{ $item->name }} - Cantidad: {{ $item->quantity }}</span>

        <form action="{{ route('cart.products.remove', ['product' => $item->id]) }}" method="POST" style="display:inline;">
            @csrf {{-- Protección CSRF [14, 21-23] --}}
            @method('DELETE') {{-- Simula una petición DELETE [14, 25] --}}
            <button type="submit">Eliminar</button>
        </form>
    </div>
@endforeach

@if(session('success')) {{-- Mostrar mensaje de éxito si existe [20, 24] --}}
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error')) {{-- Mostrar mensaje de error si existe [18, 24] --}}
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif