@forelse ($products as $product)

<div class="group relative bg-white border border-slate-200 rounded-xl
            overflow-hidden flex flex-col
            transition-all duration-300
            hover:-translate-y-1 hover:shadow-lg hover:border-[#FACC15]/60
            h-full">

    {{-- GLOW EFFECT --}}
    <div class="absolute inset-0 opacity-0 group-hover:opacity-100
                bg-gradient-to-br from-[#FACC15]/10 via-transparent to-[#1E3A8A]/5 transition"></div>

    {{-- IMAGE --}}
    <div class="relative w-full aspect-[4/3] bg-slate-50 overflow-hidden flex items-center justify-center">

        {{-- background blur placeholder (biar tidak kosong) --}}
        <div class="absolute inset-0 bg-slate-100"></div>

        <img src="{{ $product->image_url }}"
            class="relative max-h-full max-w-full object-contain p-2 transition duration-500 group-hover:scale-105"
            alt="{{ $product->name }}">

        {{-- CATEGORY BADGE --}}
        <div class="absolute top-2 left-2
                    bg-[#1E3A8A]/90 backdrop-blur-md
                    text-white
                    px-2 py-1 rounded-full
                    text-[10px] font-black capitalize tracking-widest
                    shadow-sm border border-white/10
                    flex items-center gap-1">

            <span class="w-1 h-1 bg-[#FACC15] rounded-full"></span>
            {{ $product->category->name }}

        </div>

    </div>

    {{-- BODY (lebih compact sedikit juga biar seimbang) --}}
    <div class="relative p-3 flex flex-col flex-1">

        {{-- TITLE --}}
        <h3 class="text-xs font-bold text-slate-800 mb-1 line-clamp-1
                   group-hover:text-[#1E3A8A] transition">
            {{ $product->name }}
        </h3>

        {{-- DESCRIPTION --}}
        <p class="text-[11px] text-slate-500 line-clamp-2 mb-3 leading-snug">
            {{ $product->description ?? 'Produk berkualitas tinggi dengan hasil profesional.' }}
        </p>

        {{-- FOOTER --}}
        <div class="mt-auto flex items-center justify-between">

            {{-- PRICE --}}
            <div>
                <p class="text-[8px] text-slate-400 uppercase tracking-widest">
                    Mulai dari
                </p>
                <p class="text-sm font-black text-[#EF4444]">
                    Rp {{ number_format($product->specifications->min('harga') ?? 0) }}
                </p>
            </div>

            {{-- BUTTON --}}
            <a href="{{ route('products.show', $product->id) }}"
               class="w-9 h-9 flex items-center justify-center
                      bg-gradient-to-r from-[#FACC15] to-yellow-300
                      text-[#1E3A8A]
                      rounded-lg
                      hover:from-yellow-300 hover:to-[#FACC15]
                      hover:scale-105 active:scale-95
                      transition-all duration-300 shadow-sm hover:shadow-md group">

                <i data-lucide="arrow-right"
                   class="w-4 h-4 transition-all duration-300 group-hover:translate-x-1 group-hover:scale-110">
                </i>

            </a>

        </div>

    </div>

</div>

@empty

<div class="col-span-full py-32 text-center">
    <div class="text-6xl mb-8">🔍</div>
    <h3 class="text-xl font-black text-gray-800 capitalize tracking-tighter">
        Produk Tidak Ditemukan
    </h3>
    <p class="text-gray-500 mt-2">
        Coba pilih kategori lain atau gunakan kata kunci pencarian berbeda.
    </p>
</div>

@endforelse