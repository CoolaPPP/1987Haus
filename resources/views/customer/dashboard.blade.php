@extends('layouts.app')

@section('title', '1987 Haus | Customer Dashboard')

@section('content')
<style>
    .card {
        background-color: #f8f3d9;
        border: 1px solid #ebe5c2;
    }
    .card-header {
        background-color: #504b38;
        color: #f8f3d9;
        font-weight: bold;
    }
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
    .address-card {
        background-color: #ebe5c2;
        border: 1px solid #b9b28a;
        border-radius: 8px;
    }

    .table-custom {
        background-color: #f8f3d9;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-custom thead {
        background-color: #504b38;
        color: #f8f3d9;
        font-weight: bold;
    }

    .table-custom tbody tr {
        background-color: #ebe5c2;
        transition: background-color 0.3s ease;
    }

    .table-custom tbody tr:nth-child(even) {
        background-color: #f8f3d9;
    }

    .table-custom tbody tr:hover {
        background-color: #b9b28a;
        color: #504b38;
    }

    .table-custom td, 
    .table-custom th {
        vertical-align: middle;
    }

    .table-custom .btn-sm {
        font-size: 0.8rem;
        border-radius: 6px;
    }
    .page-link {
    background-color: #b9b28a;
    color: #504b38;
    border-radius: 8px;
    border: none;
    margin: 0 3px;
    }

    .page-link:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }

    .page-item.active .page-link {
    background-color: #504b38;  /* โทนเข้ม */
    color: #f8f3d9;            /* ตัวอักษรอ่อน */
    font-weight: bold;
    border: none;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 pt-3">
            <div class="card shadow-sm">
                <div class="card-header">หน้าข้อมูลส่วนตัว</div>
                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <h3 class="fw-bold mb-2" style="color: #504b38;">ยินดีต้อนรับ คุณ {{ $customer->name }}!</h3>
                    <p class="text-muted">เข้าสู่ระบบสําเร็จ</p>

                    @if(session('success'))
                        <div class="alert alert-success" style="background-color: #b9b28a; color: #504b38;">{{ session('success') }}</div>
                    @endif 
                    @if(session('error'))
                        <div class="alert alert-danger" style="background-color: #b94a48; color: #fff;">{{ session('error') }}</div>
                    @endif
                    
                    <hr>
                    <h4 class="fw-bold mb-3" style="color: #504b38;">ข้อมูลส่วนตัว</h4>
                    <ul class="list-unstyled mb-4">
                        <li><strong>ชื่อ :</strong> {{ $customer->name }}</li>
                        <li><strong>Email :</strong> {{ $customer->email }}</li>
                        <li><strong>เบอร์โทร :</strong> {{ $customer->tel ?? 'N/A' }}</li>
                    </ul>
                    <a class="btn btn-theme mb-4" href="{{ route('customer.profile.edit') }}">แก้ไขข้อมูลส่วนตัว</a>

                    <hr>
                    <h4 class="fw-bold mb-3" style="color: #504b38;">ข้อมูลที่อยู่สำหรับจัดส่งสินค้า</h4>
                    @forelse($addresses as $address)
                        <div class="p-3 mb-3 address-card">
                            <p><strong>ที่อยู่</strong><br>{{ $address->address }}</p>
                            @if($address->address_note)
                                <p><strong>ข้อมูลที่อยู่เพิ่มเติม</strong><br>{{ $address->address_note }}</p>
                            @endif

                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-outline-theme btn-sm">แก้ไข</a>
                            @if($addresses->count() > 1)
                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('คุณต้องการลบที่อยู่นี้หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">ยังไม่พบที่อยู่สำหรับจัดส่งสินค้า</p>
                    @endforelse

                    <a href="{{ route('addresses.create') }}" class="btn btn-theme mt-2 mb-4">เพิ่มที่อยู่จัดส่ง</a>

                    <hr>
                    <h4 class="fw-bold mb-3" style="color: #504b38;">ประวัติการสั่งซื้อ</h4>
                    <div class="table-responsive shadow-sm">
                        <table class="table table-bordered align-middle text-center table-custom">
                            <thead>
                                <tr>
                                    <th>รหัสการสั่งสินค้า</th>
                                    <th>วันที่และเวลาที่สั่ง</th>
                                    <th>ราคาสุทธิ</th>
                                    <th>สถานะ</th>
                                    <th>การดำเนินการ</th>
                                    <th>แสดงใบเสร็จ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->order_datetime->format('d M Y, H:i') }}</td>
                                        <td>฿{{ number_format($order->net_price, 2) }}</td>
                                        <td>
                                            <!-- 1 = สั่งสินค้าสำเร็จ -->
                                            <!-- 2 = ชำระเงินสำเร็จ -->
                                            <!-- 3 = กำลังจัดส่ง -->
                                            <!-- 4 = ยกเลิกการสั่ง -->
                                            <!-- 5 = จัดส่งสำเร็จ --> 
                                            <span class="badge
                                                @if($order->status->id == 1) bg-warning text-dark 
                                                @elseif($order->status->id == 2) bg-info
                                                @elseif($order->status->id == 3) bg-primary
                                                @elseif($order->status->id == 4) bg-danger text-white
                                                @else bg-success 
                                                @endif">
                                                {{ $order->status->orderstatus_name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->order_status_id == 3)
                                                <a href="{{ route('order-confirm.create', $order->id) }}" class="btn btn-sm btn-theme">ยืนยันการได้รับสินค้า</a>
                                            @elseif($order->order_status_id == 4)
                                                <span class="text-muted">-</span>
                                            @elseif(!$order->payment)
                                                <a href="{{ route('payment.create', $order->id) }}" class="btn btn-sm btn-theme">ชำระเงิน</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->payment)
                                            <a href="{{ route('customer.orders.receipt', $order->id) }}" class="btn btn-sm btn-outline-theme">ใบเสร็จ</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">คุณยังไม่มีประวัติการสั่งซื้อ</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $orders->links() }}
                    </div>

                    <hr>
                    <h4 class="fw-bold mb-3" style="color: #504b38;">การยกเลิกการสั่งซื้อ</h4>
                    <div class="table-responsive shadow-sm">
                        <table class="table align-middle text-center" style="background-color: #f8f3d9; border-radius: 12px; overflow: hidden;">
                            <thead style="background-color: #504b38; color: #f8f3d9;">
                                <tr>
                                    <th>รหัสการสั่งซื้อ</th>
                                    <th>วันที่และเวลาที่ยกเลิก</th>
                                    <th>ยอดยกเลิก</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cancellations as $order)
                                    <tr style="transition: background-color 0.3s;">
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->updated_at->format('d M Y, H:i') }}</td>
                                        <td>฿{{ number_format($order->order_price, 2) }}</td>
                                        <td>
                                            <span class="badge" 
                                                style="background-color: #b94a48; color: #fff; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem;">
                                                ยกเลิกแล้ว
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted" style="padding: 20px;">
                                            ไม่มีข้อมูลการยกเลิกการสั่งซื้อ
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('order-cancel.select') }}" class="btn btn-danger">การยกเลิกการสั่งซื้อ</a>
                    <hr>
                    <form action="{{ route('logout') }}" method="POST" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
