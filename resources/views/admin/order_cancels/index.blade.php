@extends('admin.layouts.app')

@section('title', 'Cancellation Orders')

@section('content-header', 'หน้าแสดงข้อมูลการยกเลิกการสั่งซื้อ')

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
    <div class="card-header">
        <h3 class="card-title">ข้อมูลการยกเลิกการสั่งซื้อ</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการยกเลิก</th>
                    <th>รหัสการสั่งเดิม</th>
                    <th>ชื่อลูกค้า</th>
                    <th>ยอดยกเลิก</th>
                    <th>วันที่และเวลาของการยกเลิกการสั่ง</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($cancellations as $cancel)
                <tr>
                    <td>{{ $cancel->id }}</td>
                    <td>#{{ $cancel->order_id }}</td>
                    <td>{{ $cancel->customer->name }}</td>
                    <td>฿{{ number_format($cancel->cancel_price, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($cancel->cancel_datetime)->format('d M Y, H:i') }}</td>
                    <td><a href="{{ route('admin.order-cancels.show', $cancel->id) }}" class="btn btn-sm btn-outline-theme">แสดงรายละเอียด</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">ไม่มีข้อมูลการยกเลิกการสั่งซื้อ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $cancellations->links() }}</div>
</div>
@endsection