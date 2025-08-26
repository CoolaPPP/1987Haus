@extends('admin.layouts.app')

@section('title', 'Shipping Orders')

@section('content-header', 'หน้าแสดงรายการการสั่งที่กำลังจัดส่ง')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">รายการการสั่งที่กำลังจัดส่ง</h3></div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการสั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>วันที่และเวลาของการจัดส่ง</th>
                    <th>ราคาสุทธิ</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shippingOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->updated_at->format('d M Y, H:i') }}</td>
                    <td>฿{{ number_format($order->net_price, 2) }}</td>
                    <td>
                        {{-- ลิงก์สำหรับดูรายละเอียด หรือพิมพ์ใบเสร็จซ้ำ --}}
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">แสดงรายละเอียด</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่มีข้อมูลสินค้ากําลังจัดส่ง</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $shippingOrders->links() }}</div>
</div>
@endsection