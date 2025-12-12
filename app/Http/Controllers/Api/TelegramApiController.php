<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TelegramBot;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelegramApiController extends Controller
{
    /**
     * Get team by auth token
     */
    private function getTeamByToken(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return null;
        }

        return Team::whereHas('teamUsers', function ($query) use ($token) {
            $query->where('token', $token);
        })->first();
    }

    /**
     * Get Telegram bot for team
     */
    private function getBotForTeam(Team $team): ?TelegramBot
    {
        return TelegramBot::where('team_id', $team->id)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Send text message via Telegram
     */
    public function sendMessage(Request $request)
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

            $bot = $this->getBotForTeam($team);

            if (!$bot) {
                return response()->json(['status' => 'error', 'message' => 'No active Telegram bot found for this team', 'data' => null], 404);
            }

            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|string',
                'message' => 'required|string',
                'parse_mode' => 'nullable|string|in:HTML,Markdown,MarkdownV2',
                'disable_notification' => 'nullable|boolean',
                'reply_to_message_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $telegramService = TelegramService::forBot($bot);

            $options = [];
            if ($request->has('parse_mode')) {
                $options['parse_mode'] = $request->input('parse_mode');
            }
            if ($request->has('disable_notification')) {
                $options['disable_notification'] = $request->input('disable_notification');
            }
            if ($request->has('reply_to_message_id')) {
                $options['reply_to_message_id'] = $request->input('reply_to_message_id');
            }

            $result = $telegramService->sendMessage(
                $request->input('chat_id'),
                $request->input('message'),
                $options
            );

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Message sent successfully',
                    'data' => [
                        'team' => $team,
                        'bot' => [
                            'id' => $bot->id,
                            'name' => $bot->bot_name,
                            'username' => $bot->bot_username,
                        ],
                        'response' => $result,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send message', 'data' => null], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send photo via Telegram
     */
    public function sendPhoto(Request $request)
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

            $bot = $this->getBotForTeam($team);

            if (!$bot) {
                return response()->json(['status' => 'error', 'message' => 'No active Telegram bot found for this team', 'data' => null], 404);
            }

            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|string',
                'photo' => 'required|string', // URL or file_id
                'caption' => 'nullable|string|max:1024',
                'parse_mode' => 'nullable|string|in:HTML,Markdown,MarkdownV2',
                'disable_notification' => 'nullable|boolean',
                'reply_to_message_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $telegramService = TelegramService::forBot($bot);

            $options = [];
            if ($request->has('parse_mode')) {
                $options['parse_mode'] = $request->input('parse_mode');
            }
            if ($request->has('disable_notification')) {
                $options['disable_notification'] = $request->input('disable_notification');
            }
            if ($request->has('reply_to_message_id')) {
                $options['reply_to_message_id'] = $request->input('reply_to_message_id');
            }

            $result = $telegramService->sendPhoto(
                $request->input('chat_id'),
                $request->input('photo'),
                $request->input('caption'),
                $options
            );

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Photo sent successfully',
                    'data' => [
                        'team' => $team,
                        'bot' => [
                            'id' => $bot->id,
                            'name' => $bot->bot_name,
                            'username' => $bot->bot_username,
                        ],
                        'response' => $result,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send photo', 'data' => null], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send document via Telegram
     */
    public function sendDocument(Request $request)
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

            $bot = $this->getBotForTeam($team);

            if (!$bot) {
                return response()->json(['status' => 'error', 'message' => 'No active Telegram bot found for this team', 'data' => null], 404);
            }

            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|string',
                'document' => 'required|string', // URL or file_id
                'caption' => 'nullable|string|max:1024',
                'parse_mode' => 'nullable|string|in:HTML,Markdown,MarkdownV2',
                'disable_notification' => 'nullable|boolean',
                'reply_to_message_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $telegramService = TelegramService::forBot($bot);

            $options = [];
            if ($request->has('parse_mode')) {
                $options['parse_mode'] = $request->input('parse_mode');
            }
            if ($request->has('disable_notification')) {
                $options['disable_notification'] = $request->input('disable_notification');
            }
            if ($request->has('reply_to_message_id')) {
                $options['reply_to_message_id'] = $request->input('reply_to_message_id');
            }

            $result = $telegramService->sendDocument(
                $request->input('chat_id'),
                $request->input('document'),
                $request->input('caption'),
                $options
            );

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Document sent successfully',
                    'data' => [
                        'team' => $team,
                        'bot' => [
                            'id' => $bot->id,
                            'name' => $bot->bot_name,
                            'username' => $bot->bot_username,
                        ],
                        'response' => $result,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send document', 'data' => null], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
