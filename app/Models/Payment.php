<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_type',
        'payment_status',
        'gross_amount',
        'midtrans_order_id',
        'response_json'
    ];

    protected $casts = [
        'response_json' => 'array'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
