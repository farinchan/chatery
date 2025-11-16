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

    public function getChatMessages($chatId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
        ])->get(env('WAHA_API_URL') . '/api/' . $this->session . '/chats/' . $chatId . '/messages');

        if ($response->successful()) {
            $this->messages = $response->json();
            $this->dispatch('messagesUpdated');
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
