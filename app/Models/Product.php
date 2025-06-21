<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock',
        'product_image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
