@extends('layouts.guest')

@section('content')

<div class="w-full space-y-14 font-sans text-slate-800">

    {{-- ================= HEADER ================= --}}
    <section class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">

            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[#FACC15]">
                    Katalog Digital Printing
                </p>

                <h1 class="text-3xl md:text-5xl font-black text-[#1E3A8A] tracking-tight leading-tight">
                    Produk <span class="text-[#FACC15]">Unggulan</span>
                </h1>

                <p class="text-sm text-slate-500 mt-2 max-w-xl leading-relaxed">
                    Temukan produk digital printing berkualitas tinggi dengan harga terbaik dan proses cepat.
                </p>
            </div>

            {{-- QUICK INFO --}}
            <div class="hidden md:flex gap-4">

                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400">Total Produk</p>
                    <p class="text-lg font-black text-[#1E3A8A]">{{ $products->total() ?? 0 }}</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400">Kategori</p>
                    <p class="text-lg font-black text-[#EF4444]">{{ $products->total() ?? 0 }}</p>
                    @if(isset($selectedCategory))
                        <p class="text-sm text-slate-500">Kategori: {{ $selectedCategory->name }}</p>
                    @endif
                </div>

            </div>

        </div>

    </section>

    {{-- ================= ACTION BAR ================= --}}
    <section class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">

        <div class="relative flex-1">

            <input type="text"
                   id="search-input"
                   value="{{ request('search') }}"
                   placeholder="Cari produk..."
                   onkeyup="handleSearch(event)"
                   class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-200
                          focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                          outline-none transition shadow-sm">

            <i data-lucide="search"
               class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

        </div>

        <button onclick="applyFilters()"
                class="px-8 py-4 bg-[#1E3A8A] text-white rounded-2xl
                       text-[10px] font-black uppercase tracking-widest
                       hover:bg-[#FACC15] hover:text-[#1E3A8A]
                       transition shadow-sm flex items-center gap-2 justify-center">

            <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
            Filter

        </button>

    </section>

    {{-- ================= CATEGORY (SLIDER VERSION) ================= --}}
<section class="space-y-8 font-sans text-slate-800 bg-gradient-to-b from-slate-50 via-white to-slate-100 px-3 py-6 rounded-2xl">

    {{-- HEADER --}}
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

    {{-- CONTENT --}}
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

        {{-- SLIDER --}}
        <div class="p-6">

            <div class="relative group">

                {{-- LEFT --}}
                <button onclick="scrollCategory(-1)"
                        class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-10
                               bg-white border border-slate-200 shadow-md
                               w-10 h-10 rounded-full items-center justify-center
                               hover:bg-[#FACC15] transition">
                    ‹
                </button>

                {{-- SCROLL --}}
                <div id="categorySlider"
                     class="flex gap-5 overflow-x-auto scroll-smooth px-2 py-2 no-scrollbar">

                    {{-- ALL CATEGORY --}}
                    <a href="{{ route('products.index') }}"
                       data-category-id="all"
                       class="flex-shrink-0 w-44 p-5 rounded-2xl border transition block text-center
                              {{ !isset($selectedCategory) ? 'border-[#FACC15] bg-[#FACC15]/10' : 'border-slate-200 bg-white' }}">

                        <div class="w-16 h-16 mx-auto rounded-xl overflow-hidden bg-slate-100 flex items-center justify-center">
                            <i data-lucide="layout-grid" class="w-7 h-7 text-[#1E3A8A]"></i>
                        </div>

                        <p class="text-[11px] font-black mt-3 uppercase tracking-widest text-slate-700">
                            Semua
                        </p>

                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full
                                     text-[10px] font-bold uppercase tracking-widest
                                     bg-[#1E3A8A] text-white">
                            {{ $categories->sum('products_count') ?? 0 }} Produk
                        </span>

                    </a>

                    {{-- CATEGORY LIST --}}
                    @foreach ($categories as $cat)

                        @php
                            $active = isset($selectedCategory) && $selectedCategory->id == $cat->id;
                        @endphp

                        <a href="{{ route('products.byCategory', $cat->id) }}"
                           data-category-id="{{ $cat->id }}"
                           class="flex-shrink-0 w-44 p-5 rounded-2xl border transition block text-center
                                  hover:border-[#FACC15]/60 hover:shadow-md
                                  {{ $active ? 'border-[#FACC15] bg-[#FACC15]/10' : 'border-slate-200 bg-white' }}">

                            {{-- IMAGE --}}
                            <div class="w-16 h-16 mx-auto rounded-xl overflow-hidden bg-slate-100">
                                <img src="{{ $cat->image_url }}" class="w-full h-full object-cover">
                            </div>

                            {{-- NAME --}}
                            <p class="text-[11px] font-black mt-3 uppercase tracking-widest
                                      {{ $active ? 'text-[#1E3A8A]' : 'text-slate-700' }}">
                                {{ $cat->name }}
                            </p>

                            {{-- COUNT --}}
                            <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full
                                         text-[10px] font-bold uppercase tracking-widest
                                         {{ $active ? 'bg-[#1E3A8A] text-white' : 'bg-[#1E3A8A] text-white' }}">
                                {{ $cat->products_count }} Produk
                            </span>

                        </a>

                    @endforeach

                </div>

                {{-- RIGHT --}}
                <button onclick="scrollCategory(1)"
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

    {{-- AUTO SCROLL TO ACTIVE CATEGORY --}}
    @if(isset($selectedCategory))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.getElementById("categorySlider");
            const activeId = "{{ $selectedCategory->id }}";

            const activeCard = document.querySelector(`[data-category-id="${activeId}"]`);

            if (slider && activeCard) {
                slider.scrollTo({
                    left: activeCard.offsetLeft - 50,
                    behavior: "smooth"
                });
            }
        });
    </script>
    @endif


    {{-- ================= PRODUCTS ================= --}}

    <section class="space-y-6 relative">

        @if(isset($category) && $category)
            <h2 class="text-xl font-bold text-[#1E3A8A] mb-4">
                Produk Kategori: {{ $category->name }}
            </h2>
        @endif

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-black uppercase tracking-widest text-slate-500">
                Produk Tersedia
            </h2>

            <p class="text-[10px] text-slate-400 uppercase tracking-widest">
                Klik untuk detail
            </p>
        </div>

        {{-- LOADER --}}
        <div id="grid-loader"
            class="hidden absolute inset-0 bg-white/70 backdrop-blur flex items-center justify-center z-20 rounded-2xl">

            <div class="w-10 h-10 border-4 border-[#FACC15] border-t-transparent rounded-full animate-spin"></div>

        </div>

        {{-- GRID --}}
        <div id="products-list"
            class="grid
                    grid-cols-2
                    sm:grid-cols-2
                    md:grid-cols-3
                    lg:grid-cols-4
                    xl:grid-cols-5
                    gap-4 sm:gap-5 lg:gap-6">

            @include('pages.products.product_grid', ['products' => $products])

        </div>

    </section>

    {{-- ================= LOAD MORE ================= --}}
    <div class="flex justify-center">

        <button id="btn-load-more"
                onclick="loadMoreProducts()"
                class="px-10 py-4 rounded-2xl border border-slate-200
                       text-[10px] font-black uppercase tracking-widest
                       hover:bg-[#1E3A8A] hover:text-white
                       transition shadow-sm flex items-center gap-2">

            <i data-lucide="chevron-down" class="w-4 h-4"></i>
            Load More

        </button>

    </div>

</div>

<script>
function scrollCategory(direction) {
    const el = document.getElementById('categorySlider');
    el.scrollBy({ left: direction * 250, behavior: 'smooth' });
}
</script>

<script>
    let searchTimeout;

    function handleSearch(event) {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 400); // delay biar tidak spam request
    }

    function applyFilters(page = 1) {
        const search = document.getElementById('search-input').value;

        const url = new URL(window.location.href);
        url.searchParams.set("search", search);
        url.searchParams.set("page", page);

        fetch(url.toString(), {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById("products-list").innerHTML = html;

            if (typeof lucide !== "undefined") {
                lucide.createIcons();
            }
        })
        .catch(err => console.log(err));
    }
</script>
@endsection