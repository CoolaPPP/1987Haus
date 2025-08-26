@extends('admin.layouts.app')

@section('title', 'Order #' . $order->id)

@section('content-header', 'แสดงรายละเอียดคำสั่งซื้อ #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        
        <div class="card card-outline">
            <div class="card-header">
                <h3 class="card-title">รายการสินค้า</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th class="text-right">ราคา</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-right">ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                            <tr>
                                <td>{{ $detail->product->product_name }}</td>
                                <td class="text-right">฿ {{ number_format($detail->product_price, 2) }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-right">฿ {{ number_format($detail->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อความเพิ่มเติม</h3>
            </div>
            <div class="card-body">
                @if($order->order_note)
                    <p class="mb-0">
                        <strong>ข้อความแนบจากการสั่งสินค้าเพิ่มเติม :</strong><br>
                        <span class="ml-3 font-italic text-muted">"{{ $order->order_note }}"</span>
                    </p>
                @else
                    <p class="mb-0"><em class="text-muted">ไม่มีข้อความเพิ่มเติม</em></p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลลูกค้า และรายละเอียดการจัดส่ง</h3>
            </div>
            <div class="card-body">
                <strong>ชื่อลูกค้า :</strong> {{ $order->customer->name }} 
                (เบอร์โทรศัพท์ : {{ $order->customer->tel ?? 'N/A' }})<br>

                <strong>ที่อยู่สำหรับจัดส่งสินค้า :</strong><br>
                <p class="ml-3 mb-0">{!! nl2br(e($order->shippingAddress->address)) !!}</p>
                
                @if($order->shippingAddress->address_note)
                    <p class="mb-0">
                        <strong>ข้อมูลที่อยู่เพิ่มเติม :</strong> {{ $order->shippingAddress->address_note }}
                    </p>
                @endif

                @if($order->order_note)
                    <hr>
                    <p class="mb-0">
                        <strong>ข้อความแนบจากการสั่งสินค้าเพิ่มเติม :</strong><br>
                        <span class="ml-3 font-italic text-muted">"{{ $order->order_note }}"</span>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">สรุปคำสั่งซื้อ</h3>
            </div>
            <div class="card-body">
                <p>
                    <strong>ราคารวมทั้งหมด</strong>
                    <span class="float-right">฿ {{ number_format($order->order_price, 2) }}</span>
                </p>

                @if($order->promotion_id)
                    @php 
                        $discount = $order->order_price - $order->net_price; 
                    @endphp
                    <p class="text-success">
                        <strong>ส่วนลด (<code>{{ $order->promotion_id }}</code>)</strong>
                        <span class="float-right">- ฿ {{ number_format($discount, 2) }}</span>
                    </p>
                @endif

                <hr>
                <h4>
                    <strong>ราคาสุทธิ</strong>
                    <span class="float-right">฿ {{ number_format($order->net_price, 2) }}</span>
                </h4>

                <!-- <hr> 
                <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn btn-success btn-block">
                    @if($order->order_status_id == 2)
                        ยืนยันและพิมพ์ใบปะหน้าสินค้า
                    @else
                        พิมพ์ใบปะหน้าสินค้าอีกครั้ง
                    @endif
                </a> -->
                @if($order->order_status_id == 2)
                {{-- ถ้าจ่ายเงินแล้ว: แสดงปุ่ม "ยืนยันและพิมพ์" --}}
                <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn btn-success btn-block">
                    ยืนยันและพิมพ์ใบปะหน้าสินค้า
                </a>
                @elseif(in_array($order->order_status_id, [3, 5]))
                    {{-- ถ้ากำลังส่ง หรือ ส่งแล้ว: แสดงปุ่ม "พิมพ์อีกครั้ง" --}}
                    <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn btn-success btn-block">
                        พิมพ์ใบปะหน้าสินค้าอีกครั้ง
                    </a>
                @elseif($order->order_status_id == 4 && $order->cancellation)
                    {{-- ถ้าถูกยกเลิก: แสดงปุ่ม "ดูรายละเอียดการยกเลิก" --}}
                    <a href="{{ route('admin.order-cancels.show', $order->cancellation->id) }}" class="btn btn-secondary btn-block">
                        ดูรายละเอียดการยกเลิก
                    </a>
                @else
                    {{-- สถานะอื่นๆ (เช่น ยังไม่จ่ายเงิน) --}}
                    <p class="text-muted text-center">ไม่มีการดำเนินการสำหรับสถานะนี้</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
