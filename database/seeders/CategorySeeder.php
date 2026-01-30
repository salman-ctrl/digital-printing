<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Banner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stiker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brosur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
