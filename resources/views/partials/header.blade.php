{{-- ================= TOP BAR ================= --}}
<div class="bg-slate-50 border-b border-slate-200 py-2 hidden md:block">
    <div class="container mx-auto px-6 flex justify-between items-center text-[11px] text-slate-500 font-medium">

        <div class="flex items-center gap-6">
            <span class="flex items-center gap-1">
                📞 <span>+62 853-2130-0300</span>
            </span>

            <span class="flex items-center gap-1">
                🕒 <span>08:00 - 17:00</span>
            </span>
        </div>

        <div class="flex items-center gap-5">
            <a href="#" class="hover:text-[#1E3A8A] transition">FAQ</a>
            <a href="#" class="hover:text-[#1E3A8A] transition">Tracking</a>
            <span class="text-slate-400">|</span>
            <span class="text-slate-600 font-semibold">🇮🇩 IDR</span>
        </div>
    </div>
</div>


{{-- ================= HEADER ================= --}}
<header class="bg-white border-b border-slate-200 sticky top-0 z-50">

    <div class="container mx-auto px-6 py-4 space-y-4">

        {{-- ================= TOP ROW ================= --}}
        <div class="flex items-center justify-between gap-6">

            {{-- LOGO --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('images/logo-cv.png') }}" class="h-10">

                <div class="hidden lg:block leading-tight">
                    <p class="text-lg font-black text-[#1E3A8A]">MURNI</p>
                    <p class="text-[10px] text-[#FACC15] font-bold tracking-widest uppercase">
                        Digital Printing
                    </p>
                </div>
            </a>


            {{-- SEARCH (FOCUS AREA) --}}
            <div class="hidden md:flex flex-1 max-w-2xl">
                <form class="w-full relative">

                    <input type="text"
                        placeholder="Cari produk, bahan, atau kebutuhan cetak..."
                        class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                               bg-slate-50
                               focus:bg-white focus:ring-2 focus:ring-[#FACC15]/40 focus:border-[#FACC15]
                               text-sm transition-all outline-none">

                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                </form>
            </div>


            {{-- ACTIONS --}}
            <div class="flex items-center gap-5">

                {{-- CART --}}
                <div class="relative group">

                    {{-- TRIGGER --}}
                    <a href="{{ Auth::check() ? route('cart.index') : route('login') }}"
                    class="relative flex items-center justify-center w-10 h-10 rounded-xl
                            hover:bg-slate-100 transition text-lg">

                        🛒

                        <span class="absolute -top-1 -right-1 bg-[#EF4444] text-white text-[10px]
                                    w-5 h-5 flex items-center justify-center rounded-full font-bold">
                            @auth
                                {{ \App\Models\CartDetail::whereHas('cart', fn($q)=>$q->where('user_id', auth()->id()))->sum('quantity') }}
                            @else
                                0
                            @endauth
                        </span>
                    </a>

                    {{-- DROPDOWN FIX --}}
                    <div class="absolute right-0 mt-2 pt-2 w-72 z-50
                                opacity-0 invisible group-hover:visible group-hover:opacity-100
                                transition-all duration-200">

                        {{-- INNER BOX (IMPORTANT FIX) --}}
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden">

                            <div class="p-4 border-b text-xs font-semibold text-slate-500">
                                Keranjang
                            </div>

                            <div class="p-6 text-center text-slate-400 text-sm">
                                Belum ada item
                            </div>

                        </div>

                    </div>

                </div>


                {{-- ACCOUNT --}}
                @auth
                <div class="relative group">

                    {{-- TRIGGER --}}
                    <button class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#1E3A8A] text-white rounded-xl flex items-center justify-center font-bold shadow-sm">
                            {{ substr(auth()->user()->name,0,1) }}
                        </div>
                    </button>

                    {{-- DROPDOWN WRAPPER (IMPORTANT FIX) --}}
                    <div class="absolute right-0 mt-2 pt-2 w-56 z-50
                                opacity-0 invisible group-hover:visible group-hover:opacity-100
                                transition-all duration-200">

                        {{-- INNER BOX (THIS KEEPS HOVER ALIVE) --}}
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden">

                            <div class="px-4 py-3 border-b text-xs text-slate-500">
                                {{ auth()->user()->name }}
                            </div>

                            <a href="{{ route('user.dashboard') }}" 
                            class="block px-4 py-3 text-sm hover:bg-slate-50 transition">
                                Dashboard
                            </a>

                            <a href="{{ route('user.cart') }}" class="block px-4 py-3 text-sm hover:bg-slate-50 transition">
                                Pesanan
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-3 text-sm text-[#EF4444] hover:bg-red-50 transition">
                                    Logout
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
                @else
                <div class="flex items-center gap-3">

                    <a href="{{ route('login') }}"
                    class="text-sm font-bold text-[#1E3A8A] hover:text-[#FACC15]">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                    class="px-5 py-2.5 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-sm font-bold
                            hover:bg-[#EAB308] transition shadow-sm">
                        Register
                    </a>

                </div>
                @endauth

            </div>
        </div>


        {{-- Nav Links --}}
        <nav class="flex items-center space-x-8 font-bold text-xs capitalize tracking-widest mt-6 border-t border-gray-50 pt-4 overflow-x-auto no-scrollbar whitespace-nowrap">

            <a href="{{ url('/') }}"
            class="pb-1 border-b-2 transition-all duration-300
            {{ request()->is('/') ? 'text-[#FACC15] border-[#FACC15]' : 'text-[#1E3A8A] border-transparent hover:text-[#FACC15] hover:border-[#FACC15]' }}">
                Home
            </a>

            <a href="{{ route('products.index') }}"
            class="pb-1 border-b-2 transition-all duration-300
            {{ request()->routeIs('products.*') ? 'text-[#FACC15] border-[#FACC15]' : 'text-[#1E3A8A] border-transparent hover:text-[#FACC15] hover:border-[#FACC15]' }}">
                Products
            </a>

            <a href="{{ url('/rekomendasi') }}"
            class="pb-1 border-b-2 transition-all duration-300
            {{ request()->is('rekomendasi') ? 'text-[#FACC15] border-[#FACC15]' : 'text-[#1E3A8A] border-transparent hover:text-[#FACC15] hover:border-[#FACC15]' }}">
                Recommendation
            </a>

            <a href="{{ url('/profil') }}"
            class="pb-1 border-b-2 transition-all duration-300
            {{ request()->is('profil') ? 'text-[#FACC15] border-[#FACC15]' : 'text-[#1E3A8A] border-transparent hover:text-[#FACC15] hover:border-[#FACC15]' }}">
                Profile
            </a>

            <a href="{{ url('/contact') }}"
            class="pb-1 border-b-2 transition-all duration-300
            {{ request()->is('contact') ? 'text-[#FACC15] border-[#FACC15]' : 'text-[#1E3A8A] border-transparent hover:text-[#FACC15] hover:border-[#FACC15]' }}">
                Contact
            </a>

        </nav>

    </div>
</header>