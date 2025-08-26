@extends('admin.layouts.app')

@section('title', 'Cancellation Details #' . $orderCancel->id)

@section('content-header', 'หน้าแสดงข้อมูลการยกเลิกการสั่ง')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>ข้อมูลการยกเลิกการสั่ง #{{ $orderCancel->id }}</h4>
    </div>
    <div class="card-body">
        <p><strong>รหัสการสั่งเดิม : </strong> <a href="{{ route('admin.orders.show', $orderCancel->order_id) }}">#{{ $orderCancel->order_id }}</a></p>
        <p><strong>ชื่อลูกค้า : </strong> {{ $orderCancel->customer->name }}</p>
        <p><strong>ยอดยกเลิก : </strong> ฿{{ number_format($orderCancel->cancel_price, 2) }}</p>
        <p><strong>วันที่และเวลาของการยกเลิกการสั่ง : </strong> {{ \Carbon\Carbon::parse($orderCancel->cancel_datetime)->format('d F Y, H:i') }}</p>
        <hr>
        <h5>สินค้าที่ยกเลิก</h5>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th class="text-right">ราคา</th>
                    <th class="text-center">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderCancel->details as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td class="text-right">฿{{ number_format($detail->product_price, 2) }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection