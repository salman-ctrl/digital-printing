<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->withCount('children')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with(['parent'])->findOrFail($id);

        // sub kategori
        $subCategories = Category::where('parent_id', $id)->get();

        // produk langsung
        $products = Product::where('category_id', $id)->get();

        return view('admin.categories.show', compact(
            'category',
            'subCategories',
            'products'
        ));
    }

    public function create(Request $request)
    {
        $parents = Category::whereNull('parent_id')->get();
        
        if ($request->routeIs('admin.*')) {
            return view('admin.categories.create', compact('parents'));
        }

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        // Update slug jika nama berubah
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name) . '-' . time();
        }

        // ===============================
        // HAPUS GAMBAR LAMA
        // ===============================
        if ($request->remove_image == 1) {

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = null;
        }

        // ===============================
        // UPLOAD GAMBAR BARU
        // ===============================
        if ($request->hasFile('image')) {

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $parentId = $category->parent_id; // simpan parent dulu

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        // kalau ini sub kategori, balik ke detail parent
        if ($parentId) {
            return redirect()
                ->route('admin.categories.show', $parentId)
                ->with('success', 'Sub kategori berhasil dihapus');
        }

        // kalau kategori utama
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
    
}
