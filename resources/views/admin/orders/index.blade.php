@extends('admin.layouts.app')

@section('title', 'New Paid Orders')

@section('content-header', 'หน้าแสดงคำสั่งซื้อใหม่')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">คำสั่งซื้อใหม่</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการสั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>วันที่และเวลาของการสั่งสินค้า</th>
                    <th>ราคาสุทธิ</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->order_datetime }}</td>
                    <td>฿{{ number_format($order->net_price, 2) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">รายละเอียด</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่มีข้อมูลคำสั่งซื้อใหม่</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $newOrders->links() }}</div>
</div>
@endsection