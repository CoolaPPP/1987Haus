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
            <h5 class="mb-3" style="color: #504b38;">รายละเอียดสินค้า</h5>

            @php
                use App\Models\Product;
            @endphp

            @foreach(session('cart', []) as $index => $item)
                @php
                    $product = Product::find($index);
                    $categoryId = $product ? $product->producttype_id : null;
                @endphp

                @for($i = 1; $i <= $item['quantity']; $i++)
                    <div class="mb-3 p-3 border rounded bg-light">
                        <p class="fw-bold mb-2" style="color:#504b38;">
                            {{ $item['name'] }} - แก้วที่ {{ $i }}
                        </p>

                        {{-- ถ้าเป็นกาแฟ --}}
                        @if(in_array($categoryId, [1,2,3,7]))
                            <div class="mb-2">
                                <label class="form-label">เลือกระดับการคั่ว</label>
                                <select name="items[{{ $index }}][{{ $i }}][roast]" class="form-select">
                                    <option value="คั่วอ่อน">คั่วอ่อน</option>
                                    <option value="คั่วกลาง">คั่วกลาง</option>
                                    <option value="คั่วเข้ม">คั่วเข้ม</option>
                                </select>
                            </div>
                        @endif

                        {{-- ความหวาน --}}
                        <div class="mb-2">
                            <label class="form-label">เลือกระดับความหวาน</label>
                            <select name="items[{{ $index }}][{{ $i }}][sweetness]" class="form-select">
                                <option value="ไม่หวาน">ไม่หวาน</option>
                                <option value="หวานน้อย">หวานน้อย</option>
                                <option value="หวานปกติ">หวานปกติ</option>
                                <option value="เพิ่มความหวาน">หวานตัดขา</option>
                            </select>
                        </div>
                    </div>
                @endfor
            @endforeach
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-3" style="color: #504b38;">ข้อความเพิ่มเติม</h5>
            <div class="form-group">
                <textarea name="order_note" class="form-control" rows="3" placeholder="สามารถใส่รายละเอียดของการสั่งสินค้าเพิ่มเติมได้ที่นี่ เช่น การแยกน้ำแข็ง หรือรายละเอียดอื่น ๆ ได้"></textarea>
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
