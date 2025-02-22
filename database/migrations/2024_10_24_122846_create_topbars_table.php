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
        Schema::create('topbars', function (Blueprint $table) {
            $table->id();
            $table->enum('layout_type', ['layout1', 'layout2']);
            $table->string('banner_image')->nullable();
            $table->string('overlay_text_heading')->nullable();
            $table->text('overlay_text_body')->nullable();
    
            // Category foreign keys referencing the 'categories' table
            $table->foreignId('category_1_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('category_2_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('category_3_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('category_4_id')->nullable()->constrained('categories')->onDelete('set null');
    
            // Images for layout 2
            $table->string('section_1_image')->nullable();
            $table->string('section_2_image')->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topbars');
    }
};
