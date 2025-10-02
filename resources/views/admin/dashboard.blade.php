@extends('layouts.admin')

@section('title', 'Panel de Administración')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-600">Usuarios Registrados</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $usersCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-600">Productos Totales</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $productsCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-600">Órdenes Realizadas</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ordersCount }}</p>
    </div>
</div>

<div class="mt-8 bg-white p-6 rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Últimas 5 Órdenes</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID Orden</th>
                    <th class="py-2 px-4 border-b">Usuario</th>
                    <th class="py-2 px-4 border-b">Total</th>
                    <th class="py-2 px-4 border-b">Fecha</th>
                    <th class="py-2 px-4 border-b">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestOrders as $order)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b text-center">{{ $order->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->user->name }}</td>
                        <td class="py-2 px-4 border-b text-right">${{ number_format($order->total, 2) }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->status == 'completed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">No hay órdenes recientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection