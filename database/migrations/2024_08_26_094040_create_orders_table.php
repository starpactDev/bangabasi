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
            $table->bigint('id')->autoIncrement(); 
            $table->bigint('user_id'); 
            $table->bigint('address_id'); 
            $table->string(255)('unique_id'); 
            $table->double('price'); 
            $table->string(255)('payment_method')->nullable(); 
            $table->string(255)('online_payment_id')->nullable(); 
            $table->string(255)('status'); 
            $table->text('additional_info')->nullable(); 
            $table->timestamp('created_at')->nullable(); 
            $table->timestamp('updated_at')->nullable(); 
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
