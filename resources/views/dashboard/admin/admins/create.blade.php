@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ trans('dashboard/admin.create_admin') }}
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ trans('dashboard/admin.create_admin') }}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <div class="py-3 card-body">
                @include('dashboard.admin.admins.partials.form', [
                    'action' => route('admin.admins.store'),
                    'method' => 'POST',
                    'admin' => null, // No admin data for create
                ])
            </div>
            <!--end::Form-->
        </div>
    </div>
@endsection
@push('js')
<script>
    // Show Password Protection Field on click the link protection status switch
    $('.link_protection').on('change', function(){
        $(this).is(':checked') ? $('#password_protection_field').fadeIn() : $('.link_password_protection').slideUp();
    });
</script>
@endpush
