@extends('layouts.app')

@section('title', '1987 Haus | Cancel Order')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0" style="background-color: #f8f3d9; border-radius: 16px;">
        <div class="card-body">
            <h2 class="mb-4" style="color: #504b38; font-weight: bold;">ยกเลิกการสั่งซื้อ</h2>
            <p class="mb-4" style="color: #504b38;">โปรดเลือกการสั่งที่คุณต้องการยกเลิก (การสั่งที่ยังไม่ได้ชำระเงิน)</p>

            @if($unpaidOrders->isEmpty())
                <div class="alert text-center" style="background-color: #ebe5c2; color: #504b38; border-radius: 12px;">
                    คุณไม่มีการสั่งที่ยังไม่ได้ชำระเงิน
                </div>
            @else
                <form action="{{ route('order-cancel.confirm') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="order_id" style="color: #504b38; font-weight: 600;">เลือกการสั่ง</label>
                        <select name="order_id" id="order_id" class="form-control" style="border-radius: 8px; background-color: #ebe5c2; color: #504b38;" required>
                            @foreach($unpaidOrders as $order)
                                <option value="{{ $order->id }}">
                                    #{{ $order->id }} : {{ \Carbon\Carbon::parse($order->order_datetime)->format('d M Y, H:i') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-lg w-100" 
                        style="background-color: #504b38; color: #f8f3d9; border-radius: 12px;  transition: 0.3s;">
                        ดูรายละเอียดเพื่อยกเลิก
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
    .btn:hover {
        background-color: #b9b28a !important;
        color: #504b38 !important;
        
    }
</style>
@endsection
