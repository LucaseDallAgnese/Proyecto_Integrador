<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TeraStore')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <header class="absolute top-0 left-0 w-full z-10 p-4">
        <nav class="container mx-auto flex justify-between items-center">
            {{-- Logo y Nombre de la tienda --}}
            <div class="flex items-center">
                <img src="/images/logo.png" alt="Logo TeraStore" class="h-10 w-10 mr-3">
                <a href="{{ route('products.index') }}" class="text-2xl font-bold text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">TeraStore</a>
            </div>

            {{--menu de navegacion (roles)--}}
            <div>
                @auth
                    {{-- SI EL USUARIO ES ADMIN, MUESTRA ESTOS ENLACES --}}
                    @if(Auth::user()->rol === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300 mr-4 font-semibold">Dashboard</a>
                        <a href="{{ route('admin.productos.index') }}" class="text-white hover:text-gray-300 mr-4 font-semibold">Gestionar Productos</a>

                    {{-- SI ES CUALQUIER OTRO USUARIO, MUESTRA ESTOS OTROS --}}
                    @else
                        <a href="#" class="text-white hover:text-gray-300 mr-4 font-semibold">Mi Perfil</a>
                        <a href="{{ route('cart.index') }}" class="text-white hover:text-gray-300 mr-4 font-semibold">Carrito</a>
                    @endif

                    {{-- El botón de Cerrar Sesión es para TODOS los usuarios logueados --}}
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-300 font-semibold">Cerrar Sesión</button>
                    </form>

                @elseguest
                    {{-- SI NADIE HA INICIADO SESIÓN, MUESTRA ESTO --}}
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-300 font-semibold">Iniciar Sesión</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; {{ date('Y') }} TeraStore Todos los derechos reservados.</p>
    </footer>

    @vite('resources/js/app.js')
</body>
</html>