<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
        $table->unsignedBigInteger('shippingaddress_id');
        $table->timestamp('order_datetime')->useCurrent();
        $table->foreignId('order_status_id')->constrained('order_statuses');
        $table->string('promotion_id')->nullable(); // รหัสโปรโมชัน (อาจจะไม่มี)
        $table->decimal('order_price', 10, 2); // ราคารวมก่อนหักส่วนลด
        $table->decimal('net_price', 10, 2); // ราคาสุทธิ
        $table->text('order_note')->nullable();
        $table->timestamps();

        // กำหนด Foreign Key สำหรับ shippingaddress_id และ promotion_id
        $table->foreign('shippingaddress_id')->references('id')->on('shipping_addresses')->onDelete('cascade');
        $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
