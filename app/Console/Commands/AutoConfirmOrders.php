<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderConfirm;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AutoConfirmOrders extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'orders:autoconfirm';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'การยืนยันรับสินค้าอัตโนมัติจะทำงานเมื่อมีข้อมูลที่มีสถานะ "กำลังจัดส่ง" ผ่านไปแล้ว 24 ชั่วโมง';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('เริ่มการยืนยันรับสินค้าอัตโนมัติ. . . .');

        // 1. ค้นหา Order ที่ "กำลังจัดส่ง" (status=3) และถูกอัปเดตสถานะนี้นานกว่า 24 ชั่วโมง
        $ordersToConfirm = Order::where('order_status_id', 3)
            ->where('updated_at', '<=', Carbon::now()->subDay())
            ->get();

        if ($ordersToConfirm->isEmpty()) {
            $this->info('ไม่พบข้อมูลการสั่งที่ต้องการยืนยันอัตโนมัติ');
            return;
        }

        foreach ($ordersToConfirm as $order) {
            DB::transaction(function () use ($order) {
                // 2. สร้าง Record ใน order_confirms
                OrderConfirm::create([
                    'payment_id' => $order->payment->id,
                    'customer_id' => $order->customer_id,
                    'orderconfirmed_status' => 1, // 1 = ได้รับสินค้าแล้ว (สถานะอัตโนมัติ)
                    'orderconfirm_datetime' => now(),
                ]);

                // 3. อัปเดตสถานะ Order เป็น "จัดส่งสำเร็จ" (ID: 5)
                $order->update(['order_status_id' => 5]);

                $this->info("การสั่ง #{$order->id} ถูกยืนยันรับสินค้าอัตโนมัติแล้ว");
            });
        }
        
        $this->info('การยืนยันรับสินค้าอัตโนมัติเสร็จสิ้น');
    }
}