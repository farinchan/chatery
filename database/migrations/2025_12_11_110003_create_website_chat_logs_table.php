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
        Schema::create('website_chat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_chat_widget_id')->constrained()->onDelete('cascade');
            $table->foreignId('website_chat_visitor_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // info, warning, error
            $table->string('action'); // visitor_connected, message_sent, etc
            $table->json('data')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_chat_logs');
    }
};
