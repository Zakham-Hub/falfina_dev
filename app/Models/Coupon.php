<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $guarded = [];
    const STATUS = ['active', 'not active'];
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
