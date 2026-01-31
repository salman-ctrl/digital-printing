@extends('layouts.guest')

@section('hero')
<section class="bg-gradient-to-r from-red-600 to-yellow-500 text-white py-20">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">
            Sistem Pemesanan Digital Printing
        </h1>
        <p class="mb-6">
            Rekomendasi spesifikasi terbaik menggunakan metode TOPSIS
        </p>
        <a href="{{ route('register') }}" class="bg-white text-red-600 px-6 py-3 rounded font-semibold">
            Mulai Sekarang
        </a>
    </div>
</section>
@endsection

@section('content')
<h2 class="text-2xl font-bold mb-6">Produk Unggulan</h2>
{{-- preview produk --}}
@endsection
