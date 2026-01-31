<x-guest-layout title="Produk Digital Printing">

    {{-- Filter --}}
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Search --}}
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="border rounded px-4 py-2 focus:ring-red-500 focus:border-red-500"
            >

            {{-- Category --}}
            <select 
                name="category"
                class="border rounded px-4 py-2 focus:ring-red-500 focus:border-red-500"
            >
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option 
                        value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Button --}}
            <button 
                class="bg-red-600 hover:bg-red-700 text-white rounded px-6 py-2 font-semibold"
            >
                Filter
            </button>
        </form>
    </div>

    {{-- Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">

                {{-- Image --}}
                <img 
                    src="{{ asset('images/logo-cv.png' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="h-48 w-full object-cover rounded-t-lg"
                >

                {{-- Content --}}
                <div class="p-4">
                    <span class="text-sm text-red-600 font-semibold">
                        {{ $product->category->name }}
                    </span>

                    <h3 class="text-lg font-bold mt-1">
                        {{ $product->name }}
                    </h3>

                    <p class="text-gray-600 text-sm mt-2 line-clamp-3">
                        {{ $product->description }}
                    </p>

                    <a href="#"
                       class="block mt-4 text-center bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold">
                        Lihat Detail
                    </a>
                </div>

            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">
                Produk belum tersedia
            </p>
        @endforelse

    </div>

</x-guest-layout>
