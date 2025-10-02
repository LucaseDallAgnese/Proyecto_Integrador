<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TeraStore</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold">TeraStore</div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.productos.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">Productos</a>
                </nav>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title')</h1>
                <div>
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="ml-4 text-red-500 hover:text-red-700">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </header>
            <div class="p-6 flex-1 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>