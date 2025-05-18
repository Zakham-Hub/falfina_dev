<?php

namespace App\DataTables\Base;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDataTable extends DataTable
{
    public function __construct(protected Model $model)
    {
        $model = $this->model;
    }

    abstract protected function dataTable(QueryBuilder $query): EloquentDataTable;

    abstract protected function query();

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->model->getTable().'_datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->getParameters());
    }

    abstract protected function getColumns(): array;

    protected function getParameters()
    {
        return [
            'dom' => 'Blfrtip',
            'lengthMenu' => [
                [10, 25, 50, 100, 500, 750, -1],
                ['10', '25 ', '50 ', '100 ', '500 ', '750', trans('dashboard/datatable.all_records')],
            ],
            'buttons' => [
                [
                    'extend' => 'csv',
                    'className' => 'btn btn-primary',
                    'text' => "<i class='fa fa-file'></i>".trans('dashboard/datatable.ex_csv'),
                ],
                [
                    'extend' => 'excel',
                    'className' => 'btn btn-success',
                    'text' => "<i class='fa fa-file'></i>".trans('dashboard/datatable.ex_excel'),
                ],
                [
                    'extend' => 'print',
                    'className' => 'btn btn-info',
                    'text' => "<i class='fa fa-print'></i>".trans('dashboard/datatable.print'),
                ],
                [
                    'extend' => 'reload',
                    'className' => 'btn btn-dark',
                    'text' => "<i class='fa fa-sync-alt'></i>".trans('dashboard/datatable.reload'),
                ],
            ],
            'language' => datatable_lang(),
        ];
    }

    protected function filename(): string
    {
        return $this->model->getTable().'_'.date('YmdHis');
    }

    // Helper Function to set badge
    protected function formatBadge($value): string
    {
        $badge = $value == null ? 'danger' : 'success';
        if ($value == null) {
            return '<span class="badge badge-'.$badge.'">'.trans('dashboard/datatable.no_date_found').'</span>';
        }

        return '<span class="badge badge-'.$badge.'">'.$value.'</span>';
    }

    protected function formatStatus($status): string
    {
        $badge = $status == 'active' ? 'success' : 'primary';

        return '<span class="badge badge-'.$badge.'">'.$status.'</span>';
    }

    protected function formatDate($value): string
    {
        return $value ? $value->diffForHumans() : '';
    }
}
