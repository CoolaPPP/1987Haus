<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\QRCode;
use ImageKit\ImageKit;

class PaymentController extends Controller
{
     private $imageKit;

    // เพิ่ม Constructor 
    public function __construct()
    {
        $this->imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );
    }

    /**
     * แสดงหน้าชำระเงินพร้อม QR Code
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function create(Order $order)
    {
        // 1. ตรวจสอบสิทธิ์: เช็กว่า Order นี้เป็นของลูกค้าที่ล็อกอินอยู่หรือไม่
        abort_if($order->customer_id !== Auth::id(), 403, 'Unauthorized action.');

        // 2. ตรวจสอบสถานะ: อนุญาตให้จ่ายเงินได้เฉพาะ Order ที่มีสถานะเป็น 1 (สั่งสำเร็จ/ยังไม่จ่ายเงิน) เท่านั้น
        abort_if($order->order_status_id != 1, 403, 'การสั่งซื้อนี้ไม่สามารถชำระเงินได้ อาจจะถูกชำระเงินแล้วหรือถูกยกเลิกไปแล้ว.');


        // ** แก้ไขเป็นเบอร์ PromptPay หรือเลขบัตรประชาชน/ผู้เสียภาษีของคุณ **
        $promptPayId = env('PROMPTPAY_ID'); // ตัวอย่างเบอร์ PromptPay
        $amount = $order->net_price;

        // 3. สร้าง Payload และ QR Code
        $payload = $this->generatePromptPayPayload($promptPayId, $amount);
        $qrCodeData = (new QRCode)->render($payload);

        // 4. ส่งข้อมูลไปยัง View
        return view('payment.create', [
            'order' => $order,
            'qrCode' => $qrCodeData,
        ]);
    }

    /**
     * บันทึกข้อมูลการชำระเงินและอัปเดตสถานะ Order
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Order $order)
    {
            // ตรวจสอบสิทธิ์
        abort_if($order->customer_id !== Auth::id(), 403);
        
        // ตรวจสอบสถานะ (เหมือนกับข้างบน)
        abort_if($order->order_status_id != 1, 403, 'การสั่งซื้อนี้ไม่สามารถชำระเงินได้ อาจจะถูกชำระเงินแล้วหรือถูกยกเลิกไปแล้ว.');

        // ตรวจสอบข้อมูลที่ส่งมา (ต้องมีไฟล์รูปสลิป)
        $request->validate([
            'payment_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ใช้ DB Transaction เพื่อให้มั่นใจว่าทุกอย่างจะสำเร็จทั้งหมด หรือไม่สำเร็จเลย
        DB::transaction(function () use ($request, $order) {
            // 1. อัปโหลดสลิป
            // $path = $request->file('payment_pic')->store('payments', 'public');
            // $path = $request->file('payment_pic')->store('payments');
            // $filename = basename($path);
            $file_base64 = base64_encode(file_get_contents($request->file('payment_pic')));
            $uploadResult = $this->imageKit->upload([
                'file' => 'data:image/png;base64,' . $file_base64,
                'fileName' => 'slip_' . $order->id . '_' . uniqid() . '.' . $request->file('payment_pic')->extension(),
                'folder' => '/1987haus/payments/', // โฟลเดอร์สำหรับเก็บสลิป
            ]);

            // 2. สร้าง record ในตาราง payments
            Payment::create([
                'order_id' => $order->id,
                'customer_id' => Auth::id(),
                'payment_pic' => $uploadResult->result->filePath, // <-- ใช้ filePath จาก ImageKit
                'payment_datetime' => now(),
            ]);

            // 3. อัปเดตสถานะในตาราง orders เป็น 'ชำระเงินสำเร็จ' (ID: 2)
            $order->update(['order_status_id' => 2]);
        });

        return redirect()->route('customer.dashboard')->with('success', 'การชำระเงินสำเร็จแล้ว ขอขอบคุณเป็นอย่างสูง.');
    }


    /**
     * ฟังก์ชันสำหรับสร้าง Payload ของ PromptPay (เวอร์ชันแก้ไข CRC16)
     * @param string $id
     * @param float|null $amount
     * @return string
     */
    private function generatePromptPayPayload(string $id, ?float $amount = null): string
{
    // ลบขีด
    $id = str_replace('-', '', $id);

    // แปลงเบอร์โทรเป็นรูปแบบ 0066xxxxxxx
    if (strlen($id) === 10 && is_numeric($id)) {
        $merchantId = '0066' . substr($id, 1);
        $type = '01'; // Phone number
    }
    // ถ้าเป็นเลขบัตรประชาชน/เลขภาษี (13 หลัก)
    elseif (strlen($id) === 13 && is_numeric($id)) {
        $merchantId = $id;
        $type = '02'; // National ID
    } else {
        throw new \Exception('Invalid PromptPay ID format.');
    }

    // Merchant Account Info (29)
    // AID = 00 16 A000000677010111
    $merchantAccount = '00' . '16' . 'A000000677010111'
                     . $type . str_pad(strlen($merchantId), 2, '0', STR_PAD_LEFT) . $merchantId;

    // สร้าง Payload
    $payload  = '00' . '02' . '01'; // Payload Format Indicator
    $payload .= '01' . '02' . ($amount ? '12' : '11'); // Point of Initiation
    $payload .= '29' . str_pad(strlen($merchantAccount), 2, '0', STR_PAD_LEFT) . $merchantAccount; // Merchant Info
    $payload .= '53' . '03' . '764'; // Currency (THB)
    if ($amount) {
        $amt = number_format($amount, 2, '.', '');
        $payload .= '54' . str_pad(strlen($amt), 2, '0', STR_PAD_LEFT) . $amt;
    }
    $payload .= '58' . '02' . 'TH'; // Country

    // เติมช่อง CRC
    $payload .= '63' . '04';

    // คำนวณ CRC16-CCITT
    $crc = 0xFFFF;
    for ($i = 0; $i < strlen($payload); $i++) {
        $crc ^= (ord($payload[$i]) << 8);
        for ($j = 0; $j < 8; $j++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ 0x1021;
            } else {
                $crc <<= 1;
            }
            $crc &= 0xFFFF;
        }
    }

    $payload .= strtoupper(sprintf('%04X', $crc));

    return $payload;
}
}