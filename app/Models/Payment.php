<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'method', 'amount', 'amount_received', 'change', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
