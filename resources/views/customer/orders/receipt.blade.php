@extends('layouts.app')

@section('title', '1987 Haus | E-Receipt')

@section('content')
<div class="container my-5">
    <div class="card shadow border-0" style="background-color:#f8f3d9;">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color:#504b38;">
            <h4 class="mb-0"><i class="fas fa-receipt me-2"></i> ใบเสร็จ</h4>
            <!-- <button onclick="window.print()" class="btn btn-sm" style="background-color:#b9b28a; color:#504b38;">
                <i class="fas fa-print"></i> พิมพ์
            </button> -->
        </div>
        <div class="card-body" style="color:#504b38;">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h5 class="mb-3 fw-bold">1987 Haus</h5>
                    <h3 class="mb-1"></h3>
                    <div>198/7 Moo 1</div>
                    <div>San-sai Chiang Mai, 50210</div>
                    <div>Email : contact@1987haus.com</div>
                    <div>เบอร์โทรศัพท์ : 09 1987 1987</div>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <h5 class="mb-3 fw-bold">ข้อมูลลูกค้า</h5>
                    <h3 class="mb-1">{{ $order->customer->name }}</h3>
                    <div>{!! nl2br(e($order->shippingAddress->address)) !!}</div>
                    <div>Email : {{ $order->customer->email }}</div>
                    <div>เบอร์โทรศัพท์ : {{ $order->customer->tel }}</div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h5 class="mb-3 fw-bold">รายละเอียดการสั่งซื้อ</h5>
                    <div>รหัสการสั่งซื้อ : <strong>#{{ $order->id }}</strong></div>
                    <div>วันที่และเวลาในการสั่งซื้อ : <strong>{{ \Carbon\Carbon::parse($order->order_datetime)->format('d F Y, H:i') }}</strong></div>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <h5 class="mb-3 fw-bold">รายละเอียดการชำระเงิน</h5>
                    <div>วันที่และเวลาในการชำระเงิน : <strong>{{ \Carbon\Carbon::parse($order->payment->payment_datetime)->format('d F Y, H:i') }}</strong></div>
                    <div>สถานะ : <span class="badge" style="background-color:#b9b28a; color:#504b38;">ชำระเงินแล้ว</span></div>
                </div>
            </div>

            <div class="table-responsive-sm">
                <table class="table table-bordered align-middle" style="background-color:#ebe5c2;">
                    <thead style="background-color:#b9b28a; color:#504b38;">
                        <tr>
                            <th class="center">ลำดับ</th>
                            <th>ชื่อสินค้า</th>
                            <th class="text-end">ราคาต่อหน่วย</th>
                            <th class="center">จำนวน</th>
                            <th class="text-end">ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $detail->product->product_name }}</td>
                            <td class="text-end">฿{{ number_format($detail->product_price, 2) }}</td>
                            <td class="center">{{ $detail->quantity }}</td>
                            <td class="text-end">฿{{ number_format($detail->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-lg-4 col-sm-6 ms-auto">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold">ราคารวมทั้งหมด</td>
                                <td class="text-end">฿{{ number_format($order->order_price, 2) }}</td>
                            </tr>
                            @if($order->promotion_id)
                                @php $discount = $order->order_price - $order->net_price; @endphp
                                <tr>
                                    <td class="fw-bold">ส่วนลด ({{ $order->promotion_id }})</td>
                                    <td class="text-end text-success">- ฿{{ number_format($discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr style="background-color:#b9b28a; color:#504b38;">
                                <td class="fw-bold">ราคาสุทธิ</td>
                                <td class="text-end fw-bold">฿{{ number_format($order->net_price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p class="fw-bold" style="color:#504b38;">ขอบคุณสำหรับการสั่งซื้อสินค้ากับเรา, ขอให้วันนี้เป็นวันที่ดี!</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
    @media print {
        .btn, .card-header { display: none; }
        body { background: #fff; }
    }
</style>
@endpush
