@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ trans('dashboard/admin.size.edit_size') }}
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ trans('dashboard/admin.size.edit_size') }}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <div class="py-3 card-body">
                @include('dashboard.admin.sizes.partials.form', [
                    'action' => route('admin.sizes.update', $size->id),
                    'method' => 'PUT',
                    'size' => $size, // Pass the size data for edit
                ])
            </div>
            <!--end::Form-->
        </div>
    </div>
@endsection