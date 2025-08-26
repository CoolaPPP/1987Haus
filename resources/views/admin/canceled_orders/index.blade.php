@extends('admin.layouts.app')

@section('title', 'Canceled Orders')

@section('content-header', 'หน้าแสดงรายการการสั่งที่ถูกยกเลิก')

@section('content')
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
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">แสดงรายละเอียดการสั่งเดิม</a></td>
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