@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter capitalize">Edit Kategori</h2>
            <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mt-1">Ubah data kategori: {{ $category->name }}</p>
        </div>
        <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-gray-100 text-gray-800 text-[10px] font-black capitalize tracking-widest rounded-xl hover:bg-gray-200 transition-all">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Name --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 capitalize tracking-widest ml-1">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required 
                           class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl text-[14px] font-bold text-gray-700 focus:ring-2 focus:ring-red-600 transition-all placeholder:text-gray-300"
                           placeholder="Contoh: Digital Printing">
                    @error('name')
                        <p class="text-[10px] font-bold text-red-600 capitalize mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Parent Category --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 capitalize tracking-widest ml-1">Kategori Induk (Parent)</label>
                    <select name="parent_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl text-[14px] font-bold text-gray-700 focus:ring-2 focus:ring-red-600 transition-all cursor-pointer">
                        <option value="">-- Tanpa Induk (Root) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-[10px] font-bold text-red-600 capitalize mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Image Upload --}}
            <div class="space-y-3">
                <label class="text-[10px] font-black text-gray-400 capitalize tracking-widest ml-1">Gambar Kategori</label>
                <div class="relative group">
                    <div class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] flex flex-col items-center justify-center transition-all group-hover:border-red-200 group-hover:bg-red-50/30 overflow-hidden relative">
                        <div id="preview-container" class="absolute inset-0">
                            <img id="image-preview" src="{{ $category->image_url }}" alt="Preview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white text-[10px] font-black capitalize tracking-widest">Ganti Gambar</span>
                            </div>
                        </div>
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
                @error('image')
                    <p class="text-[10px] font-bold text-red-600 capitalize mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-gray-50">
                <button type="submit" class="w-full md:w-auto px-12 py-4 bg-red-600 text-white text-[10px] font-black capitalize tracking-widest rounded-2xl hover:bg-red-700 hover:scale-[1.02] transition-all shadow-xl shadow-red-100">
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
