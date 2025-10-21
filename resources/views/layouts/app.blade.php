<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TeraStore')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased"> {{-- Fondo gris claro --}}
    
    <div id="app" class="min-h-screen flex flex-col"> {{-- Contenedor principal --}}

        {{-- estilos del header --}}
        <nav class="bg-gray-900 text-white shadow-lg sticky top-0 z-50"> 
            <div class="container mx-auto ">
                <div class="flex justify-between items-center">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 mr-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo TeraStore" class="h-20 w-auto"> 
                    </a>

                    {{-- Barra de búsqueda central --}}
                    <div class="flex-grow hidden sm:block"> {{-- Oculta en móvil (sm:block) --}}
                        <form action="{{ route('tienda.index') }}" method="GET" class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Buscar productos..." 
                                {{-- Fondo ligeramente más claro, focus mejorado --}}
                                class="w-full border-blue bg-white-900 text-white placeholder-blue-300 px-5 py-2.5 pr-12 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-blue-600 transition-colors duration-200" 
                                value="{{ request('search') }}"
                            >
                            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-300 hover:text-white transition-colors"> {{-- Ajustado right-4 --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    {{-- Links de usuario y Carrito --}}
                    <div class="flex items-center space-x-5 ml-6">
                        
                        {{-- Carrito --}}
                        <a href="{{ route('carrito.detalle') }}" class="relative text-gray-300 hover:text-white transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{-- Tooltip (opcional) --}}
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-700 text-white text-xs rounded">
                              Carrito
                            </span>
                            
                            {{-- Contador --}}
                            @php
                                $cartItemCount = (session('cart') && is_array(session('cart'))) ? count(session('cart')) : 0;
                            @endphp
                            @if($cartItemCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse"> {{-- Efecto pulse opcional --}}
                                    {{ $cartItemCount }}
                                </span>
                            @endif
                        </a>

                        {{-- Autenticación --}}
                        @guest
                            {{-- Iconos para login/register (opcional) --}}
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors group relative flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                <span class="hidden md:inline">Iniciar sesión</span>
                                {{-- Tooltip --}}
                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-700 text-white text-xs rounded md:hidden">
                                    Login
                                </span>
                            </a>
                            <a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors group relative flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                <span class="hidden md:inline">Registrarse</span>
                                {{-- Tooltip --}}
                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-700 text-white text-xs rounded md:hidden">
                                    Registro
                                </span>
                            </a> 
                        @else
                            {{-- Dropdown Usuario Logueado --}}
                            <div class="relative group">
                                <button class="flex items-center text-gray-300 hover:text-white focus:outline-none transition-colors">
                                    {{-- Icono Usuario --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    {{-- Nombre (oculto en pantallas pequeñas) --}}
                                    <span class="hidden md:inline max-w-[100px] truncate">{{ Auth::user()->name }}</span> 
                                    {{-- Flecha Dropdown --}}
                                    <svg class="h-5 w-5 ml-1 hidden md:inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                {{-- Contenido del Dropdown --}}
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 
                                            opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                                            transition-all duration-300 transform scale-95 group-hover:scale-100">
                                    {{-- Saludo con nombre (opcional) --}}
                                    <div class="px-4 py-2 text-sm text-gray-500 border-b">Hola, {{ Str::limit(Auth::user()->name, 15) }}!</div> 
                                    
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-colors">Mi Perfil</a>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-colors">Panel Admin</a>
                                    @endif
                                    {{-- Separador --}}
                                    <div class="border-t border-gray-100"></div> 
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:font-semibold transition-colors">Cerrar Sesión</button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
                
                {{-- Barra de búsqueda para móvil  --}}
                <div class="mt-3 sm:hidden"> 
                     <form action="{{ route('tienda.index') }}" method="GET" class="relative">
                         <input type="text" name="search" placeholder="Buscar..." 
                                class="w-full bg-blue-700 text-white placeholder-blue-300 px-4 py-2 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-blue-600 transition-colors duration-200" 
                                value="{{ request('search') }}">
                         <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-300 hover:text-white transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                         </button>
                     </form>
                </div>

            </div> {{-- Cierre container --}}
        </nav>

        <main class="flex-grow py-8">
            @yield('content')
        </main>

        <footer class="bg-gradient-to-r from-blue-800 to-blue-900 text-blue-200 py-8 mt-16"> 
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} TeraStore. Todos los derechos reservados.</p>
                {{-- Puedes añadir más enlaces aquí si quieres --}}
                {{-- <div class="mt-4 space-x-4">
                    <a href="#" class="hover:text-white">Política de Privacidad</a>
                    <a href="#" class="hover:text-white">Términos de Servicio</a>
                </div> --}}
            </div>
        </footer>

        {{-- Scripts al final --}}
        @stack('scripts') 
    </div> {{-- Cierre div#app --}}
</body>
</html>