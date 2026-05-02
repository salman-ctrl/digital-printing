@extends('layouts.guest')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 font-[Inter] text-slate-800 pb-20">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.dashboard') }}"
               class="p-3 bg-white border-2 border-slate-100 rounded-2xl hover:bg-slate-50 transition text-slate-400">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Detail Pesanan</h1>
                <p class="text-[10px] font-black text-[#1E3A8A] uppercase tracking-[0.2em] mt-1">
                    Invoice: #{{ $order->order_code }}
                </p>
            </div>
        </div>

        @if($order->status === 'pending')
        <div class="flex items-center gap-3">
             <button onclick="snap.pay('{{ $order->snap_token }}')" 
                     class="px-8 py-4 bg-[#FACC15] text-[#1E3A8A] rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition shadow-xl shadow-yellow-100 flex items-center gap-3">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                BAYAR SEKARANG
            </button>
        </div>
        @endif
    </div>

    <div class="grid lg:grid-cols-12 gap-10 items-start">
        
        {{-- ================= LEFT: ITEMS & INFO ================= --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- STATUS TRACKER (PREMIUM LOOK) --}}
            <div class="bg-white border-2 border-slate-100 rounded-[40px] p-8 md:p-10 shadow-sm relative overflow-hidden">
                <div class="relative z-10 flex justify-between items-center mb-10">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Status Pesanan</h3>
                    <span class="px-4 py-1.5 bg-blue-50 text-[#1E3A8A] rounded-full text-[10px] font-black uppercase tracking-widest">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="relative flex justify-between">
                    {{-- Progress Line --}}
                    <div class="absolute top-5 left-0 w-full h-1 bg-slate-100 rounded-full"></div>
                    @php 
                        $currentStep = match($order->status) {
                            'pending' => 1,
                            'paid' => 2,
                            'process' => 3,
                            'shipping' => 4,
                            'completed' => 5,
                            default => 1
                        };
                    @endphp
                    <div class="absolute top-5 left-0 h-1 bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ ($currentStep - 1) * 25 }}%"></div>

                    {{-- Steps --}}
                    @foreach(['Checkout', 'Dibayar', 'Proses', 'Kirim', 'Selesai'] as $i => $step)
                        <div class="relative z-10 flex flex-col items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-md transition-all duration-500 
                                {{ $currentStep > $i ? 'bg-emerald-500 text-white' : ($currentStep == $i + 1 ? 'bg-[#1E3A8A] text-white' : 'bg-slate-100 text-slate-400') }}">
                                <i data-lucide="{{ $currentStep > $i ? 'check' : 'circle' }}" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $currentStep >= $i + 1 ? 'text-slate-800' : 'text-slate-400' }}">{{ $step }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ITEMS --}}
            <div class="bg-white border-2 border-slate-100 rounded-[40px] overflow-hidden shadow-sm">
                <div class="p-8 border-b border-slate-50 flex items-center gap-4">
                    <div class="w-2 h-6 bg-[#1E3A8A] rounded-full"></div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Item Pesanan</h3>
                </div>
                
                <div class="divide-y divide-slate-50">
                    @foreach($order->details as $item)
                    <div class="p-8 flex flex-col md:flex-row gap-6">
                        <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden border border-slate-50 flex-shrink-0">
                            <img src="{{ $item->specification->product->image_url }}" class="w-full h-full object-cover" crossorigin="anonymous">
                        </div>
                        <div class="flex-1 space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-black text-slate-800 text-lg leading-tight">{{ $item->specification->product->name }}</h4>
                                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">
                                        {{ $item->specification->material }} • {{ $item->specification->size }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-[#1E3A8A]">Rp {{ number_format($item->price) }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold">× {{ $item->quantity }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if($item->design_option === 'upload')
                                    <span class="px-3 py-1 bg-blue-50 text-[9px] font-black text-blue-600 rounded-lg uppercase">Design: Upload</span>
                                    @if($item->design_file)
                                        <a href="{{ asset('storage/' . $item->design_file) }}" target="_blank" class="px-3 py-1 bg-slate-50 text-[9px] font-black text-slate-500 rounded-lg uppercase hover:bg-slate-100">
                                            Lihat File
                                        </a>
                                    @endif
                                @else
                                    <span class="px-3 py-1 bg-purple-50 text-[9px] font-black text-purple-600 rounded-lg uppercase">Jasa Desain: {{ $item->design_difficulty }}</span>
                                @endif

                                @if($item->need_installation)
                                    <span class="px-3 py-1 bg-emerald-50 text-[9px] font-black text-emerald-600 rounded-lg uppercase">+ Jasa Pasang</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-8 bg-slate-50/50 flex justify-between items-center border-t border-slate-100">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Subtotal Pesanan</span>
                    <span class="text-xl font-black text-[#1E3A8A]">Rp {{ number_format($order->total_price) }}</span>
                </div>
            </div>
        </div>

        {{-- ================= RIGHT: SUMMARY ================= --}}
        <div class="lg:col-span-4 space-y-8 sticky top-24">
            
            {{-- SUMMARY CARD --}}
            <div class="bg-slate-900 rounded-[40px] p-8 text-white shadow-2xl shadow-blue-200">
                <h3 class="text-xl font-black mb-8 flex items-center gap-3">
                    <i data-lucide="info" class="w-6 h-6 text-[#FACC15]"></i>
                    Ringkasan
                </h3>

                <div class="space-y-6">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu Transaksi</p>
                        <p class="text-sm font-bold text-slate-200">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Catatan Pembeli</p>
                        <p class="text-xs text-slate-400 leading-relaxed italic">"{{ $order->notes ?? 'Tidak ada catatan' }}"</p>
                    </div>

                    <div class="pt-6 border-t border-white/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Total Dibayar</p>
                        <h2 class="text-3xl font-black text-[#FACC15]">Rp {{ number_format($order->total_price) }}</h2>
                    </div>
                </div>

                @if($order->status === 'paid')
                <div class="mt-10 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-4">
                    <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest leading-relaxed">Transaksi Terverifikasi<br>Midtrans Secure</p>
                </div>
                @endif
            </div>

            {{-- HELP --}}
            <div class="bg-blue-50 border-2 border-blue-100 rounded-[32px] p-6 text-center">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Ada Kendala?</p>
                <p class="text-[10px] text-slate-500 mt-2">Hubungi admin kami untuk bantuan pesanan #{{ $order->order_code }}</p>
                <a href="https://wa.me/6282184732885" target="_blank" class="flex items-center justify-center gap-2 mt-4 text-xs font-black text-[#1E3A8A] hover:text-blue-700">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    WHATSAPP SUPPORT
                </a>
            </div>
        </div>
    </div>
</div>

@if($order->status === 'pending')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
