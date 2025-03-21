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
        Schema::create('checkout_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->json('cart_data'); // Serialized cart details
            $table->double('total_price');
            $table->double('coupon_discount')->nullable();
            $table->double('shipping_fee');
            $table->double('platform_fee');
            $table->double('final_amount'); // Final payable amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_sessions');
    }
};
