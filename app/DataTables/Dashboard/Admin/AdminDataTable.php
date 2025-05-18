<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class AdminDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Admin);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Admin $admin) {
                return view('dashboard.admin.admins.btn.actions', compact('admin'));
            })
            ->editColumn('created_at', function (Admin $admin) {
                return $this->formatBadge($this->formatDate($admin->created_at));
            })
            ->editColumn('updated_at', function (Admin $admin) {
                return $this->formatBadge($this->formatDate($admin->updated_at));
            })
            ->editColumn('name', function (Admin $admin) {
                return $admin->name;
            })
            ->editColumn('status', function (Admin $admin) {
                return $this->formatStatus($admin->status);
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'status', 'name']);
    }

    public function query(): QueryBuilder
    {
        return Admin::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'email', 'data' => 'email', 'title' => trans('dashboard/admin.email')],
            ['name' => 'status', 'data' => 'status', 'title' => trans('dashboard/general.status')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
