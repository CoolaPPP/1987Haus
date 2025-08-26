@extends('admin.layouts.app')

@section('title', 'Add Promotion')

@section('content-header', 'หน้าเพิ่มข้อมูลโปรโมชัน')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">เพิ่มข้อมูลโปรโมชัน</h3></div>
    <form action="{{ route('admin.promotions.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="id">รหัสโปรโมชัน</label>
                <input type="text" name="id" id="id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotion_name">ชื่อโปรโมชัน</label>
                <input type="text" name="promotion_name" id="promotion_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotion_discount">ส่วนลด</label>
                <input type="number" step="0.01" name="promotion_discount" id="promotion_discount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotion_start">วันที่เริ่มโปรโมชัน</label>
                <input type="date" name="promotion_start" id="promotion_start" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotion_end">วันที่สิ้นสุดโปรโมชัน</label>
                <input type="date" name="promotion_end" id="promotion_end" class="form-control" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">ยืนยัน</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection