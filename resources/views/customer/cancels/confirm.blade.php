@extends('layouts.app')

@section('title', '1987 Haus | Confirm Cancellation')

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
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">หน้ายืนยันการยกเลิกการสั่งสินค้า #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <p>คุณกำลังยกเลิกการสั่งสินค้า โปรดตรวจสอบรายละเอียดให้ถูกต้อง</p>
                    
                    {{-- แสดงรายละเอียดสินค้าที่จะถูกยกเลิก --}}
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ชื่อสินค้า</th>
                                    <th class="text-right">ราคา</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-right">ราคารวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->product_name }}</td>
                                    <td class="text-right">฿{{ number_format($detail->product_price, 2) }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">฿{{ number_format($detail->total_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-right">ยอดยกเลิก</td>
                                    <td class="text-right">฿{{ number_format($order->order_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <p class="text-danger font-weight-bold">
                        <i class="fas fa-exclamation-triangle"></i>
                        ระวัง! การดำเนินการนี้ไม่สามารถย้อนกลับได้
                    </p>

                    {{-- ฟอร์มสำหรับยืนยันการยกเลิก --}}
                    <form action="{{ route('order-cancel.destroy', $order->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการสั่ง');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg btn-block">ใช่, ยืนยันการยกเลิก</button>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-theme btn-block mt-2">ย้อนกลับ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- เพิ่ม Font Awesome สำหรับไอคอน --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endpush