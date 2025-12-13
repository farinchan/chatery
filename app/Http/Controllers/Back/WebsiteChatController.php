<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WebsiteChatWidget;
use App\Models\WebsiteChatVisitor;
use App\Services\WebsiteChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteChatController extends Controller
{
    private function getTeam($nameId)
    {
        return Team::where('name_id', $nameId)->whereHas('teamUsers', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('teamUsers.user')->firstOrFail();
    }

    public function index(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

        $data = [
            'title' => 'Website Chat Integration',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'Website Chat',
                    'link' => route('back.team.webchat.index', $team->name_id)
                ],
            ],
            'team' => $team,
            'widget' => $widget,
        ];

        return view('back.pages.webchat.index', $data);
    }

    public function chat(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

        if (!$widget) {
            return redirect()->route('back.team.webchat.index', $nameId)
                ->with('error', 'Silakan setup Widget Chat terlebih dahulu.');
        }

        $data = [
            'title' => 'Website Chat',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'Website Chat',
                    'link' => route('back.team.webchat.index', $team->name_id)
                ],
                [
                    'name' => 'Chat',
                ],
            ],
            'team' => $team,
            'widget' => $widget,
            'nameId' => $nameId,
        ];

        return view('back.pages.webchat.chat', $data);
    }

    public function store(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);

        // Check if widget already exists
        $existingWidget = WebsiteChatWidget::where('team_id', $team->id)->first();
        if ($existingWidget) {
            return back()->with('error', 'Widget sudah ada. Silakan edit widget yang sudah ada.');
        }

        $request->validate([
            'widget_name' => 'required|string|max:255',
            'widget_title' => 'required|string|max:255',
            'widget_subtitle' => 'nullable|string|max:255',
            'welcome_message' => 'nullable|string|max:1000',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'position' => 'nullable|in:left,right',
            'require_name' => 'nullable|boolean',
            'require_email' => 'nullable|boolean',
        ]);

        try {
            $widget = WebsiteChatWidget::create([
                'team_id' => $team->id,
                'widget_name' => $request->widget_name,
                'widget_title' => $request->widget_title,
                'widget_subtitle' => $request->widget_subtitle ?? 'Kami siap membantu Anda',
                'welcome_message' => $request->welcome_message,
                'primary_color' => $request->primary_color ?? '#0f4aa2',
                'secondary_color' => $request->secondary_color ?? '#0fa36b',
                'position' => $request->position ?? 'right',
                'require_name' => $request->boolean('require_name', true),
                'require_email' => $request->boolean('require_email', false),
                'is_active' => true,
            ]);

            return back()->with('success', 'Widget chat berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat widget: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        $request->validate([
            'widget_name' => 'required|string|max:255',
            'widget_title' => 'required|string|max:255',
            'widget_subtitle' => 'nullable|string|max:255',
            'welcome_message' => 'nullable|string|max:1000',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'position' => 'nullable|in:left,right',
            'require_name' => 'nullable|boolean',
            'require_email' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $widget->update([
                'widget_name' => $request->widget_name,
                'widget_title' => $request->widget_title,
                'widget_subtitle' => $request->widget_subtitle ?? 'Kami siap membantu Anda',
                'welcome_message' => $request->welcome_message,
                'primary_color' => $request->primary_color ?? '#0f4aa2',
                'secondary_color' => $request->secondary_color ?? '#0fa36b',
                'position' => $request->position ?? 'right',
                'require_name' => $request->boolean('require_name', true),
                'require_email' => $request->boolean('require_email', false),
                'is_active' => $request->boolean('is_active', true),
            ]);

            return back()->with('success', 'Widget chat berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui widget: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        try {
            $widget->delete();
            return back()->with('success', 'Widget chat berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus widget: ' . $e->getMessage());
        }
    }

    public function updateQuickReplies(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        $request->validate([
            'quick_replies' => 'nullable|array',
            'quick_replies.*.text' => 'required|string|max:100',
            'quick_replies.*.message' => 'required|string|max:500',
        ]);

        try {
            $widget->update([
                'quick_replies' => $request->quick_replies ?? [],
            ]);

            return back()->with('success', 'Quick replies berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui quick replies: ' . $e->getMessage());
        }
    }

    public function updateAllowedDomains(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        $request->validate([
            'allowed_domains' => 'nullable|array',
            'allowed_domains.*' => 'required|string|max:255',
        ]);

        try {
            $widget->update([
                'allowed_domains' => $request->allowed_domains ?? [],
            ]);

            return back()->with('success', 'Domain yang diizinkan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui domain: ' . $e->getMessage());
        }
    }

    public function getStatus(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->first();

        if (!$widget) {
            return response()->json([
                'success' => false,
                'message' => 'Widget not found',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_active' => $widget->is_active,
                'online_visitors' => $widget->getOnlineVisitorsCount(),
                'unread_messages' => $widget->getUnreadMessagesCount(),
                'total_visitors' => $widget->visitors()->count(),
            ],
        ]);
    }

    public function updateWebhook(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        $request->validate([
            'webhook_url' => 'nullable|url|max:500',
            'webhook_secret' => 'nullable|string|max:255',
            'webhook_enabled' => 'nullable|boolean',
            'webhook_events' => 'nullable|array',
            'webhook_events.*' => 'required|string|in:message.received,visitor.connected,visitor.disconnected',
        ]);

        try {
            $widget->update([
                'webhook_url' => $request->webhook_url,
                'webhook_secret' => $request->webhook_secret,
                'webhook_enabled' => $request->boolean('webhook_enabled', false),
                'webhook_events' => $request->webhook_events ?? [],
            ]);

            return back()->with('success', 'Webhook berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui webhook: ' . $e->getMessage());
        }
    }

    public function testWebhook(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        if (empty($widget->webhook_url)) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook URL belum dikonfigurasi',
            ]);
        }

        try {
            $webhookService = \App\Services\WebsiteChatWebhookService::forWidget($widget);
            $result = $webhookService->testWebhook();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim test webhook: ' . $e->getMessage(),
            ]);
        }
    }

    public function toggleVisitorWebhook(Request $request, $nameId, $visitorId)
    {
        $team = $this->getTeam($nameId);
        $widget = WebsiteChatWidget::where('team_id', $team->id)->firstOrFail();

        $visitor = WebsiteChatVisitor::where('id', $visitorId)
            ->where('website_chat_widget_id', $widget->id)
            ->firstOrFail();

        $visitor->update([
            'webhook_forward_enabled' => !$visitor->webhook_forward_enabled,
        ]);

        return response()->json([
            'success' => true,
            'webhook_forward_enabled' => $visitor->webhook_forward_enabled,
            'message' => $visitor->webhook_forward_enabled
                ? 'Webhook forwarding diaktifkan untuk visitor ini'
                : 'Webhook forwarding dinonaktifkan untuk visitor ini',
        ]);
    }
}
