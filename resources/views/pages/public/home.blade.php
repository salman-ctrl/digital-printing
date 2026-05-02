@extends('layouts.guest')

@section('content')

<div class="w-full space-y-16 font-sans text-slate-800">

    {{-- ================= HEADER / HERO ================= --}}
    <section class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-sm p-10 md:p-14 flex flex-col md:flex-row items-center justify-between gap-10 font-sans">

        {{-- BACKGROUND GRADIENT (lebih clean & premium) --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#1E3A8A] via-[#1E3A8A]/90 to-[#EF4444]/90"></div>

        {{-- SOFT OVERLAY --}}
        <div class="absolute inset-0 bg-white/5 backdrop-blur-[1px]"></div>

        {{-- LIGHT ACCENT --}}
        <div class="absolute top-0 right-0 w-72 h-72 bg-[#FACC15]/20 blur-3xl"></div>

        {{-- ================= LEFT CONTENT ================= --}}
        <div class="relative z-10 max-w-xl text-white">

            {{-- LABEL --}}
            <p class="text-xs font-black uppercase tracking-widest text-[#FACC15] mb-3">
                Digital Printing Profesional
            </p>

            {{-- TITLE --}}
            <h1 class="text-3xl md:text-5xl font-black leading-tight tracking-tight">
                MURNI DIGITAL PRINTING
            </h1>

            {{-- DESC --}}
            <p class="text-sm text-white/80 mt-4 leading-relaxed">
                Solusi cetak berkualitas tinggi dengan sistem rekomendasi pintar berbasis TOPSIS.
                Praktis, efisien, dan profesional.
            </p>

            {{-- ACTION BUTTON --}}
            <div class="mt-6 flex gap-3">

                <a href="{{ route('products.index') }}"
                class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-2xl text-xs font-black uppercase tracking-widest
                        hover:bg-yellow-400 transition shadow-sm">
                    Mulai Pesan
                </a>

                <a href="{{ url('/rekomendasi') }}"
                class="px-6 py-3 border border-white/30 text-white rounded-2xl text-xs font-black uppercase tracking-widest
                        hover:bg-white/10 transition backdrop-blur-sm">
                    Rekomendasi Pintar
                </a>

            </div>
        </div>

        ]{{-- ================= RIGHT (FLYER STYLE IMAGE ONLY) ================= --}}
        <div class="relative z-10 w-56 md:w-72">

            <div class="group transition-all duration-500 ease-out transform hover:rotate-2 hover:-translate-y-2 hover:scale-105">

                <img src="{{ asset('images/logo-cv.png') }}"
                    class="w-full object-contain drop-shadow-2xl
                        rotate-[-6deg]
                        transition-all duration-500
                        group-hover:rotate-[-2deg]">
            </div>

        </div>

    </section>


    {{-- ================= KATEGORI (SLIDER VERSION) ================= --}}
    <section class="space-y-8 font-sans text-slate-800 bg-gradient-to-b from-slate-50 via-white to-slate-100 px-3 py-6 rounded-2xl">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            <div>
                <h2 class="text-2xl md:text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                    Kategori Produk
                </h2>
                <p class="text-sm text-slate-500 mt-1 tracking-widest">
                    Pilih kategori sesuai kebutuhan cetak Anda
                </p>
            </div>

            <a href="{{ route('products.index') }}"
            class="inline-flex items-center justify-center
                    bg-[#FACC15] text-[#1E3A8A]
                    px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest
                    hover:bg-yellow-400 hover:shadow-md
                    transition-all duration-300 w-fit">
                Lihat Semua
            </a>

        </div>

        {{-- ================= CONTENT ================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- CONTENT HEADER --}}
            <div class="p-5 border-b border-slate-200 bg-slate-50">
                <h3 class="text-xs font-black uppercase tracking-widest text-slate-500">
                    Daftar Kategori
                </h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest">
                    Geser untuk melihat semua kategori
                </p>
            </div>

            {{-- SLIDER CONTENT --}}
            <div class="p-6">

                <div class="relative group">

                    {{-- LEFT --}}
                    <button onclick="scrollHomeCategory(-1)"
                            class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-10
                                bg-white border border-slate-200 shadow-md
                                w-10 h-10 rounded-full items-center justify-center
                                hover:bg-[#FACC15] transition">
                        ‹
                    </button>

                    {{-- SCROLL --}}
                    <div id="homeCategorySlider"
                        class="flex gap-5 overflow-x-auto scroll-smooth px-2 py-2 no-scrollbar">

                        @forelse ($categories as $category)

                            <a href="{{ route('products.byCategory', $category->id) }}"
                            class="flex-shrink-0 w-44 p-5 rounded-2xl border border-slate-200 bg-white
                                    transition block text-center
                                    hover:border-[#FACC15]/60 hover:shadow-md">

                                <div class="w-16 h-16 mx-auto rounded-xl overflow-hidden bg-slate-100">
                                    <img src="{{ $category->image_url }}" class="w-full h-full object-cover" crossorigin="anonymous">
                                </div>

                                <p class="text-[11px] font-black mt-3 uppercase tracking-widest text-slate-700">
                                    {{ $category->name }}
                                </p>

                                <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full
                                            text-[10px] font-bold uppercase tracking-widest
                                            bg-[#1E3A8A] text-white">
                                    {{ $category->products_count }} Produk
                                </span>

                            </a>

                        @empty

                            <div class="w-full flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-4">
                                    📦
                                </div>

                                <h4 class="text-sm font-semibold text-slate-600 uppercase tracking-widest">
                                    Belum ada kategori tersedia
                                </h4>

                                <p class="text-xs text-slate-400 mt-1">
                                    Data kategori akan muncul di sini setelah ditambahkan
                                </p>
                            </div>

                        @endforelse

                    </div>

                    {{-- RIGHT --}}
                    <button onclick="scrollHomeCategory(1)"
                            class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-10
                                bg-white border border-slate-200 shadow-md
                                w-10 h-10 rounded-full items-center justify-center
                                hover:bg-[#FACC15] transition">
                        ›
                    </button>

                </div>

            </div>

        </div>

    </section>

{{-- SCRIPT SLIDER --}}
<script>
    function scrollHomeCategory(direction) {
        const slider = document.getElementById("homeCategorySlider");
        const scrollAmount = 300;
        slider.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
    }
</script>

    {{-- ================= PRODUK TERLARIS ================= --}}
    <section class="space-y-6 relative">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-2 md:gap-4">

            <div>
                <h2 class="text-xl md:text-2xl font-black text-[#1E3A8A] tracking-tight capitalize">
                    Produk Terlaris
                </h2>
                <p class="text-sm text-slate-500 mt-1 tracking-widest">
                    Produk yang paling sering dipesan pelanggan
                </p>
            </div>

        </div>

        {{-- CONTENT --}}
        @if ($featuredProducts->count())

            <div class="grid grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-6 w-full">

                @foreach ($featuredProducts as $product)

                    {{-- CARD (DISAMAKAN DENGAN PRODUK TERSEDIA) --}}
                    <div class="group relative bg-white border border-slate-200 rounded-xl
                                overflow-hidden flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1 hover:shadow-lg hover:border-[#FACC15]/60
                                h-full">

                        {{-- GLOW --}}
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100
                                    bg-gradient-to-br from-[#FACC15]/10 via-transparent to-[#1E3A8A]/5 transition"></div>

                        {{-- IMAGE --}}
                        <div class="relative w-full aspect-[4/3] bg-slate-50 overflow-hidden flex items-center justify-center">

                            <div class="absolute inset-0 bg-slate-100"></div>

                            <img src="{{ $product->image_url }}"
                                class="relative max-h-full max-w-full object-contain p-2
                                    transition duration-500 group-hover:scale-105"
                                alt="{{ $product->name }}" crossorigin="anonymous">

                            {{-- CATEGORY --}}
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

                        {{-- BODY --}}
                        <div class="relative p-3 flex flex-col flex-1">

                            <h3 class="text-xs font-bold text-slate-800 mb-1 line-clamp-1
                                    group-hover:text-[#1E3A8A] transition">
                                {{ $product->name }}
                            </h3>

                            <p class="text-[11px] text-slate-500 line-clamp-2 mb-3 leading-snug">
                                {{ $product->description ?? 'Produk berkualitas tinggi dengan hasil profesional.' }}
                            </p>

                            <div class="mt-auto flex items-center justify-between">

                                <div>
                                    <p class="text-[8px] text-slate-400 uppercase tracking-widest">
                                        Mulai dari
                                    </p>
                                    <p class="text-sm font-black text-[#EF4444]">
                                        Rp {{ number_format($product->specifications->min('harga') ?? 0) }}
                                    </p>
                                </div>

                                <a href="{{ route('products.show', $product->id) }}"
                                class="w-9 h-9 flex items-center justify-center
                                        bg-gradient-to-r from-[#FACC15] to-yellow-300
                                        text-[#1E3A8A]
                                        rounded-lg
                                        hover:from-yellow-300 hover:to-[#FACC15]
                                        hover:scale-105 active:scale-95
                                        transition-all duration-300 shadow-sm hover:shadow-md group">

                                    <i data-lucide="arrow-right"
                                    class="w-4 h-4 transition-all duration-300
                                            group-hover:translate-x-1 group-hover:scale-110">
                                    </i>

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">
                <p class="text-sm text-slate-400 uppercase tracking-widest font-semibold">
                    Produk terlaris belum tersedia
                </p>
            </div>

        @endif

    </section>


    {{-- ================= VALUE ================= --}}
    <section class="grid md:grid-cols-4 gap-5">

        @foreach ([
            ['icon'=>'🏷️','title'=>'Harga Terjangkau','desc'=>'Kompetitif'],
            ['icon'=>'🛡️','title'=>'Kualitas Terjamin','desc'=>'Profesional'],
            ['icon'=>'⚡','title'=>'Proses Cepat','desc'=>'Efisien'],
            ['icon'=>'🔒','title'=>'Transaksi Aman','desc'=>'Terpercaya'],
        ] as $item)

        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex items-center gap-4">

            <div class="text-2xl">{{ $item['icon'] }}</div>

            <div>
                <p class="text-sm font-semibold text-slate-800">
                    {{ $item['title'] }}
                </p>
                <p class="text-[10px] text-slate-400">
                    {{ $item['desc'] }}
                </p>
            </div>

        </div>

        @endforeach

    </section>


    {{-- ================= CTA ================= --}}
    <section class="bg-[#1E3A8A] rounded-2xl p-10 text-center text-white">

        <h2 class="text-2xl font-black mb-3">
            Butuh Rekomendasi Cetak?
        </h2>

        <p class="text-sm text-slate-200 mb-6">
            Gunakan sistem rekomendasi pintar untuk hasil terbaik sesuai kebutuhan Anda.
        </p>

        @guest
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#EAB308] transition">
                Daftar Sekarang
            </a>
        @else
            <a href="{{ url('/rekomendasi') }}"
               class="px-6 py-3 bg-white text-[#1E3A8A] rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-100 transition">
                Mulai Rekomendasi
            </a>
        @endguest

    </section>

</div>

@endsection