<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stocked',
    ];

    protected $casts = [
        'stocked' => 'boolean',
        'price' => 'decimal:2',
    ];
}
