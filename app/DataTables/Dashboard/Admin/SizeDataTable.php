<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Size;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SizeDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Size);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Size $size) {
                return view('dashboard.admin.sizes.btn.actions', compact('size'));
            })
            ->editColumn('created_at', function (Size $size) {
                return $this->formatBadge($this->formatDate($size->created_at));
            })
            ->editColumn('updated_at', function (Size $size) {
                return $this->formatBadge($this->formatDate($size->updated_at));
            })
            ->rawColumns(['action', 'created_at', 'updated_at']);
    }

    public function query(): QueryBuilder
    {
        return Size::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.size.name')],
            ['name' => 'gram', 'data' => 'gram', 'title' => trans('dashboard/admin.size.gram')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
