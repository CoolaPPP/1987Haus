@extends('layouts.app')

@section('title', '1987 Haus | Select Shipping Address')

@section('content')
<style>
    .card {
        background-color: #f8f3d9;
        border: 1px solid #ebe5c2;
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
    .form-check {
        background-color: #ebe5c2;
        border: 1px solid #b9b28a;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="container py-5">
    <h2 class="fw-bold text-center mb-4" style="color: #504b38;">เลือกที่อยู่สำหรับจัดส่งสินค้า</h2>

    <form action="{{ route('checkout.place-order') }}" method="POST">
        @csrf

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-3" style="color: #504b38;">เลือกที่อยู่</h5>
            @forelse($addresses as $address)
                <div class="form-check">
                    <input class="form-check-input ms-1" type="radio" name="shippingaddress_id" id="address{{$address->id}}" value="{{$address->id}}" required>
                    <label class="form-check-label ps-3" for="address{{$address->id}}">
                        {{ $address->address }}
                    </label>
                </div>
            @empty
                <div class="alert alert-warning" style="background-color: #f8f3d9; border-color: #b9b28a; color: #504b38;">
                    ไม่มีที่อยู่จัดส่ง กรุณาเพิ่มที่อยู่ก่อนทำการสั่งซื้อ
                </div>
            @endforelse
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-3" style="color: #504b38;">ข้อความเพิ่มเติม</h5>
            <div class="form-group">
                <textarea name="order_note" class="form-control" rows="3" placeholder="สามารถใส่รายละเอียดของการสั่งสินค้าเพิ่มเติมได้ที่นี่ เช่น ระบุระดับความหวานของเครื่องดื่ม การแยกน้ำแข็ง หรือรายละเอียดอื่น ๆ ได้"></textarea>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-theme btn-lg px-5">
                ยืนยันที่อยู่
            </button>
        </div>
    </form>
</div>
@endsection
