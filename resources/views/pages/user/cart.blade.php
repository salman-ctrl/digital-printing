@extends('layouts.guest')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-7xl mx-auto space-y-10 font-[Inter] text-slate-800">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-4">
        <div class="bg-blue-100 p-3 rounded-2xl">
            <i data-lucide="shopping-cart" class="w-8 h-8 text-[#1E3A8A]"></i>
        </div>
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Keranjang Belanja
            </h1>
            <p class="text-slate-500 font-medium">
                Kelola item pilihan Anda sebelum melakukan pembayaran
            </p>
        </div>
    </div>

    @if($cart && $cart->details->count() > 0)
    <form action="{{ route('checkout') }}" method="GET" id="cart-form" class="grid lg:grid-cols-12 gap-10 items-start">
        
        {{-- ================= LIST ITEMS ================= --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- SELECT ALL --}}
            <div class="bg-white border-2 border-slate-100 rounded-3xl p-6 flex justify-between items-center shadow-sm">
                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="checkbox" id="select-all" class="w-5 h-5 rounded-lg border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A]">
                    <span class="text-sm font-black text-slate-600 group-hover:text-[#1E3A8A] transition uppercase tracking-widest">Pilih Semua Item</span>
                </label>
                <button type="button" onclick="deleteSelected()" class="flex items-center gap-2 text-xs font-black text-red-400 hover:text-red-600 uppercase tracking-widest transition">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    Hapus Terpilih
                </button>
            </div>

            @foreach($cart->details as $detail)
            @php $spec = $detail->specification; @endphp
            <div class="cart-item bg-white border-2 border-slate-100 rounded-[32px] p-6 shadow-sm hover:border-blue-100 transition-all flex gap-6"
                 id="item-row-{{ $detail->id }}"
                 data-price="{{ $spec->harga }}"
                 data-design-price="{{ $detail->design_cost }}"
                 data-installation-price="{{ $detail->installation_price }}">
                
                <div class="flex items-center">
                    <input type="checkbox" name="selected_items[]" value="{{ $detail->id }}" 
                           class="item-checkbox w-6 h-6 rounded-xl border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A]">
                </div>

                {{-- IMAGE --}}
                <div class="w-32 h-32 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100">
                    <img src="{{ $spec->product->image_url }}" class="w-full h-full object-cover" crossorigin="anonymous">
                </div>

                {{-- DETAILS --}}
                <div class="flex-1 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">{{ $spec->product->category->name }}</span>
                            <h3 class="text-lg font-black text-slate-800 leading-tight">{{ $spec->product->name }}</h3>
                            <p class="text-xs font-bold text-slate-400 mt-1">{{ $spec->material }} • {{ $spec->size }} • {{ $spec->finishing }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-[#1E3A8A]">Rp {{ number_format($spec->harga) }}</p>
                            <p class="text-[10px] font-bold text-slate-400">per unit</p>
                        </div>
                    </div>

                    {{-- EXTRA INFO --}}
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-slate-50 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                            Desain: {{ $detail->design_option == 'upload' ? 'Upload Sendiri' : 'Jasa Desain ('.$detail->design_difficulty.')' }}
                        </span>
                        @if($detail->need_installation)
                        <span class="px-3 py-1 bg-blue-50 rounded-lg text-[9px] font-black text-blue-600 uppercase tracking-tighter">
                            + Jasa Pasang
                        </span>
                        @endif
                    </div>

                    <div class="flex justify-between items-end pt-2">
                        {{-- QTY CONTROLLER --}}
                        <div class="flex items-center border-2 border-slate-50 rounded-2xl overflow-hidden h-10">
                            <button type="button" onclick="updateQty('{{ $detail->id }}', -1)" class="w-10 h-full flex items-center justify-center hover:bg-slate-50 text-slate-400">
                                <i data-lucide="minus" class="w-3 h-3"></i>
                            </button>
                            <input type="number" id="qty-input-{{ $detail->id }}" value="{{ $detail->quantity }}" min="1" 
                                   class="w-12 text-center font-black text-xs border-none focus:ring-0 bg-transparent" readonly>
                            <button type="button" onclick="updateQty('{{ $detail->id }}', 1)" class="w-10 h-full flex items-center justify-center hover:bg-slate-50 text-slate-400">
                                <i data-lucide="plus" class="w-3 h-3"></i>
                            </button>
                        </div>

                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Subtotal</p>
                            <p class="text-lg font-black text-[#EF4444]" id="subtotal-item-{{ $detail->id }}">
                                Rp {{ number_format(($spec->harga * $detail->quantity) + $detail->design_cost + $detail->installation_price) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ================= SUMMARY ================= --}}
        <div class="lg:col-span-4 space-y-6 sticky top-24">
            <div class="bg-slate-900 rounded-[32px] p-8 text-white shadow-xl shadow-slate-200">
                <h3 class="text-xl font-black mb-8 flex items-center gap-3">
                    <i data-lucide="credit-card" class="w-6 h-6 text-[#FACC15]"></i>
                    Ringkasan Order
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-400 uppercase tracking-widest">Item Terpilih</span>
                        <span class="text-sm font-black" id="selected-count">0</span>
                    </div>
                    
                    <div class="pt-4 border-t border-white/10 space-y-2">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Estimasi Total</p>
                        <div class="flex justify-between items-end">
                            <h2 class="text-3xl font-black text-white" id="total-display">Rp 0</h2>
                        </div>
                    </div>
                </div>

                <button type="submit" id="btn-checkout" disabled 
                        class="w-full mt-10 bg-[#FACC15] hover:bg-yellow-400 text-[#1E3A8A] py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition shadow-lg shadow-black/20 disabled:opacity-30 disabled:cursor-not-allowed">
                    Proses Checkout
                </button>

                <p class="text-[10px] text-slate-500 text-center mt-6 font-medium">
                    Harga di atas belum termasuk ongkos kirim yang akan dihitung saat checkout.
                </p>
            </div>

            <div class="bg-blue-50 border-2 border-blue-100 rounded-[32px] p-6 text-center">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Metode Pembayaran</p>
                <div class="flex justify-center gap-3 mt-4 opacity-50 grayscale hover:opacity-100 hover:grayscale-0 transition duration-500">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dan_Brand_BCA.png" class="h-4">
                    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1200px-Bank_Mandiri_logo.svg.png" class="h-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Negara_Indonesia_46_logo.svg/1200px-Bank_Negara_Indonesia_46_logo.svg.png" class="h-4">
                </div>
            </div>
        </div>
    </form>
    @else
    <div class="bg-white border-2 border-dashed border-slate-200 rounded-[48px] p-20 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-200 mb-6">
            <i data-lucide="shopping-bag" class="w-10 h-10"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-800">Keranjang Masih Kosong</h2>
        <p class="text-slate-400 font-medium mt-2 max-w-sm mx-auto">Mungkin Anda belum menemukan produk yang tepat? Yuk cek katalog kami!</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-8 bg-[#1E3A8A] text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-800 transition shadow-xl shadow-blue-100">
            Mulai Belanja
        </a>
    </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    initCheckboxes();
    calculateTotal();
});

function initCheckboxes() {
    const selectAll = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    if(selectAll) {
        selectAll.addEventListener('change', () => {
            itemCheckboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            calculateTotal();
        });
    }

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            calculateTotal();
            if(!cb.checked && selectAll) selectAll.checked = false;
        });
    });
}

