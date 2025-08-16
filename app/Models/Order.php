<?php

namespace App\Models;

use App\Models\Branch;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\{DB};
use App\Enums\Order\{OrderStatus, OrderPaymentType};
use App\Models\Concerns\History\Historyable;
use App\Observers\OrderObserver;

class Order extends Model
{
    use HasFactory, Historyable;
    protected $fillable = ['user_id', 'status', 'total_price', 'branch_id', 'order_location', 'order_number', 'is_delivery', 'delivery_fee', 'payment_type', 'payment_status', 'coupon_discount'];

    protected static function booted()
    {
         static::addGlobalScope(new OrderScope);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('id', 'quantity', 'price', 'isUseLoyaltyPoints')
            ->using(OrderProduct::class); // Enable pivot model
    }
    public function details()
    {
        return $this->hasMany(OrderProductDetail::class);
    }

     public function extras()
    {
        return $this->hasManyThrough(OrderProductExtra::class, OrderProductDetail::class, 'order_id', 'order_product_id', 'id', 'order_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');

    }
    public function branches($id)
    {
        $order = Branch::where('id', $id)->first('name');
        return $order;
    }
    public function totalQuantity()
    {
        return $this->products()->sum('quantity');
    }

    public function totalProductsPrice()
    {
        return $this->products()->sum(DB::raw('quantity * price'));
    }

    protected $casts = [
        //'status' => OrderStatus::class,
        'payment_type' => OrderPaymentType::class
    ];

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }


    public function getDeliveryTypeAttribute() {
        if ($this->is_delivery) {
            $link = $this->order_location;
            return 'توصيل<br><a href="' . $link . '" target="_blank" class="btn btn-sm btn-primary mt-1">تتبع الطلب</a>';
        }
        return 'استلام من الفرع';
    }

        public function deliveryType()
    {
        return $this->is_delivery ? 'توصيل للعميل' : 'استلام من الفرع';
    }
}
