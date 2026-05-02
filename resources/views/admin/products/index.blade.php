@extends('layouts.admin')

@section('content')
<div class="space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-end">

        <div>
            <h1 class="text-3xl font-black capitalize tracking-tight text-[#1E3A8A]">
                Manajemen Produk
            </h1>
            <p class="text-sm text-slate-500 tracking-widest mt-1">
                Kelola daftar produk digital printing Anda
            </p>
        </div>

        {{-- ACTION BUTTON --}}
        <a href="{{ route('admin.products.create') }}"
           class="bg-[#FACC15] text-[#1E3A8A] px-6 py-3 rounded-2xl text-xs font-black tracking-widest uppercase
                  shadow-sm hover:bg-yellow-400 transition active:scale-95">
            + Tambah Produk
        </a>

    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- FILTER BAR --}}
        <div class="p-6 border-b border-slate-200 bg-slate-50 flex justify-between items-center">

            <div class="flex items-center gap-4">

                {{-- SEARCH --}}
                <div class="relative">
                    <input type="text"
                        placeholder="Cari produk..."
                        class="pl-10 pr-4 py-2.5 bg-white border border-slate-200
                               rounded-xl text-xs font-semibold text-slate-700 tracking-widest outline-none
                               focus:ring-2 focus:ring-[#FACC15]/30 w-64">

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        🔍
                    </span>
                </div>

                {{-- CATEGORY --}}
                <select class="px-4 py-2.5 bg-white border border-slate-200
                               rounded-xl text-xs font-semibold text-slate-600 tracking-widest outline-none cursor-pointer
                               focus:ring-2 focus:ring-[#FACC15]/30">
                    <option>Semua Kategori</option>
                </select>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-widest border-b">
                    <tr>
                        <th class="px-6 py-4 text-left">Produk</th>
                        <th class="px-6 py-4 text-left">Kategori</th>
                        <th class="px-6 py-4 text-left">Stok</th>
                        <th class="px-6 py-4 text-left">Harga</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y bg-white">

                    {{-- EMPTY / FEEDBACK --}}
                    @if(!isset($products) || $products->isEmpty())

                        <tr>
                            <td colspan="6" class="p-10 text-center">

                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-12 h-12 bg-[#FACC15]/20 text-[#1E3A8A] rounded-full flex items-center justify-center">
                                        📦
                                    </div>
                                    <p class="text-sm text-slate-500 font-semibold">
                                        Tidak ada produk ditemukan
                                    </p>
                                </div>

                            </td>
                        </tr>

                    @else

                        @foreach($products as $product)

                        <tr class="hover:bg-slate-50 transition group">

                            {{-- PRODUK --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden border border-slate-200">

                                        @if($product->gambar_utama || $product->image_url)
                                            <img src="{{ $product->image_url ?? $product->gambar_utama }}"
                                                class="w-full h-full object-cover"
                                                alt="{{ $product->name }}">
                                        @else
                                            <span class="text-slate-400">📦</span>
                                        @endif

                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-xs text-slate-400 font-mono">
                                            ID: {{ $product->id_produk ?? $product->id }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- KATEGORI --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $product->category->name ?? 'Umum' }}
                            </td>

                            {{-- STOK --}}
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ $product->stok ?? 0 }}
                            </td>

                            {{-- HARGA --}}
                            <td class="px-6 py-4 text-slate-600 font-semibold">
                                Rp{{ number_format($product->installation_price ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                @if(($product->stok ?? 0) > 0)
                                    <span class="px-3 py-1 rounded-full bg-[#FACC15]/20 text-[#1E3A8A] text-[10px] font-black tracking-widest uppercase">
                                        Ready
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-[10px] font-black tracking-widest uppercase">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('admin.products.show', $product->id_produk ?? $product->id) }}"
                                        class="p-2 text-slate-500 hover:text-[#1E3A8A] border border-slate-200 rounded-lg hover:bg-slate-50 transition"
                                        title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.products.edit', $product->id_produk ?? $product->id) }}"
                                        class="p-2 text-[#1E3A8A] hover:bg-[#FACC15]/20 rounded-lg transition"
                                        title="Edit Produk">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-width="2"
                                                d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.products.destroy', $product->id_produk ?? $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="p-2 text-[#EF4444] hover:bg-red-50 rounded-lg transition"
                                                title="Hapus Produk">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"/>
                                            </svg>

                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                        @endforeach

                    @endif

                </tbody>

            </table>
        </div>

        {{-- FOOTER --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-between">

            <p class="text-[10px] font-black text-slate-400 tracking-widest uppercase">
                Total: {{ $products->count() }} Produk
            </p>

        </div>

    </div>

</div>
@endsection