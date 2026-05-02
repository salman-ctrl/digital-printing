<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - CV Anugrah Murni Sejati</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfcfc] flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-80 bg-white h-full flex flex-col shrink-0 border-r border-gray-100 z-50">
        <div class="p-10">
            <div class="flex items-center space-x-4 mb-12">
                <img src="{{ asset('images/logo-cv.png') }}" class="h-10 w-auto" alt="Logo">
                <div>
                    <h1 class="text-gray-800 font-black text-sm leading-none tracking-tighter capitalize">Anugrah</h1>
                    <p class="text-[8px] text-gray-400 font-bold tracking-[0.3em] capitalize mt-1">Management</p>
                </div>
            </div>

            <nav class="space-y-3">
                <p class="text-[9px] font-black text-gray-300 capitalize tracking-[0.4em] mb-6 ml-4">Laporan Bisnis</p>
                
                <a href="{{ route('owner.dashboard') }}" class="flex items-center px-6 py-4 bg-gray-900 text-white rounded-[1.5rem] transition-all shadow-xl shadow-gray-200 group">
                    <span class="mr-4 text-xl group-hover:rotate-12 transition-transform">📈</span>
                    <span class="text-[11px] font-black capitalize tracking-widest">Ikhtisar</span>
                </a>

                <a href="#" class="flex items-center px-6 py-4 text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-[1.5rem] transition-all group">
                    <span class="mr-4 text-xl group-hover:scale-110 transition-transform">💰</span>
                    <span class="text-[11px] font-black capitalize tracking-widest">Penjualan</span>
                </a>

                <a href="#" class="flex items-center px-6 py-4 text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-[1.5rem] transition-all group">
                    <span class="mr-4 text-xl group-hover:scale-110 transition-transform">🎯</span>
                    <span class="text-[11px] font-black capitalize tracking-widest">Hasil TOPSIS</span>
                </a>

                <a href="#" class="flex items-center px-6 py-4 text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-[1.5rem] transition-all group">
                    <span class="mr-4 text-xl group-hover:scale-110 transition-transform">📦</span>
                    <span class="text-[11px] font-black capitalize tracking-widest">Stok Produk</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto p-10 border-t border-gray-50 bg-gray-50/30">
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-800 font-black border border-gray-100 shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-[9px] text-gray-400 font-bold capitalize tracking-widest">Owner</p>
                    <p class="text-[11px] font-black text-gray-800 truncate">{{ auth()->user()->name }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-6 py-4 border border-gray-200 text-gray-600 hover:bg-red-600 hover:border-red-600 hover:text-white rounded-2xl transition-all text-[10px] font-black capitalize tracking-widest">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Bar --}}
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 px-12 py-8 flex justify-between items-center shrink-0">
            <h2 class="text-xs font-black text-gray-400 capitalize tracking-[0.4em]">Sistem Informasi Eksekutif</h2>
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="text-[10px] font-black text-gray-400 hover:text-gray-900 transition-colors capitalize tracking-widest">Website</a>
                <div class="h-4 w-px bg-gray-200"></div>
                <div class="flex items-center text-[10px] font-black text-gray-800 capitalize tracking-widest">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                    Sistem Aktif
                </div>
            </div>
        </header>

        {{-- Content Area --}}
        <div class="flex-1 overflow-y-auto p-12 custom-scrollbar">
            @yield('content')
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e5e5e5; }
    </style>
</body>
</html>
