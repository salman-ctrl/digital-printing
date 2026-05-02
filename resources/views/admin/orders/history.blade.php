@extends('layouts.admin')

@section('content')
<div class="w-full px-4 py-8 space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="space-y-4">

        {{-- BACK BUTTON --}}
        <a href="{{ route('orders.index') }}"
           class="group flex items-center gap-2 text-slate-500 hover:text-[#1E3A8A] transition-all font-semibold text-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Dashboard
        </a>

        <div>
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight">
                Histori Transaksi Terhapus
            </h1>
            <p class="text-sm text-slate-500 tracking-widest mt-1">
                Data transaksi yang telah dihapus sementara (soft delete)
            </p>
        </div>

    </div>

    {{-- ================= ALERT ================= --}}
    <div class="bg-[#FACC15]/20 border border-[#FACC15]/40 p-6 rounded-2xl flex items-center gap-4">

        <div class="w-12 h-12 bg-[#FACC15]/30 text-[#1E3A8A]
                    rounded-2xl flex items-center justify-center">
            ⚠️
        </div>

        <div>
            <h2 class="text-sm font-black text-[#1E3A8A] tracking-widest uppercase">
                Histori Data Terhapus
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Data akan dihapus permanen setelah <b>5 hari</b>.
            </p>
        </div>
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-8 py-5 bg-slate-50 border-b border-slate-200">
            <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest">
                Data Transaksi Terhapus
            </h3>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-widest">
                    <tr>
                        <th class="px-8 py-5 text-left">ID Transaksi</th>
                        <th class="px-8 py-5 text-left">Nama Pelanggan</th>
                        <th class="px-8 py-5 text-center">Tanggal Dihapus</th>
                        <th class="px-8 py-5 text-center">Sisa Waktu</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody id="historyTable" class="divide-y divide-slate-100">
                    {{-- DIISI VIA JS --}}
                </tbody>
            </table>
        </div>

    </div>

    {{-- ================= FEEDBACK ================= --}}
    {{-- (placeholder untuk loading/error jika nanti pakai API) --}}

</div>

{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const table = document.getElementById('historyTable');

    const STORAGE_KEY = 'softDeletedTransactions';
    const FIVE_DAYS = 5 * 24 * 60 * 60 * 1000;

    let data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
    const now = new Date();

    // ================= FILTER DATA MASIH BERLAKU =================
    data = data.filter(item => {
        const deletedDate = new Date(item.deletedAt);
        return (now - deletedDate) < FIVE_DAYS;
    });

    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));

    // ================= FORMAT TANGGAL =================
    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    };

    // ================= SISA HARI =================
    const calculateDaysLeft = (deletedAt) => {
        const diff = new Date() - new Date(deletedAt);
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        return Math.max(0, 5 - days);
    };

    // ================= EMPTY STATE =================
    const renderEmpty = () => {
        table.innerHTML = `
            <tr>
                <td colspan="5" class="py-24 text-center">
                    <div class="w-14 h-14 bg-[#FACC15]/20 text-[#1E3A8A]
                                rounded-full flex items-center justify-center mx-auto mb-4">
                        📦
                    </div>

                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">
                        Belum ada data di tempat sampah
                    </p>
                </td>
            </tr>
        `;
    };

    // ================= RENDER TABLE =================
    const render = () => {

        if (data.length === 0) {
            renderEmpty();
            return;
        }

        table.innerHTML = '';

        data.forEach(trx => {

            const daysLeft = calculateDaysLeft(trx.deletedAt);

            const badgeColor = daysLeft <= 1
                ? 'bg-[#EF4444]/10 text-[#EF4444]'
                : 'bg-slate-100 text-slate-600';

            table.innerHTML += `
                <tr class="hover:bg-slate-50 transition">

                    <td class="px-8 py-5 font-mono font-bold text-slate-400">
                        #${trx.id_transaksi}
                    </td>

                    <td class="px-8 py-5 font-semibold text-slate-800">
                        ${trx.nama_pelanggan}
                    </td>

                    <td class="px-8 py-5 text-center text-xs text-slate-500">
                        ${formatDate(trx.deletedAt)}
                    </td>

                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ${badgeColor}">
                            ${daysLeft} hari lagi
                        </span>
                    </td>

                    <td class="px-8 py-5 text-center">
                        <button onclick="restore(${trx.id_transaksi})"
                            class="inline-flex items-center gap-2 px-4 py-2
                                   bg-[#1E3A8A] text-white rounded-xl
                                   hover:bg-[#1e40af]
                                   text-xs font-black tracking-widest uppercase transition">

                            🔄 Pulihkan
                        </button>
                    </td>

                </tr>
            `;
        });
    };

    // ================= RESTORE =================
    window.restore = (id) => {

        data = data.filter(item => item.id_transaksi !== id);

        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));

        alert('Data berhasil dipulihkan');

        render();
    };

    render();
});
</script>
@endsection