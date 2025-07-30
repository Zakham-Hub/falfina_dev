@extends('dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('pageTitle')
    {{ $PageTitle }}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl" style="width: 100%;">
        <div class="card card-xxl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <span style="color: #aecb53">{{ $PageTitle . ' فــرع ' . get_user_data()?->branch?->name }}</span>
                        <br>
                        <span style="color: #804d28">{{ get_user_data()?->branch?->address }}</span>
                    </span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                {{ ' لوحه تحكم ' . get_user_data()?->name }}
            </div>
            <!--begin::Body-->
        </div>
    @endsection

    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endsection
