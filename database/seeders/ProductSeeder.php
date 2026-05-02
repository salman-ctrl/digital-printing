<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing products
        Product::query()->delete();

        $bannerIndoor = Category::where('name', 'Banner Indoor')->first();
        $bannerOutdoor = Category::where('name', 'Banner Outdoor')->first();
        $stikerVinyl = Category::where('name', 'Stiker Vinyl')->first();
        $brosur = Category::where('name', 'Brosur')->first();

        $products = [
            [
                'category_id' => $bannerOutdoor ? $bannerOutdoor->id : null,
                'name' => 'Banner Flexi China 280gr',
                'description' => 'Banner outdoor standar untuk kebutuhan promosi jangka pendek.',
            ],
            [
                'category_id' => $bannerOutdoor ? $bannerOutdoor->id : null,
                'name' => 'Banner Flexi Korea 440gr',
                'description' => 'Banner outdoor tebal dan kuat untuk promosi jangka panjang.',
            ],
            [
                'category_id' => $bannerIndoor ? $bannerIndoor->id : null,
                'name' => 'Banner Albatros',
                'description' => 'Media cetak indoor dengan permukaan halus dan hasil warna tajam.',
            ],
            [
                'category_id' => $stikerVinyl ? $stikerVinyl->id : null,
                'name' => 'Stiker Vinyl Ritrama',
                'description' => 'Stiker outdoor berkualitas tinggi, tahan air dan sinar matahari.',
            ],
            [
                'category_id' => $brosur ? $brosur->id : null,
                'name' => 'Brosur Art Paper 150gr',
                'description' => 'Cetak brosur full color dengan kertas glossy berkualitas.',
            ],
        ];

        foreach ($products as $productData) {
            if ($productData['category_id']) {
                Product::create($productData);
            }
        }
    }
}
