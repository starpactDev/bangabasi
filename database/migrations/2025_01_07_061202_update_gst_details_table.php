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
        Schema::table('gst_details', function (Blueprint $table) {
            // Drop the pan_number column
            $table->dropColumn('pan_number');

            // Add the legal_name column
            $table->string('legal_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gst_details', function (Blueprint $table) {
            // Add the pan_number column back if needed
            $table->string('pan_number');

            // Drop the legal_name column
            $table->dropColumn('legal_name');
        });
    }
};
