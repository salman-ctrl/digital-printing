<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_specification_id',
        'quantity'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class, 'product_specification_id');
    }
}
