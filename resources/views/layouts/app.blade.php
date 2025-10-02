<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TeraStore')</title> 
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">
    {{-- =============================================================== --}}
    {{--                 BARRA DE NAVEGACIÓN MODIFICADA                  --}}
    {{-- =============================================================== --}}
    <header class="absolute top-0 left-0 w-full z-10 p-4"> {{-- Posición absoluta y z-index --}}
        <nav class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="/images/logo.png" alt="Logo TeraStore" class="h-10 w-10 mr-3">
                <a href="{{ route('products.index') }}" class="text-2xl font-bold text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">TeraStore</a> {{-- Texto blanco --}}
            </div>
            <div>
                @auth
                    {{-- Simplificado para mejor visibilidad --}}
                    <a href="#" class="text-white hover:text-gray-300 mr-4 font-semibold">Mi Cuenta</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-300 font-semibold">Cerrar Sesión</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-300 font-semibold">Iniciar Sesión</a>
                @endguest
            </div>
        </nav>
    </header>

    {{-- El <main> ya no necesita margen superior porque el contenido de la página lo manejará --}}
    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; {{ date('Y') }} TeraStore Todos los derechos reservados.</p>
    </footer>

    @vite('resources/js/app.js')
</body>
</html>