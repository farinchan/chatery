<?php

namespace App\Services;

use App\Models\TelegramBot;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use App\Models\TelegramLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected TelegramBot $bot;
    protected string $apiUrl;

    public function __construct(TelegramBot $bot)
    {
        $this->bot = $bot;
        $this->apiUrl = "https://api.telegram.org/bot{$bot->bot_token}";
    }

    public static function forBot(TelegramBot $bot): self
    {
        return new self($bot);
    }

    public function getMe(): ?array
    {
        $response = $this->makeRequest('getMe');
        return $response['result'] ?? null;
    }

    public function setWebhook(string $url): bool
    {
        $response = $this->makeRequest('setWebhook', [
            'url' => $url,
            'allowed_updates' => ['message', 'callback_query', 'edited_message'],
        ]);

        return $response['ok'] ?? false;
    }

    public function deleteWebhook(): bool
    {
        $response = $this->makeRequest('deleteWebhook');
        return $response['ok'] ?? false;
    }

    public function getWebhookInfo(): ?array
    {
        $response = $this->makeRequest('getWebhookInfo');
        return $response['result'] ?? null;
    }

    public function sendMessage(int|string $chatId, string $text, array $options = []): ?array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        $response = $this->makeRequest('sendMessage', $params);

        if ($response['ok'] ?? false) {
            $this->saveOutgoingMessage($chatId, $response['result']);
        }

        return $response['result'] ?? null;
    }

    public function sendPhoto(int|string $chatId, string $photo, ?string $caption = null, array $options = []): ?array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ], $options);

        $response = $this->makeRequest('sendPhoto', $params);

        if ($response['ok'] ?? false) {
            $this->saveOutgoingMessage($chatId, $response['result'], 'photo');
        }

        return $response['result'] ?? null;
    }

    public function sendDocument(int|string $chatId, string $document, ?string $caption = null, array $options = []): ?array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'document' => $document,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ], $options);

        $response = $this->makeRequest('sendDocument', $params);

        if ($response['ok'] ?? false) {
            $this->saveOutgoingMessage($chatId, $response['result'], 'document');
        }

        return $response['result'] ?? null;
    }

    public function getChat(int|string $chatId): ?array
    {
        $response = $this->makeRequest('getChat', ['chat_id' => $chatId]);
        return $response['result'] ?? null;
    }

    public function getChatMemberCount(int|string $chatId): ?int
    {
        $response = $this->makeRequest('getChatMemberCount', ['chat_id' => $chatId]);
        return $response['result'] ?? null;
    }

    public function getUserProfilePhotos(int $userId, int $offset = 0, int $limit = 1): ?array
    {
        $response = $this->makeRequest('getUserProfilePhotos', [
            'user_id' => $userId,
            'offset' => $offset,
            'limit' => $limit,
        ]);
        return $response['result'] ?? null;
    }

    public function getFile(string $fileId): ?array
    {
        $response = $this->makeRequest('getFile', ['file_id' => $fileId]);
        return $response['result'] ?? null;
    }

    public function getFileUrl(string $filePath): string
    {
        return "https://api.telegram.org/file/bot{$this->bot->bot_token}/{$filePath}";
    }

    protected function makeRequest(string $method, array $params = []): array
    {
        try {
            $response = Http::timeout(30)->post("{$this->apiUrl}/{$method}", $params);
            $result = $response->json();

            // Log the request only if bot is saved (has ID)
            if ($this->bot->id) {
                TelegramLog::create([
                    'telegram_bot_id' => $this->bot->id,
                    'type' => 'api_call',
                    'action' => $method,
                    'request_data' => $params,
                    'response_data' => $result,
                    'message' => $result['ok'] ?? false ? 'Success' : ($result['description'] ?? 'Unknown error'),
                ]);
            }

            return $result ?? [];
        } catch (\Exception $e) {
            Log::error("Telegram API Error: {$e->getMessage()}");

            // Log the error only if bot is saved (has ID)
            if ($this->bot->id) {
                TelegramLog::create([
                    'telegram_bot_id' => $this->bot->id,
                    'type' => 'error',
                    'action' => $method,
                    'request_data' => $params,
                    'message' => $e->getMessage(),
                ]);
            }

            return ['ok' => false, 'description' => $e->getMessage()];
        }
    }

    public function processWebhookUpdate(array $update): void
    {
        TelegramLog::create([
            'telegram_bot_id' => $this->bot->id,
            'type' => 'webhook',
            'action' => 'incoming_update',
            'request_data' => $update,
            'message' => 'Webhook update received',
        ]);

        if (isset($update['message'])) {
            $this->processMessage($update['message']);
        } elseif (isset($update['callback_query'])) {
            $this->processCallbackQuery($update['callback_query']);
        }
    }

    protected function processMessage(array $message): void
    {
        $chatData = $message['chat'];
        $from = $message['from'] ?? null;

        // Find or create chat
        $chat = TelegramChat::updateOrCreate(
            [
                'telegram_bot_id' => $this->bot->id,
                'chat_id' => $chatData['id'],
            ],
            [
                'chat_type' => $chatData['type'],
                'title' => $chatData['title'] ?? null,
                'username' => $chatData['username'] ?? ($from['username'] ?? null),
                'first_name' => $from['first_name'] ?? ($chatData['first_name'] ?? null),
                'last_name' => $from['last_name'] ?? ($chatData['last_name'] ?? null),
                'last_message_at' => now(),
            ]
        );

        // Determine message type and content
        $messageType = 'text';
        $text = $message['text'] ?? null;
        $caption = $message['caption'] ?? null;
        $fileId = null;
        $fileName = null;
        $fileSize = null;
        $mimeType = null;

        if (isset($message['photo'])) {
            $messageType = 'photo';
            $photo = end($message['photo']);
            $fileId = $photo['file_id'];
            $fileSize = $photo['file_size'] ?? null;
        } elseif (isset($message['video'])) {
            $messageType = 'video';
            $fileId = $message['video']['file_id'];
            $fileName = $message['video']['file_name'] ?? null;
            $fileSize = $message['video']['file_size'] ?? null;
            $mimeType = $message['video']['mime_type'] ?? null;
        } elseif (isset($message['audio'])) {
            $messageType = 'audio';
            $fileId = $message['audio']['file_id'];
            $fileName = $message['audio']['file_name'] ?? null;
            $fileSize = $message['audio']['file_size'] ?? null;
            $mimeType = $message['audio']['mime_type'] ?? null;
        } elseif (isset($message['voice'])) {
            $messageType = 'voice';
            $fileId = $message['voice']['file_id'];
            $fileSize = $message['voice']['file_size'] ?? null;
            $mimeType = $message['voice']['mime_type'] ?? null;
        } elseif (isset($message['document'])) {
            $messageType = 'document';
            $fileId = $message['document']['file_id'];
            $fileName = $message['document']['file_name'] ?? null;
            $fileSize = $message['document']['file_size'] ?? null;
            $mimeType = $message['document']['mime_type'] ?? null;
        } elseif (isset($message['sticker'])) {
            $messageType = 'sticker';
            $fileId = $message['sticker']['file_id'];
        } elseif (isset($message['location'])) {
            $messageType = 'location';
            $text = "📍 Location: {$message['location']['latitude']}, {$message['location']['longitude']}";
        } elseif (isset($message['contact'])) {
            $messageType = 'contact';
            $text = "👤 Contact: {$message['contact']['first_name']} ({$message['contact']['phone_number']})";
        }

        // Save message
        TelegramMessage::create([
            'telegram_chat_id' => $chat->id,
            'message_id' => $message['message_id'],
            'direction' => 'incoming',
            'message_type' => $messageType,
            'text' => $text,
            'caption' => $caption,
            'file_id' => $fileId,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'raw_data' => $message,
            'is_read' => false,
            'sent_at' => isset($message['date']) ? \Carbon\Carbon::createFromTimestamp($message['date']) : now(),
        ]);
    }

    protected function processCallbackQuery(array $callbackQuery): void
    {
        // Handle callback query if needed
        // You can implement custom logic here
    }

    protected function saveOutgoingMessage(int|string $chatId, array $result, string $type = 'text'): void
    {
        $chat = TelegramChat::where('telegram_bot_id', $this->bot->id)
            ->where('chat_id', $chatId)
            ->first();

        if (!$chat) {
            return;
        }

        $text = $result['text'] ?? null;
        $caption = $result['caption'] ?? null;
        $fileId = null;

        if ($type === 'photo' && isset($result['photo'])) {
            $photo = end($result['photo']);
            $fileId = $photo['file_id'];
        } elseif ($type === 'document' && isset($result['document'])) {
            $fileId = $result['document']['file_id'];
        }

        TelegramMessage::create([
            'telegram_chat_id' => $chat->id,
            'message_id' => $result['message_id'],
            'direction' => 'outgoing',
            'message_type' => $type,
            'text' => $text,
            'caption' => $caption,
            'file_id' => $fileId,
            'raw_data' => $result,
            'is_read' => true,
            'sent_at' => isset($result['date']) ? \Carbon\Carbon::createFromTimestamp($result['date']) : now(),
        ]);

        $chat->update(['last_message_at' => now()]);
    }
}
