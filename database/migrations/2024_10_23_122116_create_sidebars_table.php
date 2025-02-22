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
        Schema::create('sidebars', function (Blueprint $table) {
            $table->id();
            $table->string('main_image'); // To store the main image path
            $table->text('svg_1'); // To store SVG content for dialog 1
            $table->text('dialog_1'); // To store text for dialog 1
            $table->text('svg_2'); // To store SVG content for dialog 2
            $table->text('dialog_2'); // To store text for dialog 2
            $table->text('svg_3'); // To store SVG content for dialog 3
            $table->text('dialog_3'); // To store text for dialog 3
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebars');
    }
};
