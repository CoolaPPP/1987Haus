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
        Schema::create('order_confirms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->unique()->constrained('payments')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
            $table->tinyInteger('orderconfirmed_status'); // 1=ได้รับ, 2=ไม่ครบ, 3=ไม่ได้รับ
            $table->timestamp('orderconfirm_datetime')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_confirms');
    }
};
