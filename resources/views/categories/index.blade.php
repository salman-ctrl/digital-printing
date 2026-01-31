@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kategori Produk</h1>
        <a href="{{ route('categories.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Tambah Kategori</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full text-left table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Kategori</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($categories->isEmpty())
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada kategori</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
