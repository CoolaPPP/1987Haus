@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content-header', 'หน้าเพิ่มข้อมูลสินค้า')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">เพิ่มสินค้าใหม่</h3></div>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>ชื่อสินค้า</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>ประเภทสินค้าทั้งหมด</label>
                <select name="producttype_id" class="form-control" required>
                    <option value="">-- เลือกประเภทสินค้า --</option>
                    @foreach($productTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->producttype_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>ราคา</label>
                <input type="number" step="0.01" name="product_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label>รูปสินค้า</label>
                <input type="file" name="product_pic" class="form-control" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">ยืนยัน</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
@endsection