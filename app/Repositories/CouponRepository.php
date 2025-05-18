<?php

namespace  App\Repositories;

use App\DataTables\Dashboard\Admin\CouponDataTable;
use App\Models\Coupon;
use App\Services\Contracts\CouponInterface;
use Illuminate\Http\Request;

class CouponRepository implements CouponInterface
{
    public function index(CouponDataTable $couponDataTable)
    {
        return $couponDataTable->render('dashboard.admin.coupons.index', ['pageTitle' => 'coupons']);
    }

    public function create()
    {
        return view('dashboard.admin.coupons.create', ['pageTitle' => 'coupons']);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'from' => 'required|date|max:255',
            'to' => 'required|date|max:255',
            'amount' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'percentage' => 'required|string|max:255',
        ]);
        if ($request->from < date("Y-m-d")) {
            return back()->withErrors(['from' => 'تاريخ البداية يجب أن يكون بعد تاريخ اليوم.'])->withInput();
        }
        if ($request->from > $request->to) {
            return back()->withErrors(['from' => 'تاريخ البداية يجب أن يكون قبل تاريخ النهاية.'])->withInput();
        }
        Coupon::create($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function edit(Coupon $coupon)
    {
        return view('dashboard.admin.coupons.edit', ['pageTitle' => 'تعديل كوبون', 'coupon' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'from' => 'required|date|max:255',
            'to' => 'required|date|max:255',
            'amount' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'percentage' => 'required|string|max:255',

        ]);
        if ($request->from < date("Y-m-d")) {
            return back()->withErrors(['from' => 'تاريخ البداية يجب أن يكون بعد تاريخ اليوم.'])->withInput();
        }
        if ($request->from > $request->to) {
            return back()->withErrors(['from' => 'تاريخ البداية يجب أن يكون قبل تاريخ النهاية.'])->withInput();
        }
        $coupon->update($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'تم الحذف بنجاح!');
    }
}
