<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WhatsappChat extends Component
{
    public $session = "TORKATA_RESEARCH";
    public $contacts = [];
    public $ui = [];
    public $messages = [];
    public $selectedChatName = '';
    public $selectedChatPicture = '';
    public $selectedChatId = '';
    public $messageText = '';
    public $isLoading = false;
    public $isSending = false;
    public $myProfile = null;


    public function getContacts()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
        ])->get(env('WAHA_API_URL') . '/api/contacts/all', [
            'session' => $this->session,
        ]);


        if ($response->successful()) {
            $this->contacts = $response->json();
        }
    }

    public function getChatsOverview()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
        ])->get(env('WAHA_API_URL') . '/api/' . $this->session . '/chats/overview', [
            'limit' => 30,
        ]);

        if ($response->successful()) {
            $this->ui = $response->json();
        }

    }

    public function getChatMessages($chatId, $name, $picture)
    {
        $this->isLoading = true;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
        ])->get(env('WAHA_API_URL') . '/api/' . $this->session . '/chats/' . $chatId . '/messages');

        if ($response->successful()) {
            $this->messages = $response->json();
            $this->dispatch('messagesUpdated');
            $this->selectedChatName = $name;
            $this->selectedChatPicture = $picture;
            $this->selectedChatId = $chatId;
        }

        $this->isLoading = false;

        return true;
    }

    public function sendMessage()
    {
        // Validate message text
        $this->validate([
            'messageText' => 'required|string|min:1',
        ]);

        if (empty($this->selectedChatId)) {
            session()->flash('error', 'Please select a chat first');
            return;
        }

        $this->isSending = true;

        // Send message via API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('WAHA_API_URL') . '/api/sendText', [
            'session' => $this->session,
            'chatId' => $this->selectedChatId,
            'text' => $this->messageText,
        ]);

        if ($response->successful()) {
            // Clear message input
            $this->messageText = '';

            // Reload messages to show the new message (without showing loading)
            $this->refreshMessages();
            $this->dispatch('messagesUpdated');

            session()->flash('success', 'Message sent successfully');
        } else {
            session()->flash('error', 'Failed to send message');
        }

        $this->isSending = false;
    }

    public function refreshChats()
    {
        $this->getChatsOverview();
    }

    public function refreshMessages()
    {
        if (!empty($this->selectedChatId)) {
            // Fetch messages without showing loading state
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
            ])->get(env('WAHA_API_URL') . '/api/' . $this->session . '/chats/' . $this->selectedChatId . '/messages');

            if ($response->successful()) {
                $this->messages = $response->json();
            }
        }
    }

    public function handleNewMessage($data)
    {
        // Refresh chat overview when new message arrives
        $this->getChatsOverview();

        // If the message is for the currently open chat, refresh messages silently
        if (!empty($this->selectedChatId) && isset($data['chatId']) && $data['chatId'] === $this->selectedChatId) {
            $this->refreshMessages();
        }
    }

    public function getMyProfile()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
        ])->get(env('WAHA_API_URL') . '/api/' . $this->session . '/profile');

        if ($response->successful()) {
            $this->myProfile = $response->json();
        }

    }

    public function mount()
    {
        $this->getContacts();
        $this->getChatsOverview();
        $this->getMyProfile();
    }

    public function render()
    {
        return view('livewire.whatsapp-chat');
    }
}
