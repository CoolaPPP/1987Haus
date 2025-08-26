@extends('admin.layouts.app')

@section('title', 'Order Statuses')

@section('content-header', 'หน้าจัดการข้อมูลสถานะคำสั่งซื้อ')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">สถานะคำสั่งซื้อทั้งหมด</h3>
        <div class="card-tools">
            <a href="{{ route('admin.order-statuses.create') }}" class="btn btn-success">เพิ่มสถานะคำสั่งซื้อ</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10rem">รหัสสถานะคำสั่งซื้อ</th>
                    <th>ชื่อสถานะคำสั่งซื้อ</th>
                    <th style="width: 150px">การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->orderstatus_name }}</td>
                    <td>
                        <a href="{{ route('admin.order-statuses.edit', $status->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                        <form action="{{ route('admin.order-statuses.destroy', $status->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบใช่หรือไม่');">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection