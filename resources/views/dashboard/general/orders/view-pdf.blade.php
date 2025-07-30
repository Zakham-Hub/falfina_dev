{{-- @extends('dashboard.layouts.master')
@section('css')
<style>
  body {
    font-family: "DejaVu Sans", sans-serif;
    font-size: 12px;
  }

  h1 {
    font-weight: bold;
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  table td, table th {
    border: 1px solid #000;
    padding: 5px;
  }

        @font-face {
            font-family: 'Cairo';
            src: url('{{ storage_path("/fonts/cairo/Cairo/static/Cairo-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
        }
    </style>
@endsection
@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
                    <span class="mt-1 text-muted fw-bold fs-7">عرض تفاصيل الطلب</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <div class="order-info">
                    <p><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                    <p><strong>الحالة:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>طريقة الدفع:</strong> {{ ucfirst($order->payment_type) }}</p>
                    <p><strong>حالة الدفع:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>موقع الطلب:</strong> {{ $order->order_location }}</p>
                    <p><strong>التوصيل:</strong> {{ $order->is_delivery ? 'نعم' : 'لا' }}</p>
                    <p><strong>سعرالتوصيل</strong> {{ $number_format($order->delivery_free ?? )}} SAR </p>
                    <p><strong>السعر الإجمالي:</strong> {{ number_format($order->total_price, 2) }} SAR</p>
                </div>

                <div class="user-info">
                    <h3>معلومات العميل:</h3>
                    <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
                    <p><strong>رقم الهاتف:</strong> {{ $order->user->phone ?? 'غير متوفر' }}</p>
                </div>

                <div class="products">
                    <h3>المنتجات في الطلب:</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الحجم</th>
                                <th>النوع</th>
                                <th>الإضافات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>{{ number_format($product->pivot->price, 2) }} SAR</td>
                                    <td>{{ optional($product->pivot->detail?->size)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($product->pivot->detail?->type)->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($product->pivot->extras)
                                            @foreach ($product->pivot->extras as $extra)
                                                <p>{{ $extra->extra->name }} - {{ $extra->quantity }} x
                                                    {{ number_format($extra->price, 2) }} SAR</p>
                                            @endforeach
                                        @else
                                            لا توجد إضافات
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
@endsection --}}
@extends('dashboard.layouts.master')
@section('css')
   <style>
  body {
    font-family: "DejaVu Sans", sans-serif;
    font-size: 12px;
  }

  h1 {
    font-weight: bold;
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  table td, table th {
    border: 1px solid #000;
    padding: 5px;
  }

        @font-face {
            font-family: 'Cairo';
            direction: rtl !important;
            text-align: right;
            src: url('public/fonts/cairo/Amiri/Amiri-Regular.ttf');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl !important;
            text-align: right;
        }
    </style>
@endsection
@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">اظهار الطلب</span>
                    <span class="mt-1 text-muted fw-bold fs-7">عرض تفاصيل الطلب</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <div class="order-info">
                    <p><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                    <p><strong>الحالة:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>طريقة الدفع:</strong> {{ ucfirst($order->payment_type) }}</p>
                    <p><strong>حالة الدفع:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>موقع الطلب:</strong> {{ $order->order_location }}</p>
                    <p><strong>التوصيل:</strong> {{ $order->is_delivery ? 'نعم' : 'لا' }}</p>
                    <p><strong>سعرالتوصيل</strong> {{ $number_format($setting->delivery_fee ?? )}} SAR </p>
                    <p><strong>السعر الإجمالي:</strong> {{ number_format($order->total_price, 2) }} SAR</p>
                </div>

                <div class="user-info">
                    <h3>معلومات العميل:</h3>
                    <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
                    <p><strong>رقم الهاتف:</strong> {{ $order->user->phone ?? 'غير متوفر' }}</p>
                </div>

                <div class="products">
                    <h3>المنتجات في الطلب:</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الحجم</th>
                                <th>النوع</th>
                                <th>الإضافات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>{{ number_format($product->pivot->price, 2) }} SAR</td>
                                    <td>{{ optional($product->pivot->detail?->size)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($product->pivot->detail?->type)->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($product->pivot->extras)
                                            @foreach ($product->pivot->extras as $extra)
                                                <p>{{ $extra->extra->name }} - {{ $extra->quantity }} x
                                                    {{ number_format($extra->price, 2) }} SAR</p>
                                            @endforeach
                                        @else
                                            لا توجد إضافات
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
@endsection