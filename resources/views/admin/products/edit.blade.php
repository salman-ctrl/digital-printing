@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-4">

        <a href="{{ route('admin.products.index') }}"
           class="p-2 bg-[#FACC15]/20 text-[#1E3A8A] rounded-xl hover:bg-[#FACC15]/30 transition">
            ←
        </a>

        <div>
            <h1 class="text-3xl font-black text-[#1E3A8A] tracking-tight capitalize">
                Edit Produk
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi produk
            </p>
        </div>

    </div>

    {{-- ================= ERROR ================= --}}
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-sm">
            <p class="font-black mb-2 uppercase tracking-widest text-xs">
                Terjadi kesalahan input
            </p>

            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= FORM ================= --}}
    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        @csrf
        @method('PUT')

        {{-- hidden category --}}
        <input type="hidden" name="category_id" id="finalCategory"
               value="{{ old('category_id', $product->category_id) }}">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">

            <h3 class="text-xs font-black text-slate-500 border-b pb-3 tracking-widest uppercase">
                Informasi Produk
            </h3>

            {{-- NAMA --}}
            <div>
                <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                    Nama Produk
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $product->name) }}"
                       class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                              focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                              text-sm font-semibold text-slate-800 outline-none transition">
            </div>

            {{-- KATEGORI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- PARENT --}}
                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Kategori Utama
                    </label>

                    <select id="parentCategory"
                            class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                                   focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                   text-sm font-semibold text-slate-800 bg-white outline-none transition">

                        <option value="">Pilih Kategori</option>

                        @foreach($categories->whereNull('parent_id') as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- SUB --}}
                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Sub Kategori
                    </label>

                    <select id="subCategory"
                            class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                                   focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                   text-sm font-semibold text-slate-800 bg-white outline-none transition">

                        <option value="">Pilih Sub Kategori</option>

                        @foreach($categories->whereNotNull('parent_id') as $cat)
                            <option value="{{ $cat->id }}"
                                    data-parent="{{ $cat->parent_id }}"
                                    style="display:none;">
                                {{ $cat->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            {{-- HARGA + STOK --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">

                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Harga (Mulai Dari)
                    </label>

                    <input type="number"
                           name="harga"
                           value="{{ old('harga', $product->harga) }}"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                                  focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                  text-sm font-semibold text-slate-800 outline-none transition">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                        Stok
                    </label>

                    <input type="number"
                           name="stok"
                           value="{{ old('stok', $product->stok) }}"
                           class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                                  focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                  text-sm font-semibold text-slate-800 outline-none transition">
                </div>

                <div class="flex flex-col">
                    <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase mb-4">
                        Jasa Pasang
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="installation_available" value="1" {{ old('installation_available', $product->installation_available) ? 'checked' : '' }}
                               class="w-6 h-6 rounded border-slate-300 text-[#1E3A8A] focus:ring-[#FACC15]">
                        <span class="text-xs font-bold text-slate-600 tracking-widest uppercase">Tersedia</span>
                    </div>
                </div>

            </div>

            {{-- BIAYA PASANG --}}
            <div>
                <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                    Biaya Jasa Pasang (Jika Ada)
                </label>

                <input type="number"
                       name="installation_price"
                       value="{{ old('installation_price', $product->installation_price) }}"
                       class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                              focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                              text-sm font-semibold text-slate-800 outline-none transition">
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="text-[10px] font-black text-slate-500 tracking-widest uppercase">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="4"
                          class="w-full mt-2 px-4 py-3 rounded-2xl border border-slate-200
                                 focus:ring-2 focus:ring-[#FACC15]/30 focus:border-[#FACC15]
                                 text-sm font-semibold text-slate-800 outline-none transition">{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="space-y-6">

            {{-- THUMBNAIL --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

                <h3 class="text-xs font-black text-slate-500 mb-4 tracking-widest uppercase">
                    Thumbnail
                </h3>

                @if($product->image_primary)
                    <img src="{{ asset('storage/'.$product->image_primary) }}"
                         class="w-full h-40 object-cover rounded-xl mb-3">
                @endif

                <input type="file"
                       name="image"
                       class="w-full text-sm border border-slate-200 p-3 rounded-2xl bg-slate-50">
            </div>

            {{-- ACTION --}}
            <button type="submit"
                    class="w-full bg-[#FACC15] text-[#1E3A8A] py-3 rounded-2xl
                           text-xs font-black tracking-widest uppercase
                           hover:bg-[#EAB308] transition shadow-sm">
                Update Produk
            </button>

        </div>

    </form>

</div>

{{-- ================= JS ================= --}}
<script>
const parent = document.getElementById('parentCategory');
const sub = document.getElementById('subCategory');
const finalInput = document.getElementById('finalCategory');

parent.addEventListener('change', function () {
    let parentId = this.value;
    let options = document.querySelectorAll('#subCategory option');

    sub.value = '';

    options.forEach(opt => {
        if (!opt.value) return;

        opt.style.display =
            (opt.dataset.parent == parentId) ? 'block' : 'none';
    });

    finalInput.value = parentId;
});

sub.addEventListener('change', function () {
    if (this.value) {
        finalInput.value = this.value;
    } else {
        finalInput.value = parent.value;
    }
});
</script>

@endsection