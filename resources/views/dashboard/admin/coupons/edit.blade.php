@extends('dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
                    <span class="mt-1 text-muted fw-bold fs-7">{{ $pageTitle }} ( )</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
           <div class="py-3 card-body">
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3"> <!-- g-3 لإضافة تباعد بين العناصر -->

            <div class="col-md-4">
                <label for="name" class="form-label">الاسم:</label>
                <input type="text" id="name" name="name" class="form-control" required
                    value="{{ $coupon->name ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="type" class="form-label">النوع:</label>
                <input type="text" id="type" name="type" class="form-control" required
                    value="{{ $coupon->type ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="percentage" class="form-label">النسبة:</label>
                <input type="text" id="percentage" name="percentage" class="form-control" required
                    value="{{ $coupon->percentage ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="from" class="form-label">من:</label>
                <input type="date" id="from" name="from" class="form-control" required
                    value="{{ $coupon->from ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="to" class="form-label">إلى:</label>
                <input type="date" id="to" name="to" class="form-control" required
                    value="{{ $coupon->to ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="amount" class="form-label">الكمية:</label>
                <input type="text" id="amount" name="amount" class="form-control" required
                    value="{{ $coupon->amount ?? '' }}">
            </div>

            <div class="col-md-4">
                <label for="status" class="form-label">الحالة:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="">اختر الحالة</option>
                    @foreach (\App\Models\Coupon::STATUS as $item)
                        <option value="{{ $item }}" {{ $coupon->status == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100 mt-3">💾 حفظ</button>
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
