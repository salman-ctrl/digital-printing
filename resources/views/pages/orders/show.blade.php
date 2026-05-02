@extends('layouts.guest')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">
            {{-- Breadcrumb & Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 capitalize tracking-[0.2em] hover:text-red-600 transition-all group mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Pesanan Saya
                    </a>
                    <h1 class="text-4xl font-black text-gray-900 capitalize tracking-tighter leading-none mb-2">Detail Pesanan</h1>
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] font-bold text-gray-400 capitalize tracking-widest bg-white px-3 py-1 rounded-full border border-gray-100 shadow-sm">
                            ID: #{{ $order->order_code }}
                        </span>
                        <span class="text-[11px] font-bold text-gray-400 capitalize tracking-widest bg-white px-3 py-1 rounded-full border border-gray-100 shadow-sm">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if($order->status == 'paid')
                        <div class="flex items-center gap-3 bg-green-50 border border-green-100 px-6 py-3 rounded-2xl shadow-sm">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-green-600 capitalize tracking-widest leading-none mb-1">Status Pembayaran</p>
                                <p class="text-sm font-black text-gray-900 capitalize">SUDAH DIBAYAR</p>
                            </div>
                        </div>
                    @elseif($order->status == 'pending')
                        <div class="flex items-center gap-3 bg-amber-50 border border-amber-100 px-6 py-3 rounded-2xl shadow-sm">
                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-amber-600 capitalize tracking-widest leading-none mb-1">Status Pembayaran</p>
                                <p class="text-sm font-black text-gray-900 capitalize">MENUNGGU PEMBAYARAN</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 bg-red-50 border border-red-100 px-6 py-3 rounded-2xl shadow-sm">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-red-600 capitalize tracking-widest leading-none mb-1">Status Pembayaran</p>
                                <p class="text-sm font-black text-gray-900 capitalize">GAGAL / EXPIRED</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Side: Order Items --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                        <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <h3 class="text-xl font-black text-gray-900 capitalize tracking-tighter">Daftar Produk</h3>
                            <span class="bg-gray-900 text-white text-[10px] font-black px-4 py-1.5 rounded-full capitalize tracking-[0.2em]">
                                {{ $order->details->count() }} Item
                            </span>
                        </div>
                        
                        <div class="divide-y divide-gray-50">
                            @foreach($order->details as $detail)
                            <div class="p-8 group hover:bg-gray-50/50 transition-colors">
                                <div class="flex items-start gap-8">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl flex items-center justify-center border border-gray-100 shadow-inner group-hover:scale-105 transition-transform duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-lg font-black text-gray-900 capitalize tracking-tighter group-hover:text-red-600 transition-colors mb-2">{{ $detail->specification->product->name }}</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="px-3 py-1.5 bg-gray-100 text-[9px] font-black text-gray-600 rounded-xl capitalize tracking-widest border border-gray-200/50">
                                                        {{ $detail->specification->material }}
                                                    </span>
                                                    <span class="px-3 py-1.5 bg-gray-100 text-[9px] font-black text-gray-600 rounded-xl capitalize tracking-widest border border-gray-200/50">
                                                        {{ $detail->specification->size }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] font-bold text-gray-400 capitalize tracking-[0.1em] mb-1">Subtotal</p>
                                                <p class="text-xl font-black text-gray-900 tracking-tighter">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-6 p-5 rounded-[1.5rem] bg-gray-50 border border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-4">
                                                    @if($detail->design_option === 'upload')
                                                        <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center text-green-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[9px] font-black text-green-600 capitalize tracking-widest mb-0.5">Opsi Desain</p>
                                                            <p class="text-xs font-black text-gray-900 capitalize">Upload Desain Sendiri</p>
                                                        </div>
                                                    @else
                                                        <div class="w-10 h-10 bg-red-100 rounded-2xl flex items-center justify-center text-red-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[9px] font-black text-red-600 capitalize tracking-widest mb-0.5">Jasa Desain</p>
                                                            <p class="text-xs font-black text-gray-900 capitalize">{{ $detail->design_difficulty }} (+Rp{{ number_format($detail->design_cost, 0, ',', '.') }})</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($detail->need_installation)
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[9px] font-black text-blue-600 capitalize tracking-widest mb-0.5">Jasa Pasang</p>
                                                            <p class="text-xs font-black text-gray-900 capitalize">Sudah Termasuk (+Rp{{ number_format($detail->installation_price, 0, ',', '.') }})</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($detail->design_file)
                                                    <a href="{{ asset('storage/' . $detail->design_file) }}" target="_blank" class="px-5 py-2.5 bg-white border border-gray-200 text-[10px] font-black text-gray-900 capitalize tracking-widest rounded-xl hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Lihat File
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 p-10 border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 capitalize tracking-tighter mb-8 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Informasi Pengiriman
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 capitalize tracking-[0.2em] mb-2">Nama Lengkap</p>
                                    <p class="text-base font-black text-gray-900 capitalize tracking-tight">{{ $order->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 capitalize tracking-[0.2em] mb-2">Alamat Email</p>
                                    <p class="text-base font-black text-gray-900 tracking-tight">{{ $order->user->email }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-3xl p-6 border border-dashed border-gray-200 flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 mb-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest leading-relaxed">
                                    Status pengiriman akan diperbarui<br>setelah pesanan Anda selesai diproses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Summary --}}
                <div class="space-y-8">
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-gray-900/20 relative overflow-hidden">
                        {{-- Background Accent --}}
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-red-600/10 rounded-full blur-3xl"></div>
                        
                        <h3 class="text-xl font-black capitalize tracking-tighter mb-10 relative z-10">Ringkasan Biaya</h3>
                        
                        <div class="space-y-6 relative z-10">
                            <div class="flex justify-between items-center text-[11px] font-black text-gray-400 capitalize tracking-[0.2em]">
                                <span>Total Item</span>
                                <span class="text-white">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] font-black text-gray-400 capitalize tracking-[0.2em]">
                                <span>Pajak (PPN 11%)</span>
                                <span class="text-white">Termasuk</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] font-black text-gray-400 capitalize tracking-[0.2em]">
                                <span>Biaya Pengiriman</span>
                                <span class="text-green-500">GRATIS</span>
                            </div>
                            
                            <div class="pt-8 border-t border-white/10 mt-8 flex flex-col gap-1">
                                <p class="text-[10px] font-black text-gray-400 capitalize tracking-[0.3em]">Total Bayar</p>
                                <p class="text-4xl font-black text-red-500 tracking-tighter">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            @if($order->status == 'pending' && $order->snap_token)
                                <div class="mt-10">
                                    <button id="pay-button" class="group w-full py-5 bg-red-600 hover:bg-red-700 text-white font-black text-xs capitalize tracking-[0.2em] rounded-2xl transition-all shadow-xl shadow-red-900/50 flex items-center justify-center gap-4 active:scale-[0.98]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Bayar Sekarang
                                    </button>
                                    <p class="text-center text-[9px] font-bold text-gray-500 capitalize tracking-widest mt-4 leading-relaxed">
                                        Klik tombol di atas untuk melanjutkan<br>pembayaran via Midtrans Snap.
                                    </p>
                                </div>
                            @elseif($order->status == 'paid')
                                <div class="mt-10 p-6 bg-white/5 rounded-2xl border border-white/10 text-center">
                                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4 text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-black text-green-500 capitalize tracking-widest">Pembayaran Berhasil</p>
                                    <p class="text-xs font-bold text-gray-400 mt-1">Terima kasih atas pesanan Anda!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Help Card --}}
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 p-10 text-center group">
                        <div class="w-16 h-16 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-green-500 group-hover:scale-110 transition-transform duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-black text-gray-900 capitalize tracking-widest mb-2">Butuh Bantuan?</h4>
                        <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mb-8 leading-relaxed">
                            Hubungi admin kami jika Anda memiliki<br>kendala dengan pesanan ini.
                        </p>
                        <a href="https://wa.me/6282184732885" class="flex items-center justify-center gap-2 w-full py-4 bg-green-500 text-white font-black text-[10px] capitalize tracking-[0.2em] rounded-2xl hover:bg-green-600 transition-all shadow-lg shadow-green-500/30">
                            Hubungi WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($order->status == 'pending' && $order->snap_token)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function (result) {
                    window.location.href = "{{ route('orders.show', $order->id) }}";
                },
                onPending: function (result) {
                    window.location.href = "{{ route('orders.show', $order->id) }}";
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function () {
                    // Do nothing or show message
                }
            });
        });
    </script>
@endif
@endpush
