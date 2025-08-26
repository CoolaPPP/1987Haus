@extends('admin.layouts.app')

@section('title', 'Shipping Addresses')

@section('content-header', 'หน้าแสดงที่อยู่จัดส่งของลูกค้า')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ข้อมูลที่อยู่สำหรับจัดส่งสินค้าทั้งหมด</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสที่อยู่</th>
                    <th>ชื่อลูกค้า</th>
                    <th>ที่อยู่</th>
                    <th>ข้อมูลที่อยู่เพิ่มเติม</th>
                    <!-- <th>Created At</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse($addresses as $address)
                <tr>
                    <td>{{ $address->id }}</td>
                    <td>{{ $address->customer->name }}</td>
                    <td>{{ $address->address }}</td>
                    <td>{{ $address->address_note ?? 'N/A' }}</td>
                    <!-- <td>{{ $address->created_at->format('d M Y, H:i') }}</td> -->
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่พบที่อยู่ในระบบ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $addresses->links() }}
    </div>
</div>
@endsection