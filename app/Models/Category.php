<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    // Database standar digital-printing (Laravel convention)
    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image'
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories for this category.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Accessor untuk image_url
     * Menangani deteksi otomatis URL Cloudinary vs File Lokal
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
        }

        // 1. Jika data diawali 'http', berarti ini URL Cloudinary dari Admin Node.js
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // 2. Jika bukan URL, cek apakah file ada di storage lokal (Legacy data)
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        // 3. Fallback jika ada data di DB tapi file fisiknya tidak ditemukan
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the total products count including subcategories.
     */
    public function getTotalProductsCountAttribute()
    {
        $count = $this->products()->count();

        foreach ($this->children as $child) {
            $count += $child->total_products_count;
        }

        return $count;
    }
}
