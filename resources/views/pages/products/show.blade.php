@extends('layouts.guest')

@section('content')

<div class="w-full space-y-10 font-sans text-slate-800">

    {{-- ================= BREADCRUMB ================= --}}
    <section class="bg-white border border-slate-200 rounded-2xl px-6 py-4 shadow-sm">
        <nav class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-slate-400">
            <a href="/" class="hover:text-[#1E3A8A]">Beranda</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-[#1E3A8A]">Katalog</a>
            <span>/</span>
            <span class="text-[#1E3A8A]">{{ $product->name }}</span>
        </nav>
    </section>

    {{-- ================= MAIN ================= --}}
    <section class="grid lg:grid-cols-2 gap-10 items-start">

        {{-- LEFT IMAGE --}}
        <div class="space-y-4">

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <img src="{{ $product->image_url }}"
                     id="main-image"
                     class="w-full h-[420px] object-contain"
                     alt="{{ $product->name }}" crossorigin="anonymous">
            </div>

            <div class="grid grid-cols-4 gap-3">
                <div onclick="changeImage('{{ $product->image_url }}',this)"
                     class="thumb-item border-2 border-[#1E3A8A] rounded-xl overflow-hidden cursor-pointer">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover" crossorigin="anonymous">
                </div>

                @foreach($product->photos as $photo)
                <div onclick="changeImage('{{ $photo->url }}',this)"
                     class="thumb-item border border-slate-200 rounded-xl overflow-hidden cursor-pointer hover:border-[#1E3A8A]">
                    <img src="{{ $photo->url }}" class="w-full h-full object-cover" crossorigin="anonymous">
                </div>
                @endforeach
            </div>

        </div>

        {{-- RIGHT CONFIGURATOR --}}
        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8 space-y-6 sticky top-24">

            @csrf

            <div class="flex justify-between items-start">
                <div>
                    {{-- CATEGORY --}}
                    <span class="text-[10px] font-black bg-blue-50 px-3 py-1 rounded-full text-[#1E3A8A] uppercase tracking-widest">
                        {{ $product->category->name }}
                    </span>
                    {{-- TITLE --}}
                    <h1 class="text-2xl font-black text-slate-800 mt-3 leading-tight">
                        {{ $product->name }}
                    </h1>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga Mulai</p>
                    <p class="text-xl font-black text-[#EF4444]">
                        Rp {{ number_format($product->specifications->min('harga')) }}
                    </p>
                </div>
            </div>

            <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                {{ $product->description }}
            </p>

            {{-- SPEC --}}
            <div class="space-y-3">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pilih Spesifikasi</p>

                <div class="grid gap-3">
                    @foreach($product->specifications as $spec)
                    <label class="spec-item relative flex justify-between items-center border-2 border-slate-100 rounded-2xl px-5 py-4 cursor-pointer transition-all hover:border-blue-200">
                        <input type="radio"
                               name="specification_id"
                               value="{{ $spec->id }}"
                               data-price="{{ $spec->harga }}"
                               required
                               class="hidden spec-radio">

                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700">{{ $spec->material }}</span>
                            <span class="text-[11px] font-medium text-slate-400">{{ $spec->size }} • {{ $spec->finishing }}</span>
                        </div>

                        <p class="text-sm font-black text-[#1E3A8A]">
                            Rp {{ number_format($spec->harga) }}
                        </p>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- QUANTITY --}}
                <div class="space-y-3">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Jumlah</p>
                    <div class="flex items-center border-2 border-slate-100 rounded-2xl overflow-hidden h-12">
                        <button type="button" onclick="adjustQty(-1)" class="w-12 h-full flex items-center justify-center hover:bg-slate-50 text-slate-500 transition">
                            <i data-lucide="minus" class="w-4 h-4"></i>
                        </button>
                        <input type="number" name="quantity" id="quantity-input" value="1" min="1" 
                               class="w-full text-center font-bold text-sm border-none focus:ring-0 outline-none">
                        <button type="button" onclick="adjustQty(1)" class="w-12 h-full flex items-center justify-center hover:bg-slate-50 text-slate-500 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- INSTALLATION --}}
                @if($product->installation_available)
                <div class="space-y-3">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Jasa Pasang</p>
                    <label class="flex items-center gap-3 border-2 border-slate-100 rounded-2xl px-4 h-12 cursor-pointer hover:border-blue-200 transition">
                        <input type="checkbox" name="need_installation" value="1" 
                               data-price="{{ $product->installation_price }}"
                               id="install-checkbox"
                               class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-700">Ya, Pasangkan</span>
                            <span class="text-[9px] text-blue-600 font-bold">+Rp {{ number_format($product->installation_price) }}</span>
                        </div>
                    </label>
                </div>
                @endif
            </div>

            {{-- DESIGN OPTION --}}
            <div class="space-y-3">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Opsi Desain</p>

                <div class="grid grid-cols-2 gap-4">
                    <label class="design-item relative border-2 border-slate-100 rounded-2xl p-4 text-center cursor-pointer transition-all hover:border-blue-200">
                        <input type="radio" name="design_option" value="upload" checked class="hidden design-radio">
                        <div class="flex flex-col items-center gap-2">
                            <div class="p-2 bg-slate-50 rounded-xl text-slate-400 icon-container">
                                <i data-lucide="upload" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Upload File</span>
                        </div>
                    </label>

                    <label class="design-item relative border-2 border-slate-100 rounded-2xl p-4 text-center cursor-pointer transition-all hover:border-blue-200">
                        <input type="radio" name="design_option" value="tim_kami" class="hidden design-radio">
                        <div class="flex flex-col items-center gap-2">
                            <div class="p-2 bg-slate-50 rounded-xl text-slate-400 icon-container">
                                <i data-lucide="pen-tool" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Jasa Desain</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- UPLOAD BOX --}}
            <div id="upload-section" class="space-y-3">
                <div id="upload-box" class="group border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center transition-all hover:border-[#1E3A8A] hover:bg-blue-50/30 cursor-pointer relative">
                    <input type="file" name="design_file" id="design_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFile(this)">
                    <div class="space-y-2">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400 group-hover:bg-blue-100 group-hover:text-[#1E3A8A] transition">
                            <i data-lucide="image" class="w-6 h-6"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-600" id="file-name">Pilih atau Tarik File Desain</p>
                        <p class="text-[10px] text-slate-400">PDF, JPG, PNG, AI, PSD (Max 50MB)</p>
                    </div>
                </div>
            </div>

            {{-- DESIGN DIFFICULTY (Hidden initially) --}}
            <div id="difficulty-section" class="hidden space-y-3">
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-3">Tingkat Kesulitan Desain</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Simpel' => 10000, 'Sedang' => 25000, 'Kompleks' => 50000] as $level => $price)
                        <label class="flex flex-col items-center p-3 rounded-xl border bg-white cursor-pointer hover:border-blue-400 transition">
                            <input type="radio" name="design_difficulty" value="{{ $level }}" class="hidden difficulty-radio" {{ $level == 'Simpel' ? 'checked' : '' }} data-price="{{ $price }}">
                            <span class="text-[10px] font-black text-slate-700">{{ $level }}</span>
                            <span class="text-[9px] font-bold text-blue-600 mt-1">Rp{{ number_format($price) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PRICE SUMMARY --}}
            <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl shadow-slate-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</p>
                        <h2 id="price-display" class="text-2xl font-black mt-1">Rp 0</h2>
                    </div>
                    <button type="submit" name="direct_checkout" value="1" class="bg-[#1E3A8A] hover:bg-blue-600 px-6 py-3 rounded-xl text-sm font-black transition shadow-lg shadow-blue-900/20">
                        Beli Sekarang
                    </button>
                    <button type="submit" class="bg-slate-700 hover:bg-slate-800 px-6 py-3 rounded-xl text-sm font-black transition shadow-lg">
                        + Keranjang
                    </button>
                </div>
            </div>

            {{-- REKOMENDASI --}}
            <a href="/rekomendasi?category={{ $product->category_id }}" 
               class="flex items-center justify-center gap-2 w-full py-4 text-sm font-black text-slate-500 hover:text-[#1E3A8A] transition border-2 border-slate-50 rounded-2xl hover:border-blue-100">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                Lihat Rekomendasi TOPSIS
            </a>

        </form>

    </section>

</div>

<script>
lucide.createIcons();

let currentBasePrice = 0;
let currentInstallationPrice = 0;
let currentDesignPrice = 0;

// IMAGE
function changeImage(url, el){
    document.getElementById('main-image').src = url;
    document.querySelectorAll('.thumb-item').forEach(i=> i.classList.remove('border-[#1E3A8A]'));
    el.classList.add('border-[#1E3A8A]');
}

// QUANTITY
function adjustQty(val) {
    const input = document.getElementById('quantity-input');
    let newVal = parseInt(input.value) + val;
    if (newVal < 1) newVal = 1;
    input.value = newVal;
    updateTotalPrice();
}

document.getElementById('quantity-input').addEventListener('input', updateTotalPrice);

// FILE HANDLING
function handleFile(input) {
    const fileName = input.files[0] ? input.files[0].name : 'Pilih atau Tarik File Desain';
    document.getElementById('file-name').innerText = fileName;
}

// SPEC
document.querySelectorAll('.spec-radio').forEach(el=>{
    el.addEventListener('change', function(){
        document.querySelectorAll('.spec-item').forEach(i=> i.classList.remove('border-blue-400','bg-blue-50/50'));
        this.closest('.spec-item').classList.add('border-blue-400','bg-blue-50/50');
        currentBasePrice = parseInt(this.dataset.price);
        updateTotalPrice();
    });
});

// INSTALLATION
const installCheck = document.getElementById('install-checkbox');
if(installCheck) {
    installCheck.addEventListener('change', function() {
        currentInstallationPrice = this.checked ? parseInt(this.dataset.price) : 0;
        updateTotalPrice();
    });
}

// DESIGN OPTION
document.querySelectorAll('.design-radio').forEach(el=>{
    el.addEventListener('change', function(){
        document.querySelectorAll('.design-item').forEach(i=> {
            i.classList.remove('border-blue-400','bg-blue-50/50');
            i.querySelector('.icon-container').classList.remove('bg-blue-100','text-[#1E3A8A]');
        });

        const parent = this.closest('.design-item');
        parent.classList.add('border-blue-400','bg-blue-50/50');
        parent.querySelector('.icon-container').classList.add('bg-blue-100','text-[#1E3A8A]');

        const isTimKami = this.value === 'tim_kami';
        document.getElementById('upload-section').classList.toggle('hidden', isTimKami);
        document.getElementById('difficulty-section').classList.toggle('hidden', !isTimKami);
        
        if (!isTimKami) {
            currentDesignPrice = 0;
        } else {
            const activeDiff = document.querySelector('.difficulty-radio:checked');
            currentDesignPrice = activeDiff ? parseInt(activeDiff.dataset.price) : 0;
        }
        updateTotalPrice();
    });
});

// DIFFICULTY
document.querySelectorAll('.difficulty-radio').forEach(el => {
    el.addEventListener('change', function() {
        document.querySelectorAll('.difficulty-radio').forEach(r => {
            r.closest('label').classList.remove('border-blue-400', 'bg-blue-50');
        });
        this.closest('label').classList.add('border-blue-400', 'bg-blue-50');
        currentDesignPrice = parseInt(this.dataset.price);
        updateTotalPrice();
    });
});

function updateTotalPrice() {
    const qty = parseInt(document.getElementById('quantity-input').value) || 1;
    const total = (currentBasePrice * qty) + currentInstallationPrice + currentDesignPrice;
    
    document.getElementById('price-display').innerText = 
        total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : 'Rp 0';
}

// Trigger initial price if first spec is checked
window.onload = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const specId = urlParams.get('spec_id');
    
    if (specId) {
        const targetSpec = document.querySelector(`.spec-radio[value="${specId}"]`);
        if (targetSpec) {
            targetSpec.click();
            targetSpec.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
    }

    const firstSpec = document.querySelector('.spec-radio');
    if(firstSpec) {
        firstSpec.click();
    }
}
</script>

    </section>

</div>

@endsection