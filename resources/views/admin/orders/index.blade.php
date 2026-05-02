@extends('layouts.admin')

@section('content')
<div class="space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">

        <div>
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight">
                Riwayat Transaksi
            </h1>
            <p class="text-sm text-slate-500 mt-1 tracking-widest">
                Kelola dan pantau seluruh transaksi masuk Anda.
            </p>
        </div>

        {{-- ================= ACTION BUTTON ================= --}}
        <div class="flex flex-wrap gap-3 w-full md:w-auto">

            {{-- HISTORY DATA --}}
            <a href="{{ route('admin.orders.history') }}"
            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3
                   bg-[#FACC15]/20 text-[#1E3A8A]
                   rounded-2xl hover:bg-[#FACC15]/30 transition
                   text-xs font-black tracking-widest uppercase">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 8v4l3 3"/>
                    <path stroke-width="2" d="M12 3a9 9 0 100 18 9 9 0 000-18z"/>
                </svg>

                Histori Data
            </a>

            {{-- EXPORT --}}
            <a href="{{ route('orders.export') }}"
            class="flex items-center gap-2 px-6 py-3
                   bg-[#1E3A8A] text-white
                   rounded-2xl hover:bg-[#1e40af] transition
                   text-xs font-black tracking-widest uppercase shadow-sm">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 4v10m0 0l-4-4m4 4l4-4M4 20h16"/>
                </svg>

                Export Data
            </a>

        </div>
    </div>

    {{-- ================= CONTENT (TABLE CARD) ================= --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-8 py-5 bg-slate-50 border-b border-slate-200">
            <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest">
                Daftar Transaksi
            </h3>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-widest">
                    <tr>
                        <th class="px-8 py-5 text-left">Order ID</th>
                        <th class="px-8 py-5 text-left">Pelanggan</th>
                        <th class="px-8 py-5 text-left">Tanggal</th>
                        <th class="px-8 py-5 text-left">Total</th>
                        <th class="px-8 py-5 text-left">Status</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @foreach($orders as $order)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- ORDER ID --}}
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-slate-900">
                                #{{ $order->order_code }}
                            </span>
                        </td>

                        {{-- USER --}}
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 bg-[#FACC15]/20 text-[#1E3A8A]
                                            rounded-2xl flex items-center justify-center font-black">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $order->user->name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 tracking-widest">
                                        Customer
                                    </p>
                                </div>

                            </div>
                        </td>

                        {{-- DATE --}}
                        <td class="px-8 py-5 text-xs text-slate-500 font-semibold">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="px-8 py-5 text-sm font-black text-[#1E3A8A]">
                            Rp{{ number_format($order->total_price) }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                {{
                                    $order->status === 'paid'
                                        ? 'bg-[#FACC15]/20 text-[#1E3A8A]'
                                        : ($order->status === 'pending'
                                            ? 'bg-slate-100 text-slate-500'
                                            : 'bg-[#EF4444]/10 text-[#EF4444]')
                                }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="inline-flex items-center justify-center w-10 h-10
                                      bg-slate-100 text-slate-500 rounded-2xl
                                      hover:bg-[#FACC15] hover:text-[#1E3A8A]
                                      transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                            </a>
                        </td>

                    </tr>
                    @endforeach

                    {{-- ================= EMPTY STATE ================= --}}
                    @if($orders->isEmpty())
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="w-14 h-14 bg-[#FACC15]/20 text-[#1E3A8A]
                                        rounded-full flex items-center justify-center mx-auto mb-4">
                                📦
                            </div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">
                                Belum Ada Transaksi
                            </p>
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

        {{-- ================= FEEDBACK / PAGINATION ================= --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200">
            <div class="text-xs font-semibold text-slate-500">
                {{ $orders->links() }}
            </div>
        </div>

    </div>
</div>
@endsection