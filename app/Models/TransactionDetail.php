<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_specification_id',
        'quantity',
        'price',
        'subtotal',
        'design_option',
        'design_difficulty',
        'design_cost',
        'design_file',
        'need_installation',
        'installation_price'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class, 'product_specification_id');
    }
}
