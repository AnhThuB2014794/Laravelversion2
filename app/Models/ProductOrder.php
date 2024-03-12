<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'product_size',
        'product_id',
        'product_quantity',
        'product_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
}