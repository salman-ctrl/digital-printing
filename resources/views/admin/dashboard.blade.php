@extends('layouts.admin')

@section('content')
<div class="space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#1E3A8A]">
                Dashboard Utama
            </h1>
            <p class="text-sm text-slate-500 mt-1 tracking-widest">
                Ringkasan operasional harian Anda
            </p>
        </div>
    </div>

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- USERS --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-[#FACC15]/20 text-[#1E3A8A] rounded-xl flex items-center justify-center border border-[#FACC15]/30">
                    👤
                </div>

                <span class="text-[10px] font-black text-[#1E3A8A] bg-[#FACC15]/20 px-3 py-1 rounded-full uppercase tracking-widest">
                    Users
                </span>
            </div>

            <p class="text-3xl font-black text-slate-800">
                {{ number_format($stats['total_users']) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 tracking-widest">
                Total Pelanggan
            </p>
        </div>

        {{-- PRODUCTS --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-xl flex items-center justify-center border border-[#1E3A8A]/20">
                    📦
                </div>

                <span class="text-[10px] font-black text-[#1E3A8A] bg-[#1E3A8A]/10 px-3 py-1 rounded-full uppercase tracking-widest">
                    Products
                </span>
            </div>

            <p class="text-3xl font-black text-slate-800">
                {{ number_format($stats['total_products']) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 tracking-widest">
                Total Produk
            </p>
        </div>

        {{-- CATEGORIES --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-xl flex items-center justify-center border border-[#1E3A8A]/20">
                    📂
                </div>

                <span class="text-[10px] font-black text-[#1E3A8A] bg-[#1E3A8A]/10 px-3 py-1 rounded-full uppercase tracking-widest">
                    Categories
                </span>
            </div>

            <p class="text-3xl font-black text-slate-800">
                {{ number_format($stats['total_categories']) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 tracking-widest">
                Total Kategori
            </p>
        </div>

        {{-- TRANSACTIONS --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-[#EF4444]/10 text-[#EF4444] rounded-xl flex items-center justify-center border border-[#EF4444]/20">
                    💳
                </div>

                <span class="text-[10px] font-black text-[#EF4444] bg-[#EF4444]/10 px-3 py-1 rounded-full uppercase tracking-widest">
                    Orders
                </span>
            </div>

            <p class="text-3xl font-black text-slate-800">
                {{ number_format($stats['total_transactions']) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 tracking-widest">
                Total Transaksi
            </p>
        </div>

    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="space-y-4">

        <div class="flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">
                Transaksi Terbaru
            </h3>

            <a href="#"
               class="text-xs font-black text-[#FACC15] uppercase tracking-widest hover:underline">
                Lihat Semua
            </a>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <table class="w-full">

                {{-- HEADER --}}
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left">Order ID</th>
                        <th class="px-6 py-4 text-left">Pelanggan</th>
                        <th class="px-6 py-4 text-left">Total</th>
                        <th class="px-6 py-4 text-left">Status</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($stats['recent_transactions'] as $tx)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4 text-sm text-slate-400">
                            #{{ $tx->order_code }}
                        </td>

                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $tx->user->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $tx->created_at->format('d M Y') }}
                            </p>
                        </td>

                        <td class="px-6 py-4 text-sm font-bold text-[#1E3A8A]">
                            Rp{{ number_format($tx->total_price) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                {{
                                    $tx->status === 'paid'
                                        ? 'bg-[#FACC15]/20 text-[#1E3A8A]'
                                        : 'bg-[#EF4444]/10 text-[#EF4444]'
                                }}">
                                {{ $tx->status }}
                            </span>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-16 text-slate-400 text-sm italic">
                            Belum ada transaksi terbaru
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- ================= FEEDBACK ================= --}}
    {{-- Placeholder untuk loading / error state jika nanti pakai JS --}}
</div>
@endsection