<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TeraStore</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen bg-gray-200">
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">Admin TeraStore</a>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.productos.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">Productos</a>
                {{-- Puedes agregar más enlaces aquí en el futuro (Categorías, Pedidos, etc.) --}}
            </nav>
            <div class="p-4 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 rounded-md hover:bg-gray-700">Cerrar Sesión</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">@yield('page-title')</h1>
                <div>
                    <span>{{ Auth::user()->name }} (Admin)</span>
                </div>
            </header>
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </div>
        </main>
    </div>
    @vite('resources/js/app.js')
</body>
</html>