function updateQty(id, delta) {
    const input = document.getElementById(`qty-input-${id}`);
    let newVal = parseInt(input.value) + delta;
    if (newVal < 1) newVal = 1;
    input.value = newVal;

    // Optional: Send AJAX to update qty in database
    fetch(`/cart/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: newVal })
    });

    updateSubtotal(id, newVal);
    calculateTotal();
}

function updateSubtotal(id, qty) {
    const row = document.getElementById(`item-row-${id}`);
    const price = parseFloat(row.dataset.price);
    const design = parseFloat(row.dataset.designPrice);
    const install = parseFloat(row.dataset.installationPrice);
    
    const subtotal = (price * qty) + design + install;
    document.getElementById(`subtotal-item-${id}`).innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
}

function calculateTotal() {
    let total = 0;
    let count = 0;
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const btn = document.getElementById('btn-checkout');

    itemCheckboxes.forEach(cb => {
        if(cb.checked) {
            const row = cb.closest('.cart-item');
            const qty = parseInt(document.getElementById(`qty-input-${cb.value}`).value);
            const price = parseFloat(row.dataset.price);
            const design = parseFloat(row.dataset.designPrice);
            const install = parseFloat(row.dataset.installationPrice);

            total += (price * qty) + design + install;
            count++;
        }
    });

    if(document.getElementById('selected-count')) {
        document.getElementById('selected-count').innerText = count;
        document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    if(btn) {
        btn.disabled = count === 0;
    }
}

async function deleteSelected() {
    const selected = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
    if(selected.length === 0) return;

    if(!confirm('Hapus item terpilih dari keranjang?')) return;

    for(const id of selected) {
        await fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
    }
    window.location.reload();
}
</script>
@endsection
