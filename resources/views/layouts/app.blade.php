<header class="bg-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                TeraStore
            </a>

            <div class="w-1/3">
                <form action="{{ route('tienda.index') }}" method="GET">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Buscar productos..." 
                        class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ request('search') }}"
                    >
                </form>
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('carrito.detalle') }}" class="relative text-gray-600 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Iniciar sesión</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Registrarse</a> {{-- Asegúrate de tener esta ruta --}}
                @else
                    {{-- Dropdown para usuario logueado --}}
                    <div class="relative">
                        <button class="flex items-center text-gray-600 focus:outline-none">
                            {{ Auth::user()->name }}
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        {{-- Aquí iría el menú desplegable con enlaces a 'Mi Perfil' y 'Cerrar Sesión' --}}
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>