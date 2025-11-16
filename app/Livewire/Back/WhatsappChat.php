<?php

namespace App\Livewire\Back;

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

            // Reload messages to show the new message
            $this->getChatMessages($this->selectedChatId, $this->selectedChatName, $this->selectedChatPicture);

            session()->flash('success', 'Message sent successfully');
        } else {
            session()->flash('error', 'Failed to send message');
        }
    }

    public function mount()
    {
        $this->getContacts();
        $this->getChatsOverview();
    }

    public function render()
    {
        return view('livewire.back.whatsapp-chat');
    }
}
