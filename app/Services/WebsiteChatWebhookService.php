<?php

namespace App\Services;

use App\Models\WebsiteChatWidget;
use App\Models\WebsiteChatVisitor;
use App\Models\WebsiteChatMessage;
use App\Models\WebsiteChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebsiteChatWebhookService
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
     * Check if webhook is enabled and configured
     */
    public function isWebhookEnabled(): bool
    {
        return $this->widget->webhook_enabled
            && !empty($this->widget->webhook_url);
    }

    /**
     * Check if specific event is enabled
     */
    public function isEventEnabled(string $event): bool
    {
        if (!$this->isWebhookEnabled()) {
            return false;
        }

        $events = $this->widget->webhook_events ?? [];

        // If no specific events configured, all events are enabled
        if (empty($events)) {
            return true;
        }

        return in_array($event, $events);
    }

    /**
     * Send webhook for message received event
     */
    public function sendMessageReceivedWebhook(WebsiteChatVisitor $visitor, WebsiteChatMessage $message): bool
    {
        // Check if visitor has webhook forwarding enabled
        if (!$visitor->webhook_forward_enabled) {
            return false;
        }

        if (!$this->isEventEnabled('message.received')) {
            return false;
        }

        $payload = [
            'event' => 'message.received',
            'timestamp' => now()->toIso8601String(),
            'widget' => [
                'id' => $this->widget->id,
                'widget_id' => $this->widget->widget_id,
                'name' => $this->widget->widget_name,
            ],
            'visitor' => [
                'id' => $visitor->id,
                'session_id' => $visitor->session_id,
                'name' => $visitor->name,
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'ip_address' => $visitor->ip_address,
                'country' => $visitor->country,
                'city' => $visitor->city,
                'browser' => $visitor->browser,
                'device' => $visitor->device,
                'current_page' => $visitor->current_page,
                'is_online' => $visitor->is_online,
            ],
            'message' => [
                'id' => $message->id,
                'direction' => $message->direction,
                'message_type' => $message->message_type,
                'content' => $message->message,
                'file_url' => $message->file_url,
                'file_name' => $message->file_name,
                'sent_at' => $message->sent_at->toIso8601String(),
            ],
        ];

        return $this->sendWebhook($payload, 'message.received');
    }

    /**
     * Send webhook for visitor connected event
     */
    public function sendVisitorConnectedWebhook(WebsiteChatVisitor $visitor): bool
    {
        if (!$visitor->webhook_forward_enabled) {
            return false;
        }

        if (!$this->isEventEnabled('visitor.connected')) {
            return false;
        }

        $payload = [
            'event' => 'visitor.connected',
            'timestamp' => now()->toIso8601String(),
            'widget' => [
                'id' => $this->widget->id,
                'widget_id' => $this->widget->widget_id,
                'name' => $this->widget->widget_name,
            ],
            'visitor' => [
                'id' => $visitor->id,
                'session_id' => $visitor->session_id,
                'name' => $visitor->name,
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'ip_address' => $visitor->ip_address,
                'country' => $visitor->country,
                'city' => $visitor->city,
                'browser' => $visitor->browser,
                'device' => $visitor->device,
                'current_page' => $visitor->current_page,
                'referrer_url' => $visitor->referrer_url,
                'first_visit_at' => $visitor->created_at->toIso8601String(),
            ],
        ];

        return $this->sendWebhook($payload, 'visitor.connected');
    }

    /**
     * Send webhook for visitor disconnected event
     */
    public function sendVisitorDisconnectedWebhook(WebsiteChatVisitor $visitor): bool
    {
        if (!$visitor->webhook_forward_enabled) {
            return false;
        }

        if (!$this->isEventEnabled('visitor.disconnected')) {
            return false;
        }

        $payload = [
            'event' => 'visitor.disconnected',
            'timestamp' => now()->toIso8601String(),
            'widget' => [
                'id' => $this->widget->id,
                'widget_id' => $this->widget->widget_id,
                'name' => $this->widget->widget_name,
            ],
            'visitor' => [
                'id' => $visitor->id,
                'session_id' => $visitor->session_id,
                'name' => $visitor->name,
                'email' => $visitor->email,
                'last_seen_at' => $visitor->last_seen_at?->toIso8601String(),
            ],
        ];

        return $this->sendWebhook($payload, 'visitor.disconnected');
    }

    /**
     * Send webhook request
     */
    protected function sendWebhook(array $payload, string $event): bool
    {
        $url = $this->widget->webhook_url;

        if (empty($url)) {
            return false;
        }

        try {
            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => $event,
                'X-Webhook-Timestamp' => now()->timestamp,
                'X-Widget-ID' => $this->widget->widget_id,
            ];

            // Add signature if secret is configured
            if (!empty($this->widget->webhook_secret)) {
                $signature = $this->generateSignature($payload);
                $headers['X-Webhook-Signature'] = $signature;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->post($url, $payload);

            $success = $response->successful();

            // Log the webhook call
            $this->logWebhook($event, $payload, $response->status(), $response->body(), $success);

            if (!$success) {
                Log::warning('Webchat webhook failed', [
                    'widget_id' => $this->widget->widget_id,
                    'event' => $event,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }

            return $success;

        } catch (\Exception $e) {
            Log::error('Webchat webhook error', [
                'widget_id' => $this->widget->widget_id,
                'event' => $event,
                'error' => $e->getMessage(),
            ]);

            $this->logWebhook($event, $payload, 0, $e->getMessage(), false);

            return false;
        }
    }

    /**
     * Generate HMAC signature for webhook payload
     */
    protected function generateSignature(array $payload): string
    {
        $payloadJson = json_encode($payload);
        return hash_hmac('sha256', $payloadJson, $this->widget->webhook_secret);
    }

    /**
     * Log webhook call
     */
    protected function logWebhook(string $event, array $payload, int $statusCode, ?string $response, bool $success): void
    {
        try {
            WebsiteChatLog::create([
                'website_chat_widget_id' => $this->widget->id,
                'event_type' => 'webhook',
                'event_name' => $event,
                'payload' => $payload,
                'response_status' => $statusCode,
                'response_body' => Str::limit($response, 1000),
                'is_success' => $success,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log webhook', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Test webhook connection
     */
    public function testWebhook(): array
    {
        $payload = [
            'event' => 'test',
            'timestamp' => now()->toIso8601String(),
            'widget' => [
                'id' => $this->widget->id,
                'widget_id' => $this->widget->widget_id,
                'name' => $this->widget->widget_name,
            ],
            'message' => 'This is a test webhook from Chatery',
        ];

        $url = $this->widget->webhook_url;

        if (empty($url)) {
            return [
                'success' => false,
                'message' => 'Webhook URL is not configured',
            ];
        }

        try {
            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => 'test',
                'X-Webhook-Timestamp' => now()->timestamp,
                'X-Widget-ID' => $this->widget->widget_id,
            ];

            if (!empty($this->widget->webhook_secret)) {
                $signature = $this->generateSignature($payload);
                $headers['X-Webhook-Signature'] = $signature;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->post($url, $payload);

            $this->logWebhook('test', $payload, $response->status(), $response->body(), $response->successful());

            return [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'message' => $response->successful()
                    ? 'Webhook test successful'
                    : 'Webhook test failed: ' . $response->status(),
                'response' => Str::limit($response->body(), 500),
            ];

        } catch (\Exception $e) {
            $this->logWebhook('test', $payload, 0, $e->getMessage(), false);

            return [
                'success' => false,
                'message' => 'Webhook test failed: ' . $e->getMessage(),
            ];
        }
    }
}
