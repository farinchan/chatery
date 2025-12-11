<div class="tg-container">
    {{-- Telegram Style CSS --}}
    <style>
        :root {
            --tg-blue: #0088cc;
            --tg-blue-dark: #006699;
            --tg-blue-light: #e3f2fd;
            --tg-bg-chat: #e8e8e8;
            --tg-bg-sidebar: #ffffff;
            --tg-bg-header: #517da2;
            --tg-bg-input: #ffffff;
            --tg-border: #e6e6e6;
            --tg-text-primary: #222222;
            --tg-text-secondary: #707579;
            --tg-bubble-out: #effdde;
            --tg-bubble-in: #ffffff;
            --tg-hover: #f4f4f5;
            --tg-active: #3390ec;
        }

        .tg-container {
            height: calc(100vh - 120px);
            min-height: 600px;
            display: flex;
            background-color: var(--tg-bg-chat);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.06), 0 2px 5px 0 rgba(0,0,0,.2);
            width: 100%;
        }

        /* Sidebar */
        .tg-sidebar {
            width: 30%;
            min-width: 300px;
            max-width: 420px;
            background: var(--tg-bg-sidebar);
            border-right: 1px solid var(--tg-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .tg-sidebar-header {
            background: var(--tg-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
        }

        .tg-sidebar-header .tg-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .tg-sidebar-header .tg-header-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 500;
        }

        .tg-sidebar-header .tg-header-actions {
            display: flex;
            gap: 8px;
        }

        .tg-sidebar-header .tg-header-actions button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .tg-sidebar-header .tg-header-actions button:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Search Box */
        .tg-search-box {
            padding: 8px 12px;
            background: var(--tg-bg-sidebar);
            border-bottom: 1px solid var(--tg-border);
        }

        .tg-search-input-wrapper {
            background: #f4f4f5;
            border-radius: 22px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            height: 42px;
        }

        .tg-search-input-wrapper i {
            color: var(--tg-text-secondary);
            font-size: 16px;
        }

        .tg-search-input-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 0 12px;
            font-size: 14px;
            color: var(--tg-text-primary);
        }

        .tg-search-input-wrapper input::placeholder {
            color: var(--tg-text-secondary);
        }

        /* Chat List */
        .tg-chat-list {
            flex: 1;
            overflow-y: auto;
            background: var(--tg-bg-sidebar);
        }

        .tg-chat-list::-webkit-scrollbar {
            width: 6px;
        }

        .tg-chat-list::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        .tg-chat-item {
            display: flex;
            align-items: center;
            padding: 9px 13px;
            cursor: pointer;
            transition: background 0.15s;
            position: relative;
        }

        .tg-chat-item:hover {
            background: var(--tg-hover);
        }

        .tg-chat-item.active {
            background: var(--tg-active);
        }

        .tg-chat-item.active .tg-chat-name,
        .tg-chat-item.active .tg-chat-preview,
        .tg-chat-item.active .tg-chat-time {
            color: #ffffff;
        }

        .tg-chat-item .tg-avatar {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .tg-chat-item .tg-chat-info {
            flex: 1;
            min-width: 0;
        }

        .tg-chat-item .tg-chat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .tg-chat-item .tg-chat-name {
            font-size: 16px;
            font-weight: 500;
            color: var(--tg-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tg-chat-item .tg-chat-time {
            font-size: 12px;
            color: var(--tg-text-secondary);
            flex-shrink: 0;
            margin-left: 6px;
        }

        .tg-chat-item .tg-chat-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tg-chat-item .tg-chat-preview {
            font-size: 14px;
            color: var(--tg-text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .tg-chat-item .tg-unread-badge {
            background: var(--tg-active);
            color: #ffffff;
            font-size: 12px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
        }

        .tg-chat-item.active .tg-unread-badge {
            background: #ffffff;
            color: var(--tg-active);
        }

        /* Main Chat Area */
        .tg-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--tg-bg-chat);
            position: relative;
            min-width: 0;
        }

        .tg-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%23e8e8e8'/%3E%3Cpath d='M0 50h100M50 0v100' stroke='%23d9d9d9' stroke-width='0.5'/%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }

        .tg-chat-header {
            background: var(--tg-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
            z-index: 1;
        }

        .tg-chat-header .tg-chat-header-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .tg-chat-header .tg-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }

        .tg-chat-header .tg-header-name {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
        }

        .tg-chat-header .tg-header-status {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
        }

        .tg-chat-header .tg-header-actions {
            display: flex;
            gap: 8px;
        }

        .tg-chat-header .tg-header-actions button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .tg-chat-header .tg-header-actions button:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Messages Area */
        .tg-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 10%;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .tg-messages::-webkit-scrollbar {
            width: 6px;
        }

        .tg-messages::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        .tg-message {
            max-width: 65%;
            margin-bottom: 4px;
            position: relative;
        }

        .tg-message.out {
            align-self: flex-end;
        }

        .tg-message.in {
            align-self: flex-start;
        }

        .tg-message .tg-bubble {
            padding: 7px 12px 8px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
        }

        .tg-message.out .tg-bubble {
            background: var(--tg-bubble-out);
            border-bottom-right-radius: 4px;
        }

        .tg-message.in .tg-bubble {
            background: var(--tg-bubble-in);
            border-bottom-left-radius: 4px;
        }

        .tg-message .tg-text {
            font-size: 15px;
            line-height: 21px;
            color: var(--tg-text-primary);
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .tg-message .tg-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 2px;
            float: right;
            margin-left: 12px;
        }

        .tg-message .tg-time {
            font-size: 12px;
            color: rgba(0,0,0,0.35);
        }

        .tg-message.out .tg-check {
            color: #4fae4e;
            font-size: 14px;
        }

        /* Date Separator */
        .tg-date-separator {
            display: flex;
            justify-content: center;
            margin: 16px 0;
        }

        .tg-date-separator span {
            background: rgba(0,0,0,0.12);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Input Area */
        .tg-input-area {
            background: var(--tg-bg-input);
            padding: 8px 10px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            z-index: 1;
            border-top: 1px solid var(--tg-border);
        }

        .tg-input-area .tg-attach-btn {
            width: 42px;
            height: 42px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: var(--tg-text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .tg-input-area .tg-attach-btn:hover {
            background: var(--tg-hover);
            color: var(--tg-active);
        }

        .tg-input-wrapper {
            flex: 1;
            background: #f4f4f5;
            border-radius: 21px;
            display: flex;
            align-items: flex-end;
            padding: 6px 12px;
            min-height: 42px;
        }

        .tg-input-wrapper textarea {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            font-size: 15px;
            color: var(--tg-text-primary);
            resize: none;
            max-height: 120px;
            line-height: 21px;
            padding: 5px 0;
        }

        .tg-input-wrapper textarea::placeholder {
            color: var(--tg-text-secondary);
        }

        .tg-input-area .tg-send-btn {
            width: 42px;
            height: 42px;
            border: none;
            background: var(--tg-active);
            border-radius: 50%;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .tg-input-area .tg-send-btn:hover {
            background: var(--tg-blue-dark);
        }

        .tg-input-area .tg-send-btn:disabled {
            background: #c4c4c4;
            cursor: not-allowed;
        }

        /* Empty State */
        .tg-empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .tg-empty-state i {
            font-size: 80px;
            color: #bdbdbd;
            margin-bottom: 20px;
        }

        .tg-empty-state h3 {
            font-size: 20px;
            color: var(--tg-text-primary);
            margin-bottom: 8px;
        }

        .tg-empty-state p {
            font-size: 14px;
            color: var(--tg-text-secondary);
        }

        /* Loading */
        .tg-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .tg-loading .spinner-border {
            width: 24px;
            height: 24px;
            border-width: 2px;
            color: var(--tg-active);
        }

        /* Media Types */
        .tg-media-icon {
            margin-right: 6px;
            opacity: 0.7;
        }
    </style>

    {{-- Sidebar --}}
    <div class="tg-sidebar">
        <div class="tg-sidebar-header">
            <span class="tg-header-title">
                <i class="fab fa-telegram me-2"></i>
                Telegram
            </span>
            <div class="tg-header-actions">
                <button wire:click="refreshAll" title="Refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="tg-search-box">
            <div class="tg-search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="Cari...">
            </div>
        </div>

        <div class="tg-chat-list">
            @if (count($chats) > 0)
                @foreach ($chats as $chat)
                    <div class="tg-chat-item {{ $selectedChatId == $chat['id'] ? 'active' : '' }}"
                        wire:click="selectChat({{ $chat['id'] }})">
                        <img class="tg-avatar" src="{{ $chat['photo'] }}" alt="{{ $chat['name'] }}">
                        <div class="tg-chat-info">
                            <div class="tg-chat-top">
                                <span class="tg-chat-name">{{ $chat['name'] }}</span>
                                <span class="tg-chat-time">{{ $chat['last_message_time'] }}</span>
                            </div>
                            <div class="tg-chat-bottom">
                                <span class="tg-chat-preview">{{ $chat['last_message'] }}</span>
                                @if ($chat['unread_count'] > 0)
                                    <span class="tg-unread-badge">{{ $chat['unread_count'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-10">
                    <i class="fab fa-telegram fs-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada percakapan</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Main Chat Area --}}
    <div class="tg-main">
        @if ($selectedChat)
            <div class="tg-chat-header">
                <div class="tg-chat-header-info">
                    <img class="tg-avatar" src="{{ $selectedChat->photo }}"
                        alt="{{ $selectedChat->getDisplayName() }}">
                    <div>
                        <div class="tg-header-name">{{ $selectedChat->getDisplayName() }}</div>
                        <div class="tg-header-status">
                            @if ($selectedChat->username)
                                @{{ $selectedChat->username }}
                            @else
                                {{ ucfirst($selectedChat->chat_type) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tg-header-actions">
                    <button wire:click="loadMessages" title="Refresh Messages">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div class="tg-messages" id="tg-messages-container">
                @if ($isLoading)
                    <div class="tg-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                @else
                    @php $lastDate = null; @endphp
                    @foreach ($messages as $message)
                        @if ($lastDate !== $message['date'])
                            <div class="tg-date-separator">
                                <span>{{ $message['date'] }}</span>
                            </div>
                            @php $lastDate = $message['date']; @endphp
                        @endif

                        <div class="tg-message {{ $message['direction'] === 'outgoing' ? 'out' : 'in' }}">
                            <div class="tg-bubble">
                                @if ($message['type'] !== 'text')
                                    <div class="tg-media-icon">
                                        @switch($message['type'])
                                            @case('photo')
                                                📷
                                            @break

                                            @case('video')
                                                🎬
                                            @break

                                            @case('audio')
                                                🎵
                                            @break

                                            @case('voice')
                                                🎤
                                            @break

                                            @case('document')
                                                📄
                                            @break

                                            @case('sticker')
                                                🏷️
                                            @break

                                            @case('location')
                                                📍
                                            @break

                                            @case('contact')
                                                👤
                                            @break

                                            @default
                                                📎
                                        @endswitch
                                    </div>
                                @endif
                                <span class="tg-text">{{ $message['text'] ?? $message['caption'] ?? '' }}</span>
                                <span class="tg-meta">
                                    <span class="tg-time">{{ $message['time'] }}</span>
                                    @if ($message['direction'] === 'outgoing')
                                        <i class="fas fa-check-double tg-check"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="tg-input-area">
                <div class="tg-input-wrapper">
                    <textarea wire:model="messageText" wire:keydown.enter.prevent="sendMessage" placeholder="Tulis pesan..."
                        rows="1"></textarea>
                </div>
                <button class="tg-send-btn" wire:click="sendMessage" wire:loading.attr="disabled"
                    {{ $isSending ? 'disabled' : '' }}>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        @else
            <div class="tg-empty-state">
                <i class="fab fa-telegram"></i>
                <h3>Telegram Chat</h3>
                <p>Pilih percakapan untuk mulai membalas pesan</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('messagesUpdated', () => {
            setTimeout(() => {
                const container = document.getElementById('tg-messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        });
    });

    // Auto-resize textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('.tg-input-wrapper textarea');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }
    });
</script>
</div>
