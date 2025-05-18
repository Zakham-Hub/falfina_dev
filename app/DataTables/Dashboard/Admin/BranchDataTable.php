<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class BranchDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Branch);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Branch $branch) {
                return view('dashboard.admin.branches.btn.actions', compact('branch'));
            })
            ->editColumn('created_at', function (Branch $branch) {
                return $this->formatBadge($this->formatDate($branch->created_at));
            })
            ->editColumn('updated_at', function (Branch $branch) {
                return $this->formatBadge($this->formatDate($branch->updated_at));
            })
            ->editColumn('status', function (Branch $branch) {
                return $this->formatStatus($branch->status);
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'status']);
    }

    public function query(): QueryBuilder
    {
        return Branch::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'address', 'data' => 'address', 'title' => 'العنوان', 'searchable' => false],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'الهاتف', 'searchable' => false],
            ['name' => 'status', 'data' => 'status', 'title' => trans('dashboard/general.status')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
