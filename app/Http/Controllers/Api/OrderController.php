<?php

namespace App\Http\Controllers\Api;

use App\Services\Cashier\FirebaseNotificationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\{
    Order,
    OrderProductDetail,
    OrderProductExtra,
    Product,
    Setting,
    Coupon,
};
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Log};

class OrderController extends Controller
{
    use ApiTrait;

    public function store(Request $request)
    {
//        dd($request->products);
        try {
            $order = DB::transaction(function () use ($request) {
                $user = auth()->user();
                $loyaltyPoints= false;
                $order = Order::create([
                    "user_id" => $user->id,
                    "branch_id" => $request->branch_id,
                    "order_number" => rand(1000, 9999),
                    "payment_type" => $request->payment_type,
                    "payment_status" => $request->payment_status,
                    "status" => "pending",
                    "order_location" => $request->order_location,
                    "is_delivery" => $request->is_delivery ?? 0,
                    "delivery_fee" => $request->delivery_fee,
                    "total_price" => 0,
                ]);
                $totalPrice = 0;
                $couponDiscount = 0;
                foreach ($request->products as $productData) {
                    $product = Product::findOrFail($productData["product_id"]);
                    $loyaltyPoints = $productData['isUseLoyaltyPoints'] ?? false;
                    $order->products()->attach($product->id, [
                        "quantity" => $productData["quantity"],
                        "price" => $loyaltyPoints ? 0 : $product->price * $productData["quantity"],
                        'isUseLoyaltyPoints' => $loyaltyPoints ,
                    ]);
                    $orderProduct = $order
                        ->products()
                        ->where("product_id", $product->id)
                        ->first()->pivot;
                    $detail = OrderProductDetail::create([
                        "order_id" => $order->id,
                        "product_id" => $product->id,
                        "order_product_id" => $orderProduct->id,
                        "size_id" => $productData["size_id"] ?? null,
                        "type_id" => $productData["type_id"] ?? null,
                        "size_price" => $loyaltyPoints ? 0 : $productData["size_price"] ,
                        "type_price" => $loyaltyPoints ? 0 : $productData["type_price"] ,
                    ]);
                    $totalPrice +=
                        ($detail->size_price + $detail->type_price) *
                        $productData["quantity"];
                    if (!empty($productData["extras"])) {
                        foreach ($productData["extras"] as $extra) {
                            OrderProductExtra::create([
                                "order_product_id" => $orderProduct->id,
                                "extra_id" => $extra["extra_id"],
                                "quantity" => $extra["quantity"],
                                "price" => $extra["price"],
                            ]);
                            $totalPrice += $extra["price"] * $extra["quantity"];
                        }
                    }
                }
                $setting = Setting::first();
                $loyaltyPointsToAdd = $totalPrice * $setting->loyalty_points;
                if ($loyaltyPointsToAdd > 0) {
                    $user = auth()->user();
                    $user->loyalty_points += $loyaltyPointsToAdd;
                    $user->save();
                }
                $delivery_fee = $request->delivery_fee ?? 0;
                $totalPrice += $request->delivery_fee;

                if ($request->has("coupon_id") && $request->coupon_id) {
                    $coupon = Coupon::where("id", $request->coupon_id)
                        ->where("status", "active")
                        ->where("from", "<=", now())
                        ->where("to", ">=", now())
                        ->first();
                    if ($coupon) {
                        if ($coupon->percentage != null) {
                            $couponDiscount =
                                ($totalPrice * $coupon->percentage) / 100;
                        } else {
                            $couponDiscount = min($coupon->amount, $totalPrice);
                        }
                    }
                }

                $totalPrice -= $couponDiscount;
                $order->update([
                    "total_price" => max(0, $totalPrice),
                    "coupon_discount" => $couponDiscount,
                ]);
                $order->load("products", "details");
                return $order;
            });
            event(new \App\Events\NewOrderCreated($order));
            return $this->successResponse(
                (new OrderResource($order)),
                "Order created successfully",
                201,
            );
        } catch (\Exception $e) {
            Log::error("Error while creating order: " . $e->getMessage());
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Failed to create order.",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
    public function show($id)
    {
        $order = Order::with(["products", "details", "extras"])->find($id);
        if (!$order) {
            return $this->notFoundResponse("Order not found");
        }
        return $this->successResponse(new OrderResource($order));
    }
    public function getUserOrders($id)
    {
        $orders = Order::with(["products", "details", "extras"])
            ->where("user_id", $id)
            ->get();
        return OrderResource::collection($orders);
    }

    protected function calculateLoyaltyPoints($totalPrice)
    {
        return floor($totalPrice / 10);
    }
}
