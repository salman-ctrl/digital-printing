@extends('layouts.guest')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10 font-[Inter] space-y-8 bg-[#F8FAFC]">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <div class="bg-blue-100 p-3 rounded-2xl">
            <i data-lucide="settings-2" class="w-8 h-8 text-[#1E3A8A]"></i>
        </div>
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Rekomendasi Spesifikasi
            </h1>
            <p class="text-slate-500 font-medium">
                Sistem Pendukung Keputusan menggunakan metode TOPSIS
            </p>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-8">

        {{-- ================= LEFT: SIDEBAR ================= --}}
        <div class="lg:col-span-4">

            <div class="bg-white border border-slate-200 rounded-3xl p-8 space-y-8 shadow-sm sticky top-24">

                <div class="flex items-center gap-2">
                    <i data-lucide="filter" class="w-5 h-5 text-blue-600"></i>
                    <h2 class="text-lg font-bold text-slate-800">
                        Preferensi Kriteria
                    </h2>
                </div>

                {{-- FILTER PRODUK --}}
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-slate-700">Pilih Kategori Produk</label>
                    <select id="category_id"
                        onchange="calculateTotal()"
                        class="w-full px-4 py-3 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none bg-slate-50">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SLIDERS --}}
                <div id="weight-section" class="space-y-6 pt-6 border-t border-slate-100">

                    @foreach ($criterias as $index => $c)
                    <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-slate-700">{{ $c->name }}</span>
                                <span class="px-2 py-0.5 bg-blue-100 text-[10px] font-bold text-blue-600 rounded uppercase tracking-wider">
                                    C{{ $index + 1 }}
                                </span>
                            </div>
                            <span id="val-{{ $c->id }}" class="text-lg font-black text-blue-600">3.0</span>
                        </div>

                        <div class="space-y-2">
                            <input type="range"
                                min="1" max="5" step="0.5" value="3"
                                class="w-full weight-input accent-blue-600 cursor-pointer"
                                data-id="{{ $c->id }}"
                                name="weights[{{ $c->id }}]"
                                oninput="updateWeightDisplay(this)">
                            <div class="flex justify-between text-[10px] font-bold text-slate-400">
                                <span>1 (Rendah)</span>
                                <span>5 (Tinggi)</span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="bg-green-50 p-4 rounded-2xl border border-green-100 flex justify-between items-center">
                        <span class="text-sm font-bold text-green-900">Status Preferensi</span>
                        <span id="status-weight" class="text-sm font-black text-green-600">✓ Siap Dianalisis</span>
                    </div>

                    <p id="error-weight" class="text-xs text-red-500 font-medium hidden text-center">
                        Silakan pilih kategori terlebih dahulu
                    </p>

                </div>

                {{-- BUTTON --}}
                <button id="btn-submit"
                    onclick="calculateTopsis()"
                    disabled
                    class="w-full bg-[#1E3A8A] hover:bg-blue-800 text-white py-4 rounded-2xl font-bold text-base shadow-lg shadow-blue-200 transition-all transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span>Hitung Rekomendasi</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>

            </div>

        </div>

        {{-- ================= RIGHT: RESULTS ================= --}}
        <div class="lg:col-span-8 space-y-10">

            {{-- TOP 3 CARDS --}}
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <i data-lucide="trophy" class="w-6 h-6 text-orange-500"></i>
                    <h2 class="text-xl font-black text-slate-800">Rekomendasi Terbaik</h2>
                </div>
                
                <div id="top-results" class="grid md:grid-cols-3 gap-6">
                    {{-- Placeholder State --}}
                    <div class="col-span-3 py-20 text-center bg-white border border-dashed border-slate-300 rounded-3xl">
                        <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="calculator" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <p class="text-slate-400 font-medium">Atur preferensi dan klik hitung untuk melihat hasil</p>
                    </div>
                </div>
            </div>

            {{-- FULL TABLE --}}
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <i data-lucide="list" class="w-6 h-6 text-blue-600"></i>
                    <h2 class="text-xl font-black text-slate-800">Hasil Lengkap Perhitungan TOPSIS</h2>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                                    <th class="px-6 py-4 text-left">Rank</th>
                                    <th class="px-6 py-4 text-left">Produk</th>
                                    <th class="px-6 py-4 text-left">Spesifikasi</th>
                                    <th class="px-6 py-4 text-left">Harga</th>
                                    @foreach($criterias as $c)
                                    <th class="px-4 py-4 text-center text-[10px] uppercase">{{ $c->name }}</th>
                                    @endforeach
                                    <th class="px-6 py-4 text-center">CC</th>
                                </tr>
                            </thead>
                            <tbody id="result-table" class="divide-y divide-slate-50">
                                <tr>
                                    <td colspan="10" class="px-6 py-20 text-center text-slate-400 font-medium">
                                        Data perhitungan akan muncul di sini
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
lucide.createIcons();

