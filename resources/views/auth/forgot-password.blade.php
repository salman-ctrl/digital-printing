@extends('layouts.guest')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center -mt-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition-all duration-500">
            <div class="bg-gradient-to-br from-red-600 to-red-700 py-10 px-8 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <img src="{{ asset('images/logo-cv.png') }}" class="h-16 mx-auto mb-4 drop-shadow-lg" alt="Logo">
                    <h2 class="text-2xl font-black text-white tracking-tighter capitalize">Reset Password</h2>
                    <p class="text-[10px] font-bold text-red-100 capitalize tracking-[0.2em] mt-1">Lupa sandi? Tenang, kami bantu</p>
                </div>
            </div>

            <div class="p-10">
                <div class="mb-6 text-xs text-gray-500 leading-relaxed font-medium">
                    {{ __('Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.') }}
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-600 transition-all outline-none"
                               placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-2xl font-black text-xs capitalize tracking-widest transition-all shadow-xl shadow-red-100 transform active:scale-95">
                        Kirim Tautan Reset
                    </button>
                </form>

                <div class="mt-10 text-center border-t border-gray-50 pt-8">
                    <a href="{{ route('login') }}" class="text-[10px] font-bold text-gray-400 capitalize tracking-widest hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

