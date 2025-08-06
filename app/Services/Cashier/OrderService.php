<?php

namespace App\Services\Cashier;

use App\Models\Order;
//use Barryvdh\DomPDF\Facade\Pdf;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf; // Assuming you are using the Barryvdh DomPDF package
class OrderService
{
    public function find($id) {
        $order = Order::findOrFail($id);
        $order->load(['products', 'user', 'branch']);
        $order->products->each(function ($product) {
            $product->pivot->load([
                'detail.size',
                'detail.type',
                'extras.extra',
            ]);
        });
        return $order;
    }
    public function download(Order $order) {
        $order->load(['products', 'user', 'branch']);
        $order->products->each(function ($product) {
            $product->pivot->load([
                'detail.size',
                'detail.type',
                'extras.extra',
            ]);
        });

        $data = [
            'order_id' => $order->id,
            'total_price' => $order->total_price,
            'payment_type' => optional($order->payment_type)->label() ?? 'غير محدد',
            'order_location' => $order?->order_location,
            'user' => [
                'name' => $order->user->name,
            ],
            'branch' => [
                'name' => $order->branch->name,
                'address' => $order->branch->address,
            ],
            'products' => $order->products->map(function ($product) {
                $detail = $product->pivot->detail;
                return [
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,
                    'size' => $detail && $detail->size ? [
                        'name' => $detail->size->name,
                        'price' => $detail->size_price,
                    ] : null,
                    'type' => $detail && $detail->type ? [
                        'name' => $detail->type->name,
                        'price' => $detail->type->type_price,
                    ] : null,
                    'extras' => $product->pivot->extras->map(function ($extra) {
                        return [
                            'name' => $extra->extra->name ?? '',
                            'price' => $extra->price,
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
        $pdf = Pdf::loadView('dashboard.layouts.invoice', compact('order', 'data'));
        $filename = 'invoice_' . $order->order_number . '.pdf';
        return $pdf->download($filename);
    }
    public function setOrderStatus($order, $status) {
        $order->status = $status;
        $order->save();
        return $order;
    }
    public function getOrderStatus()
    {
        $statuses = \App\Enums\Order\OrderStatus::cases();
        $data = collect($statuses)->map(function ($status) {
            return [
                'value' => $status->value,
                'label' => $status->label(),
                'badge_color' => $status->badgeColor(),
            ];
        })->toArray();
        return $data;
    }
}
