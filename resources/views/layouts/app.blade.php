<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TeraStore')</title> {{-- Título dinámico [12] --}}
    @vite('resources/css/app.css') {{-- Para compilar los estilos de Tailwind CSS [1] --}}
</head>
<body class="bg-gray-100 font-sans antialiased">
    <header class="bg-white shadow-md p-4">
    <nav class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <img src="/images/logo.png" alt="Logo TeraStore" class="h-10 w-10 mr-3"> {{-- Cambia la ruta según tu imagen --}}
            <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">TeraStore</a>
        </div>
        <div>
            {{-- Aquí podrías poner enlaces a categorías, carrito, login/logout --}}
            @auth
                <a href="/profile" class="text-gray-600 hover:text-gray-900 mr-4">Perfil</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900">Cerrar Sesión</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login.show') }}" class="text-gray-600 hover:text-gray-900">Iniciar Sesión</a>
            @endguest
        </div>
    </nav>
</header>

    <main class="container mx-auto mt-8 p-4">
        @yield('content') {{-- Aquí se insertará el contenido específico de cada vista [12] --}}
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; {{ date('Y') }} TeraStore Todos los derechos reservados.</p>
    </footer>

    @vite('resources/js/app.js') {{-- Para compilar scripts de JS (si los tienes) --}}
</body>
</html>