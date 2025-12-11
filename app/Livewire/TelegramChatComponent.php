<?php

namespace App\Livewire;

use App\Models\TelegramBot;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Livewire\WithFileUploads;

class TelegramChatComponent extends Component
{
    use WithFileUploads;

    public $teamNameId = '';
    public $telegramBotId = null;
    public $chats = [];
    public $messages = [];
    public $selectedChatId = null;
    public $selectedChatData = null;
    public $messageText = '';
    public $isLoading = false;
    public $isSending = false;
    public $searchQuery = '';

    protected $listeners = ['refreshChats' => 'loadChats', 'refreshMessages' => 'loadMessages'];

    public function mount($nameId = null)
    {
        $this->teamNameId = $nameId ?? Cookie::get('current_team') ?? '';
        $this->loadBot();
        $this->loadChats();
    }

    public function loadBot()
    {
        if (!$this->teamNameId) {
            return;
        }

        $team = \App\Models\Team::where('name_id', $this->teamNameId)->first();
        if ($team) {
            $bot = TelegramBot::where('team_id', $team->id)->first();
            $this->telegramBotId = $bot ? $bot->id : null;
        }
    }

    public function getTelegramBot()
    {
        return $this->telegramBotId ? TelegramBot::find($this->telegramBotId) : null;
    }

    public function getSelectedChat()
    {
        return $this->selectedChatId ? TelegramChat::find($this->selectedChatId) : null;
    }

    public function loadChats()
    {
        if (!$this->telegramBotId) {
            return;
        }

        $query = TelegramChat::where('telegram_bot_id', $this->telegramBotId)
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('is_read', false)->where('direction', 'incoming');
            }])
            ->with(['messages' => function ($query) {
                $query->latest('sent_at')->limit(1);
            }])
            ->orderBy('last_message_at', 'desc');

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('last_name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('username', 'like', "%{$this->searchQuery}%")
                    ->orWhere('title', 'like', "%{$this->searchQuery}%");
            });
        }

        $this->chats = $query->get()->map(function ($chat) {
            $lastMessage = $chat->messages->first();
            return [
                'id' => $chat->id,
                'chat_id' => $chat->chat_id,
                'name' => $chat->getDisplayName(),
                'photo' => $chat->photo,
                'chat_type' => $chat->chat_type,
                'username' => $chat->username,
                'unread_count' => $chat->unread_count,
                'last_message' => $lastMessage ? $lastMessage->getPreviewText() : '',
                'last_message_time' => $chat->last_message_at ? $chat->last_message_at->format('H:i') : '',
                'last_message_date' => $chat->last_message_at ? $chat->last_message_at->format('d/m/Y') : '',
            ];
        })->toArray();
    }

    public function selectChat($chatId)
    {
        $this->selectedChatId = $chatId;
        $chat = TelegramChat::find($chatId);
        if ($chat) {
            $this->selectedChatData = [
                'id' => $chat->id,
                'chat_id' => $chat->chat_id,
                'name' => $chat->getDisplayName(),
                'photo' => $chat->photo,
                'chat_type' => $chat->chat_type,
                'username' => $chat->username,
            ];
        }
        $this->loadMessages();

        // Mark messages as read
        TelegramMessage::where('telegram_chat_id', $chatId)
            ->where('direction', 'incoming')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadChats(); // Refresh to update unread count
    }

    public function loadMessages()
    {
        if (!$this->selectedChatId) {
            return;
        }

        $this->isLoading = true;

        $messages = TelegramMessage::where('telegram_chat_id', $this->selectedChatId)
            ->orderBy('sent_at', 'asc')
            ->get();

        $this->messages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'message_id' => $message->message_id,
                'direction' => $message->direction,
                'type' => $message->message_type,
                'text' => $message->text,
                'caption' => $message->caption,
                'file_id' => $message->file_id,
                'file_name' => $message->file_name,
                'time' => $message->getFormattedTime(),
                'date' => $message->getFormattedDate(),
                'is_read' => $message->is_read,
            ];
        })->toArray();

        $this->isLoading = false;
        $this->dispatch('messagesUpdated');
    }

    public function sendMessage()
    {
        $this->validate([
            'messageText' => 'required|string|min:1',
        ]);

        $selectedChat = $this->getSelectedChat();
        $telegramBot = $this->getTelegramBot();

        if (!$selectedChat || !$telegramBot) {
            session()->flash('error', 'Silakan pilih chat terlebih dahulu');
            return;
        }

        $this->isSending = true;

        try {
            $service = TelegramService::forBot($telegramBot);
            $result = $service->sendMessage($selectedChat->chat_id, $this->messageText);

            if ($result) {
                $this->messageText = '';
                $this->loadMessages();
                $this->loadChats();
                $this->dispatch('messagesUpdated');
            } else {
                session()->flash('error', 'Gagal mengirim pesan');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }

        $this->isSending = false;
    }

    public function refreshAll()
    {
        $this->loadChats();
        if ($this->selectedChatId) {
            $this->loadMessages();
        }
    }

    public function updatedSearchQuery()
    {
        $this->loadChats();
    }

    public function render()
    {
        return view('livewire.telegram-chat');
    }
}
