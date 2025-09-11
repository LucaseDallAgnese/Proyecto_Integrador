<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Mostrar el carrito
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('cart.index', compact('cart', 'products'));
    }

    // Agregar producto al carrito
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $request->session()->get('cart', []);

        $quantity = $request->input('quantity', 1);

        // Validar stock
        if ($quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    // Eliminar producto del carrito
    public function remove(Request $request, $productId)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$productId]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart.');
    }

    // Actualizar cantidad de un producto
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1 || $quantity > $product->stock) {
            return back()->with('error', 'Invalid quantity.');
        }

        $cart = $request->session()->get('cart', []);
        $cart[$productId] = $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    // Vaciar el carrito
    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}