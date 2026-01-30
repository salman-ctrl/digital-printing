<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSpecificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_specifications')->insert([
            [
                'product_id' => 1,
                'material' => 'Flexi Korea',
                'size' => '60x160 cm',
                'finishing' => 'Laminasi Glossy',

                'harga' => 15000,
                'kualitas_warna' => 4,
                'daya_tahan' => 4,
                'tekstur_bahan' => 3,
                'ukuran_cetak' => 3,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'material' => 'Flexi China',
                'size' => '60x160 cm',
                'finishing' => 'Tanpa Laminasi',

                'harga' => 20000,
                'kualitas_warna' => 5,
                'daya_tahan' => 5,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 4,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'material' => 'Albatros',
                'size' => 'A2',
                'finishing' => 'Laminasi Doff',

                'harga' => 18000,
                'kualitas_warna' => 5,
                'daya_tahan' => 3,
                'tekstur_bahan' => 4,
                'ukuran_cetak' => 3,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'material' => 'Vinyl',
                'size' => 'A3',
                'finishing' => 'Cutting',

                'harga' => 12000,
                'kualitas_warna' => 3,
                'daya_tahan' => 4,
                'tekstur_bahan' => 3,
                'ukuran_cetak' => 3,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
