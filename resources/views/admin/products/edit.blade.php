@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content-header', 'หน้าแก้ไขข้อมูลสินค้า')

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
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="card card-warning">
    <div class="card-header"><h3 class="card-title">สินค้าที่กำลังแก้ไข : {{ $product->product_name }}</h3></div>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>ชื่อสินค้า</label>
                <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
            </div>
            <div class="form-group">
                <label>ประเภทสินค้า</label>
                <select name="producttype_id" class="form-control" required>
                    @foreach($productTypes as $type)
                        <option value="{{ $type->id }}" {{ $product->producttype_id == $type->id ? 'selected' : '' }}>
                            {{ $type->producttype_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>ราคา</label>
                <input type="number" step="0.01" name="product_price" class="form-control" value="{{ old('product_price', $product->product_price) }}" required>
            </div>
            <div class="form-group">
                <label>รูปสินค้าปัจจุบัน</label>
                @php
                        // สร้าง object ImageKit ชั่วคราวเพื่อสร้าง URL
                        $imageKit = new \ImageKit\ImageKit(
                            env('IMAGEKIT_PUBLIC_KEY'),
                            env('IMAGEKIT_PRIVATE_KEY'),
                            env('IMAGEKIT_URL_ENDPOINT')
                        );
                    @endphp
                <div>
                    <img src="{{ $imageKit->url(['path' => $product->product_pic]) }}" width="200">
                </div>
            </div>
            <div class="form-group">
                <label>แก้ไขรูปสินค้า (ไม่บังคับ)</label>
                <input type="file" name="product_pic" class="form-control">
                <small class="form-text text-muted">หากไม่ต้องการแก้ไขรูปสินค้า สามารถเว้นช่องนี้ให้ว่างได้</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">แก้ไข</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-theme">ย้อนกลับ</a>
        </div>
    </form>
</div>
@endsection