<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TelegramBot;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request, $botId)
    {
        $bot = TelegramBot::find($botId);

        if (!$bot || !$bot->is_active) {
            return response()->json(['ok' => false, 'description' => 'Bot not found or inactive'], 404);
        }

        $update = $request->all();

        if (empty($update)) {
            return response()->json(['ok' => false, 'description' => 'Empty update'], 400);
        }

        try {
            $service = TelegramService::forBot($bot);
            $service->processWebhookUpdate($update);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error("Telegram Webhook Error: " . $e->getMessage());
            return response()->json(['ok' => false, 'description' => $e->getMessage()], 500);
        }
    }
}