document.addEventListener('DOMContentLoaded', function(){
    initSlider();
    bindEvents();
    calculateTotal();
});

// ================= INIT =================
function initSlider(){
    let sliders = document.querySelectorAll('.weight-input');
    sliders.forEach(el=>{
        el.value = 3; // Default ke tengah skala 1-5
        let id = el.dataset.id;
        document.getElementById('val-'+id).innerText = '3.0';
    });
}

// ================= UPDATE DISPLAY =================
let debounceTimer;
function updateWeightDisplay(input){
    const id = input.dataset.id;
    const value = parseFloat(input.value);
    document.getElementById('val-'+id).innerText = value.toFixed(1);
    
    // Auto calculate with debounce
    const categoryId = document.getElementById('category_id').value;
    if(categoryId) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            calculateTopsis();
        }, 300); // 300ms faster response
    }
}

// ================= EVENT =================
function bindEvents(){
    document.getElementById('category_id').addEventListener('change', function() {
        calculateTotal();
        if(this.value) {
            calculateTopsis();
        }
    });

    document.querySelectorAll('.weight-input').forEach(el=>{
        el.addEventListener('input', function(){
            updateWeightDisplay(this);
        });
    });
}

// ================= CATEGORY =================
// No need for loadSubCategories anymore since we use single category selection

// ================= TOTAL =================
function calculateTotal(){
    const btn = document.getElementById('btn-submit');
    const error = document.getElementById('error-weight');
    const categoryId = document.getElementById('category_id').value;
    const statusWeight = document.getElementById('status-weight');

    error.classList.add('hidden');
    statusWeight.classList.remove('hidden');

    if(!categoryId){
        btn.disabled = true;
        error.innerText = 'Pilih kategori dulu';
        error.classList.remove('hidden');
        statusWeight.classList.add('hidden');
        return;
    }

    btn.disabled = false;
    statusWeight.innerText = '✓ Siap Dianalisis';
    statusWeight.classList.add('text-green-600');
}

// ================= HITUNG =================
async function calculateTopsis(){
    const categoryId = document.getElementById('category_id').value;
    const btn = document.getElementById('btn-submit');

    if(!categoryId){
        alert('Pilih kategori dulu');
        return;
    }

    const originalText = btn.innerHTML;
    btn.innerHTML = `<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> <span>Memproses...</span>`;
    btn.disabled = true;
    lucide.createIcons();

    // Kumpulkan bobot dari slider (skala 1-5 langsung)
    const weights = {};
    document.querySelectorAll('.weight-input').forEach(el=>{
        const criteriaId = el.dataset.id;
        weights[criteriaId] = parseFloat(el.value); // Sudah dalam skala 1-5
    });

    try{
        const res = await fetch('/topsis/calculate',{
            method:'POST',
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                category_id: categoryId,
                weights: weights
            })
        });

        const data = await res.json();

        if(!data.success){
            alert(data.message || 'Gagal menghitung rekomendasi');
            return;
        }

        renderTop(data.results);
        renderTable(data.results);
        
        // document.getElementById('top-results').scrollIntoView({ behavior: 'smooth', block: 'start' });

    } catch(e) {
        console.error(e);
        alert('Terjadi error sistem: ' + e.message);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
        lucide.createIcons();
    }
}

