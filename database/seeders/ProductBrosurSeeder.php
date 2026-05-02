<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBrosurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brosur = \App\Models\Product::create([
            'category_id' => 3, // Brosur
            'name' => 'Brosur A4 Premium',
            'description' => 'Cetak brosur A4 berkualitas tinggi dengan berbagai pilihan bahan.',
            'image' => 'products/brosur.jpg'
        ]);

        $specs = [
            [
                'product_id' => $brosur->id,
                'material' => 'HVS 80gr',
                'size' => 'A4',
                'finishing' => 'Tanpa Laminating',
                'harga' => 1500,
                'kualitas_warna' => 3,
                'daya_tahan' => 2,
                'tekstur_bahan' => 2,
                'ukuran_cetak' => 4,
            ],
            [
                'product_id' => $brosur->id,
                'material' => 'Art Paper 120gr',
                'size' => 'A4',
                'finishing' => 'Tanpa Laminating',
                'harga' => 2500,
                'kualitas_warna' => 4,
                'daya_tahan' => 3,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 4,
            ],
            [
                'product_id' => $brosur->id,
                'material' => 'Art Paper 150gr',
                'size' => 'A4',
                'finishing' => 'Laminating Glossy',
                'harga' => 3500,
                'kualitas_warna' => 5,
                'daya_tahan' => 4,
                'tekstur_bahan' => 5,
                'ukuran_cetak' => 4,
            ]
        ];

        foreach ($specs as $spec) {
            \App\Models\ProductSpecification::create($spec);
        }
    }
}
