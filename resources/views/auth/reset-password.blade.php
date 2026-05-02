@extends('layouts.guest')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center -mt-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition-all duration-500">
            <div class="bg-gradient-to-br from-red-600 to-red-700 py-10 px-8 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <img src="{{ asset('images/logo-cv.png') }}" class="h-16 mx-auto mb-4 drop-shadow-lg" alt="Logo">
                    <h2 class="text-2xl font-black text-white tracking-tighter capitalize">Password Baru</h2>
                    <p class="text-[10px] font-bold text-red-100 capitalize tracking-[0.2em] mt-1">Buat kata sandi baru Anda</p>
                </div>
            </div>

            <div class="p-10">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-600 transition-all outline-none">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Password Baru</label>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-600 transition-all outline-none">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-600 transition-all outline-none">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-2xl font-black text-xs capitalize tracking-widest transition-all shadow-xl shadow-red-100 transform active:scale-95">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
