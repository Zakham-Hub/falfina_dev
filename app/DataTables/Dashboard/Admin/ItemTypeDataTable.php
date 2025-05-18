<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ItemTypeDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new ItemType);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (ItemType $itemType) {
                return view('dashboard.admin.item_types.btn.actions', compact('itemType'));
            })
            ->editColumn('created_at', function (ItemType $itemType) {
                return $this->formatBadge($this->formatDate($itemType->created_at));
            })
            ->editColumn('updated_at', function (ItemType $itemType) {
                return $this->formatBadge($this->formatDate($itemType->updated_at));
            })
            ->rawColumns(['action', 'created_at', 'updated_at']);
    }

    public function query(): QueryBuilder
    {
        return ItemType::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.item_type.name')],
            ['name' => 'description', 'data' => 'description', 'title' => trans('dashboard/admin.item_type.description')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
