@extends('layouts.app')
@section('title', 'Compra exitosa')
@section('content')
<h1>¡Compra exitosa!</h1>
<p>Tu transacción: {{ $transaccion }}</p>
<a href="{{ route('home') }}">Volver al inicio</a>
@endsection