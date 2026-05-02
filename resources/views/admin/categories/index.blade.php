@extends('layouts.admin')

@section('content')
<div class="space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-end">

        <div>
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                Kategori Produk
            </h1>

            <p class="text-sm text-slate-500 mt-1 tracking-widest">
                Kelola struktur kategori utama & sub kategori
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="bg-[#FACC15] text-[#1E3A8A] px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-yellow-400 transition shadow-sm">
            + Tambah Kategori
        </a>

    </div>

    {{-- ================= FEEDBACK ================= --}}
    @if(session('success'))
        <div class="bg-[#FACC15]/20 text-[#1E3A8A] p-4 rounded-2xl text-xs font-black uppercase tracking-widest border border-[#FACC15]/30">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= CONTENT ================= --}}
    <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm">

        {{-- HEADER TABLE --}}
        <div class="p-5 border-b border-slate-200 bg-slate-50">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-500">
                Data Kategori
            </h3>

            <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest">
                Hanya kategori utama ditampilkan di tabel
            </p>
        </div>

        <table class="w-full text-left text-sm">

            {{-- HEAD --}}
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Struktur</th>
                    <th class="px-6 py-4 text-center">Sub Kategori</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-slate-100">

                {{-- HANYA TAMPILKAN KATEGORI UTAMA --}}
                @forelse($categories->whereNull('parent_id') as $cat)

                <tr class="hover:bg-slate-50 transition">

                    {{-- ID --}}
                    <td class="px-6 py-4 font-mono text-slate-400 text-xs">
                        #{{ $cat->id }}
                    </td>

                    {{-- KATEGORI --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                @if($cat->image_url)
                                    <img src="{{ $cat->image_url }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-[#FACC15]">📁</span>
                                @endif
                            </div>

                            <div>
                                <p class="font-semibold text-slate-800 text-sm">
                                    {{ $cat->name }}
                                </p>

                                <p class="text-xs text-slate-400 tracking-widest">
                                    Kategori Utama
                                </p>
                            </div>

                        </div>
                    </td>

                    {{-- STRUKTUR --}}
                    <td class="px-6 py-4 text-xs">
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-black text-[10px] uppercase tracking-widest">
                            Root
                        </span>
                    </td>

                    {{-- SUB CATEGORY --}}
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            {{ $cat->children_count > 0
                                ? 'bg-[#FACC15]/20 text-[#1E3A8A]'
                                : 'bg-slate-100 text-slate-400' }}">
                            {{ $cat->children_count ?? 0 }} Sub
                        </span>
                    </td>

                    {{-- ACTION --}}
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">

                            {{-- DETAIL --}}
                            <a href="{{ route('admin.categories.show', $cat->id) }}"
                               class="p-2 text-slate-500 hover:text-[#1E3A8A] border border-slate-200 rounded-xl hover:bg-slate-50 transition"
                               title="Lihat Detail">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-4 h-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
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
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
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
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-slate-400 text-sm italic">
                        Belum ada kategori tersedia
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">

        <h3 class="text-xl font-black text-slate-800">
            Hapus Kategori?
        </h3>

        <p class="text-sm text-slate-500 mt-2">
            Apakah Anda yakin ingin menghapus kategori ini?
        </p>

        <div class="flex gap-3 mt-8">

            <button onclick="closeDeleteModal()"
                    class="flex-1 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">
                Batal
            </button>

            <button onclick="submitDeleteForm()"
                    class="flex-1 py-3 rounded-2xl bg-[#EF4444] text-white font-bold hover:bg-red-600 transition">
                Ya, Hapus
            </button>

        </div>

    </div>
</div>

<script>
let activeDeleteForm = null;

function openDeleteModal(button){
    activeDeleteForm = button.closest('form');
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal(){
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    activeDeleteForm = null;
}

function submitDeleteForm(){
    if(activeDeleteForm){
        activeDeleteForm.submit();
    }
}
</script>

@endsection