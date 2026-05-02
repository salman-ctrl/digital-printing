<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid unique constraint errors
        Category::query()->delete();

        $categories = [
            [
                'name' => 'Banner & Display',
                'image' => 'categories/banner.jpg',
                'children' => [
                    ['name' => 'Banner Indoor', 'image' => 'categories/banner-indoor.jpg'],
                    ['name' => 'Banner Outdoor', 'image' => 'categories/banner-outdoor.jpg'],
                    ['name' => 'Roll Up Banner', 'image' => 'categories/rollup.jpg'],
                ]
            ],
            [
                'name' => 'Stiker & Label',
                'image' => 'categories/stiker.jpg',
                'children' => [
                    ['name' => 'Stiker Vinyl', 'image' => 'categories/stiker-vinyl.jpg'],
                    ['name' => 'Stiker Chromo', 'image' => 'categories/stiker-chromo.jpg'],
                    ['name' => 'Label Makanan', 'image' => 'categories/label.jpg'],
                ]
            ],
            [
                'name' => 'Promosi & Kantor',
                'image' => 'categories/promosi.jpg',
                'children' => [
                    ['name' => 'Brosur', 'image' => 'categories/brosur.jpg'],
                    ['name' => 'Kartu Nama', 'image' => 'categories/kartunama.jpg'],
                    ['name' => 'Sertifikat', 'image' => 'categories/sertifikat.jpg'],
                ]
            ],
        ];

        foreach ($categories as $catData) {
            $parent = Category::create([
                'name' => $catData['name'],
                'slug' => Str::slug($catData['name']),
                'image' => $catData['image'],
            ]);

            if (isset($catData['children'])) {
                foreach ($catData['children'] as $childData) {
                    Category::create([
                        'parent_id' => $parent->id,
                        'name' => $childData['name'],
                        'slug' => Str::slug($childData['name']),
                        'image' => $childData['image'],
                    ]);
                }
            }
        }
    }
}
