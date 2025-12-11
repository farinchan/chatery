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
        Schema::create('website_chat_widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('widget_id')->unique(); // unique identifier untuk embed
            $table->string('widget_name')->default('Support Chat');
            $table->string('widget_title')->default('Chat Support');
            $table->string('widget_subtitle')->default('Kami siap membantu Anda');
            $table->text('welcome_message')->nullable();
            $table->string('primary_color')->default('#0f4aa2');
            $table->string('secondary_color')->default('#0fa36b');
            $table->string('position')->default('right'); // left or right
            $table->json('allowed_domains')->nullable(); // domain yang boleh pakai widget
            $table->json('operating_hours')->nullable(); // jam operasional
            $table->json('quick_replies')->nullable(); // quick reply buttons
            $table->boolean('is_active')->default(true);
            $table->boolean('require_email')->default(false);
            $table->boolean('require_name')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_chat_widgets');
    }
};
