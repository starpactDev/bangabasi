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
            $table->bigint('id')->autoIncrement();
            $table->bigint('user_id')->nullable();
            $table->string(255)('name');
            $table->text('tags')->nullable();
            $table->string(255)('item_code')->nullable();
            $table->string(255)('category');
            $table->string(255)('sub_category');
            $table->string(255)('collections')->nullable();
            $table->decimal(10, 2)('original_price');
            $table->decimal(10, 2)('offer_price')->nullable();
            $table->decimal(5, 2)('discount_percentage')->nullable();
            $table->text('short_description')->nullable();
            $table->text('full_details')->nullable();
            $table->tinyint('is_active')->default('1');
            $table->tinyint('in_stock')->default('1');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
