<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\CouponDataTable;
use App\Services\Contracts\CouponInterface;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function __construct(protected CouponDataTable $couponDataTable, protected CouponInterface $couponInterface)
    {
        $this->couponInterface = $couponInterface;
        $this->couponDataTable = $couponDataTable;
    }

    public function index(CouponDataTable $couponDataTable)
    {
        return $this->couponInterface->index($this->couponDataTable);
    }

    public function create()
    {
        return $this->couponInterface->create();
    }

    public function store(Request $request)
    {
        return $this->couponInterface->store($request);
    }

    public function edit(Coupon $coupon)
    {
        return $this->couponInterface->edit($coupon);
    }

    public function update(Request $request, Coupon $coupon)
    {
        return $this->couponInterface->update($request, $coupon);
    }

    public function destroy(Coupon $coupon)
    {
        return $this->couponInterface->destroy($coupon);
    }
}
