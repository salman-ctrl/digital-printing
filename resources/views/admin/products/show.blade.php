@extends('layouts.admin')

@section('content')
@php
    function formatRupiah($value) {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    $mainImage = $product->gambar_utama ?? null;
@endphp

<div class="space-y-8 pb-10 max-w-6xl mx-auto font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-4">

        <a href="{{ route('admin.products.index') }}"
           class="p-2 bg-[#FACC15]/20 text-[#1E3A8A] rounded-xl hover:bg-[#FACC15]/30 transition">
            ←
        </a>

        <div class="flex-1">
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                {{ $product->name }}
            </h1>

            <p class="text-sm text-slate-500 mt-1 tracking-widest">
                ID: #{{ $product->id }}
                <span class="mx-2 text-slate-300">|</span>
                {{ $product->category->nama_kategori ?? 'Umum' }}
            </p>
        </div>

        {{-- ACTION BUTTON --}}
        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="bg-[#FACC15] text-[#1E3A8A] hover:bg-yellow-400 px-5 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs font-black tracking-widest uppercase shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Edit Produk
        </a>
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- ================= LEFT: IMAGE ================= --}}
        <div class="space-y-4">

            {{-- MAIN IMAGE --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-3 shadow-sm">
                <div class="aspect-square bg-slate-50 flex items-center justify-center overflow-hidden rounded-xl">

                    @if($mainImage)
                        <img id="mainImage"
                             src="{{ asset('storage/' . $mainImage) }}"
                             class="w-full h-full object-contain transition">
                    @else
                        <div class="text-center text-slate-400">
                            📦
                            <p class="text-sm mt-2 tracking-widest">Tidak ada gambar</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- THUMBNAILS --}}
            <div class="grid grid-cols-4 gap-2">

                @if($mainImage)
                    <div onclick="changeImage(this)"
                         data-src="{{ asset('storage/' . $mainImage) }}"
                         class="aspect-square cursor-pointer border-2 border-[#FACC15] rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $mainImage) }}"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                @if(!empty($product->galeri))
                    @foreach($product->galeri as $foto)
                        <div onclick="changeImage(this)"
                             data-src="{{ $foto->url }}"
                             class="aspect-square cursor-pointer border border-slate-200 rounded-xl overflow-hidden hover:border-[#FACC15] transition">
                            <img src="{{ $foto->url }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="md:col-span-2 space-y-6">

            {{-- CARD --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">

                <h3 class="text-xs font-black text-slate-500 tracking-widest uppercase border-b pb-3">
                    Informasi Produk
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">

                    {{-- HARGA --}}
                    <div>
                        <p class="text-xs text-slate-500 tracking-widest">Harga Satuan</p>
                        <p class="text-2xl font-black text-[#1E3A8A] mt-1">
                            {{ formatRupiah($product->installation_price) }}
                        </p>
                    </div>

                    {{-- STOK --}}
                    <div>
                        <p class="text-xs text-slate-500 tracking-widest">Stok</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xl font-bold text-slate-800">
                                {{ $product->stok }}
                            </span>

                            @if($product->stok > 10)
                                <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold tracking-widest">
                                    Aman
                                </span>
                            @else
                                <span class="text-[10px] bg-red-100 text-[#EF4444] px-2 py-1 rounded-full font-bold tracking-widest">
                                    Menipis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="border-t pt-4 sm:col-span-2">
                        <p class="text-xs text-slate-500 tracking-widest">Kategori</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            {{ $product->category->nama_kategori ?? 'Umum' }}
                        </p>
                    </div>

                    {{-- UPDATED --}}
                    <div class="border-t pt-4 sm:col-span-2">
                        <p class="text-xs text-slate-500 tracking-widest">Terakhir Update</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            {{ $product->updated_at->format('d F Y H:i') }}
                        </p>
                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <p class="text-xs font-black text-slate-500 tracking-widest uppercase mb-3">
                        Deskripsi Produk
                    </p>

                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl text-sm text-slate-600 whitespace-pre-line">
                        {{ $product->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                    </div>
                </div>

            </div>

            {{-- EMPTY STATE (jika diperlukan di masa depan) --}}
            {{-- FEEDBACK STATE (loading/error bisa ditambahkan tanpa ubah struktur) --}}

        </div>
    </div>
</div>

{{-- SCRIPT GALERI --}}
<script>
    function changeImage(el) {
        const src = el.getAttribute('data-src');
        document.getElementById('mainImage').src = src;

        document.querySelectorAll('[data-src]').forEach(e => {
            e.classList.remove('border-[#FACC15]');
            e.classList.add('border', 'border-slate-200');
        });

        el.classList.add('border-[#FACC15]');
    }
</script>

@endsection