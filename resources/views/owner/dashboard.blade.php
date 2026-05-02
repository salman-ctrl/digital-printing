@extends('layouts.owner')

@section('content')
<div class="space-y-10">
    {{-- Header Section --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight capitalize">Ikhtisar Bisnis</h1>
            <p class="text-xs text-gray-400 font-bold capitalize tracking-widest mt-2">Analitik performa CV Anugrah Murni Sejati</p>
        </div>
        <div class="flex space-x-4">
            <button class="bg-white border border-gray-100 text-gray-800 px-8 py-4 rounded-2xl text-[11px] font-black capitalize tracking-widest hover:shadow-xl transition-all">
                Cetak Laporan
            </button>
        </div>
    </div>

    {{-- 1. Laporan Penjualan (Stats Cards) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4">
                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-800 tracking-tighter">Rp{{ number_format($sales_report['total_revenue']) }}</h3>
            <div class="mt-4 flex items-center text-[10px] font-bold text-green-600 capitalize">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                Semua Waktu
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v14a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mb-1">Bulan Ini</p>
            <h3 class="text-2xl font-black text-gray-800 tracking-tighter">Rp{{ number_format($sales_report['monthly_sales']) }}</h3>
            <p class="mt-4 text-[10px] font-bold text-gray-400 capitalize tracking-widest">{{ now()->format('F Y') }}</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4">
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mb-1">Pesanan Sukses</p>
            <h3 class="text-2xl font-black text-gray-800 tracking-tighter">{{ $sales_report['total_paid'] }}</h3>
            <p class="mt-4 text-[10px] font-bold text-gray-400 capitalize tracking-widest">Transaksi Selesai</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4">
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mb-1">Menunggu Pembayaran</p>
            <h3 class="text-2xl font-black text-gray-800 tracking-tighter">{{ $sales_report['total_pending'] }}</h3>
            <p class="mt-4 text-[10px] font-bold text-gray-400 capitalize tracking-widest">Transaksi Pending</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        {{-- 2. Hasil TOPSIS (Recent Activity) --}}
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-gray-400 capitalize tracking-[0.2em]">Aktivitas Rekomendasi Pintar (TOPSIS)</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-left">
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 capitalize tracking-widest border-b border-gray-50">Pelanggan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 capitalize tracking-widest border-b border-gray-50">Produk Rekomendasi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 capitalize tracking-widest border-b border-gray-50 text-right">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($topsis_results as $res)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <p class="text-xs font-black text-gray-800 capitalize">{{ $res->user->name }}</p>
                                <p class="text-[9px] text-gray-400 font-bold capitalize">{{ \Carbon\Carbon::parse($res->calculated_at)->diffForHumans() }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs font-black text-red-600 capitalize">{{ $res->specification->product->name }}</p>
                                <p class="text-[9px] text-gray-400 font-bold capitalize truncate max-w-[150px]">{{ $res->specification->material }} • {{ $res->specification->size }}</p>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black">
                                    {{ number_format($res->preference_value, 4) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. Statistik Produk (Top Sales) --}}
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-gray-400 capitalize tracking-[0.2em]">Peringkat Produk Terlaris</h3>
            </div>
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-8">
                @foreach($product_stats as $index => $stat)
                <div class="space-y-3">
                    <div class="flex justify-between items-end">
                        <div>
                            <span class="text-[9px] font-black text-gray-300 capitalize tracking-[0.2em] block mb-1">Rank #{{ $index + 1 }}</span>
                            <h4 class="text-xs font-black text-gray-800 capitalize tracking-wider">{{ $stat->name }}</h4>
                        </div>
                        <span class="text-xs font-black text-red-600 capitalize tracking-tighter">{{ number_format($stat->total_sold) }} PCS terjual</span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        @php
                            $maxSold = $product_stats->first()->total_sold ?? 1;
                            $percentage = ($stat->total_sold / $maxSold) * 100;
                        @endphp
                        <div class="bg-red-600 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach

                @if($product_stats->isEmpty())
                    <div class="py-20 text-center">
                        <p class="text-[10px] font-black text-gray-300 capitalize tracking-[0.3em]">Belum Ada Data Penjualan</p>
                    </div>
                @endif
            </div>

            {{-- Summary Insight --}}
            <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-100">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                        💡
                    </div>
                    <div>
                        <h4 class="text-xs font-black capitalize tracking-widest">Business Insight</h4>
                        <p class="text-[10px] font-medium text-blue-100 mt-1 capitalize tracking-wider leading-relaxed">
                            Produk <strong>{{ $product_stats->first()->name ?? '...' }}</strong> merupakan kontributor pendapatan terbesar bulan ini. Pertimbangkan untuk menambah stok bahan baku terkait.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
