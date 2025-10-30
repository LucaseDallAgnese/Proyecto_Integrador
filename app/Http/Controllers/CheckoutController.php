<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Asegúrate de tener este use
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Muestra la página de checkout.
     */
    public function index()
    {
        // ***** LÍNEA DE CORRECCIÓN *****
        // Añade esta línea para cargar el carrito del usuario
        Cart::session(Auth::id());

        $cartItems = Cart::getContent();
        if ($cartItems->isEmpty()) {
            return redirect('/')->with('error', 'Tu carrito está vacío.');
        }
        return view('checkout.index', compact('cartItems'));
    }

    /**
     * Procesa la compra.
     */
    public function process(Request $request)
    {
        // ***** LÍNEA DE CORRECCIÓN *****
        // Añade esta línea también aquí para asegurar consistencia
        Cart::session(Auth::id());

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

            // 3. Vaciar el carrito (Ahora sí vaciará el carrito del usuario)
            Cart::clear();
            
            DB::commit();

            return redirect()->route('checkout.success')->with('success', '¡Tu compra se ha realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Es mejor redirigir al detalle del carrito si falla
            return redirect()->route('carrito.detalle')->with('error', 'Ocurrió un error al procesar tu pedido. Intenta de nuevo.');
        }
    }

    /**
     * Muestra la página de éxito.
     */
    public function success()
    {
        return view('checkout.success');
    }
}