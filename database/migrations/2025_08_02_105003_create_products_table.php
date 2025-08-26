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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('product_name'); 

        //Product_Type (FK)
        $table->foreignId('producttype_id')
              ->constrained('product_types') 
              ->onDelete('cascade'); 

        $table->decimal('product_price', 6, 2); 
        $table->string('product_pic')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
