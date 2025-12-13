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
        // Add webhook columns to website_chat_widgets table (if not exists)
        if (!Schema::hasColumn('website_chat_widgets', 'webhook_url')) {
            Schema::table('website_chat_widgets', function (Blueprint $table) {
                $table->string('webhook_url')->nullable()->after('quick_replies');
                $table->string('webhook_secret')->nullable()->after('webhook_url');
                $table->boolean('webhook_enabled')->default(false)->after('webhook_secret');
                $table->json('webhook_events')->nullable()->after('webhook_enabled');
            });
        }

        // Add webhook_enabled column to website_chat_visitors table (if not exists)
        if (!Schema::hasColumn('website_chat_visitors', 'webhook_forward_enabled')) {
            Schema::table('website_chat_visitors', function (Blueprint $table) {
                $table->boolean('webhook_forward_enabled')->default(true)->after('is_online');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_chat_widgets', function (Blueprint $table) {
            $table->dropColumn(['webhook_url', 'webhook_secret', 'webhook_enabled', 'webhook_events']);
        });

        Schema::table('website_chat_visitors', function (Blueprint $table) {
            $table->dropColumn('webhook_forward_enabled');
        });
    }
};
