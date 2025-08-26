@extends('layouts.app')

@section('title', '1987 Haus | Our Products')

@section('content')

<style>
    /* ปุ่ม */
    .btn-theme {
        background-color: #b9b28a;
        color: #504b38;
        border: none;
        transition: all 0.3s ease-in-out;
    }
    .btn-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
        transform: scale(1.05);
    }

    .btn-outline-theme {
        border: 1px solid #504b38;
        color: #504b38;
        background-color: transparent;
        transition: all 0.3s ease-in-out;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
        transform: scale(1.05);
    }

    .btn-outline-secondary {
        transition: all 0.3s ease-in-out;
    }
    .btn-outline-secondary:hover {
        transform: scale(1.05);
    }

    /* การ์ดสินค้า */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s forwards;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* Animation keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ใส่ delay ทีละการ์ด */
    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="container py-5">
    <h1 class="text-center mb-4">สินค้า</h1>
    <div class="text-center mb-4">
        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary mx-1">แสดงสินค้าทั้งหมด</a>
        @foreach($productTypes as $type)
            <a href="{{ route('shop.index', ['type' => $type->id]) }}" class="btn btn-outline-secondary mx-1">{{ $type->producttype_name }}</a>
        @endforeach
    </div>

    <div class="row g-4"> {{-- ใช้ g-4 แทน mb-4 ให้ spacing เท่ากัน --}}
        @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
            <div class="card h-100 w-100">
                @php
                    $imageKit = new \ImageKit\ImageKit(
                        env('IMAGEKIT_PUBLIC_KEY'),
                        env('IMAGEKIT_PRIVATE_KEY'),
                        env('IMAGEKIT_URL_ENDPOINT')
                    );
                @endphp
                <img src="{{ $imageKit->url(['path' => $product->product_pic]) }}" 
                     class="card-img-top" 
                     alt="{{ $product->product_name }}" 
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->product_name }}</h5>
                    <p class="card-text text-muted">{{ $product->productType->producttype_name }}</p>
                    <p class="card-text font-weight-bold">฿{{ number_format($product->product_price, 2) }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    @auth
                        <!-- Login -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary btn-minus" type="button">-</button>
                                <input type="text" name="quantity" class="form-control text-center quantity-input" value="1">
                                <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                            </div>
                            <button type="submit" class="btn btn-outline-theme w-100">เพิ่มลงตะกร้า</button>
                        </form>
                    @else
                        <!-- Guest -->
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">เข้าสู่ระบบเพื่อสั่งซื้อ</a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">ยังไม่มีสินค้าในตอนนี้ ขออภัยในความไม่สะดวก</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
