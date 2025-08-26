@extends('admin.layouts.app')
@section('title', 'Customers')

@section('content-header', 'หน้าแสดงข้อมูลลูกค้า')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ข้อมูลลูกค้าทั้งหมด</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 6rem">รหัสลูกค้า</th>
                        <th>ชื่อลูกค้า</th>
                        <th>Email</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th style="width: 12rem">วันที่และเวลาที่ลงทะเบียน</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->tel ?? 'N/A' }}</td>
                        <td>{{ $customer->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">ไม่พบลูกค้าในระบบ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $customers->links() }}
    </div>
</div>
@endsection