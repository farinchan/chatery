<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class WebsiteChatWidget extends Model
{
    protected $table = 'website_chat_widgets';

    protected $fillable = [
        'team_id',
        'widget_id',
        'widget_name',
        'widget_title',
        'widget_subtitle',
        'welcome_message',
        'primary_color',
        'secondary_color',
        'position',
        'allowed_domains',
        'operating_hours',
        'quick_replies',
        'is_active',
        'require_email',
        'require_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'require_email' => 'boolean',
        'require_name' => 'boolean',
        'allowed_domains' => 'array',
        'operating_hours' => 'array',
        'quick_replies' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->widget_id)) {
                $model->widget_id = Str::uuid()->toString();
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(WebsiteChatVisitor::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(WebsiteChatLog::class);
    }

    public function getEmbedScriptUrl(): string
    {
        return url("/api/webchat/widget/{$this->widget_id}/script.js");
    }

    public function getEmbedCode(): string
    {
        $scriptUrl = $this->getEmbedScriptUrl();
        return "<script src=\"{$scriptUrl}\" async></script>";
    }

    public function isWithinOperatingHours(): bool
    {
        if (empty($this->operating_hours)) {
            return true; // Always open if not set
        }

        $now = now();
        $dayOfWeek = strtolower($now->format('l'));

        if (!isset($this->operating_hours[$dayOfWeek])) {
            return false;
        }

        $hours = $this->operating_hours[$dayOfWeek];
        if (!$hours['enabled']) {
            return false;
        }

        $currentTime = $now->format('H:i');
        return $currentTime >= $hours['start'] && $currentTime <= $hours['end'];
    }

    public function getUnreadMessagesCount(): int
    {
        return WebsiteChatMessage::whereHas('visitor', function ($query) {
            $query->where('website_chat_widget_id', $this->id);
        })->where('is_read', false)->where('direction', 'incoming')->count();
    }

    public function getOnlineVisitorsCount(): int
    {
        return $this->visitors()->where('is_online', true)->count();
    }
}
