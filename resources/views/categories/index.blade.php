@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter capitalize">Manajemen Kategori</h2>
            <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mt-1">Kelola data kategori, sub-kategori, dan gambar</p>
        </div>
        <a href="{{ route('categories.create') }}" class="px-6 py-3 bg-red-600 text-white text-[10px] font-black capitalize tracking-widest rounded-xl hover:bg-red-700 hover:scale-105 transition-all shadow-lg shadow-red-200">
            Tambah Kategori +
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-8">
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-2xl text-[12px] font-black capitalize tracking-widest shadow-lg shadow-green-100 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    {{-- Categories Table --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-xl font-black text-gray-900 capitalize tracking-tighter">Daftar Kategori</h3>
            <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mt-1">Semua tingkat kategori</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-50">
                    <tr>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Gambar</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Nama Kategori</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Parent</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Slug</th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 capitalize tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[14px] font-black text-gray-800 capitalize tracking-tighter">{{ $category->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            @if($category->parent)
                                <span class="px-4 py-1 bg-red-50 text-[10px] font-black text-red-600 rounded-full capitalize tracking-widest">
                                    {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="px-4 py-1 bg-gray-100 text-[10px] font-black text-gray-500 rounded-full capitalize tracking-widest">
                                    Root / Utama
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-[12px] font-medium text-gray-400">{{ $category->slug }}</td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="p-3 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" onclick="return confirm('Hapus kategori ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-gray-400 text-[12px] font-bold capitalize tracking-widest">Tidak ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-gray-50">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
