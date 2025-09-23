@extends('layouts.app')

@section('title', 'TeraStore - Tienda de Componentes de PC')

@section('content')

<div class="bg-white">
  {{-- Sección de Productos Destacados --}}
  <main class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Productos Destacados</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
      @for ($i = 0; $i < 10; $i++)
      <div class="bg-white border border-gray-200 rounded-lg overflow-hidden flex flex-col items-center">
        <div class="w-full h-32 md:h-40 bg-gray-100 flex items-center justify-center">
          {{-- Placeholder para la imagen --}}
          <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div class="p-2 w-full text-center">
          <p class="text-sm font-medium text-gray-800">Nombre y Especificación</p>
          <div class="flex items-center justify-center mt-1 text-base font-semibold text-gray-900">
            <span>Precio</span>
            <button class="ml-2 text-blue-600 hover:text-blue-800 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
          </div>
        </div>
      </div>
      @endfor
    </div>
  </main>
</div>

@endsection