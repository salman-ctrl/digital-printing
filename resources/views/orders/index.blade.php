@extends('layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan Terbaru')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <table class="w-full text-left table-auto">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama Pelanggan</th>
                <th class="px-4 py-2">Produk</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $order->customer_name }}</td>
                <td class="px-4 py-2">{{ $order->product_name }}</td>
                <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded-full text-white text-sm 
                    {{ $order->status == 'Selesai' ? 'bg-green-600' : ($order->status == 'Proses' ? 'bg-yellow-500' : 'bg-red-600') }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
