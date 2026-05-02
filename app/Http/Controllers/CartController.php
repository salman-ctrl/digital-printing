<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with(['details.specification.product'])
            ->first();

        return view('pages.user.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
        }

        $request->validate([
            'specification_id' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1',
            'design_option' => 'required|in:upload,tim_kami',
            'design_difficulty' => 'nullable|required_if:design_option,tim_kami|in:Simpel,Sedang,Kompleks',
            'design_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:51200',
            'need_installation' => 'nullable'
        ]);

        $spec = ProductSpecification::with('product')->findOrFail($request->specification_id);

        $designCost = 0;
        $designFile = null;
        $installationPrice = 0;

        if ($request->design_option === 'tim_kami') {
            $costs = [
                'Simpel' => 10000,
                'Sedang' => 25000,
                'Kompleks' => 50000,
            ];
            $designCost = $costs[$request->design_difficulty] ?? 0;
        } else {
            if ($request->hasFile('design_file')) {
                $designFile = $request->file('design_file')->store('designs', 'public');
            }
        }

        // Hitung biaya pemasangan jika dipilih
        if ($request->need_installation && $spec->product->installation_available) {
            $installationPrice = $spec->product->installation_price;
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartDetail = CartDetail::create([
            'cart_id' => $cart->id,
            'product_specification_id' => $request->specification_id,
            'quantity' => $request->quantity,
            'design_option' => $request->design_option,
            'design_difficulty' => $request->design_difficulty,
            'design_cost' => $designCost,
            'design_file' => $designFile,
            'need_installation' => $request->need_installation ? 1 : 0,
            'installation_price' => $installationPrice
        ]);

        // Cek flag direct_checkout dari halaman rekomendasi
        if ($request->input('direct_checkout') == '1') {
            // Simpan cart_detail_id ke session agar checkout tahu item mana yang direct
            session(['direct_checkout_detail_id' => $cartDetail->id]);
            return redirect()->route('checkout')->with('success', 'Produk berhasil ditambahkan!');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $detail = CartDetail::findOrFail($id);
        $detail->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function destroy($id)
    {
        $detail = CartDetail::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
