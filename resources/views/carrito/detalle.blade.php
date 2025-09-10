<form action="{{ route('cart.products.add') }}" method="POST">
    @csrf
    <div>
        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" required>
        <input type="hidden" name="product_id" value="{{ $product->id }}"> {{-- ID del producto actual --}}
    </div>
    <button type="submit">Agregar al Carrito</button>
</form>

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

@if ($errors->any()) {{-- Mostrar errores de validación [18] --}}
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif