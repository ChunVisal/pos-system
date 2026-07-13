<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    protected $fillable = [
        'cashier_id',
        'product_id',
        'quantity_requested',
        'quantity_approved',
        'status',
        'approved_by',
        'admin_notes',
        'cashier_notes',
        'dispute_reason',
        'eta',
        'confirmed_at'
    ];

    protected $casts = ['confirmed_at' => 'datetime'];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
