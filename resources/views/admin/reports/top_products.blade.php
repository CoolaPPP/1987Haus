@extends('admin.layouts.app')

@section('title', 'Top 5 Selling Products Report')

@section('content-header', 'หน้าแสดงรายงานสินค้าขายดี 5 อันดับประจำเดือน')

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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">เลือกเดือนที่ต้องการแสดง</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.top-products') }}" class="form-inline">
            <div class="form-group mb-2 mr-sm-2">
                <label for="month" class="mr-2">เดือน</label>
                @php
                    // สร้าง Array เดือนภาษาไทยไว้ใช้งานใน View
                    $thaiMonths = [
                        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
                        5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
                        9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                    ];
                @endphp

                <select name="month" class="form-control mr-2">
                    @foreach($thaiMonths as $monthNumber => $monthName)
                        <option value="{{ $monthNumber }}" {{ $selectedMonth == $monthNumber ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group mb-2 mr-sm-2">
                <label for="year" class="mr-2">ปี</label>
                <input type="number" name="year" id="year" class="form-control" value="{{ $reportYear }}" placeholder="Year">
            </div>
            <button type="submit" class="btn btn-theme mb-2">แสดงรายงาน</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            สินค้าขายดี 5 อันดับประจำเดือน {{ $reportMonth }} {{ $reportYear }}
        </h3>
    </div>
    <div class="card-body">
        @if($topProducts->isEmpty())
            <div class="alert alert-info">
                ไม่พบข้อมูลการขายในช่วงเวลานี้
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px">อันดับ</th>
                            <th>ชื่อสินค้า</th>
                            <th class="text-center">จำนวนสินค้าที่ขายได้ทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td class="text-center">{{ $product->total_quantity_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection