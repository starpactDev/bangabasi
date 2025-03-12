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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); // subject VARCHAR(255)
            $table->text('content'); // content TEXT
            $table->enum('status', ['sent', 'queued', 'failed', 'draft'])->default('draft'); // status ENUM
            $table->timestamp('sent_at')->nullable(); // sent_at TIMESTAMP
            $table->integer('recipient_count')->default(0); // recipient_count INT
            $table->integer('success_count')->default(0); // success_count INT
            $table->integer('failure_count')->default(0); // failure_count INT
            $table->string('from_email'); // from_email VARCHAR(255)
            $table->string('from_name'); // from_name VARCHAR(255)
            $table->enum('type', ['regular', 'promotional', 'transactional'])->default('regular'); // type ENUM
            $table->string('unsubscribe_link')->nullable(); // unsubscribe_link VARCHAR(255)
            $table->json('sent_email_ids')->nullable(); // sent_email_ids JSON (array of recipient email IDs from the newsletter_users table)
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
