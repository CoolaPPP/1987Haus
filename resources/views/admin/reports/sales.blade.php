@extends('admin.layouts.app')

@section('title', 'Sales Report')

@section('content-header', 'หน้าแสดงรายงานการขายสินค้า')

@section('content')
<style>
    .cart-table thead {
        background-color: #504b38;
        color: #f8f3d9;
    }
    .btn-theme {
        background-color: #504b38;
        color: #f8f3d9;
        border: none;
    }
    .btn-theme:hover {
        background-color: #b9b28a;
        color: #504b38;
    }
    .btn-outline-theme {
        border: 1px solid #504b38;
        color: #504b38;
        background-color: transparent;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
{{-- Filter Forms --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">เลือกช่วงเวลาที่ต้องการแสดง</h3>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Daily Filter --}}
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.sales') }}">
                    <div class="form-group">
                        <label>รายวัน</label>
                        <input type="date" name="daily_date" class="form-control" value="{{ request('daily_date', date('Y-m-d')) }}">
                    </div>
                    <button type="submit" class="btn btn-theme">แสดงรายงานประจำวัน</button>
                </form>
            </div>
            {{-- Monthly Filter --}}
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.sales') }}">
                    <div class="form-group">
                        <label>รายเดือน</label>
                        <div class="d-flex">
                            @php
                                // สร้าง Array เดือนภาษาไทยไว้ใช้งานใน View
                                $thaiMonths = [
                                    1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
                                    5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
                                    9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                                ];
                            @endphp

                            <select name="monthly_month" class="form-control mr-2">
                                @foreach($thaiMonths as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}" {{ request('monthly_month', date('m')) == $monthNumber ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="monthly_year" class="form-control" value="{{ request('monthly_year', date('Y')) }}" placeholder="Year">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-theme">แสดงรายงานประจำเดือน</button>
                </form>
            </div>
            {{-- Yearly Filter --}}
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.sales') }}">
                    <div class="form-group">
                        <label>รายปี</label>
                        <input type="number" name="yearly_year" class="form-control" value="{{ request('yearly_year', date('Y')) }}" placeholder="Year">
                    </div>
                    <button type="submit" class="btn btn-theme">แสดงรายงานประจำปี</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

</div>

{{-- Report Results --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $reportType }}</h3>
    </div>
    <div class="card-body">
        {{-- Summary Cards --}}
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>฿{{ number_format($totalRevenue, 2) }}</h3>
                        <p>รายรับรวมสุทธิ</p>
                    </div>
                    <div class="icon"><i class="ion ion-cash"></i></div>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>การสั่งซื้อทั้งหมด</p>
                    </div>
                    <div class="icon"><i class="ion ion-bag"></i></div>
                </div>
            </div>
        </div>

        {{-- Sales Details Table --}}
        <h4>รายละเอียดการขายสินค้า</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th class="text-center">จำนวนที่ขายได้</th>
                    <th class="text-right">รายรับรวม</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salesDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->product_name ?? 'Product not found' }}</td>
                        <td class="text-center">{{ $detail->total_quantity }}</td>
                        <td class="text-right">฿{{ number_format($detail->total_revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">ไม่พบข้อมูลการขายในช่วงเวลานี้</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ใช้ document.addEventListener เพื่อให้แน่ใจว่า DOM โหลดเสร็จแล้ว
    document.addEventListener('DOMContentLoaded', function () {
        // 1. ดึงข้อมูลจาก PHP มาเป็น JavaScript
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);

        // 2. หากราฟ
        const ctx = document.getElementById('salesChart').getContext('2d');

        // 3. สร้างกราฟเส้น
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'ยอดขายทั้งหมด (฿)',
                    data: chartData,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // จัดรูปแบบแกน Y ให้เป็นสกุลเงินบาท
                            callback: function(value, index, values) {
                                return '฿' + new Intl.NumberFormat().format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += '฿' + new Intl.NumberFormat().format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
