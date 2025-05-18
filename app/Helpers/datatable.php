<?php

// ////////// datatable lang ar  Helper Function /////
if (! function_exists('datatable_lang')) {
    function datatable_lang()
    {
        return [
            'sProcessing' => trans('dashboard/datatable.sProcessing'),
            'sLengthMenu' => trans('dashboard/datatable.sLengthMenu'),
            'sZeroRecords' => trans('dashboard/datatable.sZeroRecords'),
            'sEmptyTable' => trans('dashboard/datatable.sEmptyTable'),
            'sInfo' => trans('dashboard/datatable.sInfo'),
            'sInfoEmpty' => trans('dashboard/datatable.sInfoEmpty'),
            'sInfoFiltered' => trans('dashboard/datatable.sInfoFiltered'),
            'sInfoPostFix' => trans('dashboard/datatable.sInfoPostFix'),
            'sSearch' => trans('dashboard/datatable.sSearch'),
            'sUrl' => trans('dashboard/datatable.sUrl'),
            'sInfoThousands' => trans('dashboard/datatable.sInfoThousands'),
            'sLoadingRecords' => trans('dashboard/datatable.sLoadingRecords'),
            'oPaginate' => [
                'sFirst' => trans('dashboard/datatable.sFirst'),
                'sLast' => trans('dashboard/datatable.sLast'),
                'sNext' => trans('dashboard/datatable.sNext'),
                'sPrevious' => trans('dashboard/datatable.sPrevious'),
            ],
            'oAria' => [
                'sSortAscending' => trans('dashboard/datatable.sSortAscending'),
                'sSortDescending' => trans('dashboard/datatable.sSortDescending'),
            ],
        ];
    }
}
// ////////// datatable lang ar  Helper Function /////
