@extends('admin.layouts.app')

@section('title', 'Add Order Status')

@section('content-header', 'หน้าเพิ่มข้อมูลสถานะคำสั่งซื้อ')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">เพิ่มข้อมูลสถานะคำสั่งซื้อ</h3></div>
    <form action="{{ route('admin.order-statuses.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="orderstatus_name">ชื่อสถานะคำสั่งซื้อ</label>
                <input type="text" name="orderstatus_name" id="orderstatus_name" class="form-control" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">ยืนยัน</button>
            <a href="{{ route('admin.order-statuses.index') }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection