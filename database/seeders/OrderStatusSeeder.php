<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- เพิ่ม use statement นี้

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ล้างข้อมูลเก่าก่อน (ถ้ามี) เพื่อป้องกันข้อมูลซ้ำซ้อน
        DB::table('order_statuses')->delete();

        // เพิ่มข้อมูลสถานะเริ่มต้น
        DB::table('order_statuses')->insert([
            ['id' => 1, 'orderstatus_name' => 'สั่งสินค้าสำเร็จ'],
            ['id' => 2, 'orderstatus_name' => 'ชำระเงินสำเร็จ'],
            ['id' => 3, 'orderstatus_name' => 'กำลังจัดส่ง'],
            ['id' => 4, 'orderstatus_name' => 'ยกเลิกการสั่ง'],
            ['id' => 5, 'orderstatus_name' => 'จัดส่งสำเร็จ'],
        ]);
    }
}