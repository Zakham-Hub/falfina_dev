@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ trans('dashboard/admin.edit_admin') }}
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ trans('dashboard/admin.edit_admin') }}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <div class="py-3 card-body">
                @include('dashboard.admin.admins.partials.form', [
                    'action' => route('admin.admins.update', $admin->id),
                    'method' => 'PUT',
                    'admin' => $admin, // Pass the admin data for edit
                ])
            </div>
            <!--end::Form-->
        </div>
    </div>
@endsection
