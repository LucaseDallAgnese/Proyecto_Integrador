<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function do_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $guestCart = $request->session()->get('cart', []);

            $request->session()->regenerate();

            if (!empty($guestCart)) {
                $request->session()->put('cart', $guestCart);
            }

            if (Auth::user()->rol == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}