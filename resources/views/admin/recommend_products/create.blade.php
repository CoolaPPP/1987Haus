@extends('admin.layouts.app')

@section('title', 'Add Recommended Product')

@section('content-header', 'หน้าเพิ่มข้อมูลสินค้าแนะนำ')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">เพิ่มข้อมูลสินค้าแนะนำ</h3></div>
    <form action="{{ route('admin.recommend-products.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>สินค้า</label>
                <select name="product_id" class="form-control" required>
                    <option value="">-- เลือกสินค้า --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>ข้อความเพิ่มเติม</label>
                <textarea name="recommend_note" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">ยืนยัน</button>
            <a href="{{ route('admin.recommend-products.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection