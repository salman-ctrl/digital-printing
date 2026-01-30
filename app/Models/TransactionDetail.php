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
        'subtotal'
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
