<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'photo_url', 'description'];

    public function getUrlAttribute()
    {
        if (!$this->photo_url)
            return null;

        if (str_starts_with($this->photo_url, 'http')) {
            return $this->photo_url;
        }

        return Storage::url($this->photo_url);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
