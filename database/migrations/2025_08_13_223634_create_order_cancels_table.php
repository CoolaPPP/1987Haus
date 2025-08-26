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
        Schema::create('order_cancels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer');
            $table->foreignId('order_id')->unique()->constrained('orders');
            $table->decimal('cancel_price', 10, 2);
            $table->timestamp('cancel_datetime')->useCurrent();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cancels');
    }
};
