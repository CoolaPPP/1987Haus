@extends('admin.layouts.app')

@section('title', 'Edit Recommendation')

@section('content-header', 'หน้าแก้ไขข้อมูลสินค้าแนะนำ')

@section('content')
<div class="card card-warning">
    <div class="card-header"><h3 class="card-title">สินค้าแนะนำที่กำลังแก้ไข : {{ $recommendProduct->product->product_name }}</h3></div>
    <form action="{{ route('admin.recommend-products.update', $recommendProduct->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>ข้อความเพิ่มเติม</label>
                <textarea name="recommend_note" class="form-control" rows="3">{{ old('recommend_note', $recommendProduct->recommend_note) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">แก้ไข</button>
            <a href="{{ route('admin.recommend-products.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection