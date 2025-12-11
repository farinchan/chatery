<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteChatMessage extends Model
{
    protected $table = 'website_chat_messages';

    protected $fillable = [
        'website_chat_visitor_id',
        'direction',
        'message_type',
        'message',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'sent_by_user_id',
        'is_read',
        'read_at',
        'sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(WebsiteChatVisitor::class, 'website_chat_visitor_id');
    }

    public function sentByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
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
            return mb_strlen($this->message) > 50 ? mb_substr($this->message, 0, 50) . '...' : ($this->message ?? '');
        }

        $types = [
            'image' => '📷 Gambar',
            'file' => '📄 File',
            'system' => '⚙️ Sistem',
        ];

        return $types[$this->message_type] ?? '📎 Media';
    }

    public function getFileUrl(): ?string
    {
        if (!$this->file_path) {
            return null;
        }
        return asset('storage/' . $this->file_path);
    }

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}
