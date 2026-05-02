<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSpecificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_specifications')->delete();

        $specs = [
            [
                'product_name' => 'Banner Flexi China 280gr',
                'material' => 'Flexi China',
                'size' => 'Permeter',
                'finishing' => 'Mata Ayam',
                'harga' => 15000,
                'kualitas_warna' => 3,
                'daya_tahan' => 3,
                'tekstur_bahan' => 2,
                'ukuran_cetak' => 5,
            ],
            [
                'product_name' => 'Banner Flexi Korea 440gr',
                'material' => 'Flexi Korea',
                'size' => 'Permeter',
                'finishing' => 'Mata Ayam / Selongsong',
                'harga' => 35000,
                'kualitas_warna' => 4,
                'daya_tahan' => 5,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 5,
            ],
            [
                'product_name' => 'Banner Albatros',
                'material' => 'Albatros',
                'size' => 'Permeter',
                'finishing' => 'Laminasi Glossy/Doff',
                'harga' => 45000,
                'kualitas_warna' => 5,
                'daya_tahan' => 3,
                'tekstur_bahan' => 5,
                'ukuran_cetak' => 4,
            ],
            [
                'product_name' => 'Stiker Vinyl Ritrama',
                'material' => 'Vinyl Ritrama',
                'size' => 'Permeter',
                'finishing' => 'Tanpa Cutting',
                'harga' => 65000,
                'kualitas_warna' => 5,
                'daya_tahan' => 5,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 4,
            ],
            [
                'product_name' => 'Brosur Art Paper 150gr',
                'material' => 'Art Paper 150gr',
                'size' => 'A4',
                'finishing' => 'Potong Pas',
                'harga' => 1500,
                'kualitas_warna' => 4,
                'daya_tahan' => 3,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 2,
            ],
        ];

        foreach ($specs as $specData) {
            $product = Product::where('name', $specData['product_name'])->first();
            if ($product) {
                unset($specData['product_name']);
                $specData['product_id'] = $product->id;
                $specData['created_at'] = now();
                $specData['updated_at'] = now();
                DB::table('product_specifications')->insert($specData);
            }
        }
    }
}
