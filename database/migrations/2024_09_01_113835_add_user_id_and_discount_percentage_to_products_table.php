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
        Schema::table('products', function (Blueprint $table) {
          // Add user_id after id
          $table->unsignedBigInteger('user_id')->nullable()->after('id');

          // Add discount_percentage after offer_price
          $table->decimal('discount_percentage', 5, 2)->nullable()->after('offer_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('discount_percentage');
        });
    }
};
