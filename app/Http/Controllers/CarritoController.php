<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session; // Para usar la fachada Session si se desea, o Request->session()

class CartController extends Controller
{
    /**
     * Agrega un producto al carrito de compras.
     */
    public function addProduct(Request $request)
    {
        // 1. Validar los datos enviados desde el formulario [18]
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'], // Asumiendo que existe una tabla 'products'
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // 2. Obtener el carrito actual de la sesión, o inicializarlo si no existe [2, 5]
        $cart = $request->session()->get('cart', []);

        // 3. Agregar o actualizar el producto en el carrito
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // 4. Guardar el carrito actualizado en la sesión [2, 5]
        $request->session()->put('cart', $cart);

        // 5. Redirigir a la página anterior con un mensaje de éxito [18, 19]
        return back()->with('success', 'Producto agregado al carrito exitosamente.'); // [19, 20]
    }

    /**
     * Elimina un producto del carrito de compras.
     */
    public function removeProduct(Request $request, $productId)
    {
        // 1. Obtener el carrito actual de la sesión [2, 5]
        $cart = $request->session()->get('cart', []);

        // 2. Eliminar el producto si existe en el carrito
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            // 3. Actualizar la sesión con el carrito modificado [2, 5]
            $request->session()->put('cart', $cart);
            return back()->with('success', 'Producto eliminado del carrito exitosamente.'); // [19, 20]
        }

        // Si el producto no estaba en el carrito
        return back()->with('error', 'El producto no se encontró en el carrito.'); // [18]
    }
}

