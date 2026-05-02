@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[3rem] shadow-2xl p-16 text-center border border-gray-100 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative z-10">
                <div class="w-24 h-24 bg-green-500 text-white rounded-[2rem] flex items-center justify-center mx-auto mb-10 shadow-xl shadow-green-100 animate-bounce-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="text-4xl font-black text-gray-900 capitalize tracking-tighter mb-4">Pembayaran Berhasil!</h2>
                <p class="text-gray-500 text-lg font-medium max-w-md mx-auto leading-relaxed">Terima kasih, Anugrah! Pembayaran Anda telah kami terima dan pesanan akan segera diproses oleh tim produksi kami.</p>

                <div class="grid grid-cols-2 gap-6 mt-12 mb-12">
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 text-left">
                        <p class="text-[9px] font-black text-gray-400 capitalize tracking-widest mb-1">Kode Pesanan</p>
                        <p class="text-lg font-black text-blue-600 capitalize tracking-tight">{{ $transaction->order_code }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 text-left">
                        <p class="text-[9px] font-black text-gray-400 capitalize tracking-widest mb-1">Total Dibayar</p>
                        <p class="text-lg font-black text-gray-900 capitalize tracking-tight">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="px-10 py-5 bg-[#1a1c23] text-white font-black rounded-2xl text-xs capitalize tracking-[0.2em] hover:bg-red-600 transition-all shadow-xl shadow-gray-200">
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('orders.show', $transaction->id) }}" class="px-10 py-5 bg-white text-gray-900 border-2 border-gray-100 font-black rounded-2xl text-xs capitalize tracking-[0.2em] hover:border-blue-600 transition-all">
                        Lihat Detail Pesanan
                    </a>
                </div>

                <p class="mt-12 text-[10px] font-bold text-gray-400 capitalize tracking-[0.3em]">
                    CV Anugrah Murni Sejati
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
</style>
