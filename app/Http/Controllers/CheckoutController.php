<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        if ($cartItems->isEmpty()) {
            return redirect('/')->with('error', 'Tu carrito está vacío.');
        }
        return view('checkout.index', compact('cartItems'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect('/');
        }
        
        // Usamos una transacción para asegurar la integridad de los datos
        DB::beginTransaction();
        try {
            // 1. Crear la orden
            $order = Order::create([
                'user_id' => $user->id,
                'total' => Cart::getTotal(),
                // Puedes agregar más campos como dirección, estado, etc.
            ]);

            // 2. Crear los items de la orden
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            // 3. Vaciar el carrito
            Cart::clear();
            
            DB::commit();

            return redirect()->route('checkout.success')->with('success', '¡Tu compra se ha realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Ocurrió un error al procesar tu pedido. Intenta de nuevo.');
        }
    }

    public function success()
    {
        return view('checkout.success');
    }
}