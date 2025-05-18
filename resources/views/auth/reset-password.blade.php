@extends('dashboard.layouts.login')

@section('css')
@endsection

@section('pageTitle')
    {{ trans('dashboard/auth.reset_password_title') }}
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
            <form class="form w-100" novalidate="novalidate" method="POST" id="kt_reset_password_form" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">{{ trans('dashboard/auth.password') }}</h1>
                    <!--end::Title-->
                    <!--begin::Subtitle-->
                    <div class="text-gray-400 fw-bold fs-4">
                        {{ trans('dashboard/auth.password') }}
                    </div>
                    <!--end::Subtitle-->
                </div>
                <!--begin::Heading-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark">{{ trans('dashboard/auth.email_address') }}</label>
                    <input class="form-control form-control-lg form-control-solid"
                           type="email"
                           name="email"
                           value="{{request()->email}}"
                           required
                           autocomplete="email"
                           readonly
                           style="background-color: #f5f5f5; cursor: not-allowed;" />
                    @error('email')
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block text-danger">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">{{ trans('dashboard/auth.password') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid"
                           type="password"
                           name="password"
                           required
                           autocomplete="new-password" />
                    <!--end::Input-->
                    @error('password')
                        <div class="fv-plugins-message-container">
                            <div data-field="password" data-validator="notEmpty" class="fv-help-block text-danger">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">{{ trans('dashboard/auth.password_confirmation') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid"
                           type="password"
                           name="password_confirmation"
                           required
                           autocomplete="new-password" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button type="submit" id="kt_reset_password_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">{{ trans('dashboard/auth.reset_password') }}</span>
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
        // Form validation
        $("#kt_reset_password_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "[name=password]"
                }
            },
            messages: {
                password_confirmation: {
                    equalTo: "{{ trans('dashboard/auth.passwords_must_match') }}"
                }
            }
        });

        // Handle form submission
        $('#kt_reset_password_submit').click(function() {
            if ($("#kt_reset_password_form").valid()) {
                $(this).attr('data-kt-indicator', 'on');
                $(this).prop('disabled', true);
                $("#kt_reset_password_form").submit();
            }
        });

        @if(session('toastr'))
            var toastrOptions = {!! json_encode(session('toastr')) !!};
            toastr[toastrOptions.type](toastrOptions.message);
        @endif
    });
</script>
@endsection
