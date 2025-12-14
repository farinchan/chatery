<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Free Tier',
                'slug' => 'free-tier',
                'description' => 'Paket gratis untuk memulai dengan fitur dasar',
                'price' => 0,
                'billing_cycle' => 'lifetime',
                'badge_color' => '#6c757d',
                'icon' => 'abstract-26',
                'max_members' => 2,
                'max_whatsapp_sessions' => 1,
                'max_telegram_bots' => 1,
                'max_webchat_widgets' => 1,
                'max_messages_per_day' => 100,
                'message_history_days' => 7,
                'has_api_access' => false,
                'has_webhook' => false,
                'has_bulk_message' => false,
                'has_auto_reply' => false,
                'has_analytics' => false,
                'has_export' => false,
                'has_priority_support' => false,
                'has_custom_branding' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'description' => 'Paket untuk bisnis kecil dengan fitur lebih lengkap',
                'price' => 99000,
                'billing_cycle' => 'monthly',
                'badge_color' => '#C0C0C0',
                'icon' => 'abstract-24',
                'max_members' => 5,
                'max_whatsapp_sessions' => 3,
                'max_telegram_bots' => 3,
                'max_webchat_widgets' => 3,
                'max_messages_per_day' => 500,
                'message_history_days' => 30,
                'has_api_access' => true,
                'has_webhook' => true,
                'has_bulk_message' => false,
                'has_auto_reply' => true,
                'has_analytics' => false,
                'has_export' => false,
                'has_priority_support' => false,
                'has_custom_branding' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'description' => 'Paket untuk bisnis menengah dengan fitur lengkap',
                'price' => 249000,
                'billing_cycle' => 'monthly',
                'badge_color' => '#FFD700',
                'icon' => 'abstract-21',
                'max_members' => 15,
                'max_whatsapp_sessions' => 10,
                'max_telegram_bots' => 10,
                'max_webchat_widgets' => 10,
                'max_messages_per_day' => 2000,
                'message_history_days' => 90,
                'has_api_access' => true,
                'has_webhook' => true,
                'has_bulk_message' => true,
                'has_auto_reply' => true,
                'has_analytics' => true,
                'has_export' => true,
                'has_priority_support' => false,
                'has_custom_branding' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'description' => 'Paket premium untuk bisnis besar dengan fitur prioritas',
                'price' => 499000,
                'billing_cycle' => 'monthly',
                'badge_color' => '#E5E4E2',
                'icon' => 'crown',
                'max_members' => 50,
                'max_whatsapp_sessions' => -1, // Unlimited
                'max_telegram_bots' => -1, // Unlimited
                'max_webchat_widgets' => -1, // Unlimited
                'max_messages_per_day' => -1, // Unlimited
                'message_history_days' => 365,
                'has_api_access' => true,
                'has_webhook' => true,
                'has_bulk_message' => true,
                'has_auto_reply' => true,
                'has_analytics' => true,
                'has_export' => true,
                'has_priority_support' => true,
                'has_custom_branding' => false,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Diamond',
                'slug' => 'diamond',
                'description' => 'Paket enterprise dengan semua fitur tanpa batas',
                'price' => 999000,
                'billing_cycle' => 'monthly',
                'badge_color' => '#B9F2FF',
                'icon' => 'diamond',
                'max_members' => -1, // Unlimited
                'max_whatsapp_sessions' => -1, // Unlimited
                'max_telegram_bots' => -1, // Unlimited
                'max_webchat_widgets' => -1, // Unlimited
                'max_messages_per_day' => -1, // Unlimited
                'message_history_days' => -1, // Unlimited
                'has_api_access' => true,
                'has_webhook' => true,
                'has_bulk_message' => true,
                'has_auto_reply' => true,
                'has_analytics' => true,
                'has_export' => true,
                'has_priority_support' => true,
                'has_custom_branding' => true,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }
    }
}
