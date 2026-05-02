<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'image_primary', 'harga', 'stok', 'installation_available',
    'installation_price'];

    public function getImageUrlAttribute()
    {
        if (!$this->image_primary) {
            return 'https://placehold.co/600x400/f3f4f6/1f2937?text=' . urlencode($this->name);
        }

        if (str_starts_with($this->image_primary, 'http')) {
            return $this->image_primary;
        }

        if (Storage::disk('public')->exists($this->image_primary)) {
            return Storage::url($this->image_primary);
        }

        return 'https://placehold.co/600x400/f3f4f6/1f2937?text=' . urlencode($this->name);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
