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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigint('id')->autoIncrement(); 
            $table->bigint('product_id'); 
            $table->string(20)('sku')->nullable(); 
            $table->integer('quantity')->nullable(); 
            $table->double('unit_price')->nullable(); 
            $table->timestamp('created_at')->nullable(); 
            $table->timestamp('updated_at')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
