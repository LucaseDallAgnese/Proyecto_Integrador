<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Guarda el nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $// 2. RESCATAR EL CARRITO (Se hace ANTES de crear nada)
        $guestCart = $request->session()->get('cart', []);

        // 3. CREAR EL USUARIO
        // Esta línea es la única que crea el usuario.
        // Nota que $request->only() funciona porque tu User Model
        // tiene 'password' => 'hashed' en el $casts.
        $user = User::create($request->only('name', 'email', 'password'));

        // 4. INICIAR SESIÓN
        Auth::login($user);

        // 5. REGENERAR SESIÓN (Esto borra el carrito viejo)
        $request->session()->regenerate();

        // 6. RESTAURAR EL CARRITO (en la nueva sesión)
        if (!empty($guestCart)) {
            $request->session()->put('cart', $guestCart);
        }

        // 7. REDIRIGIR AL DESTINO (que era el checkout)
        return redirect()->intended(route('tienda.index'));

        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Bienvenido! Tu cuenta ha sido creada exitosamente.');
    }
}