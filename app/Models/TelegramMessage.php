<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramMessage extends Model
{
    protected $table = 'telegram_messages';

    protected $fillable = [
        'telegram_chat_id',
        'message_id',
        'direction',
        'message_type',
        'text',
        'caption',
        'file_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'raw_data',
        'is_read',
        'sent_at',
    ];

    protected $casts = [
        'raw_data' => 'array',
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function telegramChat(): BelongsTo
    {
        return $this->belongsTo(TelegramChat::class);
    }

    public function isOutgoing(): bool
    {
        return $this->direction === 'outgoing';
    }

    public function isIncoming(): bool
    {
        return $this->direction === 'incoming';
    }

    public function getFormattedTime(): string
    {
        return $this->sent_at ? $this->sent_at->format('H:i') : '';
    }

    public function getFormattedDate(): string
    {
        if (!$this->sent_at) return '';

        if ($this->sent_at->isToday()) {
            return 'Hari Ini';
        } elseif ($this->sent_at->isYesterday()) {
            return 'Kemarin';
        } else {
            return $this->sent_at->format('d/m/Y');
        }
    }

    public function getPreviewText(): string
    {
        if ($this->message_type === 'text') {
            return mb_strlen($this->text) > 50 ? mb_substr($this->text, 0, 50) . '...' : $this->text;
        }

        $types = [
            'photo' => '📷 Foto',
            'video' => '🎬 Video',
            'audio' => '🎵 Audio',
            'voice' => '🎤 Pesan Suara',
            'document' => '📄 Dokumen',
            'sticker' => '🏷️ Sticker',
            'location' => '📍 Lokasi',
            'contact' => '👤 Kontak',
        ];

        return $types[$this->message_type] ?? '📎 Media';
    }
}
