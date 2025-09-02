<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        //total_amount, unit_amount
        'unit_amount',
        'total_amount',
    ];

    // belongs to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // belongs to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
