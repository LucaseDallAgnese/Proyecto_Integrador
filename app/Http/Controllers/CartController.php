<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartAddRequest;
use App\Models\Product;
// Ya no necesitamos 'use Darryldecode\Cart\Facades\CartFacade as Cart;'

class CartController extends Controller
{
    public function index()
    {
        return view('carrito.detalle');
    }

    /**
     * Agrega un producto al carrito en la sesión.
     */
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
                "discount" => $product->discount
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
            'message' => trim('¡Producto agregado al carrito!'),
            'cartItemCount' => $totalItems
        ]);
    }

    /**
     * NUEVO: Actualiza la cantidad de un producto en el carrito.
     */
    public function actualizar(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);
        
        $cart = session()->get('cart');

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = (int)$request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cantidad actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo actualizar el producto.');
    }

    /**
     * CORREGIDO: Elimina un producto del carrito en la sesión.
     */
    public function remove(Request $request)
    {
        $request->validate([ 'product_id' => 'required' ]);
        
        $cart = session()->get('cart');

        if(isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            
            return back()->with('success', 'Producto eliminado del carrito.');
        }

        return back()->with('error', 'No se pudo eliminar el producto.');
    }

    /**
     * CORREGIDO: Vacía todo el carrito de la sesión.
     */
    public function clear()
    {
        session()->forget('cart');
        
        return redirect()->route('carrito.detalle')->with('success', 'El carrito ha sido vaciado.');
    }
}