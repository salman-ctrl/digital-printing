@extends('layouts.guest')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center -mt-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition-all duration-500">
            <div class="bg-gradient-to-br from-red-600 to-red-700 py-10 px-8 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <img src="{{ asset('images/logo-cv.png') }}" class="h-16 mx-auto mb-4 drop-shadow-lg" alt="Logo">
                    <h2 class="text-2xl font-black text-white tracking-tighter capitalize">Konfirmasi</h2>
                    <p class="text-[10px] font-bold text-red-100 capitalize tracking-[0.2em] mt-1">Sandi diperlukan untuk melanjutkan</p>
                </div>
            </div>

            <div class="p-10">
                <div class="mb-6 text-xs text-gray-500 leading-relaxed font-medium">
                    {{ __('Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="password" class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-600 transition-all outline-none"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-2xl font-black text-xs capitalize tracking-widest transition-all shadow-xl shadow-red-100 transform active:scale-95">
                        Konfirmasi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
