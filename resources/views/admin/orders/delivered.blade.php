@extends('admin.layouts.app')

@section('title', 'Delivered Orders')

@section('content-header', 'หน้าแสดงการสั่งที่จัดส่งสำเร็จ')

@section('content')
<style>
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
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">การสั่งที่จัดส่งสำเร็จ</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการสั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>วันที่และเวลาของการรับสินค้า</th>
                    <th>ราคาสุทธิ</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveredOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->updated_at->format('d M Y, H:i') }}</td>
                    <td>฿{{ number_format($order->net_price, 2) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-theme">แสดงรายละเอียด</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">ไม่มีข้อมูลสินค้าที่จัดส่งสำเร็จ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="px-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-theme">
        กลับไปยังหน้าจัดการการขาย
    </a>
</div>
@endsection