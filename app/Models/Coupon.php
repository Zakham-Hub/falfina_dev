<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;

class Coupon extends Model
{
    use HasFactory, Historyable;

    protected $table = 'coupons';
    protected $guarded = [];
    protected $casts = [
        'from' => 'date',
        'to' => 'date',
    ];
    const STATUS = ['active', 'not active'];
    const TYPES = ['percentage', 'fixed'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isValidForProduct(Product $product = null)
    {
        // Check if coupon is active
        if ($this->status != 'active') {
            return false;
        }

        // Check date validity
        if (now() < $this->from || now() > $this->to) {
            return false;
        }

        // Check remaining amount
        if ($this->amount <= 0) {
            return false;
        }

        // If coupon has specific products, check if product is included
        if ($this->products->isNotEmpty() && $product && !$this->products->contains($product)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total)
    {
        if ($this->type == 'percentage') {
            return $total * ($this->percentage / 100);
        }

        return min($this->percentage, $total);
    }
}
