{{-- HERO SECTION --}}
<section class="bg-gradient-to-r from-red-600 to-yellow-500 text-white py-20">
    <div class="container mx-auto text-center px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Sistem Pemesanan Digital Printing
        </h1>
        <p class="text-lg md:text-xl mb-6 max-w-2xl mx-auto">
            Pesan produk digital printing secara online dengan rekomendasi
            spesifikasi terbaik menggunakan sistem pendukung keputusan.
        </p>

        @guest
        <a href="{{ route('register') }}"
           class="bg-white text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Mulai Pemesanan
        </a>
        @endguest
    </div>
</section>