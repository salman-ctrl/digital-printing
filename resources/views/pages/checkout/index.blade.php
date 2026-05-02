@extends('layouts.guest')

@section('content')
    {{-- Load Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="min-h-screen bg-gray-50 pt-20 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Bar -->
            <div class="mb-12">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center text-blue-600">
                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 border-2 border-blue-600 font-semibold text-sm">1</span>
                        <span class="ml-2 font-medium">Keranjang</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-600 rounded"></div>
                    <div class="flex items-center text-blue-600">
                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-semibold text-sm">2</span>
                        <span class="ml-2 font-semibold">Checkout</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-200 rounded"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 border-2 border-gray-200 font-semibold text-sm">3</span>
                        <span class="ml-2 font-medium">Pembayaran</span>
                    </div>
                </div>
            </div>

            {{-- Form membungkus seluruh konten --}}
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                {{-- FIX: Input Hidden untuk mengirimkan ID item yang dipilih ke Controller --}}
                @foreach($cartItems as $item)
                    <input type="hidden" name="cart_item_ids[]" value="{{ $item->id }}">
                @endforeach

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Order Items -->
                        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-blue-50 to-transparent">
                                <h2 class="text-xl font-bold text-gray-900 capitalize tracking-tight">Ringkasan Pesanan</h2>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black rounded-full capitalize tracking-wider">
                                    {{ $cartItems->count() }} Item
                                </span>
                            </div>
                            <div class="divide-y divide-gray-50">
                                @foreach($cartItems as $item)
                                    <div class="p-6 flex gap-6">
                                        <div class="w-24 h-24 bg-gray-100 rounded-2xl flex-shrink-0 flex items-center justify-center overflow-hidden border border-gray-100 shadow-inner">
                                            <img src="{{ $item->specification->product->image_url }}"
                                                alt="{{ $item->specification->product->name }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.src='https://placehold.co/200x200?text=No+Image'">
                                        </div>

                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-lg leading-tight capitalize tracking-tight">{{ $item->specification->product->name }}</h3>
                                                    <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mt-1">Detail Biaya:</p>
                                                    <div class="mt-2 space-y-1">
                                                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-600 capitalize">
                                                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                                                            <span>Harga Produk: Rp {{ number_format($item->specification->harga, 0, ',', '.') }} x {{ $item->quantity }}</span>
                                                        </div>
                                                        
                                                        @if($item->design_cost > 0)
                                                            <div class="flex items-center gap-2 text-[10px] font-bold text-red-600 capitalize">
                                                                <span class="w-1.5 h-1.5 bg-red-300 rounded-full"></span>
                                                                <span>Jasa Desain ({{ $item->design_difficulty }}): Rp {{ number_format($item->design_cost, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endif

                                                        @if($item->need_installation)
                                                            <div class="flex items-center gap-2 text-[10px] font-bold text-blue-600 capitalize">
                                                                <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>
                                                                <span>Jasa Pasang: Rp {{ number_format($item->installation_price, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <p class="text-[10px] font-black text-gray-400 capitalize tracking-widest mt-3">Spesifikasi:</p>
                                                    <div class="flex flex-wrap gap-2 mt-2">
                                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg capitalize tracking-tight">{{ $item->specification->material }}</span>
                                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg capitalize tracking-tight">{{ $item->specification->size }}</span>
                                                        
                                                        @if($item->design_option === 'upload')
                                                            <span class="px-2.5 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg capitalize tracking-tight flex items-center gap-1">
                                                                <i data-lucide="file-check" class="w-3 h-3"></i> Desain Sendiri
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-lg font-black text-blue-600 tracking-tighter">Rp {{ number_format(($item->specification->harga * $item->quantity) + $item->design_cost + $item->installation_price, 0, ',', '.') }}</p>
                                                    <p class="text-[9px] font-bold text-gray-400 mt-1 tracking-widest">
                                                        Total Per Item
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Informasi Penerima -->
                        <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                            <div class="flex items-center gap-3 mb-8">
                                <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                                <h2 class="text-xl font-bold text-gray-900 capitalize tracking-tight">Informasi Penerima</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                    <input type="text" value="{{ auth()->user()->name }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-100 outline-none bg-gray-50 font-bold text-gray-700"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Alamat Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-100 outline-none bg-gray-50 font-bold text-gray-700"
                                        readonly>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-gray-400 capitalize tracking-widest mb-2 ml-1">Catatan Pesanan (Opsional)</label>
                                    <textarea name="notes"
                                        placeholder="Tuliskan instruksi tambahan seperti ukuran custom, catatan warna, atau detail pengemasan..."
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all outline-none h-32 text-sm shadow-inner"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Summary & Payment -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-50 capitalize tracking-tight">Detail Pembayaran</h2>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-bold capitalize tracking-widest text-[10px]">Subtotal Item</span>
                                    <span class="font-black text-gray-700">Rp {{ number_format($cartItems->sum(function ($i) { return ($i->specification->harga * $i->quantity) + $i->design_cost + $i->installation_price; }), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-bold capitalize tracking-widest text-[10px]">Biaya Layanan</span>
                                    <span class="text-green-600 font-black italic text-[10px] capitalize">Gratis</span>
                                </div>
                                <div class="pt-6 border-t border-gray-100 flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 capitalize tracking-[0.2em]">Total Tagihan</p>
                                        <p class="text-3xl font-black text-blue-600 mt-1 tracking-tighter">Rp {{ number_format($cartItems->sum(function ($i) { return ($i->specification->harga * $i->quantity) + $i->design_cost + $i->installation_price; }), 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-xs capitalize tracking-[0.2em] py-5 rounded-2xl shadow-lg shadow-blue-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                <span>Konfirmasi & Bayar</span>
                            </button>

                            <p class="mt-6 text-center text-[9px] text-gray-400 font-bold capitalize leading-relaxed tracking-wider">
                                Aman & Terenkripsi. Dengan membayar, Anda menyetujui <a href="#" class="text-blue-500 hover:underline">S&K</a> kami.
                            </p>

                            <div class="mt-8 pt-8 border-t border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 capitalize tracking-widest text-center mb-6">Metode Pembayaran Tersedia</p>
                                <div class="grid grid-cols-2 gap-3 opacity-50 grayscale">
                                    <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col items-center gap-2">
                                        <i data-lucide="landmark" class="w-4 h-4"></i>
                                        <span class="text-[7px] font-black capitalize tracking-widest">Transfer Bank</span>
                                    </div>
                                    <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col items-center gap-2">
                                        <i data-lucide="wallet" class="w-4 h-4"></i>
                                        <span class="text-[7px] font-black capitalize tracking-widest">QRIS / E-Wallet</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endsection
