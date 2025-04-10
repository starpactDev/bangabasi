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
        Schema::create('package_dimensions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->bigInteger('product_id')->unsigned(); // Foreign key to products table
            $table->decimal('length', 10, 2); // Length in cm
            $table->decimal('width', 10, 2); // Width in cm
            $table->decimal('height', 10, 2); // Height in cm
            $table->decimal('weight', 10, 2); // Weight in kg
            $table->decimal('volumetric_weight', 10, 2); // Volumetric weight in kg
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_dimensions');
    }
};
