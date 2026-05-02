@extends('layouts.guest')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center -mt-12">
    <div class="w-full max-w-md text-center">
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition-all duration-500">
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 py-12 px-8 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full blur-2xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tighter capitalize">Verifikasi Email</h2>
                    <p class="text-[10px] font-bold text-yellow-900 capitalize tracking-[0.2em] mt-1">Satu langkah lagi untuk mulai</p>
                </div>
            </div>

            <div class="p-10">
                <div class="mb-8 text-sm text-gray-500 leading-relaxed font-medium">
                    {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-8 p-4 bg-green-50 rounded-2xl border border-green-100 text-xs font-bold text-green-600 capitalize tracking-widest leading-relaxed">
                        {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-2xl font-black text-xs capitalize tracking-widest transition-all shadow-xl shadow-red-100 transform active:scale-95">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold text-gray-400 capitalize tracking-widest hover:text-red-600 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
