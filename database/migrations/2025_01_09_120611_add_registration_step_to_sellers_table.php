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
        Schema::table('sellers', function (Blueprint $table) {
            $table->tinyInteger('registration_step')->default(0); // Default to 0 (not started)
            $table->tinyInteger('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            Schema::table('sellers', function (Blueprint $table) {
                // Add registration_step column
                $table->dropColumn('registration_step');
                $table->dropColumn('is_active');
            });
        });
    }
};
