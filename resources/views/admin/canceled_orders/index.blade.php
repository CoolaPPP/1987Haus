@extends('admin.layouts.app')

@section('title', 'Canceled Orders')

@section('content-header', 'หน้าแสดงรายการการสั่งที่ถูกยกเลิก')

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
        <h3 class="card-title">รายการการสั่งที่ถูกยกเลิก</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการสั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>วันที่และเวลาที่ยกเลิก</th>
                    <th>ยอดยกเลิก</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @forelse($canceledOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->updated_at->format('d M Y, H:i') }}</td>
                    <td>฿{{ number_format($order->order_price, 2) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-theme">แสดงรายละเอียดการสั่งเดิม</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">ไม่มีข้อมูลการสั่งที่ถูกยกเลิก</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $canceledOrders->links() }}</div>
</div>
@endsection