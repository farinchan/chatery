<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramBot extends Model
{
    protected $table = 'telegram_bots';

    protected $fillable = [
        'team_id',
        'bot_token',
        'bot_username',
        'bot_name',
        'webhook_url',
        'is_active',
        'bot_info',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bot_info' => 'array',
    ];

    protected $hidden = [
        'bot_token',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(TelegramChat::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(TelegramLog::class);
    }

    public function getApiUrl(): string
    {
        return "https://api.telegram.org/bot{$this->bot_token}";
    }

    public function getMaskedToken(): string
    {
        if (strlen($this->bot_token) > 20) {
            return substr($this->bot_token, 0, 10) . '...' . substr($this->bot_token, -5);
        }
        return '***';
    }
}
