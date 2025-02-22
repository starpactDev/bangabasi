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
        Schema::create('order_responses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->string('channel_order_id');
            $table->bigInteger('shipment_id')->nullable();
            $table->string('status');
            $table->integer('status_code');
            $table->boolean('onboarding_completed_now');
            $table->string('awb_code')->nullable();
            $table->string('courier_company_id')->nullable();
            $table->string('courier_name')->nullable();
            $table->boolean('new_channel');
            $table->string('packaging_box_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_responses');
    }
};
