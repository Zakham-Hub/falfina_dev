<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderProductExtra;

class OrderResource extends JsonResource
{
    public function toArray($request) {
        $allExtras = OrderProductExtra::whereIn('order_product_id', $this->products->pluck('pivot.id')->all())->get();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'branch_id' => $this->branch_id,
            'branch_name' => $this->branches($this->branch_id) ?? '',
            'status' => $this->status,
            'total_price' => $this->total_price,
            'is_delivery' => $this->is_delivery,
            'order_location' => $this->order_location,
            'products' => $this->products->map(function ($product) use ($allExtras) {
                $productDetail = $this->details->where('order_product_id', $product->pivot->id)->first();
                $productExtras = $allExtras->where('order_product_id', $product->pivot->id);
                
                // Prepare details array
                $details = [];
                if ($productDetail) {
                    if (!is_null($productDetail->size_id)) {
                        $details['size_id'] = $productDetail->size_id;
                    }
                    if (!is_null($productDetail->size_price)) {
                        $details['size_price'] = $productDetail->size_price;
                    }
                    if (!is_null($productDetail->type_id)) {
                        $details['type_id'] = $productDetail->type_id;
                    }
                }
                
                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'base_price' => $product->price,
                    'total_product_price' => $product->pivot->price,
                    'details' => $details, // This will be an empty array if no details
                    'extras' => $productExtras->map(function ($extra) {
                        return [
                            'extra_id' => $extra->extra_id,
                            'quantity' => $extra->quantity,
                            'price' => $extra->price,
                            'total_extra_price' => $extra->quantity * $extra->price,
                        ];
                    })->values(),
                    'media' => $product->getMediaUrl('product'),
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}