@extends('layouts.admin')

@section('content')
<div class="w-full space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-4">

        <a href="{{ route('admin.categories.index') }}"
            class="p-2 bg-[#FACC15]/20 text-[#1E3A8A] rounded-xl hover:bg-[#FACC15]/30 transition">
            ←
        </a>

        <div>
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                Edit Kategori
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi kategori produk
            </p>
        </div>

    </div>

    {{-- ================= FORM ================= --}}
    <form action="{{ route('admin.categories.update', $category->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        @csrf
        @method('PUT')
        <input type="hidden" name="remove_image" id="removeImageFlag" value="0">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-3 space-y-6">

            {{-- CARD --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-6">

                <h3 class="text-xs font-black text-slate-500 border-b pb-3 tracking-widest uppercase">
                    Informasi Kategori
                </h3>

                {{-- NAMA --}}
                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Nama Kategori
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $category->name) }}"
                           class="w-full mt-2 px-4 py-3 rounded-xl border border-slate-200
                                  focus:ring-2 focus:ring-[#FACC15]/40 focus:border-[#FACC15]
                                  text-sm font-semibold text-slate-800 outline-none transition"
                           placeholder="Contoh: Banner, Stiker, Undangan">
                </div>

                {{-- PARENT --}}
                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Induk Kategori
                    </label>

                    <select name="parent_id"
                            class="w-full mt-2 px-4 py-3 rounded-xl border border-slate-200
                                   focus:ring-2 focus:ring-[#FACC15]/40 focus:border-[#FACC15]
                                   text-sm font-semibold text-slate-800 bg-white outline-none transition">

                        <option value="">-- Jadikan Root Category --</option>

                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach

                    </select>

                    <p class="text-[10px] text-slate-400 mt-1 tracking-widest">
                        Opsional: pilih jika ini sub-kategori
                    </p>
                </div>

            </div>

            {{-- ================= ACTION BUTTON ================= --}}
            <div class="flex gap-3">

                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-3 bg-slate-100 text-slate-600
                          rounded-xl text-xs font-black tracking-widest uppercase
                          hover:bg-slate-200 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-3 bg-[#FACC15] text-[#1E3A8A]
                               rounded-xl text-xs font-black tracking-widest uppercase
                               hover:bg-[#EAB308] transition shadow-sm">
                    Update Kategori
                </button>

            </div>

        </div>

        {{-- ================= RIGHT ================= --}}
<div class="lg:col-span-1">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-full">

        <h3 class="text-xs font-black text-slate-500 mb-4 tracking-widest uppercase">
            Gambar Kategori
        </h3>

        {{-- WRAPPER --}}
        <div id="uploadBox"
             class="relative border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 min-h-[260px]
                    flex flex-col items-center justify-center hover:bg-slate-100 transition overflow-hidden">

            {{-- PREVIEW IMAGE --}}
            <img id="previewImage"
                 src="{{ $category->image ? $category->image : '#' }}"
                 class="{{ $category->image ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover rounded-xl">

            {{-- PLACEHOLDER --}}
            <div id="uploadPlaceholder"
                 class="{{ $category->image ? 'hidden' : '' }} text-center z-10">

                <div class="w-12 h-12 bg-[#FACC15]/20 rounded-full flex items-center justify-center mx-auto mb-2 text-[#1E3A8A]">
                    📷
                </div>

                <p class="text-xs text-slate-500 font-black tracking-widest uppercase">
                    Upload Gambar
                </p>

                <p class="text-[10px] text-slate-400 mt-1">
                    PNG, JPG, JPEG (max 2MB)
                </p>

            </div>

            {{-- LABEL CURRENT --}}
            @if($category->image)
            <div id="currentBadge"
                 class="absolute top-3 right-3 z-20">
                <span class="text-[10px] font-black text-[#1E3A8A] bg-[#FACC15]/30 px-3 py-1 rounded-full tracking-widest">
                    Current Image
                </span>
            </div>
            @endif

            {{-- INPUT FILE --}}
            <input type="file"
                   id="imageInput"
                   name="image"
                   accept="image/png,image/jpeg,image/jpg"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30">

        </div>

        {{-- REMOVE BUTTON --}}
        <button type="button"
                id="removeImage"
                class="mt-4 w-full py-3 rounded-xl bg-red-50 text-[#EF4444]
                       font-bold text-xs tracking-widest uppercase hover:bg-red-100 transition
                       {{ $category->image ? '' : 'hidden' }}">
            Hapus Gambar
        </button>

    </div>

</div>

{{-- ================= SCRIPT PREVIEW ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('imageInput');
    const preview = document.getElementById('previewImage');
    const placeholder = document.getElementById('uploadPlaceholder');
    const removeBtn = document.getElementById('removeImage');
    const currentBadge = document.getElementById('currentBadge');
    const removeFlag = document.getElementById('removeImageFlag');

    input.addEventListener('change', function () {

        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            removeBtn.classList.remove('hidden');

            if (currentBadge) currentBadge.classList.add('hidden');

            removeFlag.value = 0;
        }

        reader.readAsDataURL(file);
    });

    removeBtn.addEventListener('click', function () {

        input.value = '';
        preview.src = '#';
        preview.classList.add('hidden');

        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');

        if (currentBadge) currentBadge.classList.add('hidden');

        removeFlag.value = 1;
    });

});
</script>

    </form>

</div>
@endsection