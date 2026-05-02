@extends('layouts.admin')

@section('content')
@php
    $cat = $category;
@endphp

<div class="space-y-10 pb-10 font-[Inter] text-slate-800">

    @if(session('success'))
    <div id="successAlert"
        class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow-sm flex items-center justify-between">

        <div class="flex items-center gap-3">
            <span class="font-semibold text-sm">
                {{ session('success') }}
            </span>
        </div>

        <button onclick="document.getElementById('successAlert').remove()"
                class="text-green-700 font-bold hover:text-green-900">
            ✕
        </button>
    </div>
    @endif

    {{-- ================= HEADER ================= --}}
    <div class="flex items-start gap-4 border-b border-slate-200 pb-6">

        {{-- BACK --}}
        <a href="{{ route('admin.categories.index') }}"
           class="p-2 bg-[#FACC15]/20 text-[#1E3A8A] rounded-xl hover:bg-[#FACC15]/30 transition">
            ←
        </a>

        <div class="flex-1">

            {{-- BREADCRUMB --}}
            <div class="flex items-center gap-2 text-[10px] text-slate-400 mb-2 uppercase tracking-widest font-black">

                <a href="{{ route('admin.categories.index') }}"
                   class="hover:text-[#1E3A8A] transition">
                    Kategori
                </a>

                @if($cat->parent)
                    <span>›</span>
                    <span>{{ $cat->parent->name }}</span>
                @endif

                <span>›</span>

                <span class="text-[#1E3A8A] font-black">
                    {{ $cat->name }}
                </span>

            </div>

            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                {{ $cat->name }}
            </h1>

            <p class="text-xs text-slate-500 mt-1 tracking-widest">
                ID: #{{ $cat->id }} •
                {{ $cat->parent_id ? 'Sub Kategori' : 'Kategori Utama' }}
            </p>

        </div>

    </div>

    {{-- ================= SUB KATEGORI ================= --}}
    <div class="space-y-5">

        <h2 class="text-xs font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 bg-[#FACC15] rounded-full"></span>
            Sub Kategori ({{ $subCategories->count() }})
        </h2>

        @if($subCategories->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @foreach($subCategories as $sub)

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">

                    <div class="flex items-start justify-between gap-3">

                        <a href="{{ route('admin.categories.show', $sub->id) }}"
                           class="flex items-center gap-3 group flex-1">

                            <div class="p-2 bg-[#FACC15]/20 rounded-xl text-[#1E3A8A]
                                        group-hover:bg-[#FACC15] group-hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-slate-800 group-hover:text-[#1E3A8A] transition">
                                    {{ $sub->name }}
                                </h4>

                                <p class="text-[10px] text-slate-400 tracking-widest">
                                    {{ $sub->products_count ?? 0 }} Produk
                                </p>
                            </div>

                        </a>

                        {{-- ACTION SUB CATEGORY --}}
                        <div class="flex gap-1">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.categories.edit', $sub->id) }}"
                            class="p-2 text-[#1E3A8A] hover:bg-[#FACC15]/20 rounded-xl border border-transparent hover:border-[#FACC15]/30 transition"
                            title="Edit">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                    <path stroke-width="2"
                                        d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>

                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('admin.categories.destroy', $sub->id) }}"
                                method="POST"
                                class="deleteForm inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        onclick="openDeleteModal(this)"
                                        class="p-2 text-[#EF4444] hover:bg-red-50 rounded-xl border border-transparent hover:border-red-200 transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"/>
                                    </svg>

                                </button>
                            </form>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        @else

            <div class="p-8 bg-white rounded-2xl border border-dashed border-slate-300 text-center">
                <p class="text-xs text-slate-400 tracking-widest uppercase font-black">
                    Belum ada sub kategori
                </p>
            </div>

        @endif

    </div>

    {{-- ================= PRODUK ================= --}}
    <div class="space-y-5 pt-4">

        <h2 class="text-xs font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 bg-[#EF4444] rounded-full"></span>
            Produk ({{ $products->count() }})
        </h2>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] tracking-widest font-black">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Harga</th>
                        <th class="px-6 py-4 text-left">Stok</th>
                        <th class="px-6 py-4 text-left">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition">


                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $product->id_produk ?? $product->id }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            Rp {{ number_format($product->installation_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $product->stok ?? 0 }}
                        </td>

                        <td class="px-6 py-4">
                            @if(($product->stok ?? 0) > 0)
                                <span class="px-3 py-1 text-[10px] font-black rounded-full bg-green-100 text-green-600 tracking-widest">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-black rounded-full bg-red-100 text-red-600 tracking-widest">
                                    Habis
                                </span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 text-xs font-black tracking-widest uppercase">
                            Belum ada produk
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">

        <div class="w-16 h-16 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-5">
            ⚠️
        </div>

        <h3 class="text-xl font-black text-slate-800">
            Hapus Kategori?
        </h3>

        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Apakah Anda yakin ingin menghapus data ini?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <div class="flex gap-3 mt-8">

            <button type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">
                Batal
            </button>

            <button type="button"
                    onclick="submitDeleteForm()"
                    class="flex-1 py-3 rounded-2xl bg-[#EF4444] text-white font-bold hover:bg-red-600 transition">
                Ya, Hapus
            </button>

        </div>

    </div>

</div>

<script>
let activeDeleteForm = null;

function openDeleteModal(button) {
    activeDeleteForm = button.closest('form');
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    activeDeleteForm = null;
}

function submitDeleteForm() {
    if (activeDeleteForm) {
        activeDeleteForm.submit();
    }
}

window.addEventListener('click', function(e){
    const modal = document.getElementById('deleteModal');
    if(e.target === modal){
        closeDeleteModal();
    }
});
</script>

<script>
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if(alert){
        alert.remove();
    }
}, 3000);
</script>
@endsection