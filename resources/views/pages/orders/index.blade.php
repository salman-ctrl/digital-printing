@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-5xl mx-auto">
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 capitalize tracking-tighter">Riwayat Pesanan</h1>
            <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mt-1">Pantau status pesanan digital printing Anda</p>
        </div>

        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50 border-b border-gray-50">
                        <tr>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Order ID</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest">Tanggal</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 capitalize tracking-widest text-center">Status</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 capitalize tracking-widest">Total Tagihan</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 capitalize tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/80 transition-all group">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-gray-800 capitalize tracking-tight">#{{ $order->order_code }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-bold text-gray-500 capitalize tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1 {{ $order->status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} rounded-full text-[9px] font-black capitalize tracking-widest">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-black text-red-600 tracking-tighter">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('orders.show', $order->id) }}" class="px-6 py-2 bg-gray-900 text-white text-[9px] font-black capitalize tracking-widest rounded-xl hover:bg-red-600 transition-all shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="text-5xl mb-4">📦</div>
                                <h3 class="text-sm font-black text-gray-800 capitalize tracking-tighter">Belum Ada Pesanan</h3>
                                <p class="text-[10px] font-bold text-gray-400 capitalize tracking-widest mt-2">Silakan lakukan pemesanan produk digital printing pertama Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
            <div class="p-8 border-t border-gray-50">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
