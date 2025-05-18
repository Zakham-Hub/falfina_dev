<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class UserDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new User);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (User $user) {
                return view('dashboard.admin.users.btn.actions', compact('user'));
            })
            ->editColumn('created_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->created_at));
            })
            ->editColumn('updated_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->updated_at));
            })
            ->editColumn('name', function (User $user) {
                return $user->name;
            })
            ->editColumn('status', function (User $user) {
                return $this->formatStatus($user->status);
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'status', 'name']);
    }

    public function query(): QueryBuilder
    {
        return User::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => 'الاسم'],
            ['name' => 'email', 'data' => 'email', 'title' => 'الايميل'],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'رقم الهاتف'],
            ['name' => 'status', 'data' => 'status', 'title' => trans('dashboard/general.status')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
