<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        if (config('app.env') === 'local') {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
            ];
        }
    }

    /**
     * Tampilkan halaman ringkasan checkout
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Cek apakah ini Direct Checkout (Tombol 'Beli Sekarang' dari detail produk)
        $directDetailId = session()->get('direct_checkout_detail_id');

        // 2. Cek apakah ada item yang dipilih dari halaman Keranjang (Checkbox)
        $selectedIds = $request->input('selected_items', []);

        if ($directDetailId) {
            // Hanya proses item dari tombol 'Beli Sekarang'
            $cartItems = CartDetail::where('id', $directDetailId)
                ->whereHas('cart', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('specification.product')
                ->get();
        } elseif (!empty($selectedIds)) {
            // PROSES HANYA ITEM YANG DICEKLIS (Shopee Style)
            $cartItems = CartDetail::whereIn('id', $selectedIds)
                ->whereHas('cart', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('specification.product')
                ->get();
        } else {
            // Jika tidak ada item terpilih dan bukan direct checkout
            return redirect()->route('cart.index')->with('error', 'Silakan pilih minimal satu produk untuk di-checkout.');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan atau keranjang Anda kosong.');
        }

        return view('pages.checkout.index', compact('cartItems'));
    }

    /**
     * Simpan transaksi dan buat Snap Token Midtrans
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Ambil ID item yang diteruskan dari form ringkasan checkout
        $cartItemIds = $request->input('cart_item_ids', []);
        $directDetailId = session()->get('direct_checkout_detail_id');

        // Bersihkan transaksi pending lama milik user ini agar tidak menumpuk
        Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        // Query item yang akan diproses
        $query = CartDetail::whereHas('cart', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('specification.product');

        if ($directDetailId) {
            $query->where('id', $directDetailId);
        } else {
            // Hanya proses item yang dikirimkan ID-nya
            $query->whereIn('id', $cartItemIds);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sesi checkout berakhir atau item tidak valid.');
        }

        try {
            DB::beginTransaction();

            $itemDetails = [];
            $totalPrice = 0;

            foreach ($cartItems as $item) {
                $productPrice = (int) $item->specification->harga;
                $productQty = (int) $item->quantity;

                // Nama produk dibersihkan untuk Midtrans (max 45 char)
                $cleanName = preg_replace('/[^a-zA-Z0-9 \(\)\-]/', '', $item->specification->product->name);
                $cleanName = trim($cleanName) ?: 'Produk Digital Printing';

                // Item Utama
                $itemDetails[] = [
                    'id' => 'P-' . $item->id,
                    'price' => $productPrice,
                    'quantity' => $productQty,
                    'name' => substr($cleanName, 0, 45)
                ];
                $totalPrice += ($productPrice * $productQty);

                // Biaya Desain (Jika ada)
                if ($item->design_cost > 0) {
                    $itemDetails[] = [
                        'id' => 'D-' . $item->id,
                        'price' => (int) $item->design_cost,
                        'quantity' => 1,
                        'name' => 'Jasa Desain: ' . ($item->design_difficulty ?? 'Custom')
                    ];
                    $totalPrice += (int) $item->design_cost;
                }

                // Biaya Pemasangan (Jika ada)
                if ($item->need_installation && $item->installation_price > 0) {
                    $itemDetails[] = [
                        'id' => 'I-' . $item->id,
                        'price' => (int) $item->installation_price,
                        'quantity' => 1,
                        'name' => 'Jasa Pemasangan'
                    ];
                    $totalPrice += (int) $item->installation_price;
                }
            }

            // 1. Buat Header Transaksi
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'order_code' => 'INV-' . strtoupper(Str::random(8)) . '-' . time(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes // Catatan dari halaman checkout
            ]);

            // 2. Buat Detail Transaksi
            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_specification_id' => $item->product_specification_id,
                    'quantity' => $item->quantity,
                    'price' => $item->specification->harga,
                    'design_option' => $item->design_option,
                    'design_difficulty' => $item->design_difficulty,
                    'design_cost' => $item->design_cost,
                    'design_file' => $item->design_file,
                    'need_installation' => $item->need_installation,
                    'installation_price' => $item->installation_price,
                    'subtotal' => ($item->specification->harga * $item->quantity) + $item->design_cost + $item->installation_price
                ]);
            }

            $payload = [
                'transaction_details' => [
                    'order_id' => $transaction->order_code,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user->name ?: 'Customer',
                    'email' => $user->email,
                ],
                'item_details' => $itemDetails,
            ];

            Log::info('Midtrans Payload Generated', $payload);

            // 3. Minta Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($payload);
            $transaction->update(['snap_token' => $snapToken]);

            // 4. Hapus HANYA item keranjang yang di-checkout (item lain tetap ada di cart)
            CartDetail::whereIn('id', $cartItems->pluck('id'))->delete();

            // 5. Bersihkan session direct checkout jika ada
            session()->forget('direct_checkout_detail_id');

            DB::commit();
            return view('pages.checkout.payment', compact('transaction', 'snapToken'));

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout Store Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
