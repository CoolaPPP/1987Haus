@extends('layouts.app')

@section('title', '1987 Haus | Cart')

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
        background-color: transparent;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
    .card {
        background-color: #f8f3d9;
        border: 1px solid #ebe5c2;
    }
    
</style>

<div class="container py-5">
    <h1 class="mb-4 text-center fw-bold" style="color: #504b38;">ตะกร้าสินค้า</h1>

    @if(session('cart'))
        @php $total = 0; @endphp

        <div class="table-responsive shadow-sm rounded">
            <table class="table align-middle cart-table">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th class="text-center">ราคา</th>
                        <th class="text-center">จำนวน</th>
                        <th class="text-center">ราคารวม</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr>
                            <td>
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center">
                                    @php
                                        // สร้าง object ImageKit ชั่วคราวเพื่อสร้าง URL
                                        $imageKit = new \ImageKit\ImageKit(
                                        env('IMAGEKIT_PUBLIC_KEY'),
                                        env('IMAGEKIT_PRIVATE_KEY'),
                                        env('IMAGEKIT_URL_ENDPOINT')
                                    );
                                    @endphp
                                        <img src="{{ $imageKit->url(['path' => $details['pic'], 'transformation' => [['height' => 120, 'width' => 120]]]) }}" 
                                        class="img-thumbnail me-2 mb-2 mb-sm-0" 
                                        style="width: 60px; height: 60px; object-fit: cover;"
                                        alt="{{ $details['name'] }}">
                                    <span class="fw-semibold text-break" style="flex: 1;">
                                        {{ $details['name'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">฿{{ number_format($details['price'], 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                    @csrf 
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="99" class="form-control form-control-sm text-center" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btn-outline-theme">อัพเดท</button>
                                </form>
                            </td>
                            <td class="text-center">฿{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>

        <div class="row g-4">
            {{-- คูปองส่วนลด --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="fw-bold" style="color: #504b38;">กรอกโค้ดส่วนลด</h4>
                        <p class="text-muted small">กรอกรหัสโปรโมชันเพื่อรับส่วนลดเพิ่มเติม</p>
                        <form action="{{ route('cart.apply-promo') }}" method="POST" class="d-flex flex-column flex-sm-row gap-2">
                            @csrf
                            <input type="text" name="promo_code" class="form-control" placeholder="กรอกโปรโมชันที่นี่">
                            <button type="submit" class="btn btn-theme fw-bold">ยืนยัน</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- สรุปยอดรวม --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-end">
                        <h5 class="text-muted">ราคาก่อนใช้ส่วนลด</h5>
                        <h4 style="color: #504b38;">฿{{ number_format($total, 2) }}</h4>

                        @if(session('promo'))
                            @php
                                $discount = session('promo')['discount'];
                                $netTotal = $total - $discount;
                            @endphp
                            <h6 class="text-success">ส่วนลด: -฿{{ number_format($discount, 2) }}</h6>
                            <h3 class="fw-bold" style="color: #504b38;">ราคาสุทธิ : ฿{{ number_format($netTotal, 2) }}</h3>
                        @else
                            <h3 class="fw-bold" style="color: #504b38;">ราคาสุทธิ : ฿{{ number_format($total, 2) }}</h3>
                        @endif

                        <a href="{{ route('checkout.address') }}" class="btn btn-theme w-100 mt-3">ดูรายละเอียดการสั่งและเลือกที่อยู่จัดส่ง เพื่อยืนยันการสั่งซื้อ</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center mt-4" style="background-color: #f8f3d9; border: 1px solid #b9b28a; color: #504b38;">
            ไม่มีสินค้าในตะกร้า
        </div>
    @endif
</div>
@endsection
