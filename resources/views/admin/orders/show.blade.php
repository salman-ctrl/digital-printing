@extends('layouts.admin')

@section('content')
<div class="space-y-10 text-slate-800 font-[Inter]">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}"
               class="p-3 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition shadow-sm text-slate-500 hover:text-[#1E3A8A]">
                ←
            </a>

            <div>
                <h1 class="text-3xl font-black tracking-tight text-[#1E3A8A]">
                    Detail Transaksi
                </h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">
                    #{{ $order->order_code }}
                </p>
            </div>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="flex items-center gap-3">

            <button onclick="window.print()"
                class="px-6 py-3 bg-[#1E3A8A] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#1e40af] transition">
                Print Invoice
            </button>

            {{-- STATUS --}}
            <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest
                {{
                    $order->status === 'paid'
                        ? 'bg-[#FACC15]/20 text-[#1E3A8A]'
                        : ($order->status === 'pending'
                            ? 'bg-slate-100 text-slate-600'
                            : 'bg-[#EF4444]/10 text-[#EF4444]')
                }}">
                {{ $order->status }}
            </span>

        </div>
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- ITEM CARD --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                <div class="p-6 bg-slate-50 border-b border-slate-200 flex justify-between">
                    <h3 class="font-black uppercase text-xs tracking-widest text-slate-500">
                        Item Pesanan
                    </h3>

                    <span class="text-[10px] font-bold text-slate-400 uppercase">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </span>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4 text-left">Produk</th>
                            <th class="px-6 py-4 text-center">Harga</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->details ?? [] as $item)
                        <tr class="hover:bg-slate-50 transition">

                            {{-- PRODUCT --}}
                            <td class="px-6 py-6">
                                <div class="font-bold text-slate-900">
                                    {{ $item->specification->product->name ?? 'Produk' }}
                                </div>
                                <div class="text-[10px] text-slate-400 uppercase font-bold tracking-widest mt-1">
                                    {{ $item->specification->material ?? '-' }} • {{ $item->specification->size ?? '-' }}
                                </div>
                                
                                {{-- DESIGN & INSTALLATION INFO --}}
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @if($item->design_option === 'upload')
                                        <span class="px-2 py-1 bg-blue-50 text-[9px] font-black text-blue-600 rounded uppercase tracking-tighter">
                                            File: {{ $item->design_file ? 'Uploaded' : 'No File' }}
                                        </span>
                                        @if($item->design_file)
                                            <a href="{{ asset('storage/' . $item->design_file) }}" target="_blank" class="px-2 py-1 bg-slate-100 text-[9px] font-black text-slate-500 rounded uppercase tracking-tighter hover:bg-slate-200">
                                                Download File
                                            </a>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 bg-purple-50 text-[9px] font-black text-purple-600 rounded uppercase tracking-tighter">
                                            Jasa Desain ({{ $item->design_difficulty }})
                                        </span>
                                    @endif

                                    @if($item->need_installation)
                                        <span class="px-2 py-1 bg-green-50 text-[9px] font-black text-green-600 rounded uppercase tracking-tighter">
                                            + Jasa Pasang
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- PRICE --}}
                            <td class="px-6 py-6 text-center text-slate-600 font-semibold">
                                Rp{{ number_format($item->price) }}
                                @if($item->design_cost > 0)
                                    <div class="text-[9px] text-purple-500">+Desain: Rp{{ number_format($item->design_cost) }}</div>
                                @endif
                                @if($item->installation_price > 0)
                                    <div class="text-[9px] text-green-500">+Pasang: Rp{{ number_format($item->installation_price) }}</div>
                                @endif
                            </td>

                            {{-- QTY --}}
                            <td class="px-6 py-6 text-center font-bold">
                                {{ $item->quantity }}
                            </td>

                            {{-- SUBTOTAL --}}
                            <td class="px-6 py-6 text-right font-bold text-[#1E3A8A]">
                                Rp{{ number_format($item->subtotal) }}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- TOTAL --}}
                <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <div class="text-right space-y-2">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                            Total Pembayaran
                        </p>
                        <p class="text-2xl font-black text-[#1E3A8A]">
                            Rp{{ number_format($order->total_price) }}
                        </p>
                    </div>
                </div>

            </div>

        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="space-y-6">

            {{-- CUSTOMER --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <h3 class="font-black uppercase text-xs text-slate-500 tracking-widest mb-5">
                    Customer
                </h3>

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 bg-[#FACC15]/20 text-[#1E3A8A] rounded-full flex items-center justify-center font-black">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $order->user->email ?? '-' }}</p>
                    </div>

                </div>
            </div>

            {{-- INFO --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <h3 class="font-black uppercase text-xs text-slate-500 tracking-widest mb-5">
                    Informasi Order
                </h3>

                <div class="space-y-4 text-sm">

                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Order ID</p>
                        <p class="font-bold text-slate-900">#{{ $order->order_code }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Tanggal</p>
                        <p class="font-semibold text-slate-700">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Status</p>
                        <p class="font-bold capitalize text-slate-800">{{ $order->status }}</p>
                    </div>

                </div>

            </div>

            {{-- NOTE --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <h3 class="font-black uppercase text-xs text-slate-500 tracking-widest mb-3">
                    Catatan
                </h3>

                <p class="text-sm text-slate-500">
                    {{ $order->note ?? 'Tidak ada catatan dari pelanggan.' }}
                </p>

            </div>

        </div>

    </div>

    {{-- ================= FEEDBACK ================= --}}
    {{-- placeholder loading / error jika nanti pakai async data --}}

</div>
@endsection