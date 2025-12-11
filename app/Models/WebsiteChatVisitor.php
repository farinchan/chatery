<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebsiteChatVisitor extends Model
{
    protected $table = 'website_chat_visitors';

    protected $fillable = [
        'website_chat_widget_id',
        'session_id',
        'name',
        'email',
        'phone',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'browser',
        'platform',
        'device',
        'referrer_url',
        'current_page',
        'is_online',
        'last_seen_at',
        'last_message_at',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_seen_at' => 'datetime',
        'last_message_at' => 'datetime',
    ];

    public function widget(): BelongsTo
    {
        return $this->belongsTo(WebsiteChatWidget::class, 'website_chat_widget_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WebsiteChatMessage::class);
    }

    public function getDisplayName(): string
    {
        if ($this->name) {
            return $this->name;
        }
        if ($this->email) {
            return explode('@', $this->email)[0];
        }
        return 'Visitor #' . $this->id;
    }

    public function getAvatarAttribute(): string
    {
        $name = urlencode($this->getDisplayName());
        return "https://ui-avatars.com/api/?background=0f4aa2&color=fff&size=128&name={$name}";
    }

    public function getLocationAttribute(): string
    {
        $parts = array_filter([$this->city, $this->country]);
        return implode(', ', $parts) ?: 'Unknown Location';
    }

    public function getDeviceInfoAttribute(): string
    {
        $parts = array_filter([$this->browser, $this->platform]);
        return implode(' on ', $parts) ?: 'Unknown Device';
    }

    public function unreadCount(): int
    {
        return $this->messages()->where('is_read', false)->where('direction', 'incoming')->count();
    }

    public function lastMessage()
    {
        return $this->messages()->latest('sent_at')->first();
    }

    public function markAsOnline(): void
    {
        $this->update([
            'is_online' => true,
            'last_seen_at' => now(),
        ]);
    }

    public function markAsOffline(): void
    {
        $this->update([
            'is_online' => false,
            'last_seen_at' => now(),
        ]);
    }
}
