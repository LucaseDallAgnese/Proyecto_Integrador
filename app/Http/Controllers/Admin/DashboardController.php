<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del dashboard.
     */
    public function index()
    {
        // Se asume que el usuario ya está autenticado y tiene permisos de admin
        // gracias a la lógica en el LoginController y las rutas.
        return view('admin.dashboard');
    }
}