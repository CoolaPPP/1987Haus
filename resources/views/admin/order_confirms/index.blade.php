@extends('admin.layouts.app')

@section('title', 'Order Confirmations')

@section('content-header', 'หน้าแสดงข้อมูลการยืนยันรับสินค้า')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ข้อมูลการยืนยันรับสินค้า</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการยืนยัน</th>
                    <th>รหัสการสั่ง</th>
                    <th>รหัสการชำระเงิน</th>
                    <th>ชื่อลูกค้า</th>
                    <th>สถานะสินค้าที่ได้รับ</th>
                    <th>วันที่และเวลาที่ได้รับสินค้า</th>
                </tr>
            </thead>
            <tbody>
                @php $statuses = [1 => 'ได้รับสำเร็จ', 2 => 'ได้รับไม่สมบูรณ์', 3 => 'ไม่ได้รับ']; @endphp
                @forelse($confirmations as $confirm)
                <tr>
                    <td>{{ $confirm->id }}</td>
                    <td>#{{ $confirm->payment->order->id }}</td>
                    <td>#{{ $confirm->payment->id }}</td>
                    <td>{{ $confirm->customer->name }}</td>
                    <td>{{ $statuses[$confirm->orderconfirmed_status] ?? 'Unknown' }}</td>
                    <td>{{ $confirm->orderconfirm_datetime }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">ไม่มีข้อมูลการยืนยันรับสินค้า</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection