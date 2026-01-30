<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('criterias')->insert([
            [
                'name' => 'Harga',
                'type' => 'cost',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kualitas Warna',
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Daya Tahan',
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tekstur Bahan',
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ukuran Cetak',
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
