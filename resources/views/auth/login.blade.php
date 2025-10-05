@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4">Iniciar sesión</h2>
    <form method="POST" action="{{ route('login.process') }}">
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
            ¿Olvidaste tu contraseña?
        </a>
        @csrf
        <div class="mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password">Contraseña</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
</div>
@endsection