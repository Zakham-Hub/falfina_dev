<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class OrderDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Order);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Order $order) {
            return view('dashboard.general.orders.btn.actions', compact('order'));
            })
            ->editColumn('user.name', function (Order $order) {
                return $order->user ? $order->user->name : 'N/A';
            })
            ->editColumn('user.phone', function (Order $order) {
                return $order->user ? $order->user->phone : 'N/A';
            })
            ->editColumn('branch.name', function (Order $order) {
                return $order->branch ? $order->branch->name : 'N/A';
            })
            ->editColumn('total_price', function (Order $order) {
                return number_format($order->total_price, 2);
            })
            ->editColumn('created_at', function (Order $order) {
                return $this->formatBadge($this->formatDate($order->created_at));
            })
            ->editColumn('updated_at', function (Order $order) {
                return $this->formatBadge($this->formatDate($order->updated_at));
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'total_price']);
    }

    public function query(): QueryBuilder
    {
        $query = Order::with(['user', 'branch']);

        if ($this->request->has('from') && $this->request->from) {
            $query->whereDate('created_at', '>=', $this->request->from);
        }

        if ($this->request->has('to') && $this->request->to) {
            $query->whereDate('created_at', '<=', $this->request->to);
        }

        if ($this->request->has('branch_id') && $this->request->branch_id) {
            $query->where('branch_id', $this->request->branch_id);
        }

        return $query->latest();
    }


    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'order_number', 'data' => 'order_number', 'title' => 'رقم الطلب'],
            ['name' => 'user.name', 'data' => 'user.name', 'title' => 'اسم العميل'],
            ['name' => 'user.phone', 'data' => 'user.phone', 'title' => 'رقم الهاتف'],
            ['name' => 'branch.name', 'data' => 'branch.name', 'title' => 'اسم الفرع'],
            ['name' => 'payment_status', 'data' => 'payment_status', 'title' => 'حالة الدفع'],
            ['name' => 'payment_type', 'data' => 'payment_type', 'title' => 'طريقة الدفع'],
            ['name' => 'status', 'data' => 'status', 'title' => 'حالة الطلب'],
            ['name' => 'total_price', 'data' => 'total_price', 'title' => 'المبلغ الإجمالي'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'تاريخ الإنشاء', 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'تاريخ التحديث', 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => 'الإجراءات', 'orderable' => false, 'searchable' => false],
        ];
    }
}
