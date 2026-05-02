<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\TopsisResult;
use App\Models\TopsisLog;
use App\Models\ProductSpecification;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Show the recommendation page (Global).
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        $criterias = Criteria::all();
        
        return view('pages.public.rekomendasi', compact('categories', 'criterias'));
    }

    /**
     * Get subcategories for a parent category.
     */
    public function getSubCategories($parentId)
    {
        $subcategories = Category::where('parent_id', $parentId)->get();
        return response()->json($subcategories);
    }

    /**
     * Get products for a category.
     */
    public function getProducts($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json($products);
    }

    /**
     * Get criteria ranges (min/max) for a category or product.
     */
    public function getCriteriaRanges($categoryId)
    {
        // Get products in this category and all its sub-categories
        $categoryIds = Category::where('id', $categoryId)
            ->orWhere('parent_id', $categoryId)
            ->pluck('id');
            
        $productIds = Product::whereIn('category_id', $categoryIds)->pluck('id');
        
        $specifications = ProductSpecification::whereIn('product_id', $productIds)->get();

        if ($specifications->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk dalam kategori ini']);
        }

        $minPrice = $specifications->min('harga');
        $maxPrice = $specifications->max('harga');
        $avgPrice = $specifications->avg('harga');

        $ranges = [];
        $criteriaCols = ['harga', 'kualitas_warna', 'daya_tahan', 'tekstur_bahan', 'ukuran_cetak'];

        foreach ($criteriaCols as $col) {
            $ranges[$col] = [
                'min' => $specifications->min($col),
                'max' => $specifications->max($col),
            ];
        }

        // Always provide 3 buckets so users can set their preference (weight)
        // Even if prices are same, the weight still affects TOPSIS results relative to other criteria
        if ($minPrice == $maxPrice) {
            $priceBuckets = [
                ['label' => 'Harga Termurah (Prioritas Budget)', 'min' => $minPrice, 'max' => $maxPrice, 'weight' => 5],
                ['label' => 'Harga Standar (Keseimbangan)', 'min' => $minPrice, 'max' => $maxPrice, 'weight' => 3],
                ['label' => 'Kualitas Premium (Prioritas Hasil)', 'min' => $minPrice, 'max' => $maxPrice, 'weight' => 1],
            ];
        } else {
            $priceBuckets = [
                ['label' => 'Harga Termurah', 'min' => $minPrice, 'max' => ($minPrice + $avgPrice) / 2, 'weight' => 5],
                ['label' => 'Harga Menengah', 'min' => ($minPrice + $avgPrice) / 2, 'max' => ($avgPrice + $maxPrice) / 2, 'weight' => 3],
                ['label' => 'Kualitas Premium', 'min' => ($avgPrice + $maxPrice) / 2, 'max' => $maxPrice, 'weight' => 1],
            ];
        }

        return response()->json([
            'success' => true,
            'ranges' => $ranges,
            'price_buckets' => $priceBuckets
        ]);
    }

    /**
     * Handle TOPSIS calculation.
     */
    public function calculate(Request $request)
    {
        try {
            $request->validate([
                'weights' => 'required|array',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Get category ID from request
            $categoryId = $request->input('category_id');

            // Get all category IDs including sub-categories
            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id');

            $productIds = Product::whereIn('category_id', $categoryIds)->pluck('id');

            $specifications = ProductSpecification::whereIn('product_id', $productIds)->get();

            if ($specifications->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada spesifikasi yang ditemukan untuk kategori ini.'
                ]);
            }

            $criterias = Criteria::all();
            
            // Ambil bobot dari request, pastikan formatnya benar
            $rawWeights = $request->input('weights', []);
            $weights = [];

            foreach ($criterias as $criteria) {
                // Gunakan bobot dari request jika ada, jika tidak default ke 1.0
                $weights[$criteria->id] = isset($rawWeights[$criteria->id]) && is_numeric($rawWeights[$criteria->id])
                    ? (float)$rawWeights[$criteria->id]
                    : 1.0;
            }

            // DEBUG: Log incoming weights to verify
            \Log::info('TOPSIS Raw Weights:', (array)$rawWeights);
            \Log::info('TOPSIS Processed Weights:', $weights);
            \Log::info('TOPSIS Category ID:', ['category_id' => $categoryId]);
            \Log::info('TOPSIS Product Count:', ['count' => $productIds->count()]);

            $topsis = $this->topsisService->calculate($specifications, $weights, $criterias);
            $results = collect($topsis['results']);
            
            // Simpan log perhitungan untuk admin
            try {
                TopsisLog::create([
                    'user_id' => Auth::id(),
                    'category_id' => $categoryId,
                    'weights' => $weights,
                    'full_calculation' => $topsis
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log TOPSIS: ' . $e->getMessage());
            }

            // Optional: Save results for authenticated users (Top 5)
            if (Auth::check() && $results->isNotEmpty()) {
                foreach ($results->take(5) as $index => $res) {
                    try {
                        TopsisResult::updateOrCreate(
                            [
                                'user_id' => Auth::id(),
                                'product_specification_id' => $res['specification_id'],
                            ],
                            [
                                'preference_value' => $res['preference_value'],
                                'rank' => $index + 1,
                                'calculated_at' => now(),
                            ]
                        );
                    } catch (\Exception $e) {
                        \Log::error('Gagal menyimpan hasil TOPSIS: ' . $e->getMessage());
                    }
                }
            }

            // Transform results to include more details for frontend
            $formattedResults = $results->map(function($res) use ($topsis, $criterias) {
                $spec = ProductSpecification::with('product.category')->find($res['specification_id']);
                
                // Get matrix values for this spec ordered by criteria name to ensure C1-C5 consistency
                // C1: Harga, C2: Kualitas Warna, C3: Daya Tahan, C4: Tekstur Bahan, C5: Ukuran Cetak
                $matrixMap = [
                    'Harga' => 'C1',
                    'Kualitas Warna' => 'C2',
                    'Daya Tahan' => 'C3',
                    'Tekstur Bahan' => 'C4',
                    'Ukuran Cetak' => 'C5'
                ];

                $matrixValues = [];
                foreach ($matrixMap as $name => $code) {
                    $criteria = $criterias->first(function($c) use ($name) {
                        return trim($c->name) === $name;
                    });
                    
                    // Get raw value from spec model based on mapping in TopsisService
                    $column = match (trim($name)) {
                        'Harga' => 'harga',
                        'Kualitas Warna' => 'kualitas_warna',
                        'Daya Tahan' => 'daya_tahan',
                        'Tekstur Bahan' => 'tekstur_bahan',
                        'Ukuran Cetak' => 'ukuran_cetak',
                        default => null
                    };

                    $matrixValues[$code] = $column ? $spec->$column : 0;
                }
                
                return [
                    'preference_value' => number_format($res['preference_value'], 4),
                    'specification' => $spec,
                    'product_name' => $spec->product->name,
                    'category_name' => $spec->product->category->name,
                    'image' => $spec->product->image_url,
                    'material' => $spec->material,
                    'size' => $spec->size,
                    'finishing' => $spec->finishing,
                    'price' => $spec->harga,
                    'matrix' => $matrixValues, // Now an object: {C1: x, C2: y, ...}
                    'details' => [
                        'Harga' => 'Rp ' . number_format($spec->harga, 0, ',', '.'),
                        'Kualitas' => $spec->kualitas_warna . '/5',
                        'Daya Tahan' => $spec->daya_tahan . '/5',
                        'Tekstur' => $spec->tekstur_bahan . '/5',
                        'Ukuran' => $spec->ukuran_cetak . ' m²'
                    ]
                ];
            });

            return response()->json([
                'success' => true,

                // hasil utama
                'results' => $formattedResults,

                // 🔥 DETAIL PERHITUNGAN TOPSIS
                'debug' => [
                    'matrix' => $topsis['matrix'],
                    'normalized_matrix' => $topsis['normalized_matrix'],
                    'weighted_matrix' => $topsis['weighted_matrix'],
                    'ideal_positive' => $topsis['ideal_positive'],
                    'ideal_negative' => $topsis['ideal_negative'],
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('TOPSIS Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
