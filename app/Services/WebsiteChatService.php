<?php

namespace App\Services;

use App\Models\WebsiteChatWidget;
use App\Models\WebsiteChatVisitor;
use App\Models\WebsiteChatMessage;
use App\Models\WebsiteChatLog;
use App\Services\WebsiteChatWebhookService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class WebsiteChatService
{
    protected WebsiteChatWidget $widget;

    public function __construct(WebsiteChatWidget $widget)
    {
        $this->widget = $widget;
    }

    public static function forWidget(WebsiteChatWidget $widget): self
    {
        return new self($widget);
    }

    /**
     * Get or create a visitor session
     */
    public function getOrCreateVisitor(
        string $sessionId,
        ?string $name = null,
        ?string $email = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?string $referrerUrl = null,
        ?string $currentPage = null
    ): WebsiteChatVisitor {
        $visitor = WebsiteChatVisitor::where('session_id', $sessionId)
            ->where('website_chat_widget_id', $this->widget->id)
            ->first();

        if ($visitor) {
            // Update visitor info
            $updateData = [
                'is_online' => true,
                'last_seen_at' => now(),
            ];

            if ($name) $updateData['name'] = $name;
            if ($email) $updateData['email'] = $email;
            if ($currentPage) $updateData['current_page'] = $currentPage;

            $visitor->update($updateData);
            return $visitor;
        }

        // Parse user agent for device info
        $deviceInfo = $this->parseUserAgent($userAgent);

        // Get location from IP (you can use geoip2 package)
        $locationInfo = $this->getLocationFromIp($ipAddress);

        $visitor = WebsiteChatVisitor::create([
            'website_chat_widget_id' => $this->widget->id,
            'session_id' => $sessionId,
            'name' => $name,
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'device' => $deviceInfo['device'],
            'country' => $locationInfo['country'],
            'city' => $locationInfo['city'],
            'referrer_url' => $referrerUrl,
            'current_page' => $currentPage,
            'is_online' => true,
            'last_seen_at' => now(),
        ]);

        // Log visitor connected
        if ($this->widget->id) {
            WebsiteChatLog::log(
                $this->widget->id,
                'info',
                'visitor_connected',
                [
                    'session_id' => $sessionId,
                    'name' => $name,
                    'email' => $email,
                ],
                $visitor->id,
                $ipAddress
            );

            // Send webhook for visitor connected
            $this->sendVisitorConnectedWebhook($visitor);
        }

        return $visitor;
    }

    /**
     * Send webhook for visitor connected
     */
    protected function sendVisitorConnectedWebhook(WebsiteChatVisitor $visitor): void
    {
        try {
            $webhookService = WebsiteChatWebhookService::forWidget($this->widget);
            $webhookService->sendVisitorConnectedWebhook($visitor);
        } catch (\Exception $e) {
            Log::error('Failed to send visitor connected webhook', [
                'widget_id' => $this->widget->id,
                'visitor_id' => $visitor->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Parse user agent string
     */
    protected function parseUserAgent(?string $userAgent): array
    {
        if (!$userAgent) {
            return [
                'browser' => null,
                'platform' => null,
                'device' => null,
            ];
        }

        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        return [
            'browser' => $agent->browser() ?: null,
            'platform' => $agent->platform() ?: null,
            'device' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
        ];
    }

    /**
     * Get location from IP address
     */
    protected function getLocationFromIp(?string $ipAddress): array
    {
        if (!$ipAddress || $ipAddress === '127.0.0.1' || $ipAddress === '::1') {
            return [
                'country' => null,
                'city' => null,
            ];
        }

        try {
            $location = geoip()->getLocation($ipAddress);
            return [
                'country' => $location->country ?? null,
                'city' => $location->city ?? null,
            ];
        } catch (\Exception $e) {
            return [
                'country' => null,
                'city' => null,
            ];
        }
    }

    /**
     * Send message from visitor
     */
    public function sendMessageFromVisitor(
        WebsiteChatVisitor $visitor,
        string $message,
        string $messageType = 'text',
        ?string $filePath = null,
        ?string $fileName = null,
        ?string $fileType = null,
        ?int $fileSize = null
    ): WebsiteChatMessage {
        $chatMessage = WebsiteChatMessage::create([
            'website_chat_visitor_id' => $visitor->id,
            'direction' => 'incoming',
            'message_type' => $messageType,
            'message' => $message,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'sent_at' => now(),
        ]);

        // Update visitor last message time
        $visitor->update(['last_message_at' => now()]);

        // Log message sent
        if ($this->widget->id) {
            WebsiteChatLog::log(
                $this->widget->id,
                'info',
                'message_received',
                [
                    'message_id' => $chatMessage->id,
                    'message_type' => $messageType,
                    'preview' => mb_substr($message, 0, 100),
                ],
                $visitor->id
            );
        }

        // Send webhook if enabled
        $this->sendMessageWebhook($visitor, $chatMessage);

        return $chatMessage;
    }

    /**
     * Send webhook for incoming message
     */
    protected function sendMessageWebhook(WebsiteChatVisitor $visitor, WebsiteChatMessage $message): void
    {
        try {
            $webhookService = WebsiteChatWebhookService::forWidget($this->widget);
            $webhookService->sendMessageReceivedWebhook($visitor, $message);
        } catch (\Exception $e) {
            Log::error('Failed to send message webhook', [
                'widget_id' => $this->widget->id,
                'visitor_id' => $visitor->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send message from admin
     */
    public function sendMessageFromAdmin(
        WebsiteChatVisitor $visitor,
        string $message,
        int $userId,
        string $messageType = 'text',
        ?string $filePath = null,
        ?string $fileName = null,
        ?string $fileType = null,
        ?int $fileSize = null
    ): WebsiteChatMessage {
        $chatMessage = WebsiteChatMessage::create([
            'website_chat_visitor_id' => $visitor->id,
            'direction' => 'outgoing',
            'message_type' => $messageType,
            'message' => $message,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'sent_by_user_id' => $userId,
            'sent_at' => now(),
        ]);

        // Log message sent
        if ($this->widget->id) {
            WebsiteChatLog::log(
                $this->widget->id,
                'info',
                'message_sent',
                [
                    'message_id' => $chatMessage->id,
                    'sent_by' => $userId,
                    'message_type' => $messageType,
                    'preview' => mb_substr($message, 0, 100),
                ],
                $visitor->id
            );
        }

        return $chatMessage;
    }

    /**
     * Mark messages as read
     */
    public function markMessagesAsRead(WebsiteChatVisitor $visitor, string $direction = 'incoming'): void
    {
        $visitor->messages()
            ->where('direction', $direction)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get unread messages count for widget
     */
    public function getUnreadCount(): int
    {
        return $this->widget->getUnreadMessagesCount();
    }

    /**
     * Get online visitors count
     */
    public function getOnlineVisitorsCount(): int
    {
        return $this->widget->getOnlineVisitorsCount();
    }

    /**
     * Update visitor online status
     */
    public function updateVisitorStatus(string $sessionId, bool $isOnline): void
    {
        $visitor = WebsiteChatVisitor::where('session_id', $sessionId)
            ->where('website_chat_widget_id', $this->widget->id)
            ->first();

        if ($visitor) {
            $visitor->update([
                'is_online' => $isOnline,
                'last_seen_at' => now(),
            ]);
        }
    }

    /**
     * Generate embed script for widget
     */
    public function generateEmbedScript(): string
    {
        $config = [
            'widgetId' => $this->widget->widget_id,
            'title' => $this->widget->widget_title,
            'subtitle' => $this->widget->widget_subtitle,
            'welcomeMessage' => $this->widget->welcome_message,
            'primaryColor' => $this->widget->primary_color,
            'secondaryColor' => $this->widget->secondary_color,
            'position' => $this->widget->position,
            'quickReplies' => $this->widget->quick_replies ?? [],
            'requireName' => $this->widget->require_name,
            'requireEmail' => $this->widget->require_email,
            'apiBaseUrl' => url('/api/webchat'),
        ];

        return view('widgets.webchat-script', ['config' => $config])->render();
    }
}
