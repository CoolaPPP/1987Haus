@extends('admin.layouts.app')

@section('title', 'Edit Promotion')

@section('content-header', 'หน้าแก้ไขข้อมูลโปรโมชัน')

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
    <div class="card-header"><h3 class="card-title">โปรโมชันที่กำลังแก้ไข : {{ $promotion->id }}</h3></div>
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>รหัสโปรโมชัน</label>
                <input type="text" class="form-control" value="{{ $promotion->id }}" readonly>
            </div>
            <div class="form-group">
                <label for="promotion_name">ชื่อโปรโมชัน</label>
                <input type="text" name="promotion_name" id="promotion_name" class="form-control" value="{{ old('promotion_name', $promotion->promotion_name) }}" required>
            </div>
            <div class="form-group">
                <label for="promotion_discount">ส่วนลด</label>
                <input type="number" step="0.01" name="promotion_discount" id="promotion_discount" class="form-control" value="{{ old('promotion_discount', $promotion->promotion_discount) }}" required>
            </div>
            <div class="form-group">
                <label for="promotion_start">วันที่เริ่มโปรโมชัน</label>
                <input type="date" name="promotion_start" id="promotion_start" class="form-control" value="{{ old('promotion_start', $promotion->promotion_start) }}" required>
            </div>
            <div class="form-group">
                <label for="promotion_end">วันที่สิ้นสุดโปรโมชัน</label>
                <input type="date" name="promotion_end" id="promotion_end" class="form-control" value="{{ old('promotion_end', $promotion->promotion_end) }}" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">แก้ไข</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-theme">ย้อนกลับ</a>
        </div>
    </form>
</div>
@endsection