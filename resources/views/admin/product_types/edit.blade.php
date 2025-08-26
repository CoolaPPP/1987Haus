@extends('admin.layouts.app')

@section('title', 'Edit Product Type')

@section('content-header', 'หน้าแก้ไขข้อมูลประเภทสินค้า')

@section('content')
<div class="card card-warning">
    <div class="card-header"><h3 class="card-title">ประเภทสินค้าที่กำลังแก้ไข : {{ $productType->producttype_name }}</h3></div>
    <form action="{{ route('admin.product-types.update', $productType->id) }}" method="POST">
        @csrf
        @method('PUT') 
        <div class="card-body">
            <div class="form-group">
                <label>ชื่อประเภทสินค้า</label>
                <input type="text" name="producttype_name" class="form-control @error('producttype_name') is-invalid @enderror" value="{{ old('producttype_name', $productType->producttype_name) }}" required>
                @error('producttype_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">แก้ไข</button>
            <a href="{{ route('admin.product-types.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection