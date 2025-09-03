@extends('admin.layouts.app')

@section('title', 'New Paid Orders')

@section('content-header', 'หน้าแสดงคำสั่งซื้อใหม่')

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
    <div class="card-header"><h3 class="card-title">คำสั่งซื้อใหม่</h3></div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสการสั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>วันที่และเวลาของการสั่งสินค้า</th>
                    <th>ราคาสุทธิ</th>
                    <th>สถานะ</th>
                    <th>แสดงข้อมูลการชำระเงิน</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $imageKit = new \ImageKit\ImageKit(
                        env('IMAGEKIT_PUBLIC_KEY'),
                        env('IMAGEKIT_PRIVATE_KEY'),
                        env('IMAGEKIT_URL_ENDPOINT')
                    );
                @endphp
                @forelse($newOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->order_datetime->format('d M Y, H:i') }}</td>
                    <td>฿{{ number_format($order->net_price, 2) }}</td>
                    <td>
                        @if($order->order_status_id == 2)
                            <span class="badge bg-secondary">ยังไม่เตรียมสินค้า</span>
                        @elseif($order->order_status_id == 6)
                            <span class="badge bg-success">กำลังเตรียมสินค้า</span>
                        @endif
                    </td>
                    <td>
                        @if($order->payment && $order->payment->payment_pic)
                            <a href="#" class="btn btn-sm btn-outline-theme" 
                               data-bs-toggle="modal" 
                               data-bs-target="#imageModal" 
                               data-image="{{ $imageKit->url(['path' => $order->payment->payment_pic]) }}"
                               data-payment-id="{{ $order->payment->id }}">
                               แสดงสลิป
                            </a>
                        @else
                            <span class="text-muted">ไม่มีข้อมูล</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-theme">รายละเอียด</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">ไม่มีข้อมูลคำสั่งซื้อใหม่</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $newOrders->links() }}</div>
</div>
<div class="px-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-theme">
        กลับไปยังหน้าจัดการการขาย
    </a>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">แสดงสลิป</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid" alt="Full-size slip">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imageUrl = button.data('image');
        var modal = $(this);
        modal.find('.modal-body #modalImage').attr('src', imageUrl);
    });
</script>
@endpush