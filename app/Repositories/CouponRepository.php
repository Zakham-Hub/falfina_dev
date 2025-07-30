<?php

namespace App\Repositories;

use App\DataTables\Dashboard\Admin\CouponDataTable;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\Contracts\CouponInterface;
use Illuminate\Http\Request;

class CouponRepository implements CouponInterface
{
    public function index(CouponDataTable $couponDataTable)
    {
        $products = Product::get();
        return $couponDataTable->render('dashboard.admin.coupons.index', [
            'pageTitle' => 'Coupons',
            'products' => $products
        ]);
    }

    public function create()
    {
        $products = Product::get();
        return view('dashboard.admin.coupons.create', [
            'pageTitle' => 'Create Coupon',
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name',
            'type' => 'required|in:percentage,fixed',
            'percentage' => 'required|numeric|min:0',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:active,not active',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id'
        ]);

        $coupon = Coupon::create($request->only([
            'name', 'type', 'percentage', 'from', 'to', 'amount', 'status'
        ]));

        if ($request->has('products')) {
            $coupon->products()->sync($request->products);
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully');
    }

    public function edit(Coupon $coupon)
    {
        $products = Product::get();
        return view('dashboard.admin.coupons.edit', [
            'pageTitle' => 'Edit Coupon',
            'coupon' => $coupon,
            'products' => $products
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name,'.$coupon->id,
            'type' => 'required|in:percentage,fixed',
            'percentage' => 'required|numeric|min:0',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:active,not active',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id'
        ]);

        $coupon->update($request->only([
            'name', 'type', 'percentage', 'from', 'to', 'amount', 'status'
        ]));

        $coupon->products()->sync($request->products ?? []);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->products()->detach();
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully');
    }
}
