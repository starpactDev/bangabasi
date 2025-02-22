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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->string('store_name')->nullable(); // Nullable as required
            $table->string('email')->unique()->nullable(); // Nullable as required
            $table->text('description')->nullable(); // Nullable as required
            $table->string('logo')->nullable(); // Optional logo
            $table->tinyInteger('registration_step')->default(0); // Default to 0 (not started)
            $table->tinyInteger('is_active')->default(0); // Default to 0 (inactive)
            $table->timestamps(); // Includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
