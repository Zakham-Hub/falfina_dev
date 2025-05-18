<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductExtra extends Model
{
    use HasFactory;
    protected $table = 'order_product_extras';
    protected $fillable = ['order_product_id', 'extra_id', 'quantity', 'price'];
    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }

    /*public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function product()
    {
        return $this->hasOneThrough(Product::class, OrderProduct::class, 'id', 'id', 'order_product_id', 'product_id');
    }*/
}
