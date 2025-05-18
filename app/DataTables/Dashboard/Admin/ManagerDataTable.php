<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\{Manager};
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ManagerDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Manager);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Manager $manager) {
                return view('dashboard.admin.managers.btn.actions', compact('manager'));
            })
            ->editColumn('created_at', function (Manager $manager) {
                return $this->formatBadge($this->formatDate($manager->created_at));
            })
            ->editColumn('updated_at', function (Manager $manager) {
                return $this->formatBadge($this->formatDate($manager->updated_at));
            })
            ->addColumn('branch', function (Manager $manager) {
                return $manager->branch?->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'branch']);
    }

    public function query(): QueryBuilder
    {
        return Manager::with('branch')->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'email', 'data' => 'email', 'title' => trans('dashboard/admin.email')],
            ['name' => 'phone', 'data' => 'phone', 'title' => trans('dashboard/admin.phone')],
            ['name' => 'branch', 'data' => 'branch', 'title' => 'الفرع التابع', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
