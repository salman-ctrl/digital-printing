@extends('layouts.guest')

@section('content')

<div class="w-full space-y-16 font-sans text-slate-800">

    {{-- ================= HEADER ================= --}}
    <section class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-sm p-10 md:p-14">

        {{-- BACKGROUND --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#1E3A8A] via-[#1E3A8A]/90 to-[#EF4444]/90"></div>
        <div class="absolute inset-0 bg-white/5 backdrop-blur-[1px]"></div>

        <div class="relative z-10 text-white max-w-2xl">

            <p class="text-xs font-black uppercase tracking-widest text-[#FACC15] mb-3">
                Hubungi Kami
            </p>

            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                KONTAK & LOKASI KAMI
            </h1>

            <p class="text-white/80 text-sm mt-3 leading-relaxed">
                Silakan hubungi kami atau kunjungi langsung workshop kami untuk konsultasi dan pemesanan layanan digital printing.
            </p>

        </div>

    </section>


    {{-- ================= ACTION BUTTON ================= --}}
    <section class="flex flex-wrap gap-3">

        <a href="https://wa.me/6282184732885"
           class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition">
            Chat WhatsApp
        </a>

        <a href="mailto:admin@digitalprinting.com"
           class="px-6 py-3 border border-slate-200 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition">
            Email Kami
        </a>

    </section>


    {{-- ================= CONTENT ================= --}}
    <section class="grid lg:grid-cols-2 gap-6">

        {{-- ================= CONTACT INFO CARD ================= --}}
        <div class="bg-white border rounded-2xl shadow-sm p-8 space-y-6">

            <h2 class="text-lg font-black text-[#1E3A8A]">
                Informasi Kontak
            </h2>

            <div class="space-y-4 text-sm text-slate-600">

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Alamat</p>
                    <p class="font-medium">
                        Jl. Prof. Dr. Hamka No.363, Parupuk Tabing, Kec. Koto Tangah, Kota Padang, Sumatera Barat 25586
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Telepon</p>
                    <p class="font-medium">+62 821-8473-2885</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Email</p>
                    <p class="font-medium">admin@digitalprinting.com</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Jam Operasional</p>
                    <p class="font-medium">
                        Senin - Sabtu: 08:00 - 21:00<br>
                        Minggu: 10:00 - 17:00
                    </p>
                </div>

            </div>

        </div>


        {{-- ================= MAP CARD ================= --}}
        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b bg-slate-50">
                <h3 class="text-xs font-black uppercase tracking-widest text-slate-500">
                    Lokasi Workshop
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Temukan kami di Google Maps
                </p>
            </div>

            <div class="h-[420px] w-full">

                <iframe
                    class="w-full h-full"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q=Jl.%20Prof.%20Dr.%20Hamka%20No.363,%20Parupuk%20Tabing,%20Kec.%20Koto%20Tangah,%20Kota%20Padang,%20Sumatera%20Barat%2025586&output=embed">
                </iframe>

            </div>

        </div>

    </section>


    {{-- ================= EMPTY STATE (Optional Support Section) ================= --}}
    <section class="bg-slate-50 border rounded-2xl p-10 text-center">

        <div class="text-4xl mb-3">📍</div>

        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-widest">
            Butuh Bantuan Lebih Lanjut?
        </h3>

        <p class="text-xs text-slate-400 mt-2">
            Tim kami siap membantu Anda melalui WhatsApp atau email kapan saja.
        </p>

    </section>


    {{-- ================= CTA ================= --}}
    <section class="bg-[#1E3A8A] rounded-2xl p-10 text-center text-white">

        <h2 class="text-2xl font-black">
            Siap Konsultasi Sekarang?
        </h2>

        <p class="text-sm text-white/70 mt-2">
            Hubungi kami untuk mendapatkan penawaran terbaik.
        </p>

        <div class="mt-6 flex justify-center gap-3">

            <a href="https://wa.me/6282184732885"
               class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition">
                WhatsApp
            </a>

            <a href="{{ url('/products') }}"
               class="px-6 py-3 border border-white/30 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white/10 transition">
                Lihat Produk
            </a>

        </div>

    </section>

</div>

@endsection