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
    <h2 class="fw-bold text-center mb-4" style="color: #504b38;">รายละเอียดของสินค้า และที่อยู่สำหรับจัดส่งสินค้า</h2>

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

                            @if(in_array($categoryId, [1,2,3,7]))
                                <div class="mb-3">
                                    <label class="form-label d-block">เลือกระดับการคั่ว</label>
                                    <div class="form-check mb-1 ps-5 mt-2">
                                        <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][roast]" id="roast-light-{{ $index }}-{{ $i }}" value="คั่วอ่อน">
                                        <label class="form-check-label ps-3" for="roast-light-{{ $index }}-{{ $i }}">
                                            คั่วอ่อน <br>Ethiopia Yirgacheffe Geisha | <small class="text-muted">Taste note : Jasmin, Peach, Brown sugar, Green tea</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-1 ps-5 mt-2">
                                        <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][roast]" id="roast-medium-{{ $index }}-{{ $i }}" value="คั่วกลาง" checked>
                                        <label class="form-check-label ps-3" for="roast-medium-{{ $index }}-{{ $i }}">
                                            คั่วกลาง <br>Thailand Mea Jan Tai / Brazil Santos Blend | <small class="text-muted">Taste note : Frutty, Caramel, Smooth body</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-1 ps-5 mt-2">
                                        <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][roast]" id="roast-dark-{{ $index }}-{{ $i }}" value="คั่วเข้ม">
                                        <label class="form-check-label ps-3" for="roast-dark-{{ $index }}-{{ $i }}">
                                            คั่วเข้ม <br>Thailand Pang Khon / Lao Bolaven Blend | <small class="text-muted">Taste note : Dark Chocolate, Caramel, Brown sugar, Nutty</small>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label d-block">เลือกระดับความหวาน</label>
                                <div class="form-check mb-1 ps-5 mt-2">
                                    <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][sweetness]" id="sweet-0-{{ $index }}-{{ $i }}" value="ไม่หวาน">
                                    <label class="form-check-label ps-3" for="sweet-0-{{ $index }}-{{ $i }}">
                                        ไม่หวาน <br>ความหวาน 0% | <small class="text-muted">เหมาะสำหรับคนที่ไม่ชอบความหวาน</small>
                                    </label>
                                </div>
                                <div class="form-check mb-1 ps-5 mt-2">
                                    <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][sweetness]" id="sweet-1-{{ $index }}-{{ $i }}" value="หวานน้อย">
                                    <label class="form-check-label ps-3" for="sweet-1-{{ $index }}-{{ $i }}">
                                        หวานน้อย <br>ความหวาน 50% | <small class="text-muted">รสกลมกล่อม หวานเบา ๆ</small>
                                    </label>
                                </div>
                                <div class="form-check mb-1 ps-5 mt-2">
                                    <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][sweetness]" id="sweet-2-{{ $index }}-{{ $i }}" value="หวานปกติ" checked>
                                    <label class="form-check-label ps-3" for="sweet-2-{{ $index }}-{{ $i }}">
                                        หวานปกติ <br>ความหวาน 100% | <small class="text-muted">ระดับความหวานปกติของร้าน หวานพอดี</small>
                                    </label>
                                </div>
                                <div class="form-check mb-1 ps-5 mt-2">
                                    <input class="form-check-input mt-3" type="radio" name="items[{{ $index }}][{{ $i }}][sweetness]" id="sweet-3-{{ $index }}-{{ $i }}" value="เพิ่มความหวาน">
                                    <label class="form-check-label ps-3" for="sweet-3-{{ $index }}-{{ $i }}">
                                        หวานตัดขา <br>ความหวาน 300% | <small class="text-muted">หวานจัดจ้าน เหมาะกับสายหวานแท้ ๆ</small>
                                    </label>
                                </div>
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
            <button type="submit" class="btn btn-theme btn-block px-5">
                ยืนยัน
            </button>
        </div>
    </form>
</div>
@endsection
