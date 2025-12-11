<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TelegramBot;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class TelegramController extends Controller
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
        $telegramBot = TelegramBot::where('team_id', $team->id)->first();

        $data = [
            'title' => 'Telegram Bot Setting',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'Telegram',
                    'link' => route('back.team.telegram.index', $team->name_id)
                ],
            ],
            'team' => $team,
            'telegramBot' => $telegramBot,
            'token' => $team->teamUsers()->where('user_id', Auth::id())->first()->token,
        ];

        return view('back.pages.telegram.index', $data);
    }

    public function chat(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $telegramBot = TelegramBot::where('team_id', $team->id)->first();

        if (!$telegramBot) {
            return redirect()->route('back.team.telegram.index', $nameId)
                ->with('error', 'Silakan setup bot Telegram terlebih dahulu.');
        }

        $data = [
            'title' => 'Telegram Chat',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'Telegram',
                    'link' => route('back.team.telegram.index', $team->name_id)
                ],
                [
                    'name' => 'Chat',
                ],
            ],
            'team' => $team,
            'telegramBot' => $telegramBot,
            'nameId' => $nameId,
        ];

        return view('back.pages.telegram.chat', $data);
    }

    public function store(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);

        $request->validate([
            'bot_token' => 'required|string|unique:telegram_bots,bot_token',
        ]);

        // Test the token by calling getMe
        try {
            $tempBot = new TelegramBot([
                'team_id' => $team->id,
                'bot_token' => $request->bot_token,
            ]);

            $service = TelegramService::forBot($tempBot);
            $botInfo = $service->getMe();

            if (!$botInfo) {
                return back()->with('error', 'Token bot tidak valid. Silakan periksa kembali.');
            }

            // Create the bot
            $telegramBot = TelegramBot::create([
                'team_id' => $team->id,
                'bot_token' => $request->bot_token,
                'bot_username' => $botInfo['username'] ?? null,
                'bot_name' => $botInfo['first_name'] ?? null,
                'bot_info' => $botInfo,
                'is_active' => true,
            ]);

            // Set webhook
            $webhookUrl = route('api.telegram.webhook', ['botId' => $telegramBot->id]);
            $service = TelegramService::forBot($telegramBot);
            $service->setWebhook($webhookUrl);

            $telegramBot->update(['webhook_url' => $webhookUrl]);

            return back()->with('success', 'Bot Telegram berhasil dihubungkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghubungkan bot: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $telegramBot = TelegramBot::where('team_id', $team->id)->firstOrFail();

        $request->validate([
            'bot_token' => 'required|string|unique:telegram_bots,bot_token,' . $telegramBot->id,
        ]);

        try {
            // Delete old webhook first
            $oldService = TelegramService::forBot($telegramBot);
            $oldService->deleteWebhook();

            // Update token
            $telegramBot->bot_token = $request->bot_token;

            // Test new token
            $service = TelegramService::forBot($telegramBot);
            $botInfo = $service->getMe();

            if (!$botInfo) {
                return back()->with('error', 'Token bot tidak valid. Silakan periksa kembali.');
            }

            $telegramBot->bot_username = $botInfo['username'] ?? null;
            $telegramBot->bot_name = $botInfo['first_name'] ?? null;
            $telegramBot->bot_info = $botInfo;
            $telegramBot->save();

            // Set new webhook
            $webhookUrl = route('api.telegram.webhook', ['botId' => $telegramBot->id]);
            $service->setWebhook($webhookUrl);
            $telegramBot->update(['webhook_url' => $webhookUrl]);

            return back()->with('success', 'Bot Telegram berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui bot: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $telegramBot = TelegramBot::where('team_id', $team->id)->firstOrFail();

        try {
            // Delete webhook
            $service = TelegramService::forBot($telegramBot);
            $service->deleteWebhook();

            // Delete bot
            $telegramBot->delete();

            return back()->with('success', 'Bot Telegram berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus bot: ' . $e->getMessage());
        }
    }

    public function refreshWebhook(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $telegramBot = TelegramBot::where('team_id', $team->id)->firstOrFail();

        try {
            $service = TelegramService::forBot($telegramBot);

            // Delete old webhook
            $service->deleteWebhook();

            // Set new webhook
            $webhookUrl = route('api.telegram.webhook', ['botId' => $telegramBot->id]);
            $result = $service->setWebhook($webhookUrl);

            if ($result) {
                $telegramBot->update(['webhook_url' => $webhookUrl]);
                return back()->with('success', 'Webhook berhasil di-refresh!');
            }

            return back()->with('error', 'Gagal mengatur webhook.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal refresh webhook: ' . $e->getMessage());
        }
    }

    public function getStatus(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $telegramBot = TelegramBot::where('team_id', $team->id)->first();

        if (!$telegramBot) {
            return response()->json([
                'status' => 'not_connected',
                'message' => 'Bot belum dihubungkan',
            ]);
        }

        try {
            $service = TelegramService::forBot($telegramBot);
            $botInfo = $service->getMe();
            $webhookInfo = $service->getWebhookInfo();

            return response()->json([
                'status' => 'connected',
                'bot' => [
                    'id' => $botInfo['id'] ?? null,
                    'username' => $botInfo['username'] ?? null,
                    'name' => $botInfo['first_name'] ?? null,
                ],
                'webhook' => [
                    'url' => $webhookInfo['url'] ?? null,
                    'has_custom_certificate' => $webhookInfo['has_custom_certificate'] ?? false,
                    'pending_update_count' => $webhookInfo['pending_update_count'] ?? 0,
                    'last_error_date' => $webhookInfo['last_error_date'] ?? null,
                    'last_error_message' => $webhookInfo['last_error_message'] ?? null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
