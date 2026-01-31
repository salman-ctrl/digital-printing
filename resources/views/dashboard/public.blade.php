<x-guest-layout>
    {{-- Banner --}}
    <div class="mb-8 bg-red-600 text-white rounded-xl shadow p-8 text-center">
        <h1 class="text-4xl font-bold mb-2">Selamat Datang di CV Anugrah Mandiri</h1>
        <p class="text-lg">Sistem Digital Printing Modern dan Lengkap</p>
    </div>

    {{-- Kategori Produk --}}
    <h2 class="text-2xl font-bold mb-4">Kategori Produk</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @foreach($categories as $category)
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="font-semibold text-lg">{{ $category->name }}</h3>
            <a href="#" class="text-red-600 hover:underline mt-2 block">Lihat Produk</a>
        </div>
        @endforeach
    </div>

    {{-- Statistik --}}
    <h2 class="text-2xl font-bold mb-4">Statistik</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-xl p-6 text-center">
            <p class="text-gray-500">Total Produk</p>
            <h2 class="text-2xl font-bold">{{ $totalProducts ?? 0 }}</h2>
        </div>
        <div class="bg-white shadow rounded-xl p-6 text-center">
            <p class="text-gray-500">Total Kategori</p>
            <h2 class="text-2xl font-bold">{{ $totalCategories ?? 0 }}</h2>
        </div>
        <div class="bg-white shadow rounded-xl p-6 text-center">
            <p class="text-gray-500">Total Pesanan</p>
            <h2 class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</h2>
        </div>
    </div>

    {{-- CTA Checkout --}}
    <div class="text-center mt-8">
        <p class="mb-4">Untuk melakukan checkout produk, silakan pilih produk dan klik tombol checkout.</p>

        @guest
        <a href="{{ route('login') }}" 
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold">
            Login untuk Checkout
        </a>
        @else
        <a href="{{ route('checkout') }}" 
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold">
            Checkout Sekarang
        </a>
        @endguest
    </div>
</x-guest-layout>
