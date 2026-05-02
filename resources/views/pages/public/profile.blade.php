@extends('layouts.guest')

@section('content')

<div class="w-full space-y-16 font-sans text-slate-800">

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-sm p-12 md:p-20">

        {{-- background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#1E3A8A] via-[#1E3A8A]/90 to-[#EF4444]/90"></div>
        <div class="absolute inset-0 bg-white/5 backdrop-blur-[2px]"></div>

        <div class="relative z-10 max-w-3xl text-white">

            <p class="text-xs font-black uppercase tracking-widest text-[#FACC15] mb-3">
                Tentang Kami
            </p>

            <h1 class="text-4xl md:text-6xl font-black leading-tight">
                CV. ANUGRAH MURNI SEJATI
            </h1>

            <p class="text-white/80 mt-4 text-sm md:text-base leading-relaxed">
                Solusi digital printing modern dengan kualitas premium, cepat, dan terpercaya untuk semua kebutuhan cetak Anda.
            </p>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('products.index') }}"
                   class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition">
                    Lihat Produk
                </a>

                <a href="https://wa.me/6282184732885"
                   class="px-6 py-3 border border-white/30 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white/10 transition">
                    Hubungi Kami
                </a>
            </div>

        </div>

    </section>


    {{-- ================= ABOUT ================= --}}
    <section class="grid lg:grid-cols-2 gap-10 items-center">

        <div class="bg-white border rounded-2xl shadow-sm p-8">
            <h2 class="text-lg font-black text-[#1E3A8A] mb-3">Tentang Kami</h2>

            <p class="text-sm text-slate-600 leading-relaxed">
                Berawal dari workshop kecil, kami berkembang menjadi perusahaan digital printing profesional
                dengan teknologi modern dan standar kualitas tinggi.
            </p>

            <p class="text-sm text-slate-600 mt-3">
                Kami berkomitmen memberikan hasil cetak terbaik dengan presisi warna, ketahanan material,
                dan pelayanan cepat.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4">

            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm">
                <p class="text-3xl font-black text-[#1E3A8A]">5+</p>
                <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest">Tahun</p>
            </div>

            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm">
                <p class="text-3xl font-black text-[#EF4444]">1000+</p>
                <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest">Client</p>
            </div>

            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm">
                <p class="text-3xl font-black text-[#1E3A8A]">99%</p>
                <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest">Kepuasan</p>
            </div>

            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm">
                <p class="text-3xl font-black text-[#FACC15]">24H</p>
                <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest">Support</p>
            </div>

        </div>

    </section>


    {{-- ================= VISI MISI ================= --}}
    <section class="space-y-6">

        <div>
            <h2 class="text-2xl font-black text-[#1E3A8A]">Visi & Misi</h2>
            <p class="text-sm text-slate-500">Arah dan tujuan perusahaan kami</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            {{-- VISI --}}
            <div class="bg-white border rounded-2xl p-6 shadow-sm">
                <h3 class="font-black text-[#EF4444] mb-2">Visi</h3>
                <p class="text-sm text-slate-600">
                    Menjadi perusahaan digital printing terdepan di Indonesia dengan kualitas dan inovasi terbaik.
                </p>
            </div>

            {{-- MISI --}}
            <div class="bg-white border rounded-2xl p-6 shadow-sm">
                <h3 class="font-black text-[#1E3A8A] mb-3">Misi</h3>

                <ul class="space-y-2 text-sm text-slate-600">
                    <li>• Menggunakan teknologi cetak modern</li>
                    <li>• Memberikan layanan cepat & responsif</li>
                    <li>• Menjaga kualitas produk terbaik</li>
                    <li>• Memberikan harga kompetitif</li>
                </ul>

            </div>

        </div>

    </section>


    {{-- ================= SERVICES ================= --}}
    <section class="space-y-6">

        <div>
            <h2 class="text-2xl font-black text-[#1E3A8A]">Layanan Kami</h2>
            <p class="text-sm text-slate-500">Solusi lengkap kebutuhan cetak</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach ([
                ['title'=>'Indoor & Outdoor','desc'=>'Banner, stiker, dan media promosi'],
                ['title'=>'Offset Printing','desc'=>'Brosur, katalog, dan kartu nama'],
                ['title'=>'Merchandise','desc'=>'Souvenir & branding custom'],
            ] as $item)

            <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition">

                <div class="w-10 h-10 bg-[#FACC15]/20 rounded-xl flex items-center justify-center mb-3">
                    🎯
                </div>

                <h3 class="font-bold text-[#1E3A8A]">{{ $item['title'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $item['desc'] }}</p>

            </div>

            @endforeach

        </div>

    </section>


    {{-- ================= CTA ================= --}}
    <section class="bg-[#1E3A8A] rounded-2xl p-10 text-center text-white">

        <h2 class="text-2xl font-black">Siap Cetak Sekarang?</h2>
        <p class="text-sm text-white/70 mt-2">
            Gunakan layanan kami untuk hasil terbaik
        </p>

        <div class="mt-6">
            <a href="{{ url('/rekomendasi') }}"
               class="px-6 py-3 bg-[#FACC15] text-[#1E3A8A] rounded-xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition">
                Mulai Rekomendasi
            </a>
        </div>

    </section>

</div>

@endsection