<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\CouponDataTable;
use Illuminate\Http\Request;
use App\Models\Coupon;

interface CouponInterface
{
    public function index(CouponDataTable $couponDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Coupon $coupon);
    public function update(Request $request, Coupon $coupon);
    public function destroy(Coupon $coupon);
}
