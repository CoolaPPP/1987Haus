@extends('admin.layouts.app')

@section('title', 'Add Order Status')

@section('content-header', 'หน้าเพิ่มข้อมูลสถานะคำสั่งซื้อ')

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
            <a href="{{ route('admin.order-statuses.index') }}" class="btn btn-outline-theme">ย้อนกลับ</a>
        </div>
    </form>
</div>
@endsection