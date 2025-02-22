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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigint('id')->autoIncrement(); 
            $table->bigint('order_id'); 
            $table->bigint('product_id'); 
            $table->string(20)('sku')->nullable(); 
            $table->integer('quantity')->nullable(); 
            $table->double('unit_price')->nullable(); 
            $table->timestamp('created_at')->nullable(); 
            $table->timestamp('updated_at')->nullable(); 
            $table->string(255)('status')->nullable(); 
            $table->string(255)('order_status')->default('pending'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
