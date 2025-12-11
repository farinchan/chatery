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
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telegram_chat_id')->constrained()->onDelete('cascade');
            $table->bigInteger('message_id')->index();
            $table->enum('direction', ['incoming', 'outgoing'])->default('incoming');
            $table->enum('message_type', ['text', 'photo', 'video', 'audio', 'voice', 'document', 'sticker', 'location', 'contact', 'other'])->default('text');
            $table->text('text')->nullable();
            $table->text('caption')->nullable();
            $table->string('file_id')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->json('raw_data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['telegram_chat_id', 'message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
