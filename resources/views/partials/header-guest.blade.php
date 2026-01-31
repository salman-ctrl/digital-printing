<header class="bg-white shadow border-b-4 border-yellow-500">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-cv.png') }}" class="h-10">
            <div>
                <h1 class="font-bold">CV Anugrah Murni Sejati</h1>
                <p class="text-xs text-gray-500">Digital Printing</p>
            </div>
        </div>

        <nav class="space-x-4 font-semibold">
            <a href="/" class="hover:text-red-600">Beranda</a>
            <a href="/produk" class="hover:text-red-600">Produk</a>
            <a href="{{ route('login') }}" class="bg-red-600 text-white px-4 py-2 rounded">Login</a>
        </nav>
    </div>
</header>
