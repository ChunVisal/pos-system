<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'code',
        'image',
        'name',
        'status',
        'sort_order',
        'tax_rate',
        'discount_allowed',
    ];
}
