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
        Schema::table('users', function (Blueprint $table) {
            // Remove the existing 'name' column
            $table->dropColumn('name');

            // Add 'firstname' and 'lastname' columns
            $table->string('firstname')->after('id');
            $table->string('lastname')->after('firstname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop 'firstname' and 'lastname' columns
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');

            // Add back the 'name' column
            $table->string('name')->after('id');
        });
    }
};
