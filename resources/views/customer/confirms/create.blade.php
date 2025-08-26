@extends('layouts.app')

@section('content')

@section('title', '1987 Haus | Order Confirmation')

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
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="container py-5">
    <h2>ยืนยันการรับสินค้าสำหรับคําสั่งซื้อ #{{ $order->id }}</h2>
    <p><strong>วันที่และเวลาที่ชำระเงิน : </strong> {{ $order->payment->payment_datetime }}</p>

    {{-- แสดงข้อความเงื่อนไขเวลา --}}
    @if(!$canConfirm)
        <div class="alert alert-warning">
            คุณสามารถยืนยันการรับสินค้าได้หลังจากเวลาผ่านไปอย่างน้อย 10 นาที นับจากเวลาชำระเงิน
            เวลาที่สามารถยืนยัน : **{{ $confirmAvailableAt }}**
        </div>
    @endif

    <form id="confirmForm" action="{{ route('order-confirm.store', $order->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5>สถานะสินค้า</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderconfirmed_status" id="status1" value="1" checked>
                    <label class="form-check-label" for="status1">ได้รับสินค้าครบถ้วน</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderconfirmed_status" id="status2" value="2">
                    <label class="form-check-label" for="status2">ได้รับสินค้า แต่สินค้าได้รับความเสียหาย/ได้รับสินค้าไม่ครบ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderconfirmed_status" id="status3" value="3">
                    <label class="form-check-label" for="status3">ยังไม่ได้รับสินค้า</label>
                </div>
            </div>
        </div>
        <button type="submit" id="confirmButton" class="btn btn-theme btn-lg mt-3">ยืนยัน</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmButton = document.getElementById('confirmButton');
    const canConfirm = {{ $canConfirm ? 'true' : 'false' }};

    if (!canConfirm) {
        confirmButton.disabled = true;
    }

    confirmButton.addEventListener('click', function(event) {
        if (!canConfirm) {
            event.preventDefault(); // หยุดการ submit form
            alert('Please wait until 10 minutes have passed since payment to confirm.');
        }
    });
});
</script>
@endpush