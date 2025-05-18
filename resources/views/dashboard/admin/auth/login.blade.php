@extends('dashboard.layouts.login')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('dashboard/auth.admin_auth_form_title') }}
@endsection

@section('content')
    <!--begin::Content-->
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="#" class="mb-12">
            <img alt="{{$settings?->name}}" src="{{ $logo ?? asset('dashboard/assets/media/logos/logo-demo13-compact.svg') }}" class="h-75px" />
        </a>
        <!--end::Logo-->

        <!--begin::Wrapper-->
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            @include('dashboard.layouts.common._partial.messages')
            <form class="form w-100" novalidate="novalidate" method="POST" id="kt_sign_in_form" action="{{route('admin.post.login')}}">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">{{ trans('dashboard/auth.admin_auth_form_title') }}</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">{{ trans('dashboard/auth.email_address') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" />
                    <!--end::Input-->
                    @error('email')
                        <div class="fv-plugins-message-container">
                            <div data-field="email" data-validator="notEmpty" class="fv-help-block text-danger">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-2">
                        <!--begin::Label-->
                        <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ trans('dashboard/auth.password') }}</label>
                        <!--end::Label-->
                        <!--begin::Link-->
                        <a href="{{ route('admin.forgot.password') }}" class="link-primary fs-6 fw-bolder">{{ trans('dashboard/auth.forgot_password') }}</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                    <!--end::Input-->
                    @error('password')
                    <div class="fv-plugins-message-container">
                        <div data-field="password" data-validator="notEmpty" class="fv-help-block text-danger">{{ $message }}</div>
                    </div>
                    @enderror
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">{{ trans('dashboard/auth.login') }}</span>
                        <span class="indicator-progress">
                            {{ trans('dashboard/auth.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Submit button-->
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Content-->
@endsection

@section('js')
<script>
    $(document).ready(function() {
        @if(session('toastr'))
            var toastrOptions = session('toastr');
            toastr[toastrOptions.type](toastrOptions.message);
        @endif
    });
</script>
@endsection
