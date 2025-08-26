@extends('admin.layouts.app')

@section('title', 'Promotions')

@section('content-header', 'หน้าจัดการข้อมูลโปรโมชัน')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">โปรโมชันทั้งหมด</h3>
        <div class="card-tools">
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">เพิ่มโปรโมชัน</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead><tr><th>รหัสโปรโมชัน</th><th>ชื่อโปรโมชัน</th><th>ส่วนลด</th><th>วันที่เริ่มโปรโมชัน</th><th>วันที่สิ้นสุดโปรโมชัน</th><th>การจัดการข้อมูล</th></tr></thead>
            <tbody>
                @foreach($promotions as $promo)
                <tr>
                    <td><code>{{ $promo->id }}</code></td>
                    <td>{{ $promo->promotion_name }}</td>
                    <td>{{ number_format($promo->promotion_discount, 2) }}</td>
                    <td>{{ $promo->promotion_start }}</td>
                    <td>{{ $promo->promotion_end }}</td>
                    <td>
                        <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                        <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
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
    <div class="card-footer">{{ $promotions->links() }}</div>
</div>
@endsection