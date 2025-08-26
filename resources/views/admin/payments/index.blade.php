@extends('admin.layouts.app')

@section('title', 'Show Payment Details')

@section('content-header', 'หน้าแสดงข้อมูลการชำระเงิน')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">ข้อมูลการชำระเงินทั้งหมด</h3></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>รหัสการชำระเงิน</th>
                        <th>รหัสการสั่งซื้อ</th>
                        <th>ชื่อลูกค้า</th>
                        <th>วันที่และเวลาของการชำระเงิน</th>
                        <th>รูปหลักฐานการชำระเงิน (สลิป)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        @php
                            // สร้าง object ImageKit ชั่วคราวเพื่อสร้าง URL
                            $imageKit = new \ImageKit\ImageKit(
                                env('IMAGEKIT_PUBLIC_KEY'),
                                env('IMAGEKIT_PRIVATE_KEY'),
                                env('IMAGEKIT_URL_ENDPOINT')
                            );
                        @endphp
                        <td>{{ $payment->id }}</td>
                        <td>#{{ $payment->order_id }}</a></td>
                        <td>{{ $payment->customer->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_datetime)->format('d M Y, H:i') }}</td>
                        <td>
                            {{-- เปลี่ยนเป็นลิงก์ธรรมดาที่เปิดในแท็บใหม่ --}}
                            <a href="{{ $imageKit->url(['path' => $payment->payment_pic]) }}" target="_blank">
                                <img src="{{ $imageKit->url(['path' => $payment->payment_pic]) }}" alt="Payment Slip" style="width: 100px; height: auto; cursor: pointer;">
                            </a>
                        </td> 
                    </tr>     
                    @empty
                    <tr><td colspan="5" class="text-center">ไม่พบข้อมูลการชำระเงิน</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $payments->links() }}</div>
</div>
@endsection
