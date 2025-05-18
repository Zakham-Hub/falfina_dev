@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
                    <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}} ( )</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <form action="{{ route('admin.types.update', $extra->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="gap-2 col-md-8 d-flex align-items-end">
                            <div style="flex: 0 0 60%;">
                                <label for="name" class="form-label">الاسم:</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{$extra->name}}" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100" style="flex: 1;">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--begin::Body-->
        </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endpush
