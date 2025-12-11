<?php

namespace App\Livewire;

use App\Models\WebsiteChatWidget;
use App\Models\WebsiteChatVisitor;
use App\Models\WebsiteChatMessage;
use App\Services\WebsiteChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Livewire\WithFileUploads;

class WebsiteChatComponent extends Component
{
    use WithFileUploads;

    public $teamNameId = '';
    public $widgetId = null;
    public $visitors = [];
    public $messages = [];
    public $selectedVisitorId = null;
    public $selectedVisitorData = null;
    public $messageText = '';
    public $isLoading = false;
    public $isSending = false;
    public $searchQuery = '';

    protected $listeners = ['refreshVisitors' => 'loadVisitors', 'refreshMessages' => 'loadMessages'];

    public function mount($nameId = null)
    {
        $this->teamNameId = $nameId ?? Cookie::get('current_team') ?? '';
        $this->loadWidget();
        $this->loadVisitors();
    }

    public function loadWidget()
    {
        if (!$this->teamNameId) {
            return;
        }

        $team = \App\Models\Team::where('name_id', $this->teamNameId)->first();
        if ($team) {
            $widget = WebsiteChatWidget::where('team_id', $team->id)->first();
            $this->widgetId = $widget ? $widget->id : null;
        }
    }

    public function getWidget()
    {
        return $this->widgetId ? WebsiteChatWidget::find($this->widgetId) : null;
    }

    public function getSelectedVisitor()
    {
        return $this->selectedVisitorId ? WebsiteChatVisitor::find($this->selectedVisitorId) : null;
    }

    public function loadVisitors()
    {
        if (!$this->widgetId) {
            return;
        }

        $query = WebsiteChatVisitor::where('website_chat_widget_id', $this->widgetId)
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('is_read', false)->where('direction', 'incoming');
            }])
            ->with(['messages' => function ($query) {
                $query->latest('sent_at')->limit(1);
            }])
            ->orderBy('last_message_at', 'desc');

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('email', 'like', "%{$this->searchQuery}%")
                    ->orWhere('ip_address', 'like', "%{$this->searchQuery}%");
            });
        }

        $this->visitors = $query->get()->map(function ($visitor) {
            $lastMessage = $visitor->messages->first();
            return [
                'id' => $visitor->id,
                'session_id' => $visitor->session_id,
                'name' => $visitor->getDisplayName(),
                'avatar' => $visitor->avatar,
                'email' => $visitor->email,
                'is_online' => $visitor->is_online,
                'location' => $visitor->location,
                'device_info' => $visitor->device_info,
                'unread_count' => $visitor->unread_count,
                'last_message' => $lastMessage ? $lastMessage->getPreviewText() : '',
                'last_message_time' => $visitor->last_message_at ? $visitor->last_message_at->format('H:i') : '',
                'last_message_date' => $visitor->last_message_at ? $visitor->last_message_at->format('d/m/Y') : '',
                'last_seen' => $visitor->last_seen_at ? $visitor->last_seen_at->diffForHumans() : '',
            ];
        })->toArray();
    }

    public function selectVisitor($visitorId)
    {
        $this->selectedVisitorId = $visitorId;
        $visitor = WebsiteChatVisitor::find($visitorId);
        if ($visitor) {
            $this->selectedVisitorData = [
                'id' => $visitor->id,
                'session_id' => $visitor->session_id,
                'name' => $visitor->getDisplayName(),
                'avatar' => $visitor->avatar,
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'is_online' => $visitor->is_online,
                'location' => $visitor->location,
                'device_info' => $visitor->device_info,
                'current_page' => $visitor->current_page,
                'last_seen' => $visitor->last_seen_at ? $visitor->last_seen_at->diffForHumans() : '',
            ];
        }
        $this->loadMessages();

        // Mark messages as read
        WebsiteChatMessage::where('website_chat_visitor_id', $visitorId)
            ->where('direction', 'incoming')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadVisitors(); // Refresh to update unread count
    }

    public function loadMessages()
    {
        if (!$this->selectedVisitorId) {
            return;
        }

        $this->isLoading = true;

        $messages = WebsiteChatMessage::where('website_chat_visitor_id', $this->selectedVisitorId)
            ->orderBy('sent_at', 'asc')
            ->with('sentByUser')
            ->get();

        $this->messages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'direction' => $message->direction,
                'type' => $message->message_type,
                'message' => $message->message,
                'file_url' => $message->getFileUrl(),
                'file_name' => $message->file_name,
                'time' => $message->getFormattedTime(),
                'date' => $message->getFormattedDate(),
                'is_read' => $message->is_read,
                'sent_by' => $message->sentByUser ? $message->sentByUser->name : null,
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

        $selectedVisitor = $this->getSelectedVisitor();
        $widget = $this->getWidget();

        if (!$selectedVisitor || !$widget) {
            session()->flash('error', 'Silakan pilih visitor terlebih dahulu');
            return;
        }

        $this->isSending = true;

        try {
            $service = WebsiteChatService::forWidget($widget);
            $result = $service->sendMessageFromAdmin(
                $selectedVisitor,
                $this->messageText,
                Auth::id()
            );

            if ($result) {
                $this->messageText = '';
                $this->loadMessages();
                $this->loadVisitors();
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
        $this->loadVisitors();
        if ($this->selectedVisitorId) {
            $this->loadMessages();
        }
    }

    public function updatedSearchQuery()
    {
        $this->loadVisitors();
    }

    public function deleteVisitor($visitorId)
    {
        try {
            $visitor = WebsiteChatVisitor::find($visitorId);
            if ($visitor && $visitor->website_chat_widget_id == $this->widgetId) {
                $visitor->delete();

                if ($this->selectedVisitorId == $visitorId) {
                    $this->selectedVisitorId = null;
                    $this->selectedVisitorData = null;
                    $this->messages = [];
                }

                $this->loadVisitors();
                session()->flash('success', 'Visitor berhasil dihapus');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.webchat-chat');
    }
}
