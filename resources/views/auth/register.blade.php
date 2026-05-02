@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-50 font-sans text-slate-800">

    <div class="w-full max-w-md space-y-8">

        {{-- ================= HEADER ================= --}}
        <div class="text-center space-y-3">

            <p class="text-xs font-black uppercase tracking-[0.3em] text-[#EF4444]">
                Digital Printing Profesional
            </p>

            <h1 class="text-3xl md:text-4xl font-black text-[#1E3A8A] tracking-tight">
                DAFTAR AKUN
            </h1>

            <p class="text-sm text-slate-500">
                Bergabung untuk mengakses sistem digital printing
            </p>

        </div>

        {{-- ================= CARD REGISTER ================= --}}
        <div class="relative overflow-hidden rounded-3xl border border-slate-200 shadow-sm bg-white">

            {{-- TOP ACCENT --}}
            <div class="h-2 bg-gradient-to-r from-[#1E3A8A] via-[#FACC15] to-[#EF4444]"></div>

            <div class="p-8 space-y-6">

                {{-- LOGO --}}
                <div class="text-center">

                    <div class="w-20 h-20 mx-auto rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('images/logo-cv.png') }}"
                             class="h-12 object-contain"
                             alt="Logo">
                    </div>

                    <h2 class="mt-4 text-xl font-black text-[#1E3A8A]">
                        Buat Akun Baru
                    </h2>

                    <p class="text-xs text-slate-500 mt-1 tracking-widest uppercase">
                        Isi data untuk mendaftar
                    </p>

                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- NAME --}}
                    <div class="space-y-2">

                        <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                            Nama Lengkap
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="Nama lengkap"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('name')" class="text-xs text-red-500" />

                    </div>

                    {{-- EMAIL --}}
                    <div class="space-y-2">

                        <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                            Email Address
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="nama@email.com"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500" />

                    </div>

                    {{-- PASSWORD --}}
                    <div class="space-y-2">

                        <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500" />

                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="space-y-2">

                        <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                            Konfirmasi Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-xs text-red-500" />

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full py-3 rounded-2xl
                                   bg-gradient-to-r from-[#1E3A8A] to-[#162a66]
                                   text-white text-xs font-black uppercase tracking-[0.25em]
                                   hover:shadow-lg hover:-translate-y-0.5
                                   active:scale-[0.98]
                                   transition-all duration-300">

                        Daftar

                    </button>

                </form>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="text-center space-y-2">

            <p class="text-xs text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                   class="font-black text-[#1E3A8A] hover:underline">
                    Login sekarang
                </a>
            </p>

            <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">
                © {{ date('Y') }} CV. Anugrah Murni Sejati
            </p>

        </div>

    </div>

</div>

@endsection