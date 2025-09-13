<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Muestra el formulario de checkout
        return view('checkout.index');
    }

    public function store(Request $request)
    {
        // Procesa la compra (simulado)
        session()->forget('cart');
        return redirect()->route('checkout.success', ['transaccion' => uniqid()]);
    }

    public function success($transaccion)
    {
        return view('checkout.success', compact('transaccion'));
    }
}
