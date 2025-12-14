<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'max_members' => 'integer',
        'max_whatsapp_sessions' => 'integer',
        'max_telegram_bots' => 'integer',
        'max_webchat_widgets' => 'integer',
        'max_messages_per_day' => 'integer',
        'message_history_days' => 'integer',
        'has_api_access' => 'boolean',
        'has_webhook' => 'boolean',
        'has_bulk_message' => 'boolean',
        'has_auto_reply' => 'boolean',
        'has_analytics' => 'boolean',
        'has_export' => 'boolean',
        'has_priority_support' => 'boolean',
        'has_custom_branding' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get all teams using this package
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->price == 0) {
            return 'Gratis';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get billing cycle label
     */
    public function getBillingCycleLabelAttribute()
    {
        return match($this->billing_cycle) {
            'monthly' => 'per Bulan',
            'yearly' => 'per Tahun',
            'lifetime' => 'Selamanya',
            default => $this->billing_cycle,
        };
    }

    /**
     * Check if limit is unlimited
     */
    public function isUnlimited($field)
    {
        return $this->{$field} === -1;
    }

    /**
     * Get limit display
     */
    public function getLimitDisplay($field)
    {
        $value = $this->{$field};
        return $value === -1 ? 'Unlimited' : $value;
    }

    /**
     * Get all features as array
     */
    public function getFeaturesAttribute()
    {
        return [
            'API Access' => $this->has_api_access,
            'Webhook' => $this->has_webhook,
            'Bulk Message' => $this->has_bulk_message,
            'Auto Reply' => $this->has_auto_reply,
            'Analytics' => $this->has_analytics,
            'Export Data' => $this->has_export,
            'Priority Support' => $this->has_priority_support,
            'Custom Branding' => $this->has_custom_branding,
        ];
    }

    /**
     * Get all limits as array
     */
    public function getLimitsAttribute()
    {
        return [
            'Max Members' => $this->getLimitDisplay('max_members'),
            'WhatsApp Sessions' => $this->getLimitDisplay('max_whatsapp_sessions'),
            'Telegram Bots' => $this->getLimitDisplay('max_telegram_bots'),
            'Webchat Widgets' => $this->getLimitDisplay('max_webchat_widgets'),
            'Messages/Day' => $this->getLimitDisplay('max_messages_per_day'),
            'History (Days)' => $this->getLimitDisplay('message_history_days'),
        ];
    }

    /**
     * Scope active packages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered packages
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }
}
