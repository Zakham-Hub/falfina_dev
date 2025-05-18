@extends('dashboard.layouts.master')

@section('css')

@endsection

@section('pageTitle')
    ادخل كلمه المرور
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Body-->
            <div class="py-3 card-body">
                <form method="POST" action="{{ route('admin.link_password.verify') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password">أدخل كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="mt-2 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="mt-3 btn btn-primary w-100">تأكيد</button>
                </form>
            </div>
            <!--begin::Body-->
        </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endpush
