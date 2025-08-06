<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Order;
use App\Models\Branch;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Cashier\OrderService;

class OrderController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected OrderService $orderService){}

    public function index(Request $request)
    {
        $user = auth()->user();

        $perPage = $request->input('per_page', 15); // القيمة الافتراضية 15
        $page = $request->input('page', 1);

        // Start building the base query
        if ($user instanceof \App\Models\Admin) {
            // Admin: كل الطلبات
            $query = Order::query();
        } elseif ($user instanceof \App\Models\Manager) {
            // Manager: طلبات الفرع الخاص به فقط
            $query = Order::where('branch_id', $user->branch_id);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }

        // Apply client_name filter if present
        if ($request->filled('client_name')) {
            $clientName = $request->input('client_name');
            $query->whereHas('user', function ($q) use ($clientName) {
                $q->where('name', 'like', "%$clientName%");
            });
        }

        // Apply order_number filter if present
        if ($request->filled('order_number')) {
            $orderNumber = $request->input('order_number');
            $query->where('order_number', 'like', "%$orderNumber%");
        }

        $orders = $query->paginate($perPage, ['*'], 'page', $page);

        return $this->successResponse(OrderResource::collection($orders), 'Orders retrieved successfully');
    }

    public function downloadInvoice($id) {
        try {
        return $this->orderService->download(Order::findOrFail($id));
        }catch (\Throwable $e) {
            return $this->errorResponse('Error downloading invoice: ' . $e->getMessage(), 500);
        }
    }

    public function getOrderStatus()
    {
        try {
            $data = $this->orderService->getOrderStatus();
            return $this->successResponse($data, message:'Order statuses retrieved successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse('Error retrieving order statuses: ' . $e->getMessage(), 500);
        }

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
        try {
            $order = $this->orderService->find($id);
            return $this->successResponse(new OrderResource($order), 'Order retrieved successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse('Order not found: ' . $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $order = Order::findOrFail($id);
//            dd($order);
         $this->orderService->setOrderStatus($order, $request->input('status'));
            return $this->successResponse($order, 'Order status updated successfully');
        }catch (\Throwable $e) {
            return $this->errorResponse('Error updating order status: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->load(['products', 'user', 'branch']);
            $order->delete();
            return $this->successResponse(null, 'Order deleted successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse('Order not found', 404);
        }
    }

    // public function getSummary(Request $request){
    //     $user = auth()->user();
    //     $branchId = null;
    //     // dd($request->branch_name);
    //     if ($user instanceof \App\Models\Admin) {
    //         // Admin: can specify branch by name
    //         if ($request->has('branch_name') && !empty($request->branch_name)) {
    //             $branch = \App\Models\Branch::where('name', $request->branch_name)->first();
    //             if (!$branch) {
    //                 return $this->errorResponse('Branch not found', 404);
    //             }
    //             $branchId = $branch->id;
    //         }
    //     } elseif ($user instanceof \App\Models\Manager) {
    //         // Manager: only their branch, ignore branch_name parameter
    //         $branch = $user->branch;
    //     } else {
    //         return $this->errorResponse('Unauthorized', 401);
    //     }

    //     // Build base query for today's orders
    //     $today = now()->format('Y-m-d');
    //     $query = Order::whereDate('created_at', $today);
        
    //     if ($branch->id) {
    //         $query->where('branch_id', $branch->id);
    //     }

    //     // Get counts for different statuses
    //     $todayOrders = $query->count();
    //     $pendingOrders = (clone $query)->where('status', 'pending')->count();
    //     $completedOrders = (clone $query)->whereIn('status', ['completed', 'delivered'])->count();
        
    //     // Calculate today's profits (completed and delivered orders only)
    //     $todayProfits = (clone $query)
    //         ->whereIn('status', ['completed', 'delivered'])
    //         ->sum('total_price');

    //     $summary = [
    //         'today_orders' => $todayOrders,
    //         'pending_orders' => $pendingOrders,
    //         'completed_orders' => $completedOrders,
    //         'today_profits' => $todayProfits,
    //         // 'branch_id' => $branchId,
    //         'branch_name' => $branch->name,
    //         'date' => $today
    //     ];

    //     return $this->successResponse($summary, 'Orders summary retrieved successfully');
    // }
    public function getSummary(Request $request)
{
    $user = auth()->user();
    $branch = null;

    if ($user instanceof \App\Models\Admin) {
        // Admin: يمكنه تحديد الفرع بالاسم
        if ($request->has('branch_name') && !empty($request->branch_name)) {
            $branch = \App\Models\Branch::where('name', $request->branch_name)->first();
            if (!$branch) {
                return $this->errorResponse('Branch not found', 404);
            }
        } else {
            return $this->errorResponse('branch_name is required for admin', 400);
        }
    } elseif ($user instanceof \App\Models\Manager) {
        // Manager: فرعه فقط
        $branch = $user->branch;
    } else {
        return $this->errorResponse('Unauthorized', 401);
    }

    // التأكد أن branch موجود
    if (!$branch) {
        return $this->errorResponse('Branch not resolved', 400);
    }

    $today = now()->format('Y-m-d');

    $query = Order::whereDate('created_at', $today)
                  ->where('branch_id', $branch->id);

    $todayOrders = $query->count();
    $pendingOrders = (clone $query)->where('status', 'pending')->count();
    $completedOrders = (clone $query)->whereIn('status', ['completed', 'delivered'])->count();

    $todayProfits = (clone $query)
        ->whereIn('status', ['completed', 'delivered'])
        ->sum('total_price');

    $summary = [
        'today_orders' => $todayOrders,
        'pending_orders' => $pendingOrders,
        'completed_orders' => $completedOrders,
        'today_profits' => $todayProfits,
        'branch_name' => $branch->name,
        'date' => $today
    ];

    return $this->successResponse($summary, 'Orders summary retrieved successfully');
}

}
