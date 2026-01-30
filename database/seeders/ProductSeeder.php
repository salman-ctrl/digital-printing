<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'name' => 'Banner Flexi',
                'description' => 'Banner berbahan flexi berkualitas tinggi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Banner Albatros',
                'description' => 'Banner indoor dengan kualitas warna tajam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Stiker Vinyl',
                'description' => 'Stiker tahan air dan cuaca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
