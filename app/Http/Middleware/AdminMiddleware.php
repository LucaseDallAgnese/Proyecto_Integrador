<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
   
    //@param \Clousure(\Illuminte\Http\Request): (\Symfony\Component\HttpFoundation\Response) ñext

    public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check() || Auth::user()->role !== 'admin'){
        abort(403, 'Acceso no autorizado. Se requiere rol de administrador.');

    }
return $next($request);
}    
}