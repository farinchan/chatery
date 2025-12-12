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

    // ============================================
    // AGENT/TEAM API ENDPOINTS (Authenticated)
    // ============================================

    /**
     * Get team by auth token
     */
    private function getTeamByToken(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return null;
        }

        return \App\Models\Team::whereHas('teamUsers', function ($query) use ($token) {
            $query->where('token', $token);
        })->first();
    }

    /**
     * Get all visitors/conversations for the team
     */
    public function getVisitors(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            // Get widget for this team
            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $query = WebsiteChatVisitor::where('website_chat_widget_id', $widget->id);

            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filter by online status
            if ($request->has('is_online')) {
                $query->where('is_online', $request->boolean('is_online'));
            }

            // Filter by unread
            if ($request->boolean('unread_only')) {
                $query->where('unread_count', '>', 0);
            }

            // Order by last activity
            $query->orderBy('last_activity_at', 'desc');

            // Pagination
            $perPage = $request->input('per_page', 20);
            $visitors = $query->paginate($perPage);

            $data = $visitors->map(function ($visitor) {
                $lastMessage = $visitor->messages()->orderBy('sent_at', 'desc')->first();
                return [
                    'id' => $visitor->id,
                    'session_id' => $visitor->session_id,
                    'name' => $visitor->name,
                    'email' => $visitor->email,
                    'phone' => $visitor->phone,
                    'display_name' => $visitor->getDisplayName(),
                    'is_online' => $visitor->is_online,
                    'status' => $visitor->status,
                    'unread_count' => $visitor->unread_count,
                    'ip_address' => $visitor->ip_address,
                    'country' => $visitor->country,
                    'city' => $visitor->city,
                    'browser' => $visitor->browser,
                    'device' => $visitor->device,
                    'current_page' => $visitor->current_page,
                    'referrer' => $visitor->referrer,
                    'last_message' => $lastMessage ? [
                        'message' => Str::limit($lastMessage->message, 50),
                        'direction' => $lastMessage->direction,
                        'sent_at' => $lastMessage->sent_at->toIso8601String(),
                    ] : null,
                    'first_visit_at' => $visitor->first_visit_at?->toIso8601String(),
                    'last_activity_at' => $visitor->last_activity_at?->toIso8601String(),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Visitors fetched successfully',
                'data' => [
                    'visitors' => $data,
                    'pagination' => [
                        'current_page' => $visitors->currentPage(),
                        'last_page' => $visitors->lastPage(),
                        'per_page' => $visitors->perPage(),
                        'total' => $visitors->total(),
                    ],
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Get specific visitor info
     */
    public function getVisitor(Request $request, $visitorId)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $visitor = WebsiteChatVisitor::where('id', $visitorId)
                ->where('website_chat_widget_id', $widget->id)
                ->first();

            if (!$visitor) {
                return response()->json(['status' => 'error', 'message' => 'Visitor not found', 'data' => null], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Visitor fetched successfully',
                'data' => [
                    'id' => $visitor->id,
                    'session_id' => $visitor->session_id,
                    'name' => $visitor->name,
                    'email' => $visitor->email,
                    'phone' => $visitor->phone,
                    'display_name' => $visitor->getDisplayName(),
                    'is_online' => $visitor->is_online,
                    'status' => $visitor->status,
                    'unread_count' => $visitor->unread_count,
                    'ip_address' => $visitor->ip_address,
                    'country' => $visitor->country,
                    'city' => $visitor->city,
                    'browser' => $visitor->browser,
                    'device' => $visitor->device,
                    'os' => $visitor->os,
                    'current_page' => $visitor->current_page,
                    'referrer' => $visitor->referrer,
                    'notes' => $visitor->notes,
                    'tags' => $visitor->tags,
                    'first_visit_at' => $visitor->first_visit_at?->toIso8601String(),
                    'last_activity_at' => $visitor->last_activity_at?->toIso8601String(),
                    'created_at' => $visitor->created_at->toIso8601String(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Get visitor messages (conversation history)
     */
    public function getVisitorMessages(Request $request, $visitorId)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $visitor = WebsiteChatVisitor::where('id', $visitorId)
                ->where('website_chat_widget_id', $widget->id)
                ->first();

            if (!$visitor) {
                return response()->json(['status' => 'error', 'message' => 'Visitor not found', 'data' => null], 404);
            }

            $query = $visitor->messages()->orderBy('sent_at', 'asc');

            // Get messages after specific ID
            if ($request->has('after_id')) {
                $query->where('id', '>', $request->after_id);
            }

            // Limit messages
            if ($request->has('limit')) {
                $query->limit($request->limit);
            }

            $messages = $query->get()->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'direction' => $msg->direction,
                    'message_type' => $msg->message_type,
                    'message' => $msg->message,
                    'file_url' => $msg->getFileUrl(),
                    'file_name' => $msg->file_name,
                    'is_read' => $msg->is_read,
                    'sent_at' => $msg->sent_at->toIso8601String(),
                    'formatted_time' => $msg->getFormattedTime(),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Messages fetched successfully',
                'data' => [
                    'visitor' => [
                        'id' => $visitor->id,
                        'display_name' => $visitor->getDisplayName(),
                        'is_online' => $visitor->is_online,
                    ],
                    'messages' => $messages,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send message to visitor (agent reply)
     */
    public function sendMessageToVisitor(Request $request, $visitorId)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'message' => 'required|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $visitor = WebsiteChatVisitor::where('id', $visitorId)
                ->where('website_chat_widget_id', $widget->id)
                ->first();

            if (!$visitor) {
                return response()->json(['status' => 'error', 'message' => 'Visitor not found', 'data' => null], 404);
            }

            // Create outgoing message (agent to visitor)
            $message = WebsiteChatMessage::create([
                'website_chat_visitor_id' => $visitor->id,
                'direction' => 'outgoing',
                'message_type' => 'text',
                'message' => $request->message,
                'sent_at' => now(),
                'is_read' => false,
            ]);

            // Update visitor status to active if needed
            if ($visitor->status === 'pending') {
                $visitor->update(['status' => 'active']);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'data' => [
                    'id' => $message->id,
                    'direction' => $message->direction,
                    'message_type' => $message->message_type,
                    'message' => $message->message,
                    'sent_at' => $message->sent_at->toIso8601String(),
                    'formatted_time' => $message->getFormattedTime(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead(Request $request, $visitorId)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $visitor = WebsiteChatVisitor::where('id', $visitorId)
                ->where('website_chat_widget_id', $widget->id)
                ->first();

            if (!$visitor) {
                return response()->json(['status' => 'error', 'message' => 'Visitor not found', 'data' => null], 404);
            }

            // Mark all incoming messages as read
            $visitor->messages()
                ->where('direction', 'incoming')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            // Reset unread count
            $visitor->update(['unread_count' => 0]);

            return response()->json([
                'status' => 'success',
                'message' => 'Messages marked as read',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Close/resolve conversation
     */
    public function closeConversation(Request $request, $visitorId)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

            if (!$widget) {
                return response()->json(['status' => 'error', 'message' => 'No webchat widget found for this team', 'data' => null], 404);
            }

            $visitor = WebsiteChatVisitor::where('id', $visitorId)
                ->where('website_chat_widget_id', $widget->id)
                ->first();

            if (!$visitor) {
                return response()->json(['status' => 'error', 'message' => 'Visitor not found', 'data' => null], 404);
            }

            // Update visitor status to closed
            $visitor->update([
                'status' => 'closed',
                'unread_count' => 0,
            ]);

            // Mark all messages as read
            $visitor->messages()
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'status' => 'success',
                'message' => 'Conversation closed successfully',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
