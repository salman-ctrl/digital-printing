<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /* ======================================================
        LIST PRODUK
    ====================================================== */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $query = Product::with(['category', 'specifications']);

        // Filter kategori
        if ($request->category) {
            $categoryIds = Category::where('id', $request->category)
                ->orWhere('parent_id', $request->category)
                ->pluck('id');

            $query->whereIn('category_id', $categoryIds);
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(8)->withQueryString();

        if ($request->ajax()) {
            return view('pages.products.product_grid', compact('products'))->render();
        }

        if ($request->routeIs('admin.*')) {
            return view('admin.products.index', compact('products', 'categories'));
        }

        return view('pages.products.index', compact('products', 'categories'));
    }

    /* ======================================================
        FILTER CATEGORY USER
    ====================================================== */
    public function byCategory(Request $request, $id)
    {
        $selectedCategory = Category::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();

        $categoryIds = Category::where('id', $id)
            ->orWhere('parent_id', $id)
            ->pluck('id');

        $query = Product::with(['category', 'specifications'])
            ->whereIn('category_id', $categoryIds);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(8)->withQueryString();

        if ($request->ajax()) {
            return view('pages.products.product_grid', compact('products'))->render();
        }

        return view('pages.products.index', compact(
            'products',
            'selectedCategory',
            'categories'
        ));
    }

    /* ======================================================
        DETAIL PRODUK
    ====================================================== */
    public function show($id)
    {
        $product = Product::with(['category', 'specifications'])->findOrFail($id);
        $criterias = Criteria::all();

        return view('pages.products.show', compact('product', 'criterias'));
    }

    public function adminShow($id)
    {
        $product = Product::with(['category', 'specifications'])->findOrFail($id);
        $criterias = Criteria::all();

        return view('admin.products.show', compact('product', 'criterias'));
    }

    /* ======================================================
        FORM CREATE
    ====================================================== */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /* ======================================================
        STORE PRODUK
    ====================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'description'        => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'nullable|integer|min:0',
            'installation_price' => 'nullable|numeric|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = new Product();

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->harga = $request->harga;
        $product->stok = $request->stok ?? 0;

        $product->installation_available = $request->has('installation_available') ? 1 : 0;
        $product->installation_price = $request->installation_price ?? 0;

        if ($request->hasFile('image')) {
            $product->image_primary = $request->file('image')
                ->store('products', 'public');
        }

        $product->save();

        // SIMPAN GALERI (Tambahkan ini)
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $path = $file->store('products/gallery', 'public');
                \App\Models\ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_url'  => $path
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /* ======================================================
        FORM EDIT
    ====================================================== */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /* ======================================================
        UPDATE PRODUK
    ====================================================== */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'description'        => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'nullable|integer|min:0',
            'installation_price' => 'nullable|numeric|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->harga = $request->harga;
        $product->stok = $request->stok ?? 0;

        $product->installation_available = $request->has('installation_available') ? 1 : 0;
        $product->installation_price = $request->installation_price ?? 0;

        if ($request->hasFile('image')) {

            if ($product->image_primary) {
                Storage::disk('public')->delete($product->image_primary);
            }

            $product->image_primary = $request->file('image')
                ->store('products', 'public');
        }

        $product->save();

        // SIMPAN GALERI (Tambahkan ini)
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $path = $file->store('products/gallery', 'public');
                \App\Models\ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_url'  => $path
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /* ======================================================
        DELETE PRODUK
    ====================================================== */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_primary) {
            Storage::disk('public')->delete($product->image_primary);
        }

        $product->delete();

        return redirect()
            ->back()
            ->with('success', 'Produk berhasil dihapus');
    }
}