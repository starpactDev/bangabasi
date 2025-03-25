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
        Schema::create('order_amount_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id'); // Foreign key to the order
            // Breakdown of the order
            $table->double('platform_fee')->nullable(); // The platform fee for the order
            $table->double('shipping_charge')->nullable(); // Shipping charge for the order
            $table->double('coupon_discount')->nullable(); // Any coupon discount applied
            $table->double('total_paid_by_customer'); // Total paid by the customer (including all products, fees, and discounts)
            // Seller-specific breakdown
            $table->double('admin_fee')->nullable(); // Seller fee deducted from the seller
            $table->double('amount_to_seller'); // The final amount to be paid to the seller
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_amount_breakdowns');
    }
};
