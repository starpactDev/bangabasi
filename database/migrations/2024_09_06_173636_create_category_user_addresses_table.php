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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('firstname', 255)->nullable();
            $table->string('lastname', 255)->nullable();
            $table->string('street_name', 255)->nullable();
            $table->string('apartment', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('pin', 255)->nullable();
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Adding soft delete functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
