@extends('dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .order-details-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .section-title {
            color: #3F4254;
            font-weight: 600;
            border-bottom: 1px solid #EBEDF3;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .info-card {
            background: #F8F9FA;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 0.75rem;
        }
        
        .info-label {
            font-weight: 600;
            color: #7E8299;
            min-width: 150px;
            font-size: 15px !important;
        }
        
        .info-value {
            color: #3F4254;
            font-size: 15px !important;
            flex-grow: 1;
        }
        
        .badge-lg {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .action-btns {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        
        .map-container {
            height: 300px;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 1rem;
        }
        
        .text-decoration-line-through {
            text-decoration: line-through;
        }
        
        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                margin-bottom: 0.25rem;
            }
        }
    </style>
@endsection

@section('pageTitle')
    عرض تفاصيل الطلب
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="order-details-container card">
            <!-- Header -->
            <div class="card-header border-0 py-5">
                <div class="card-title">
                    <h2 class="fw-bolder mb-0">{{ $pageTitle }}</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('general.orders.index') }}" class="btn btn-sm btn-light-primary">
                        <i class="fas fa-arrow-left me-2"></i> الرجوع إلى الطلبات
                    </a>
                </div>
            </div>
            
            <!-- Body -->
            <div class="card-body pt-0">
                <!-- Order Summary -->
                <div class="info-card">
                    <h4 class="section-title">معلومات الطلب</h4>
                    
                    <div class="info-row">
                        <span class="info-label">رقم الطلب:</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">حالة الطلب:</span>
                        <span class="info-value">
                            @php
                                $statusEnum = App\Enums\Order\OrderStatus::tryFrom($order->status);
                            @endphp
                            @if($statusEnum)
                                <span class="badge badge-lg bg-{{ $statusEnum->badgeColor() }}">
                                    {{ $statusEnum->label() }}
                                </span>
                            @else
                                <span class="badge badge-lg bg-secondary">غير معروفة</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">طريقة الدفع:</span>
                        <span class="info-value">
                            <span class="badge badge-lg bg-{{ $order?->payment_type?->badgeColor() }}">
                                {{ $order?->payment_type?->label() }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">حالة الدفع:</span>
                        <span class="info-value">
                            @php
                                $status = (int) $order->payment_status;
                                $label = match ($status) {
                                    1 => 'تم الدفع',
                                    0 => 'الدفع عند الإستلام',
                                    default => 'لم يُحدد',
                                };
                                $class = match ($status) {
                                    1 => 'bg-success',
                                    0 => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge badge-lg {{ $class }}">{{ $label }}</span>
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">نوع الطلب:</span>
                        <span class="info-value">{{ $order->deliveryType() }}</span>
                    </div>
                    
                    @if($order->coupon)
                    <div class="info-row">
                        <span class="info-label">كود الخصم:</span>
                        <span class="info-value">
                            {{ $order->coupon->name }}
                            @if($order->coupon->type === 'percentage')
                                ({{ $order->coupon->percentage }}%)
                            @else
                                ({{ number_format($order->coupon->amount, 2) }} {{ $settings?->currency }})
                            @endif
                        </span>
                    </div>
                    @endif
                    
                    @php
                        $subtotal = $order->products->sum(function($product) {
                            return ($product->pivot->detail?->size_price ?? $product->price) * $product->pivot->quantity;
                        });
                        
                     $extrasTotal = $order->products->sum(function($product) {
    return $product->pivot->extras->sum(function($extra) {
        return $extra->price * $extra->quantity;
    });
});
                    @endphp
                    
                    <!-- إجمالي المنتجات -->
                    <div class="info-row">
                        <span class="info-label">إجمالي المنتجات:</span>
                        <span class="info-value">{{ number_format($subtotal, 2) }} {{ $settings?->currency }}</span>
                    </div>
                    
                    <!-- الخصم (إذا وجد) -->
                    @if($order->coupon_discount > 0)
                    <div class="info-row">
                        <span class="info-label">قيمة الخصم:</span>
                        <span class="info-value text-danger">- {{ number_format($order->coupon_discount, 2) }} {{ $settings?->currency }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">نسبة الخصم:</span>
                        <span class="info-value">
                            @php
                                $discountPercentage = ($order->coupon_discount / $subtotal) * 100;
                            @endphp
                            {{ number_format($discountPercentage, 2) }}%
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">إجمالي بعد الخصم:</span>
                        <span class="info-value">{{ number_format($subtotal - $order->coupon_discount, 2) }} {{ $settings?->currency }}</span>
                    </div>
                    @endif
                    
                    <!-- رسوم التوصيل -->
                    @if($order->delivery_fee > 0)
                    <div class="info-row">
                        <span class="info-label">رسوم التوصيل:</span>
                        <span class="info-value">{{ number_format($order->delivery_fee, 2) }} {{ $settings?->currency }}</span>
                    </div>
                    @endif
                    
                    <!-- السعر الإجمالي النهائي -->
                    <div class="info-row">
                        <span class="info-label">السعر الإجمالي:</span>
                        <span class="info-value fw-bold">
                            {{ number_format(($subtotal - ($order->coupon_discount ?? 0)) + ($order->delivery_fee ?? 0)+$extrasTotal, 2) }} 
                            {{ $settings?->currency }}
                        </span>
                    </div>
                </div>
                
                <!-- Customer Info -->
                <div class="info-card">
                    <h4 class="section-title">معلومات العميل</h4>
                    
                    <div class="info-row">
                        <span class="info-label">الاسم:</span>
                        <span class="info-value">{{ $order->user->name }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">البريد الإلكتروني:</span>
                        <span class="info-value">{{ $order->user->email }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">رقم الهاتف:</span>
                        <span class="info-value">{{ $order->user->phone ?? 'غير متوفر' }}</span>
                    </div>
                </div>
                
                <!-- Location Info -->
                @if($order->order_location)
                <div class="info-card">
                    <h4 class="section-title">موقع التوصيل</h4>
                    
                    <div class="info-row">
                        <span class="info-label">العنوان:</span>
                        <span class="info-value">
                            <div class="d-flex gap-2">
                                <a href="{{ $order->order_location }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i> عرض على الخريطة
                                </a>
                                <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('{{ $order->order_location }}')">
                                    <i class="fas fa-copy me-2"></i> نسخ الرابط
                                </button>
                            </div>
                        </span>
                    </div>
                    
                    <div class="map-container" id="orderLocationMap"></div>
                </div>
                @endif
                
                <!-- Products -->
                <div class="info-card">
                    <h4 class="section-title">المنتجات</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th class="text-center">الكمية</th>
                                    <th class="text-end">السعر</th>
                                    <th class="text-end">السعر بعد الخصم</th>
                                    <th class="text-center">الحجم</th>
                                    <th class="text-center">النوع</th>
                                    <th class="text-center">الإضافات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                @php
                                    // سعر المنتج (الحجم إذا وجد أو السعر الأساسي)
                                    $productPrice = $product->pivot->detail?->size_price ?? $product->price;
                                    $basePrice = $productPrice * $product->pivot->quantity;
                                    
                                    // حساب حصة المنتج من الخصم (نسبيًا)
                                    $productDiscount = $subtotal > 0 ? ($basePrice / $subtotal) * ($order->coupon_discount ?? 0) : 0;
                                    $finalPrice = $basePrice - $productDiscount;
                                @endphp
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->pivot->quantity }}</td>
                                    <td class="text-end">
                                        {{ number_format($basePrice, 2) }} {{ $settings?->currency }}
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($finalPrice, 2) }} {{ $settings?->currency }}
                                        @if($productDiscount > 0)
                                            <small class="text-success d-block">(خصم {{ number_format($productDiscount, 2) }})</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ optional($product->pivot->detail?->size)->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ optional($product->pivot->detail?->type)->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($product->pivot->extras && count($product->pivot->extras) > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($product->pivot->extras as $extra)
                                                    <li>
                                                        <small>{{ $extra->extra->name }} ({{ $extra->quantity }} × {{ number_format($extra->price, 2) }} {{ $settings?->currency }})</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">لا توجد إضافات</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="action-btns">
                    <a href="{{ route('general.orders.index') }}" class="btn btn-light-primary">
                        <i class="fas fa-arrow-left me-2"></i> الرجوع
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function copyToClipboard(text) {
            try {
                navigator.clipboard.writeText(text).then(function() {
                    toastr.success("تم نسخ الرابط بنجاح", "نجاح", {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 3000
                    });
                }, function() {
                    fallbackCopy(text);
                });
            } catch (e) {
                fallbackCopy(text);
            }
            
            function fallbackCopy(text) {
                const tempInput = document.createElement("input");
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                
                toastr.success("تم نسخ الرابط بنجاح", "نجاح", {
                    progressBar: true,
                    closeButton: true,
                    timeOut: 3000
                });
            }
        }
        
        // Initialize map if location exists
        @if($order->order_location)
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Extract coordinates from the location URL
                const url = new URL('{{ $order->order_location }}');
                const params = new URLSearchParams(url.search);
                const q = params.get('q');
                
                if (q) {
                    const coords = q.split(',');
                    if (coords.length === 2) {
                        const lat = parseFloat(coords[0]);
                        const lng = parseFloat(coords[1]);
                        
                        if (!isNaN(lat) && !isNaN(lng)) {
                            const map = L.map('orderLocationMap').setView([lat, lng], 15);
                            
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            
                            L.marker([lat, lng]).addTo(map)
                                .bindPopup('موقع التوصيل')
                                .openPopup();
                        }
                    }
                }
            } catch (e) {
                console.error("Error initializing map:", e);
                document.getElementById('orderLocationMap').innerHTML = 
                    '<div class="alert alert-warning m-0">تعذر تحميل الخريطة. يمكنك <a href="{{ $order->order_location }}" target="_blank">مشاهدتها هنا</a></div>';
            }
        });
        @endif
    </script>
@endpush