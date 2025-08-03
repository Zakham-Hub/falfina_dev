<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTrait;
class OrderController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $perPage = $request->input('per_page', 15); // القيمة الافتراضية 15
        $page = $request->input('page', 1);

        if ($user instanceof \App\Models\Admin) {
            // Admin: كل الطلبات
            $orders = \App\Models\Order::paginate($perPage, ['*'], 'page', $page);
        } elseif ($user instanceof \App\Models\Manager) {
            // Manager: طلبات الفرع الخاص به فقط
            $orders = \App\Models\Order::where('branch_id', $user->branch_id)
                ->paginate($perPage, ['*'], 'page', $page);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }

        return $this->successResponse($orders, 'Orders retrieved successfully');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
