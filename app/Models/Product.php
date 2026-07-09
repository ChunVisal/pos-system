<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'code',

        'name',
        'category_id',
        'barcode',
        'selling_price',
        'stock_quantity',
        'status',
        'cost_price',
        'brand',
        'image',
        'low_stock_threshold',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function cashierStocks()
    {
        return $this->hasMany(CashierStock::class);
    }
}
