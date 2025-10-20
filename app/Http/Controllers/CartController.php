<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartAddRequest;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        return view('carrito.detalle', compact('cartItems'));
    }

    public function agregar(CartAddRequest $request)
    {
        $validated = $request->validated();
        $productId = $validated['product_id'];
        $quantity = $validated['quantity'] ?? 1;

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        // Si el producto ya está en el carrito, actualiza la cantidad
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Si no está, lo agrega
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->discount > 0 ? $product->price * (1 - $product->discount / 100) : $product->price,
                "image" => $product->image,
                "discount" => $product->discount // Guardamos el descuento por si acaso
            ];
        }

        session()->put('cart', $cart); // Guarda el carrito actualizado en la sesión

        // Calcula el nuevo total de items en el carrito
        $totalItems = 0;
        foreach ($cart as $details) {
            $totalItems += $details['quantity'];
        }

        // Devuelve una respuesta JSON
        return response()->json([
            'success' => true,
            'message' => '¡Producto agregado al carrito!',
            'cartItemCount' => $totalItems // Envía el nuevo total de items
        ]);
    }

    public function remove(Request $request)
    {
        Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    public function clear()
    {
        Cart::clear();
        return redirect()->route('cart.index')->with('success', 'El carrito ha sido vaciado.');
    }



}