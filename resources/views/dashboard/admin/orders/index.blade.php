@extends('dashboard.layouts.master')

@section('pageTitle') {{ $pageTitle }} @endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')

<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <div class="pt-5 border-0 card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
            </h3>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-success">+ إضافة طلب جديد</a>
        </div>

        <div class="card-body">
            <form id="filter-form" class="row mb-4">
                <div class="col-md-3">
                    <label>من 2 تاريخ</label>
                    <input type="date" name="from" id="from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>إلى تاريخ</label>
                    <input type="date" name="to" id="to" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>الفرع</label>
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">كل الفروع</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <button type="button" id="filter" class="btn btn-primary mt-2">فلترة</button>
                    <button type="button" id="reset" class="btn btn-light mt-2">إعادة تعيين</button>
                </div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['id' => 'orders-datatable', 'class' => 'table table-striped'], true) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function () {
            let table = window.LaravelDataTables["orders-datatable"];

            table.on('preXhr.dt', function (e, settings, data) {
                data.from = $('#from').val();
                data.to = $('#to').val();
                data.branch_id = $('#branch_id').val();
            });

            $('#filter').click(function () {
                table.draw();
            });

            $('#reset').click(function () {
                $('#from').val('');
                $('#to').val('');
                $('#branch_id').val('');
                table.draw();
            });

            $.fn.dataTable.ext.errMode = 'none';
        });
    </script>
@endpush
