<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ProductDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Product);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Product $product) {
                return view('dashboard.admin.products.btn.actions', compact('product'));
            })
            ->addColumn('product', function (Product $product) {
                return '<img src="' . $product->getMediaUrl('product') . '" class="img-fluid" alt="' . $product->name . '" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 5px;"/>';
            })
            ->addColumn('categories', function (Product $product) {
                return $product->categories->pluck('name')->implode(', ');
            })
            ->addColumn('types', function (Product $product) {
            if ($product->types->isEmpty()) return '<span class="text-muted">لا يوجد</span>';
                $list = '<ul class="list-unstyled mb-0">';
                foreach ($product->types as $type) {
                    $list .= '<li>* ' . $type->name . '</li>';
                }
                $list .= '</ul>';
                return $list;
            })
            ->addColumn('sizes', function (Product $product) {
                if ($product->sizes->isEmpty()) return '<span class="text-muted">لا يوجد</span>';
                $list = '<ul class="list-unstyled mb-0">';
                foreach ($product->sizes as $size) {
                    $list .= '<li>✔ ' . $size->name . ' - <strong>' . number_format($size->pivot->price, 2) .  ' ر.س' . '</strong></li>';
                }
                $list .= '</ul>';
                return $list;
            })
            ->addColumn('addons', function (Product $product) {
                $addons = $product->extras->where('type', 'addon');
                if ($addons->isEmpty()) return '<span class="text-muted">لا يوجد</span>';
                $list = '<ul class="list-unstyled mb-0">';
                foreach ($addons as $addon) {
                    $list .= '<li>➕ ' . $addon->name . ' - <strong>' . number_format($addon->price ?? 0, 2) . ' ر.س</strong></li>';
                }
                $list .= '</ul>';
                return $list;
            })
            ->addColumn('sauces', function (Product $product) {
                $sauces = $product->extras->where('type', 'sauce');
                if ($sauces->isEmpty()) return '<span class="text-muted">لا يوجد</span>';
                $list = '<ul class="list-unstyled mb-0">';
                foreach ($sauces as $sauce) {
                    $list .= '<li>🌶 ' . $sauce->name . ' - <strong>' . number_format($sauce->price ?? 0, 2) . ' ر.س</strong></li>';
                }
                $list .= '</ul>';
                return $list;
            })
            ->editColumn('created_at', function (Product $product) {
                return $this->formatBadge($this->formatDate($product->created_at));
            })
            ->editColumn('updated_at', function (Product $product) {
                return $this->formatBadge($this->formatDate($product->updated_at));
            })
            ->rawColumns(['categories', 'sizes', 'addons', 'types', 'sauces','action', 'created_at', 'updated_at', 'product']);
    }

    public function query(): QueryBuilder
    {
        return Product::with(['categories', 'sizes', 'types', 'extras'])->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.product.name')],
            ['name' => 'product', 'data' => 'product', 'title' => 'الصوره', 'orderable' => false, 'searchable' => false],
            ['name' => 'categories', 'data' => 'categories', 'title' => 'التصنيف', 'orderable' => false, 'searchable' => false],
            ['name' => 'sizes', 'data' => 'sizes', 'title' => 'الحجم', 'orderable' => false, 'searchable' => false],
            ['name' => 'types', 'data' => 'types', 'title' => 'الانواع', 'orderable' => false, 'searchable' => false],
            ['name' => 'addons', 'data' => 'addons', 'title' => 'الاضافات', 'orderable' => false, 'searchable' => false],
            ['name' => 'sauces', 'data' => 'sauces', 'title' => 'الصوصات', 'orderable' => false, 'searchable' => false],
            ['name' => 'price', 'data' => 'price', 'title' => trans('dashboard/admin.product.price')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
