<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    use HasFactory;
    protected $table = 'order_product';
    protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];
    public function detail()
    {
        return $this->hasOne(OrderProductDetail::class, 'order_product_id');
    }

    public function extras()
    {
        return $this->hasMany(OrderProductExtra::class, 'order_product_id');
    }
}
