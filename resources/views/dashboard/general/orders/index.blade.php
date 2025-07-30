@extends('dashboard.layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{$pageTitle}}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" >
                        <a href="{{route('general.orders.create')}}" class="btn btn-sm btn-light btn-active-primary" >
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->اضافه طلب جديد
                        
                        
                        </a>
                    </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <x-orders.admin-order-branch-filter :branches="$branches ?? []" />

                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-row-bordered gy-5 gs-7">
                        {!! $dataTable->table() !!}
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! $dataTable->scripts() !!}
<x-datatables.filter-script tableId="orders-datatable" />
<script>
    const updateStatusUrl = "{{ route('general.orders.updateStatus', ['order' => ':id']) }}";
    $(document).on('change', '.order-status-dropdown', function () {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        const $select = $(this);
        const url = updateStatusUrl.replace(':id', orderId);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $select.css('background-color', `var(--bs-${response.badgeColor})`);
                $select.css('color', '#fff');
                toastr.success(response.message);
            },
            error: function (xhr) {
                toastr.error('حدث خطأ أثناء تحديث الحالة');
            }
        });
    });
</script>
@endpush
