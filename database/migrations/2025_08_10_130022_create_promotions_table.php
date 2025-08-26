<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('promotion_name');
            $table->decimal('promotion_discount', 6, 2); 
            $table->date('promotion_start');
            $table->date('promotion_end');
            $table->timestamps();
        });
    }
};