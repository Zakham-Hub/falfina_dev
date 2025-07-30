@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('pageTitle')
    {{ $PageTitle }}
@endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')

<div id="kt_content_container" class="container-xxl" style="width: 100%; direction: rtl;">
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $PageTitle }}</span>
            </h3>
        </div>

        <div class="card-body py-3">
            <div class="d-flex mb-4">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <label for="filter" class="form-label">عرض حسب:</label>
                    <select name="filter" id="filter" class="form-select d-inline-block w-auto mx-2" onchange="this.form.submit()">
                        <option value="daily" {{ $currentFilter == 'daily' ? 'selected' : '' }}>يومي</option>
                        <option value="weekly" {{ $currentFilter == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                        <option value="monthly" {{ $currentFilter == 'monthly' ? 'selected' : '' }}>شهري</option>
                        <option value="yearly" {{ $currentFilter == 'yearly' ? 'selected' : '' }}>سنوي</option>
                    </select>
                </form>
            </div>

            @php
                $filterTitle = [
                    'daily' => 'اليومي',
                    'weekly' => 'الأسبوعي',
                    'monthly' => 'الشهري',
                    'yearly' => 'السنوي',
                ][$currentFilter];
            @endphp

            <div class="text-center mb-4">
                <h5 class="fw-bold">عرض الإحصائيات بشكل {{ $filterTitle }}</h5>
            </div>



            <!-- Best Selling Products Chart -->
            <div class="col-md-12 mt-5">
                <canvas id="bestSellingChart" width="1000" height="250"></canvas>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <canvas id="ordersChart" width="1000" height="350"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="priceChart" width="1000" height="350"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ordersData = @json($ordersPerDay);
    const labels = ordersData.map(item => item.date);
    const data = ordersData.map(item => item.total);
    const priceData = ordersData.map(item => item.total_price);

    // Orders Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'عدد الطلبات',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'عدد الطلبات' }
                },
                x: {
                    title: { display: true, text: 'التاريخ' }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: "'Cairo', sans-serif"
                        }
                    }
                }
            }
        }
    });

    // Price Chart
    const ctx2 = document.getElementById('priceChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'إجمالي الأسعار',
                data: priceData,
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'السعر بالعملة' }
                },
                x: {
                    title: { display: true, text: 'التاريخ' }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: "'Cairo', sans-serif"
                        }
                    }
                }
            }
        }
    });

    // Best Selling Products Chart
    const bestSellingData = @json($bestSellingProducts);
    const productLabels = bestSellingData.map(item => item.name);
    const productQuantities = bestSellingData.map(item => item.total_sold);

    const ctx3 = document.getElementById('bestSellingChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'الأكثر مبيعًا',
                data: productQuantities,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'عدد القطع المباعة'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'المنتجات'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: "'Cairo', sans-serif"
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
