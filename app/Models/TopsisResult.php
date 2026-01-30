<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopsisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_specification_id',
        'preference_value',
        'rank',
        'calculated_at'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specification()
    {
        return $this->belongsTo(ProductSpecification::class, 'product_specification_id');
    }
}
