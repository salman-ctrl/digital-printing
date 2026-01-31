<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // jika pakai cart
use App\Models\CartDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // halaman checkout (harus login)
    public function index()
    {
        $user = Auth::user();

        // ambil semua cart user (jika pakai keranjang)
        $cartItems = CartDetail::whereHas('cart', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('product')->get();

        return view('checkout.index', compact('cartItems'));
    }

    // simpan transaksi
    public function store(Request $request)
    {
        $user = Auth::user();

        // misal ambil cart user
        $cartItems = CartDetail::whereHas('cart', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('product')->get();

        if($cartItems->isEmpty()){
            return redirect()->back()->with('error', 'Cart kosong');
        }

        // hitung total harga
        $totalPrice = $cartItems->sum(function($item){
            return $item->product->price * $item->quantity;
        });

        // buat transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_code' => 'TRX'.time(),
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // simpan detail transaksi
        foreach($cartItems as $item){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // hapus cart
        CartDetail::whereIn('id', $cartItems->pluck('id'))->delete();

        return redirect()->route('checkout')->with('success', 'Transaksi berhasil dibuat!');
    }
}
