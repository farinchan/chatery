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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free Tier, Platinum, Diamond
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'lifetime'])->default('monthly');
            $table->string('badge_color')->default('#6c757d'); // Warna badge
            $table->string('icon')->nullable(); // Icon package

            // Limits
            $table->integer('max_members')->default(5); // Max member per team
            $table->integer('max_whatsapp_sessions')->default(1);
            $table->integer('max_telegram_bots')->default(1);
            $table->integer('max_webchat_widgets')->default(1);
            $table->integer('max_messages_per_day')->default(100); // -1 for unlimited
            $table->integer('message_history_days')->default(30); // Berapa hari history disimpan

            // Features (boolean)
            $table->boolean('has_api_access')->default(false);
            $table->boolean('has_webhook')->default(false);
            $table->boolean('has_bulk_message')->default(false);
            $table->boolean('has_auto_reply')->default(true);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_export')->default(false);
            $table->boolean('has_priority_support')->default(false);
            $table->boolean('has_custom_branding')->default(false);

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
