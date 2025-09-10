<form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST">
    @csrf {{-- Protección CSRF [34-37] --}}

    @if(isset($product))
        @method('PUT') {{-- Para la acción de actualizar [36, 38] --}}
    @endif

    <div>
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') {{-- Mostrar errores de validación para el campo 'name' [39] --}}
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="description">Descripción:</label>
        <textarea id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" required>
        @error('price')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" min="0" required>
        @error('stock')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">{{ isset($product) ? 'Actualizar Producto' : 'Crear Producto' }}</button>
</form>

{{-- Para mostrar mensajes de éxito o error globales [11, 12, 39, 40] --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
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