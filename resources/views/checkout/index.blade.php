@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<h1>Checkout</h1>
<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <button type="submit" class="btn btn-success">Finalizar compra</button>
</form>
@endsection