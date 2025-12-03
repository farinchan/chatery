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
        Schema::create('whatsapp_session_users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['owner', 'agent', 'member'])->default('member');
            $table->foreignId('whatsapp_session_id')->constrained('whatsapp_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'blocked', 'pending'])->default('pending');
            $table->text('session_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_session_users');
    }
};
