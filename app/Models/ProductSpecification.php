<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'material',
        'size',
        'finishing',
        'price',
        'quality_score',
        'durability_score',
        'texture_score'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function topsisResults()
    {
        return $this->hasMany(TopsisResult::class);
    }
}
