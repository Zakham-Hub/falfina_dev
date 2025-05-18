<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\{Package};
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class PackageDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Package);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Package $package) {
                return view('dashboard.admin.packages.btn.actions', compact('package'));
            })
            ->editColumn('created_at', function (Package $package) {
                return $this->formatBadge($this->formatDate($package->created_at));
            })
            ->editColumn('updated_at', function (Package $package) {
                return $this->formatBadge($this->formatDate($package->updated_at));
            })
            ->rawColumns(['action', 'created_at', 'updated_at']);
    }

    public function query(): QueryBuilder
    {
        return Package::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'price', 'data' => 'price', 'title' => 'السعر'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
