@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl p-12 text-center border border-gray-100">
            <div class="mb-8">
                <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900 capitalize tracking-tighter">Selesaikan Pembayaran</h2>
                <p class="text-gray-500 mt-2 font-medium">Pesanan Anda telah berhasil dibuat. Silakan selesaikan pembayaran untuk memproses pesanan.</p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100 inline-block mx-auto">
                <p class="text-[10px] font-bold text-gray-400 capitalize tracking-[0.2em] mb-1">Kode Pesanan</p>
                <p class="text-xl font-black text-blue-600">{{ $transaction->order_code }}</p>
            </div>

            <div class="mb-12">
                <p class="text-sm text-gray-400 mb-1 font-bold capitalize tracking-widest">Total Tagihan</p>
                <p class="text-5xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>

            <button id="pay-button" class="w-full max-w-sm mx-auto bg-blue-600 hover:bg-blue-700 text-white font-black py-6 rounded-2xl shadow-xl shadow-blue-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-4 text-lg">
                <span>Bayar Sekarang</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>

            <p class="mt-8 text-xs text-gray-400 font-medium">
                Pembayaran Anda diproses secara aman melalui Midtrans Payment Gateway.
            </p>
        </div>
    </div>
</div>

<form id="payment-form" method="POST" action="{{ route('payment.success') }}">
    @csrf
    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
</form>

@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                /* You may add your own implementation here */
                console.log(result);
                document.getElementById('payment-form').submit();
            },
            onPending: function (result) {
                /* You may add your own implementation here */
                console.log(result);
                alert("Pembayaran tertunda!");
            },
            onError: function (result) {
                /* You may add your own implementation here */
                console.log(result);
                alert("Pembayaran gagal!");
            },
            onClose: function () {
                /* You may add your own implementation here */
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });

    // Auto trigger for better experience
    window.onload = function() {
        payButton.click();
    };
</script>
@endpush
