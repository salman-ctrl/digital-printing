<footer class="bg-white border-t border-slate-200 pt-16 pb-8">
    <div class="container mx-auto px-6">

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            {{-- COMPANY --}}
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-cv.png') }}"
                         class="h-12 bg-white p-1 rounded-xl border border-slate-200">

                    <div>
                        <p class="text-lg font-black text-[#1E3A8A] leading-tight">
                            MURNI
                        </p>
                        <p class="text-[10px] text-[#FACC15] font-bold tracking-widest uppercase">
                            Digital Printing
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-500 leading-relaxed">
                    Solusi cetak digital profesional dengan kualitas terbaik dan proses cepat.
                </p>

                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-bold hover:bg-[#FACC15] hover:text-[#1E3A8A] transition">
                        FB
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-bold hover:bg-[#FACC15] hover:text-[#1E3A8A] transition">
                        IG
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-bold hover:bg-[#FACC15] hover:text-[#1E3A8A] transition">
                        WA
                    </a>
                </div>
            </div>

            {{-- NAVIGASI --}}
            <div>
                <h4 class="text-sm font-black text-slate-700 mb-4 uppercase tracking-widest">
                    Navigasi
                </h4>

                <ul class="space-y-3 text-sm text-slate-500">
                    <li><a href="/" class="hover:text-[#1E3A8A] transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-[#1E3A8A] transition">Products</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Recommendation</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Profile</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Cara Pesan</a></li>
                </ul>
            </div>

            {{-- BANTUAN --}}
            <div>
                <h4 class="text-sm font-black text-slate-700 mb-4 uppercase tracking-widest">
                    Bantuan
                </h4>

                <ul class="space-y-3 text-sm text-slate-500">
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-[#1E3A8A] transition">Komplain</a></li>
                </ul>
            </div>

            {{-- KONTAK --}}
            <div>
                <h4 class="text-sm font-black text-slate-700 mb-4 uppercase tracking-widest">
                    Kontak
                </h4>

                <ul class="space-y-3 text-sm text-slate-500">
                    <li class="flex gap-2">
                        <span>📍</span>
                        <span>Padang, Sumatera Barat</span>
                    </li>
                    <li class="flex gap-2">
                        <span>📞</span>
                        <span>+62 853-2130-0300</span>
                    </li>
                    <li class="flex gap-2">
                        <span>✉️</span>
                        <span>anugrahmurnisejati@gmail.com</span>
                    </li>
                    <li class="flex gap-2">
                        <span>⏰</span>
                        <span>09:00 - 22:00</span>
                    </li>
                </ul>
            </div>

        </div>


        {{-- BOTTOM --}}
        <div class="border-t border-slate-200 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">

            <p class="text-xs text-slate-400">
                © {{ date('Y') }} CV Anugrah Murni Sejati
            </p>

            <div class="flex items-center gap-4 opacity-60">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" class="h-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" class="h-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/1200px-PayPal.svg.png" class="h-4">
            </div>

        </div>
    </div>
</footer>


{{-- FLOATING WA --}}
<a href="https://wa.me/6282184732885"
   target="_blank"
   class="fixed bottom-6 right-6 z-50
          bg-[#25D366]
          w-14 h-14 rounded-xl flex items-center justify-center
          shadow-md hover:shadow-lg hover:scale-105
          transition-all duration-300">

    {{-- WhatsApp Official Icon (SVG) --}}
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 32 32"
         class="w-7 h-7 fill-white">

        <path d="M19.11 17.53c-.27-.14-1.6-.79-1.85-.88-.25-.09-.43-.14-.61.14-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.14-1.13-.42-2.16-1.34-.8-.71-1.34-1.59-1.5-1.86-.16-.27-.02-.42.12-.56.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.02-.22-.53-.45-.46-.61-.47h-.52c-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.26 0 1.33.97 2.61 1.1 2.79.14.18 1.9 2.9 4.6 4.07.64.28 1.14.45 1.53.58.64.2 1.22.17 1.68.1.51-.08 1.6-.65 1.83-1.28.23-.63.23-1.18.16-1.28-.07-.1-.25-.16-.52-.3z"/>

        <path d="M16 3C9.37 3 4 8.37 4 15c0 2.11.55 4.09 1.51 5.81L4 29l8.39-1.47A11.93 11.93 0 0016 27c6.63 0 12-5.37 12-12S22.63 3 16 3zm0 21.5c-1.8 0-3.48-.5-4.92-1.37l-.35-.21-4.98.87.84-4.86-.23-.38A9.47 9.47 0 016.5 15c0-5.24 4.26-9.5 9.5-9.5s9.5 4.26 9.5 9.5-4.26 9.5-9.5 9.5z"/>
    </svg>

</a>