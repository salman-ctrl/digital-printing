<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function weights()
    {
        return $this->hasMany(CriteriaWeight::class);
    }
}
