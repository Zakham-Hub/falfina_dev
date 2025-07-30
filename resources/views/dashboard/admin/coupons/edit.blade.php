@extends('dashboard.layouts.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
                </h3>
            </div>

            <div class="py-3 card-body">
                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="name" class="form-label">Coupon Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="{{ $coupon->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="percentage" class="form-label">Value</label>
                            <input type="number" step="0.01" id="percentage" name="percentage"
                                   class="form-control" value="{{ $coupon->percentage }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="from" class="form-label">Start Date</label>
                            <input type="date" id="from" name="from" class="form-control"
                                   value="{{ $coupon->from->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="to" class="form-label">End Date</label>
                            <input type="date" id="to" name="to" class="form-control"
                                   value="{{ $coupon->to->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">Usage Limit</label>
                            <input type="number" id="amount" name="amount" class="form-control"
                                   value="{{ $coupon->amount }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="not active" {{ $coupon->status == 'not active' ? 'selected' : '' }}>Not Active</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="products" class="form-label">Applicable Products (Leave empty for all products)</label>
                            <select id="products" name="products[]" class="form-control select2" multiple>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $coupon->products->contains($product->id) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Coupon</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select products",
                allowClear: true
            });
        });
    </script>
@endsection
