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
        Schema::create('order_item_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_item_id'); // Foreign key to the order_items table
            $table->bigInteger('seller_id'); // Seller's ID (which seller is selling this item)
            
            // Breakdown details for the item
            $table->double('platform_fee')->nullable(); // Platform fee for the specific item
            $table->double('shipping_charge')->nullable(); // Shipping charge applied to the item
            $table->double('coupon_discount')->nullable(); // Coupon discount for this item
            $table->double('item_total')->nullable(); // Total price of the item (after any discounts or adjustments)
            $table->double('amount_to_seller'); // Amount the seller gets after deductions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_breakdowns');
    }
};
