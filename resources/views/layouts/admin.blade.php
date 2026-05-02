<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Murni Digital Printing</title>

    <script>
        tailwind = {
            config: {
                // Konfigurasi tailwind jika diperlukan
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .transition-sidebar {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-closed #sidebar {
            transform: translateX(-100%);
            position: absolute;
        }

        .sidebar-closed #main {
            margin-left: 0 !important;
            width: 100% !important;
        }
    </style>
</head>

<body id="app" class="bg-slate-50 flex h-screen overflow-hidden text-slate-800 sidebar-open">

{{-- SIDEBAR --}}
<aside id="sidebar"
    class="w-72 bg-white h-full flex flex-col shrink-0 shadow-sm">

    {{-- BRAND / LOGO (SEJAJAR NAVBAR) --}}
    <div class="px-6 h-[76px] flex items-center bg-white">

        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl overflow-hidden bg-white flex items-center justify-center border border-slate-200">
                <img src="{{ asset('images/logo-cv.png') }}"
                    class="w-full h-full object-contain">
            </div>

            <div>
                <h1 class="text-[#1E3A8A] font-bold text-m leading-tight">
                    Murni Digital Printing
                </h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest">
                    Admin Dashboard
                </p>
            </div>
        </div>

    </div>

    {{-- MENU --}}
    <nav class="p-4 space-y-2 border-t border-slate-200">

        @php
        $base = "flex items-center gap-3 px-4 py-3 rounded-xl transition text-sm font-semibold";
        $active = $base . " bg-[#FACC15] text-[#1E3A8A] shadow-sm";
        $inactive = $base . " text-slate-500 hover:bg-[#FEF9C3] hover:text-[#CA8A04]";
        @endphp

        <a href="{{ route('admin.dashboard') }}"
        class="{{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">
            <svg class="w-6 h-6 flex-shrink-0 stroke-[1.8]" fill="none" stroke="currentColor">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.categories.index') }}"
        class="{{ request()->routeIs('admin.categories.*') ? $active : $inactive }}">
            <svg class="w-6 h-6 flex-shrink-0 stroke-[1.8]" fill="none" stroke="currentColor">
                <path d="M4 4h6l2 3h8v13H4z"/>
            </svg>
            Kategori
        </a>

        <a href="{{ route('admin.products.index') }}"
        class="{{ request()->routeIs('admin.products.*') ? $active : $inactive }}">
            <svg class="w-6 h-6 flex-shrink-0 stroke-[1.8]" fill="none" stroke="currentColor">
                <path d="M20 7l-8-4-8 4 8 4 8-4zM4 10v6l8 4 8-4v-6"/>
            </svg>
            Produk
        </a>

        <a href="{{ route('admin.topsis.index') }}"
        class="{{ request()->routeIs('admin.topsis.*') ? $active : $inactive }}">
            <svg class="w-6 h-6 flex-shrink-0 stroke-[1.8]" fill="none" stroke="currentColor">
                <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z"/>
            </svg>
            TOPSIS
        </a>

        <a href="{{ route('orders.index') }}"
        class="{{ request()->routeIs('orders.*') ? $active : $inactive }}">
            <svg class="w-5 h-5 flex-shrink-0 stroke-[1.8]" fill="none" stroke="currentColor">
                <path d="M3 7h18M3 12h18M3 17h18"/>
            </svg>
            Transaksi
        </a>

    </nav>

    {{-- USER --}}
    <div class="mt-auto p-4 border-t border-slate-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-[#EF4444] text-white hover:bg-red-600 transition px-4 py-3 rounded-xl text-xs font-bold uppercase shadow-sm">
                Logout
            </button>
        </form>
    </div>

</aside>

{{-- MAIN --}}
<main id="main" class="flex-1 flex flex-col transition-sidebar w-full">

    {{-- TOPBAR --}}
    <header class="bg-white border-b border-slate-200 h-[76px] px-8 flex items-center justify-end shadow-sm relative">

        {{-- GARIS PEMBATAS SIDEBAR (PERFECT ALIGN) --}}
        <div class="absolute left-0 top-0 h-full w-px bg-slate-200"></div>

        {{-- RIGHT --}}
        <div class="flex items-center gap-6">

            {{-- NOTIFICATION --}}
            <div class="relative">
                <button onclick="toggleNotif()"
                    class="relative p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/>
                    </svg>

                    <span id="notifBadge"
                        class="absolute -top-1 -right-1 bg-[#EF4444] text-white text-[9px] w-5 h-5 flex items-center justify-center rounded-full font-bold">
                        0
                    </span>
                </button>

                <div id="notifBox"
                    class="hidden absolute right-0 mt-4 w-80 bg-white border border-slate-200 rounded-2xl shadow-lg z-50">

                    <div class="p-4 border-b bg-slate-50">
                        <p class="text-xs font-bold uppercase text-slate-600 tracking-widest">
                            Notifikasi Transaksi
                        </p>
                    </div>

                    <div class="max-h-72 overflow-y-auto">
                        <a href="{{ route('orders.index') }}"
                        class="flex items-center gap-3 p-4 hover:bg-slate-50 transition border-b">

                            <div class="w-9 h-9 bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor">
                                    <path stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Pesanan baru masuk
                                </p>
                                <p class="text-xs text-slate-400">
                                    Klik untuk lihat transaksi
                                </p>
                            </div>

                        </a>
                    </div>

                    <a href="{{ route('orders.index') }}"
                    class="block text-center text-xs font-bold text-slate-500 p-3 hover:bg-slate-50">
                        Lihat Semua
                    </a>

                </div>
            </div>

            {{-- USER --}}
            <div class="flex items-center gap-3 pl-5 border-l border-slate-200">

                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-slate-900">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-[#FACC15] font-bold uppercase tracking-widest">
                        Admin
                    </p>
                </div>

                <div class="w-10 h-10 bg-[#1E3A8A] rounded-xl flex items-center justify-center text-white font-bold shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>

            </div>

        </div>
    </header>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto p-8 bg-slate-50 space-y-8">
        @yield('header')
        @yield('content')
    </div>

</main>

{{-- SCRIPT --}}
<script>
function toggleNotif() {
    document.getElementById('notifBox').classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#notifBox') && !e.target.closest('button')) {
        document.getElementById('notifBox').classList.add('hidden');
    }
});

async function loadNotif() {
    try {
        const res = await fetch('/admin/notifications/count');
        const data = await res.json();
        const badge = document.getElementById('notifBadge');

        if (data.count > 0) {
            badge.style.display = 'flex';
            badge.innerText = data.count;
        } else {
            badge.style.display = 'none';
        }
    } catch (err) {}
}

loadNotif();
setInterval(loadNotif, 10000);
</script>

</body>
</html>