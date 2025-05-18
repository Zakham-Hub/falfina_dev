<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Models\Type;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ApiTrait;

    public function index($id): JsonResponse
    {
        try {
            $coupon = Coupon::where('id', $id)->first();
            return $this->successResponse([
                'coupons'    => CouponResource::make($coupon),
            ], 'Coupon retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Coupons.', 500, $e->getMessage());
        }
    }
    public function getAll(): JsonResponse
    {
        try {
            $coupon = Coupon::orderByDesc('created_at')->paginate(10);

            return $this->successResponse([
                'coupons'    => CouponResource::collection($coupon->items()),
                'pagination' => [
                    'total'         => $coupon->total(),
                    'per_page'      => $coupon->perPage(),
                    'current_page'  => $coupon->currentPage(),
                    'last_page'     => $coupon->lastPage(),
                ],
            ], 'Coupons retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Coupons.', 500, $e->getMessage());
        }
    }
}