// ================= RENDER =================
function renderTop(results){
    const el = document.getElementById('top-results');
    el.innerHTML='';

    if(results.length === 0) {
        el.innerHTML = '<div class="col-span-3 p-10 text-center text-slate-400 font-medium">Tidak ada hasil</div>';
        return;
    }

    results.slice(0,3).forEach((r,i)=>{
        const isFirst = i === 0;
        
        el.innerHTML += `
        <div class="relative bg-white border ${isFirst ? 'border-[#FACC15] ring-2 ring-[#FACC15]/20' : 'border-slate-200'} rounded-[32px] p-6 shadow-xl flex flex-col h-full transition-all hover:scale-[1.02]">
            
            ${isFirst ? '<div class="absolute -top-3 right-6 bg-[#EF4444] text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-lg tracking-widest">REKOMENDASI TERBAIK</div>' : ''}

            <div class="flex justify-between items-start mb-6">
                <div class="bg-slate-100 text-[#1E3A8A] text-[10px] font-black px-3 py-1.5 rounded-full">
                    #${i+1} ${r.product_name.split(' ')[0]}
                </div>
            </div>

            <div class="mb-4">
                <h3 class="font-black text-slate-800 text-lg leading-tight mb-2 line-clamp-2 uppercase tracking-tight">
                    ${r.product_name}
                </h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                    Finishing: ${r.finishing || '-'}
                </p>
            </div>

            <div class="mt-auto">
                <p class="text-xl font-black text-[#EF4444] mb-3">
                    Rp ${Number(r.price || 0).toLocaleString('id-ID')}
                </p>
                <div class="flex items-center gap-1 text-[#FACC15] mb-6">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <span class="text-[11px] font-black text-slate-600">Skor: ${r.preference_value}</span>
                </div>
                
                <a href="/products/${r.specification.product_id}?spec_id=${r.specification_id}" class="w-full bg-[#1E3A8A] hover:bg-blue-800 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center justify-center gap-2 transition-all transform active:scale-95 shadow-xl shadow-blue-100">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    <span>PILIH PRODUK</span>
                </a>
            </div>
        </div>`;
    });
    lucide.createIcons();
}

function renderTable(results){
    const el = document.getElementById('result-table');
    el.innerHTML='';

    results.forEach((r,i)=>{
        const isTop = i < 3;
        
        // Extract matrix values safely using C1-C5 keys
        const m = r.matrix;
        const matrixHTML = `
            <td class="px-4 py-6 text-center text-slate-600 font-medium">${m.C1 || 0}</td>
            <td class="px-4 py-6 text-center text-slate-600 font-medium">${m.C2 || 0}</td>
            <td class="px-4 py-6 text-center text-slate-600 font-medium">${m.C3 || 0}</td>
            <td class="px-4 py-6 text-center text-slate-600 font-medium">${m.C4 || 0}</td>
            <td class="px-4 py-6 text-center text-slate-600 font-medium">${m.C5 || 0}</td>
        `;

        el.innerHTML += `
        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
            <td class="px-6 py-6 text-center">
                <div class="w-8 h-8 ${isTop ? 'bg-orange-500 text-white' : 'bg-blue-50 text-blue-600'} rounded-full flex items-center justify-center text-xs font-black mx-auto shadow-sm">
                    #${i+1}
                </div>
            </td>
            <td class="px-6 py-6">
                <div class="font-bold text-slate-800 text-sm leading-snug max-w-[150px]">
                    ${r.product_name}
                </div>
            </td>
            <td class="px-6 py-6">
                <div class="flex flex-col gap-1">
                    <span class="text-xs font-bold text-slate-700">${r.material}</span>
                    <span class="text-[10px] text-slate-400">${r.size} / ${r.finishing}</span>
                </div>
            </td>
            <td class="px-6 py-6 font-black text-blue-700 whitespace-nowrap">
                Rp ${Number(r.price || 0).toLocaleString('id-ID')}
            </td>
            
            ${matrixHTML}

            <td class="px-6 py-6 text-center font-black text-[#1E3A8A]">
                ${r.preference_value}
            </td>
        </tr>`;
    });
    lucide.createIcons();
}
</script>

@endsection
