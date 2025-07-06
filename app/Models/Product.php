<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'price', 'image', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];
}
