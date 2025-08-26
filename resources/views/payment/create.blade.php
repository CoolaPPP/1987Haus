@extends('layouts.app')

@section('title', '1987 Haus | Order Payment')

@section('content')
<style>
    .card {
        background-color: #ffffff;
        border: 1px solid #504b38;
        }
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
        background-color: transparent;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>หมายเลขคำสั่งซื้อ # {{ $order->id }}</h2>
                </div>
                <div class="card-body text-center">
                    <p>จำนวนเงินที่ต้องชำระ : </p>
                    <h1 class="font-weight-bold">฿{{ number_format($order->net_price, 2) }}</h1>
                    <hr>
                    <p>กรุณาชำระเงินโดยใช้ PromptPay</p>
                    <hr>
                    <strong class="text-danger">กรุณาตรวจสอบจำนวนเงินให้ถูกต้องก่อนชำระเงิน</strong><br>
                    <strong class="text-danger"> หากไม่ถูกต้องท่านสามารถยกเลิกโดยการยกเลิกการสั่งซื้อได้</strong>
                    <hr>
                    {{-- แสดง QR Code --}}
                    
                    [Image of QR code for payment]

                    <img src="{{ $qrCode }}" alt="PromptPay QR Code">
                    
                    <p class="mt-3"><strong>ชื่อบัญชี :</strong> เผ่าพันธ์ โพธิ์ธรรม</p>

                    <hr>
                    <h3>ขั้นตอนการชำระเงิน</h3>
                    <p>
                        1. เปิดแอปพลิเคชันธนาคารบนโทรศัพท์ของคุณ<br>
                        2. เลือก "สแกน QR Code" หรือ "ชำระเงินด้วย QR Code"<br>
                        3. สแกน QR Code ด้านบน<br>
                        4. ตรวจสอบจำนวนเงินและยืนยันการชำระเงิน<br>
                        5. อัปโหลดหลักฐานการชำระเงินที่ด้านล่างนี้
                    </p>
                    <hr>

                    <form action="{{ route('payment.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-left">
                            <label for="payment_pic">
                                <strong>อัปโหลดหลักฐานการชำระเงิน</strong>
                                <small class="text-danger">* บังคับ</small>
                            </label>
                            <input type="file" name="payment_pic" id="payment_pic" class="form-control" required>
                            @error('payment_pic') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-lg btn-theme mt-4">ยืนยันการชำระเงิน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection