@extends('layouts.admin')

@section('content')

{{-- STYLE SHORTCUT --}}
@php
    $table = "w-full text-sm";
    $th = "px-8 py-5 text-[10px] font-black text-slate-500 tracking-widest uppercase";
    $td = "px-8 py-4 text-xs text-slate-700 border-t border-slate-100";
    $card = "bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden";
    $sectionHeader = "px-8 py-5 bg-slate-50 border-b border-slate-200";
@endphp

<div class="space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#1E3A8A]">
                Analisis TOPSIS
            </h1>
            <p class="text-sm text-slate-500 tracking-widest mt-1">
                Detail perhitungan keputusan produk
            </p>
        </div>
    </div>

    {{-- ================= HISTORY / LOGS ================= --}}
    <div class="{{ $card }}">
        <div class="{{ $sectionHeader }} flex justify-between items-center">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Riwayat Perhitungan
            </h2>
            <span class="text-[10px] font-bold text-slate-400">Menampilkan 10 terakhir</span>
        </div>
        <div class="overflow-x-auto">
            <table class="{{ $table }}">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Waktu</th>
                        <th class="{{ $th }}">User</th>
                        <th class="{{ $th }}">Kategori</th>
                        <th class="{{ $th }}">Status</th>
                        <th class="{{ $th }}">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition {{ $selectedLog && $selectedLog->id == $log->id ? 'bg-blue-50/50' : '' }}">
                            <td class="{{ $td }}">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="{{ $td }}">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">{{ $log->user->name ?? 'Guest' }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $log->user ? 'Member' : 'Pengunjung' }}</span>
                                </div>
                            </td>
                            <td class="{{ $td }}">
                                <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 font-bold text-[10px]">
                                    {{ $log->category->name }}
                                </span>
                            </td>
                            <td class="{{ $td }}">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-emerald-600 font-bold text-[10px]">Saved</span>
                                </span>
                            </td>
                            <td class="{{ $td }}">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.topsis.index', ['log_id' => $log->id]) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[10px] font-bold text-slate-600 hover:bg-slate-50 transition gap-2 shadow-sm">
                                        Lihat Detail
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                    <form action="{{ route('admin.topsis.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-400 hover:text-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="{{ $td }} text-center py-10 text-slate-400">
                                Belum ada riwayat perhitungan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-100">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @if($selectedLog)
    <div class="p-6 bg-[#1E3A8A] rounded-2xl text-white flex flex-col md:flex-row justify-between items-center gap-6 shadow-lg shadow-blue-900/20">
        <div class="flex items-center gap-5">
            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-2xl">
                📊
            </div>
            <div>
                <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.2em] mb-0.5">Detail Terpilih</p>
                <h3 class="text-xl font-black">{{ $selectedLog->category->name }}</h3>
            </div>
        </div>
        <div class="flex gap-4 w-full md:w-auto">
            <div class="flex-1 md:flex-none bg-white/5 border border-white/10 px-6 py-3 rounded-xl backdrop-blur-sm">
                <p class="text-blue-200 text-[8px] font-black uppercase tracking-widest mb-1">User</p>
                <p class="font-bold text-sm">{{ $selectedLog->user->name ?? 'Guest' }}</p>
            </div>
            <div class="flex-1 md:flex-none bg-white/5 border border-white/10 px-6 py-3 rounded-xl backdrop-blur-sm">
                <p class="text-blue-200 text-[8px] font-black uppercase tracking-widest mb-1">Waktu</p>
                <p class="font-bold text-sm">{{ $selectedLog->created_at->format('H:i:s') }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- ========================= --}}
    {{-- 1. MATRIX --}}
    {{-- ========================= --}}
    <div class="{{ $card }}">

        <div class="{{ $sectionHeader }}">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Matriks Keputusan (X)
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="{{ $table }}">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Alt</th>
                        @foreach($criterias as $c)
                            <th class="{{ $th }}">
                                <div class="flex flex-col items-center">
                                    <span>{{ $c->name }}</span>
                                    <span class="text-[8px] text-slate-400">C{{ $loop->iteration }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($topsis['matrix'] ?? [] as $row)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="{{ $td }} font-black text-slate-900">
                                A{{ $loop->iteration }}
                            </td>
                            @foreach($criterias as $c)
                                <td class="{{ $td }}">
                                    {{ $row[$c->id] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{-- ========================= --}}
    {{-- 2. NORMALISASI --}}
    {{-- ========================= --}}
    <div class="{{ $card }}">

        <div class="{{ $sectionHeader }}">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Normalisasi (R)
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="{{ $table }}">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Alt</th>
                        @foreach($criterias as $c)
                            <th class="{{ $th }}">
                                <div class="flex flex-col items-center">
                                    <span>{{ $c->name }}</span>
                                    <span class="text-[8px] text-slate-400">C{{ $loop->iteration }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($topsis['normalized_matrix'] ?? [] as $row)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="{{ $td }} font-black text-slate-900">
                                A{{ $loop->iteration }}
                            </td>
                            @foreach($criterias as $c)
                                <td class="{{ $td }}">
                                    {{ number_format($row[$c->id] ?? 0, 4) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{-- ========================= --}}
    {{-- 3. WEIGHTED --}}
    {{-- ========================= --}}
    <div class="{{ $card }}">

        <div class="{{ $sectionHeader }}">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Matriks Terbobot (Y)
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="{{ $table }}">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Alt</th>
                        @foreach($criterias as $c)
                            <th class="{{ $th }}">
                                <div class="flex flex-col items-center">
                                    <span>{{ $c->name }}</span>
                                    <span class="text-[8px] text-slate-400">C{{ $loop->iteration }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($topsis['weighted_matrix'] ?? [] as $row)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="{{ $td }} font-black text-slate-900">
                                A{{ $loop->iteration }}
                            </td>
                            @foreach($criterias as $c)
                                <td class="{{ $td }}">
                                    {{ number_format($row[$c->id] ?? 0, 4) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{-- ========================= --}}
    {{-- 4. IDEAL --}}
    {{-- ========================= --}}
    <div class="{{ $card }}">

        <div class="{{ $sectionHeader }}">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Solusi Ideal
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="{{ $table }}">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Kriteria</th>
                        <th class="{{ $th }}">A+</th>
                        <th class="{{ $th }}">A-</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($criterias as $c)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="{{ $td }} font-black text-slate-900">
                                {{ $c->name }}
                            </td>

                            <td class="{{ $td }} text-[#1E3A8A] font-bold">
                                {{ number_format($topsis['ideal_positive'][$c->id] ?? 0, 4) }}
                            </td>

                            <td class="{{ $td }} text-[#EF4444] font-bold">
                                {{ number_format($topsis['ideal_negative'][$c->id] ?? 0, 4) }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{-- ========================= --}}
    {{-- 5. RANKING --}}
    {{-- ========================= --}}
    <div class="{{ $card }}">

        <div class="{{ $sectionHeader }}">
            <h2 class="text-xs font-black tracking-widest text-slate-500 uppercase">
                Ranking Produk
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="{{ $table }}">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="{{ $th }}">Rank</th>
                        <th class="{{ $th }}">Produk</th>
                        <th class="{{ $th }}">D+</th>
                        <th class="{{ $th }}">D-</th>
                        <th class="{{ $th }}">Skor</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($topsis['results'] ?? [] as $i => $r)
                        <tr class="hover:bg-slate-50 transition {{ $i == 0 ? 'bg-[#FACC15]/10' : '' }}">

                            <td class="{{ $td }}">
                                <span class="px-2 py-1 rounded-xl text-[10px] font-black bg-slate-100 text-slate-600">
                                    #{{ $i+1 }}
                                </span>
                            </td>

                            <td class="{{ $td }} font-black text-slate-900">
                                {{ $r['specification']->product->name ?? '-' }}
                            </td>

                            <td class="{{ $td }}">
                                {{ number_format($r['d_plus'], 4) }}
                            </td>

                            <td class="{{ $td }}">
                                {{ number_format($r['d_minus'], 4) }}
                            </td>

                            <td class="{{ $td }} font-black text-[#1E3A8A]">
                                {{ number_format($r['preference_value'], 4) }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    {{-- ================= FEEDBACK ================= --}}
    {{-- Placeholder untuk loading / error state --}}
</div>

@endsection