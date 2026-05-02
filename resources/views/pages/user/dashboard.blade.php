@extends('layouts.guest')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto space-y-10 font-[Inter] text-slate-800 pb-20">

    {{-- ================= HEADER / PROFILE ================= --}}
    <div class="bg-white border-2 border-slate-100 rounded-[40px] p-8 md:p-10 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-yellow-50/50 rounded-full -ml-16 -mb-16"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="relative">
                    <div class="w-24 h-24 rounded-[32px] bg-[#1E3A8A] flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-blue-200 ring-4 ring-blue-50">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-emerald-500 border-4 border-white rounded-2xl shadow-lg flex items-center justify-center">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800">
                        Selamat Datang, <span class="text-[#1E3A8A]">{{ explode(' ', auth()->user()->name)[0] }}</span>!
                    </h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3">
                        <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            Verified Member
                        </span>
                        <span class="text-slate-400 font-bold text-sm flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <a href="{{ route('rekomendasi') }}" class="flex-1 sm:flex-none flex items-center justify-center gap-3 px-8 py-4 bg-[#FACC15] hover:bg-yellow-400 rounded-2xl text-sm font-black text-[#1E3A8A] transition-all transform hover:scale-105 shadow-xl shadow-yellow-100">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                    SMART RECOMMENDATION
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-white border-2 border-red-50 rounded-2xl text-sm font-black text-red-500 hover:bg-red-50 transition shadow-sm">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        KELUAR
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= STATS GRID ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        
        {{-- Total Pesanan --}}
        <div class="group bg-white border-2 border-slate-100 rounded-[32px] p-8 shadow-sm hover:border-[#1E3A8A] transition-all duration-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-blue-50 text-[#1E3A8A] rounded-2xl flex items-center justify-center group-hover:bg-[#1E3A8A] group-hover:text-white transition-all duration-500">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas</p>
                    <p class="text-xs font-bold text-emerald-500 mt-0.5">Live Data</p>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalOrders }}</h3>
            <p class="text-sm text-slate-500 font-bold mt-2">Total Transaksi</p>
        </div>

        {{-- Pending --}}
        <div class="group bg-white border-2 border-slate-100 rounded-[32px] p-8 shadow-sm hover:border-[#FACC15] transition-all duration-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-yellow-50 text-[#FACC15] rounded-2xl flex items-center justify-center group-hover:bg-[#FACC15] group-hover:text-[#1E3A8A] transition-all duration-500">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</p>
                    <p class="text-xs font-bold text-yellow-600 mt-0.5">Need Pay</p>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $pendingOrders }}</h3>
            <p class="text-sm text-slate-500 font-bold mt-2">Belum Dibayar</p>
        </div>

        {{-- Success (Paid) --}}
        <div class="group bg-white border-2 border-slate-100 rounded-[32px] p-8 shadow-sm hover:border-emerald-200 transition-all duration-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</p>
                    <p class="text-[10px] font-bold text-emerald-600 mt-0.5">Success</p>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($totalSpent) }}</h3>
            <p class="text-sm text-slate-500 font-bold mt-2">Total Pengeluaran</p>
        </div>

        {{-- Keranjang --}}
        <div class="group bg-[#1E3A8A] border-4 border-blue-50 rounded-[32px] p-8 shadow-2xl shadow-blue-200 transform hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10 flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center group-hover:bg-white group-hover:text-[#1E3A8A] transition-all duration-500">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest">Basket</p>
                    <p class="text-xs font-bold text-[#FACC15] mt-0.5">Items</p>
                </div>
            </div>
            <h3 class="text-4xl font-black text-white tracking-tight relative z-10">{{ $cartCount }}</h3>
            <p class="text-sm text-white/70 font-bold mt-2 relative z-10">Dalam Keranjang</p>
        </div>

    </div>

    <div class="grid lg:grid-cols-12 gap-10 items-start">
        
        {{-- ================= RECENT ACTIVITY ================= --}}
        <div class="lg:col-span-8 space-y-8">
            <div class="flex items-end justify-between px-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 flex items-center gap-4">
                        <div class="w-2 h-8 bg-[#EF4444] rounded-full"></div>
                        Riwayat Transaksi
                    </h2>
                    <p class="text-slate-400 text-sm font-medium mt-1">Pantau status pengadaan produk Anda</p>
                </div>
                <a href="{{ route('orders.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-[#1E3A8A] hover:text-white rounded-xl text-[10px] font-black text-slate-500 uppercase tracking-widest transition-all">Lihat Semua</a>
            </div>

            <div class="bg-white border-2 border-slate-100 rounded-[40px] overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaksi</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</th>
                                <th class="px-8 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($latestOrders as $order)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-100 group-hover:text-[#1E3A8A] transition-colors">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm">#{{ $order->order_code }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusConfig = [
                                            'paid' => ['class' => 'bg-emerald-50 text-emerald-600', 'label' => 'LUNAS', 'icon' => 'check'],
                                            'pending' => ['class' => 'bg-yellow-50 text-yellow-600', 'label' => 'PENDING', 'icon' => 'clock'],
                                            'cancelled' => ['class' => 'bg-red-50 text-red-600', 'label' => 'BATAL', 'icon' => 'x'],
                                            'expired' => ['class' => 'bg-slate-100 text-slate-400', 'label' => 'EXPIRED', 'icon' => 'slash']
                                        ][$order->status] ?? ['class' => 'bg-slate-50 text-slate-500', 'label' => strtoupper($order->status), 'icon' => 'help-circle'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-[10px] font-black tracking-tighter {{ $statusConfig['class'] }}">
                                        <i data-lucide="{{ $statusConfig['icon'] }}" class="w-3 h-3"></i>
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p class="text-sm font-black text-[#1E3A8A]">Rp {{ number_format($order->total_price) }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold">Midtrans Secure</p>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="w-10 h-10 bg-slate-50 hover:bg-[#1E3A8A] hover:text-white rounded-xl transition-all inline-flex items-center justify-center shadow-sm">
                                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center gap-6">
                                        <div class="w-24 h-24 bg-slate-50 rounded-[32px] flex items-center justify-center text-slate-200">
                                            <i data-lucide="shopping-bag" class="w-12 h-12"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-black text-slate-400">Belum Ada Transaksi</p>
                                            <p class="text-sm text-slate-300 font-medium mt-1">Ayo mulai belanja kebutuhan percetakan Anda</p>
                                        </div>
                                        <a href="{{ route('products.index') }}" class="px-10 py-4 bg-[#1E3A8A] text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:scale-105 transition">Catalog Produk</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= SIDEBAR ================= --}}
        <div class="lg:col-span-4 space-y-10">
            
            <!-- {{-- Recommendations --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-3">
                        <i data-lucide="sparkles" class="w-6 h-6 text-[#FACC15]"></i>
                        Rekomendasi Untukmu
                    </h2>
                </div>

                <div class="grid gap-5">
                    @foreach($recommendedProducts as $prod)
                    <a href="{{ route('products.show', $prod->id) }}" class="group bg-white border-2 border-slate-50 rounded-[32px] p-5 flex gap-5 hover:border-[#1E3A8A] hover:shadow-2xl hover:shadow-blue-100/50 transition-all duration-500">
                        <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-50 relative">
                             <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <img src="{{ $prod->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" crossorigin="anonymous">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-[9px] font-black text-[#EF4444] uppercase tracking-widest mb-1">{{ $prod->category->name }}</span>
                            <h4 class="text-sm font-black text-slate-800 line-clamp-1 group-hover:text-[#1E3A8A] transition-colors uppercase tracking-tight">{{ $prod->name }}</h4>
                            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Mulai Dari</p>
                            <p class="text-sm font-black text-[#1E3A8A]">Rp {{ number_format($prod->harga) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div> -->

            {{-- Support Card --}}
            <div class="bg-[#1E3A8A] rounded-[48px] p-10 text-white relative overflow-hidden shadow-2xl shadow-blue-200 group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#FACC15]/10 rounded-full -mr-32 -mt-32 group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-red-500/10 rounded-full -ml-16 -mb-16"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-8 border border-white/10">
                        <i data-lucide="help-circle" class="w-7 h-7 text-[#FACC15]"></i>
                    </div>
                    <h3 class="text-2xl font-black leading-tight tracking-tight">Butuh Bantuan<br>Cetak?</h3>
                    <p class="text-sm text-white/60 mt-4 leading-relaxed font-medium">Tim ahli kami siap membantu Anda 24/7 untuk hasil cetak maksimal.</p>
                    
                    <a href="https://wa.me/6282184732885" target="_blank" class="flex items-center justify-center gap-3 mt-10 bg-[#FACC15] text-[#1E3A8A] w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-black/20 hover:bg-white transition-all transform active:scale-95">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                        HUBUNGI ADMIN
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white border-2 border-slate-100 rounded-[40px] p-8 shadow-sm">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 border-b border-slate-50 pb-4">Menu Pintar</h4>
                <div class="space-y-4">
                    <a href="{{ route('cart.index') }}" class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-transparent hover:border-[#1E3A8A] hover:bg-white transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 group-hover:text-[#1E3A8A] shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-[#1E3A8A]">Keranjang</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-transparent hover:border-[#1E3A8A] hover:bg-white transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 group-hover:text-[#1E3A8A] shadow-sm">
                                <i data-lucide="grid" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-[#1E3A8A]">Katalog</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
