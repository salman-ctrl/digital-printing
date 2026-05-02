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
                LOGIN AKUN
            </h1>

            <p class="text-sm text-slate-500">
                Masuk untuk mengakses sistem digital printing
            </p>

        </div>

        {{-- ================= CARD LOGIN ================= --}}
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
                        Selamat Datang Kembali
                    </h2>

                    <p class="text-xs text-slate-500 mt-1 tracking-widest uppercase">
                        Silakan login ke akun Anda
                    </p>

                </div>

                {{-- STATUS --}}
                @if(session('status'))
                    <div class="rounded-2xl px-4 py-3 bg-[#FACC15]/20 text-[#1E3A8A] text-xs font-bold">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="space-y-2">

                        <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                            Email Address
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               placeholder="nama@email.com"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500" />

                    </div>

                    {{-- PASSWORD --}}
                    <div class="space-y-2">

                        <div class="flex justify-between items-center">

                            <label class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-500">
                                Password
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-[10px] font-bold text-[#EF4444] hover:underline">
                                    Lupa Password?
                                </a>
                            @endif

                        </div>

                        <input type="password"
                               name="password"
                               required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                                      focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                      outline-none transition">

                        <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500" />

                    </div>

                    {{-- REMEMBER --}}
                    <div class="flex items-center gap-3">

                        <input type="checkbox"
                               name="remember"
                               class="w-4 h-4 rounded border-slate-300 text-[#EF4444] focus:ring-[#FACC15]">

                        <span class="text-xs text-slate-500">
                            Ingat saya
                        </span>

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full py-3 rounded-2xl
                                   bg-gradient-to-r from-[#1E3A8A] to-[#162a66]
                                   text-white text-xs font-black uppercase tracking-[0.25em]
                                   hover:shadow-lg hover:-translate-y-0.5
                                   active:scale-[0.98]
                                   transition-all duration-300">

                        Masuk

                    </button>

                </form>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="text-center space-y-2">

            <p class="text-xs text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="font-black text-[#1E3A8A] hover:underline">
                    Daftar sekarang
                </a>
            </p>

            <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">
                © {{ date('Y') }} CV. Anugrah Murni Sejati
            </p>

        </div>

    </div>

</div>

@endsection