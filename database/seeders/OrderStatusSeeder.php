<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class OrderStatusSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('order_statuses')->delete();

        DB::table('order_statuses')->insert([
            ['id' => 1, 'orderstatus_name' => 'สั่งสินค้าสำเร็จ'],
            ['id' => 2, 'orderstatus_name' => 'ชำระเงินสำเร็จ'],
            ['id' => 3, 'orderstatus_name' => 'กำลังจัดส่ง'],
            ['id' => 4, 'orderstatus_name' => 'ยกเลิกการสั่ง'],
            ['id' => 5, 'orderstatus_name' => 'จัดส่งสำเร็จ'],
            ['id' => 6, 'orderstatus_name' => 'กำลังเตรียมสินค้า'],
        ]);
    }
}