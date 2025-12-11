<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramChat extends Model
{
    protected $table = 'telegram_chats';

    protected $fillable = [
        'telegram_bot_id',
        'chat_id',
        'chat_type',
        'title',
        'username',
        'first_name',
        'last_name',
        'photo_url',
        'is_blocked',
        'last_message_at',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'last_message_at' => 'datetime',
    ];

    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TelegramMessage::class);
    }

    public function getDisplayName(): string
    {
        if ($this->chat_type === 'private') {
            $name = trim($this->first_name . ' ' . $this->last_name);
            return $name ?: ($this->username ?: 'Unknown User');
        }
        return $this->title ?: 'Unknown Chat';
    }

    public function getPhotoAttribute(): string
    {
        $value = $this->photo_url;
        if ($value && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
            return $value;
        }
        return $value ? asset('storage/' . $value) : "https://ui-avatars.com/api/?background=0088cc&color=fff&size=128&name=" . urlencode($this->getDisplayName());
    }

    public function unreadCount(): int
    {
        return $this->messages()->where('is_read', false)->where('direction', 'incoming')->count();
    }

    public function lastMessage()
    {
        return $this->messages()->latest('sent_at')->first();
    }
}
