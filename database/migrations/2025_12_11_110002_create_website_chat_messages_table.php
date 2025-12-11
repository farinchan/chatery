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
        Schema::create('website_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_chat_visitor_id')->constrained()->onDelete('cascade');
            $table->enum('direction', ['incoming', 'outgoing']); // incoming = dari visitor, outgoing = dari admin
            $table->enum('message_type', ['text', 'image', 'file', 'system'])->default('text');
            $table->text('message')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->foreignId('sent_by_user_id')->nullable()->constrained('users')->onDelete('set null'); // admin yg kirim
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_chat_messages');
    }
};
