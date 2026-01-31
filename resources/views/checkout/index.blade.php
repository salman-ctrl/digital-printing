@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Checkout</h2>

@if(session('success'))
<div class="bg-green-200 text-green-800 p-4 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if($cartItems->isEmpty())
<p>Keranjang kosong.</p>
@else
<table class="w-full bg-white shadow rounded mb-4">
    <thead>
        <tr>
            <th class="p-2 border">Produk</th>
            <th class="p-2 border">Harga</th>
            <th class="p-2 border">Qty</th>
            <th class="p-2 border">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cartItems as $item)
        <tr>
            <td class="p-2 border">{{ $item->product->name }}</td>
            <td class="p-2 border">{{ $item->product->price }}</td>
            <td class="p-2 border">{{ $item->quantity }}</td>
            <td class="p-2 border">{{ $item->product->price * $item->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-semibold">
        Bayar & Checkout
    </button>
</form>
@endif

@endsection
