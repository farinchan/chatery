<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebsiteChatWidget;
use App\Models\WebsiteChatVisitor;
use App\Models\WebsiteChatMessage;
use App\Services\WebsiteChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebsiteChatApiController extends Controller
{
    /**
     * Get widget script
     */
    public function getScript($widgetId)
    {
        $widget = WebsiteChatWidget::where('widget_id', $widgetId)->first();

        if (!$widget || !$widget->is_active) {
            return response('// Widget not found or inactive', 404)
                ->header('Content-Type', 'application/javascript');
        }

        $service = WebsiteChatService::forWidget($widget);
        $script = $service->generateEmbedScript();

        return response($script)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Initialize chat session
     */
    public function initSession(Request $request)
    {
        $request->validate([
            'widget_id' => 'required|string',
            'session_id' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $widget = WebsiteChatWidget::where('widget_id', $request->widget_id)->first();

        if (!$widget || !$widget->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Widget not found or inactive',
            ], 404);
        }

        // Check domain if allowed_domains is set
        if (!empty($widget->allowed_domains)) {
            $origin = $request->header('Origin') ?? $request->header('Referer');
            if ($origin) {
                $originHost = parse_url($origin, PHP_URL_HOST);
                if (!in_array($originHost, $widget->allowed_domains)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Domain not allowed',
                    ], 403);
                }
            }
        }

        $sessionId = $request->session_id ?? Str::uuid()->toString();
        $service = WebsiteChatService::forWidget($widget);

        $visitor = $service->getOrCreateVisitor(
            $sessionId,
            $request->name,
            $request->email,
            $request->ip(),
            $request->userAgent(),
            $request->header('Referer'),
            $request->current_page
        );

        // Get chat history
        $messages = $visitor->messages()
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'direction' => $msg->direction,
                    'message_type' => $msg->message_type,
                    'message' => $msg->message,
                    'file_url' => $msg->getFileUrl(),
                    'file_name' => $msg->file_name,
                    'sent_at' => $msg->sent_at->toIso8601String(),
                    'formatted_time' => $msg->getFormattedTime(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'session_id' => $sessionId,
                'visitor_id' => $visitor->id,
                'visitor_name' => $visitor->getDisplayName(),
                'welcome_message' => $widget->welcome_message,
                'quick_replies' => $widget->quick_replies ?? [],
                'messages' => $messages,
                'is_within_operating_hours' => $widget->isWithinOperatingHours(),
            ],
        ]);
    }

    /**
     * Send message from visitor
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'widget_id' => 'required|string',
            'session_id' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        $widget = WebsiteChatWidget::where('widget_id', $request->widget_id)->first();

        if (!$widget || !$widget->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Widget not found or inactive',
            ], 404);
        }

        $visitor = WebsiteChatVisitor::where('session_id', $request->session_id)
            ->where('website_chat_widget_id', $widget->id)
            ->first();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found',
            ], 404);
        }

        $service = WebsiteChatService::forWidget($widget);
        $chatMessage = $service->sendMessageFromVisitor($visitor, $request->message);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $chatMessage->id,
                'direction' => $chatMessage->direction,
                'message_type' => $chatMessage->message_type,
                'message' => $chatMessage->message,
                'sent_at' => $chatMessage->sent_at->toIso8601String(),
                'formatted_time' => $chatMessage->getFormattedTime(),
            ],
        ]);
    }

    /**
     * Get new messages (polling)
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'widget_id' => 'required|string',
            'session_id' => 'required|string',
            'last_message_id' => 'nullable|integer',
        ]);

        $widget = WebsiteChatWidget::where('widget_id', $request->widget_id)->first();

        if (!$widget || !$widget->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Widget not found or inactive',
            ], 404);
        }

        $visitor = WebsiteChatVisitor::where('session_id', $request->session_id)
            ->where('website_chat_widget_id', $widget->id)
            ->first();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found',
            ], 404);
        }

        // Update visitor online status
        $visitor->markAsOnline();

        $query = $visitor->messages()->orderBy('sent_at', 'asc');

        if ($request->last_message_id) {
            $query->where('id', '>', $request->last_message_id);
        }

        $messages = $query->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'direction' => $msg->direction,
                'message_type' => $msg->message_type,
                'message' => $msg->message,
                'file_url' => $msg->getFileUrl(),
                'file_name' => $msg->file_name,
                'sent_at' => $msg->sent_at->toIso8601String(),
                'formatted_time' => $msg->getFormattedTime(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'messages' => $messages,
            ],
        ]);
    }

    /**
     * Update visitor info
     */
    public function updateVisitorInfo(Request $request)
    {
        $request->validate([
            'widget_id' => 'required|string',
            'session_id' => 'required|string',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $widget = WebsiteChatWidget::where('widget_id', $request->widget_id)->first();

        if (!$widget) {
            return response()->json([
                'success' => false,
                'message' => 'Widget not found',
            ], 404);
        }

        $visitor = WebsiteChatVisitor::where('session_id', $request->session_id)
            ->where('website_chat_widget_id', $widget->id)
            ->first();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found',
            ], 404);
        }

        $updateData = [];
        if ($request->has('name')) $updateData['name'] = $request->name;
        if ($request->has('email')) $updateData['email'] = $request->email;
        if ($request->has('phone')) $updateData['phone'] = $request->phone;

        $visitor->update($updateData);

        return response()->json([
            'success' => true,
            'data' => [
                'visitor_name' => $visitor->getDisplayName(),
            ],
        ]);
    }

    /**
     * Disconnect visitor (mark offline)
     */
    public function disconnect(Request $request)
    {
        $request->validate([
            'widget_id' => 'required|string',
            'session_id' => 'required|string',
        ]);

        $widget = WebsiteChatWidget::where('widget_id', $request->widget_id)->first();

        if ($widget) {
            $service = WebsiteChatService::forWidget($widget);
            $service->updateVisitorStatus($request->session_id, false);
        }

        return response()->json(['success' => true]);
    }
}
