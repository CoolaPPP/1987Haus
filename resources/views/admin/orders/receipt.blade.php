<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt for Order #{{ $order->id }}</title>
    {{-- เพิ่ม CSRF Token สำหรับ JavaScript --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        .receipt-container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        
        /* ซ่อนส่วนควบคุมเมื่อพิมพ์ */
        @media print {
            .no-print { display: none !important; }
            .receipt-container { border: none; }
        }
        @media print { .no-print { display: none !important; } .receipt-container { border: none; } }
    </style>
</head>
<body>
    {{-- ส่วนควบคุมการพิมพ์ (จะไม่แสดงตอนพิมพ์) --}}
    <div class="container text-center my-3 no-print">
        <h3>แสดงตัวอย่างใบปะหน้าสินค้า</h3>
        <p>ตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการพิมพ์</p>
        {{-- เปลี่ยนข้อความปุ่มตามสถานะ --}}
        <button id="printButton" 
                class="btn btn-lg btn-success" 
                data-status="{{ $order->order_status_id }}" 
                data-redirect-url="{{ route('admin.orders.new') }}">
            @if($order->order_status_id = 6)
                ยินยันและพิมพ์ใบปะหน้าสินค้า
            @else
                พิมพ์ซ้ำ 
            @endif
        </button>
    </div>

    <div class="receipt-container">
        <h2 class="text-center">1987 Haus</h2>
        <p class="text-center">เบอร์โทรศัพท์ของร้าน : {{ $owner->tel ?? 'N/A' }}</p>
        <hr>
        <h4>คำสั่งซื้อลำดับที่ #{{ $order->id }}</h4>
        <p><strong>วันที่และเวลาที่สั่ง : </strong> {{ $order->order_datetime }}</p>
        <hr>
        <h4>ข้อมูลลูกค้า</h4>
        <p>
            <strong>ชื่อ : </strong> {{ $order->customer->name }}<br>
            <strong>เบอร์โทรศัพท์ : </strong> {{ $order->customer->tel ?? 'N/A' }}<br>
            <strong>ที่อยู่จัดส่ง : </strong> {{ $order->shippingAddress->address }}<br>
            <strong>ข้อมูลที่อยู่เพิ่มเติม : </strong> {{ $order->shippingAddress->address_note }}
        </p>
        <hr>
        <h4>รายละเอียดคําสั่งซื้อ</h4>
        <table class="table table-sm">
            <thead><tr><th>ชื่อสินค้า</th><th class="text-center">จำนวน</th><th class="text-right">ราคาต่อหน่วย</th><th class="text-right">ราคารวม</th></tr></thead>
            <tbody>
                @foreach($order->details as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">฿ {{ number_format($detail->product_price, 2) }}</td>
                    <td class="text-right">฿ {{ number_format($detail->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <h5>ข้อความเพิ่มเติม</h5>
        <strong>{{ $order->order_note ?? 'N/A' }}</strong>
        <hr>
        <div class="row">
            <div class="col-6 offset-6">
                <p><strong>ราคารวมทั้งหมด</strong> <span class="float-right">฿ {{ number_format($order->order_price, 2) }}</span></p>
                @if($order->promotion_id)
                    @php $discount = $order->order_price - $order->net_price; @endphp
                    <p><strong>ส่วนลด ({{ $order->promotion_id }}) </strong> <span class="float-right">- ฿ {{ number_format($discount, 2) }}</span></p>
                @endif
                <hr>
                <h4><strong>ราคาสุทธิ</strong> <span class="float-right">฿ {{ number_format($order->net_price, 2) }}</span></h4>
            </div>
        </div>
    </div>
    
    <script>
    document.getElementById('printButton').addEventListener('click', function() {
        // ดึงค่าจาก data attribute
        const printButton = this;
        const currentStatus = parseInt(printButton.dataset.status);
        const redirectUrl = printButton.dataset.redirectUrl;
        
        const isAlreadyProcessed = currentStatus >= 3;

        // ถ้ายังไม่เคยประมวลผล
        if (!isAlreadyProcessed) {
            if (confirm('ยินยันการพิมพ์ใบปะหน้าสินค้า? หลังจากการยืนยันการพิมพ์ สถานะการสั่งจะถูกอัปเดตเป็น "จัดส่งสินค้า"')) {
                printButton.disabled = true;
                printButton.textContent = 'Processing...';

                fetch("{{ route('admin.orders.update-status', $order->id) }}", {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.print();
                        window.location.href = redirectUrl; // ใช้ URL ที่ดึงมา
                    } else {
                        alert('Error updating order status.');
                        printButton.disabled = false;
                        printButton.textContent = 'Confirm & Print';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                    printButton.disabled = false;
                    printButton.textContent = 'Confirm & Print';
                });
            }
        } 
        // ถ้าเคยประมวลผลแล้ว (พิมพ์ซ้ำ)
        else {
            window.print();
        }
    });
</script>
</body>
</html>