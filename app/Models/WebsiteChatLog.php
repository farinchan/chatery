<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteChatLog extends Model
{
    protected $table = 'website_chat_logs';

    protected $fillable = [
        'website_chat_widget_id',
        'website_chat_visitor_id',
        'type',
        'action',
        'data',
        'ip_address',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function widget(): BelongsTo
    {
        return $this->belongsTo(WebsiteChatWidget::class, 'website_chat_widget_id');
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(WebsiteChatVisitor::class, 'website_chat_visitor_id');
    }

    public static function log(
        int $widgetId,
        string $type,
        string $action,
        array $data = [],
        ?int $visitorId = null,
        ?string $ipAddress = null
    ): self {
        return self::create([
            'website_chat_widget_id' => $widgetId,
            'website_chat_visitor_id' => $visitorId,
            'type' => $type,
            'action' => $action,
            'data' => $data,
            'ip_address' => $ipAddress,
        ]);
    }
}
