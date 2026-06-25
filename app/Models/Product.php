<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'code',
        'image',
        'brand',
        'name',
        'barcode',
        'category_id',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'low_stock_threshold',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
