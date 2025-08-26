@extends('layouts.app')

@section('title', '1987 Haus | Order Complete')

@section('content')
<style>
    .card {
        background-color: #f8f3d9;
        border: 1px solid #ebe5c2;
    }
    .card-header {
        background-color: #504b38;
        color: #f8f3d9;
        font-weight: bold;
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
    <div class="card shadow border-0 rounded-4" style="background-color: #f8f3d9;">
        <div class="card-body text-center p-5">

            <div class="mb-4">
                <i class="fas fa-check-circle" style="font-size: 4rem; color: #504b38;"></i>
            </div>

            <h2 class="fw-bold mb-3" style="color: #504b38;">ขอบคุณสำหรับการสั่งซื้อ !</h2>
            <p class="fs-5" style="color: #504b38;">
                ออเดอร์ <strong>#{{ $order->id }}</strong> ถูกเพิ่มเข้าระบบสำเร็จ
            </p>

            <div class="mt-4">
                <a href="{{ route('payment.create', $order->id) }}" 
                   class="btn btn-theme btn-lg px-4 me-2 shadow-sm">
                    <i class="fas fa-credit-card me-2"></i> ชำระเงิน
                </a>
                <a href="{{ route('shop.index') }}" 
                   class="btn btn-outline-theme btn-lg px-4 shadow-sm">
                    <i class="fas fa-shopping-bag me-2"></i> เลือกสินค้าต่อ
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endpush
