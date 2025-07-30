<?php

namespace App\DataTables\Dashboard\General;

use App\DataTables\Base\BaseDataTable;
use App\Models\{Order, Setting};
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
use Illuminate\Support\Facades\Cache;
use App\Enums\Order\OrderStatus;
class   OrderDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Order);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Order $order) {
                return view('dashboard.general.orders.btn.actions', compact('order'));
            })
            ->editColumn('created_at', function (Order $order) {
                return $this->formatBadge($this->formatDate($order->created_at));
            })
            ->editColumn('updated_at', function (Order $order) {
                return $this->formatBadge($this->formatDate($order->updated_at));
            })
            ->editColumn('price', function (Order $order) {
                $settings = Cache::get('settings', new Setting());
                return $order->total_price . ' ' . ($settings?->currency ?? 'ر.س');
            })
            ->editColumn('user_id', function (Order $order) {
                return $order?->user?->name;
            })
            ->addColumn('phone', function(Order $order) {
                return $order?->user?->phone;
            })
            ->editColumn('branch_id', function (Order $order) {
                return $order?->branch?->name;
            })

            ->addColumn('product_count_quantity', function (Order $order) {
                return $order->totalQuantity();
            })
            ->addColumn('order_products_count', function (Order $order) {
                return $order->details->count();
            })
            ->editColumn('status', function (Order $order) {
                $statusEnum = OrderStatus::from($order->status);
                $statusOptions = '';

                foreach (OrderStatus::cases() as $status) {
                    $selected = $status->value === $order->status ? 'selected' : '';
                    $statusOptions .= "<option value='{$status->value}' {$selected}>{$status->label()}</option>";
                }

                return '
                    <select class="order-status-dropdown"
                            data-order-id="' . $order->id . '"
                            style="
                                background-color: var(--bs-' . $statusEnum->badgeColor() . ');
                                color: #fff;
                                border: none;
                                padding: 4px 8px;
                                border-radius: 4px;
                                width: auto;
                                min-width: max-content;
                                font-size: 14px;
                            ">
                        ' . $statusOptions . '
                    </select>
                ';
            })
            ->editColumn('payment_status', function (Order $order) {
                $status = (int) $order->payment_status;
            
                $label = match ($status) {
                    1 => 'تم الدفع',
                    0 => 'الدفع عند الإستلام',
                    default => 'لم يُحدد',
                };
            
                $badgeClass = match ($status) {
                    1 => 'bg-success',
                    0 => 'bg-danger',
                    default => 'bg-secondary',
                };
            
                return '<span class="badge ' . $badgeClass . '">' . $label . '</span>';
            })

            ->editColumn('payment_type', function (Order $order) {
                return  $order?->payment_type?->label();
            })
            ->editColumn('is_delivery', function (Order $order) {
                return $order->delivery_type;
            })
            ->rawColumns(['is_delivery','phone','action', 'created_at', 'updated_at', 'user_id', 'branch_id', 'product_count_quantity', 'order_products_count', 'status', 'payment_type', 'payment_status']);
    }


    public function query(): QueryBuilder
    {
        $query = Order::with(['user', 'branch', 'products', 'details']);
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
            ['name' => 'price', 'data' => 'price', 'title' => 'السعر', 'orderable' => true, 'searchable' => true],
            ['name' => 'product_count_quantity', 'data' => 'product_count_quantity', 'title' => 'الكميه', 'orderable' => true, 'searchable' => true],
            ['name' => 'order_products_count', 'data' => 'order_products_count', 'title' => 'عدد المنتجات', 'orderable' => false, 'searchable' => false],
            ['name' => 'user_id', 'data' => 'user_id', 'title' => 'العميل', 'orderable' => false, 'searchable' => false],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'الهاتف', 'orderable' => false, 'searchable' => false],
            ['name' => 'status', 'data' => 'status', 'title' => 'حاله الطلب', 'orderable' => false, 'searchable' => false],
            ['name' => 'payment_status', 'data' => 'payment_status', 'title' => 'حاله الدفع', 'orderable' => false, 'searchable' => false],
            ['name' => 'payment_type', 'data' => 'payment_type', 'title' => 'طريقة الدفع', 'orderable' => false, 'searchable' => false],
            ['name' => 'is_delivery', 'data' => 'is_delivery', 'title' => 'حاله التوصيل', 'orderable' => false, 'searchable' => false],
            ['name' => 'branch_id', 'data' => 'branch_id', 'title' => 'الفرع', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
