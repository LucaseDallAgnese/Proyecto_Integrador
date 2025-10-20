<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TeraStore')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@stack('scripts')
<body class="bg-gray-100 font-sans antialiased">
    
    <div class="bg-blue-800 text-white shadow-md">
        {{-- Cabecera Principal --}}
        <header class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="text-3xl font-bold">TeraStore</a>

                {{-- Barra de búsqueda central --}}
                <div class="flex-grow max-w-xl mx-8">
                    <form action="{{ route('tienda.index') }}" method="GET" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Buscar productos..." 
                            class="w-full bg-blue-700 text-white placeholder-blue-300 px-5 py-2 pr-10 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ request('search') }}"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-300 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Links de usuario (Iniciar Sesión / Registrarse / Dropdown) y Carrito --}}
                <div class="flex items-center space-x-6">
                    <a href="{{ route('carrito.detalle') }}" class="relative hover:text-blue-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{-- Contador de items en el carrito --}}
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-200 transition-colors">Registrarse</a> 
                    @else
                        {{-- Dropdown para usuario logueado --}}
                        <div class="relative group">
                            <button class="flex items-center hover:text-blue-200 focus:outline-none">
                                <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Panel Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </header>
    </div>

    {{-- Contenido Principal --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-blue-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} TeraStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>