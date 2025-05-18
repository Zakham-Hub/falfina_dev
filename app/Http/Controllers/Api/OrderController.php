<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\{Order, OrderProductDetail, OrderProductExtra, Product};
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Log};

class OrderController extends Controller
{
    use ApiTrait;
    public function store(Request $request)
    {
        try {
            $order = DB::transaction(function () use ($request) {
                $user = auth()->user();
                $order = Order::create([
                    'user_id' => $user->id,
                    'branch_id' => $request->branch_id,
                    'order_number' => rand(1000, 9999),
                    'payment_type' => $request->payment_type,
                    'payment_status' => $request->payment_status,
                    'status' => 'pending',
                    'order_location' => $request->order_location,
                    'is_delivery' => $request->is_delivery ?? 0,
                    'total_price' => 0
                ]);
                $totalPrice = 0;
                foreach ($request->products as $productData) {
                    $product = Product::findOrFail($productData['product_id']);
                    $order->products()->attach($product->id, [
                        'quantity' => $productData['quantity'],
                        'price' => $product->price * $productData['quantity']
                    ]);
                    $orderProduct = $order->products()->where('product_id', $product->id)->first()->pivot;
                    $detail = OrderProductDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'order_product_id' => $orderProduct->id,
                        'size_id' => $productData['size_id'] ?? null,
                        'type_id' => $productData['type_id'] ?? null,
                        'size_price' => $productData['size_price'] ?? 0,
                        'type_price' => $productData['type_price'] ?? 0,
                    ]);
                    $totalPrice += ($product->price + $detail->size_price + $detail->type_price) * $productData['quantity'];
                    if (!empty($productData['extras'])) {
                        foreach ($productData['extras'] as $extra) {
                            OrderProductExtra::create([
                                'order_product_id' => $orderProduct->id,
                                'extra_id' => $extra['extra_id'],
                                'quantity' => $extra['quantity'],
                                'price' => $extra['price']
                            ]);
                            $totalPrice += $extra['price'] * $extra['quantity'];
                        }
                    }
                }
                $order->update(['total_price' => $totalPrice]);
                $order->load('products', 'details');
                return $order;
            });
            event(new \App\Events\NewOrderCreated($order));
            return $this->successResponse(new OrderResource($order), 'Order created successfully', 201);
        } catch (\Exception $e) {
            Log::error('Error while creating order: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        $order = Order::with(['products', 'details', 'extras'])->find($id);
        if (!$order) {
            return $this->notFoundResponse('Order not found');
        }
        return $this->successResponse(new OrderResource($order));
    }
    public function getUserOrders($id)
    {
        $orders = Order::with(['products', 'details', 'extras'])->where('user_id', $id)->get();
        return OrderResource::collection($orders);
    }
}
