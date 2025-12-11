<div class="wc-container">
    {{-- Website Chat Style CSS --}}
    <style>
        :root {
            --wc-primary: #0f4aa2;
            --wc-primary-dark: #0d3d8a;
            --wc-primary-light: #e3f2fd;
            --wc-secondary: #0fa36b;
            --wc-bg-chat: #f5f7fb;
            --wc-bg-sidebar: #ffffff;
            --wc-bg-header: #0f4aa2;
            --wc-bg-input: #ffffff;
            --wc-border: #e6e6e6;
            --wc-text-primary: #222222;
            --wc-text-secondary: #707579;
            --wc-bubble-out: #dcf8c6;
            --wc-bubble-in: #ffffff;
            --wc-hover: #f4f4f5;
            --wc-active: #0f4aa2;
            --wc-online: #4ade80;
        }

        .wc-container {
            height: calc(100vh - 65px);
            min-height: 600px;
            display: flex;
            background-color: var(--wc-bg-chat);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
            width: 100%;
            max-width: 100vw;
        }

        /* Sidebar */
        .wc-sidebar {
            width: 30%;
            min-width: 300px;
            max-width: 420px;
            background: var(--wc-bg-sidebar);
            border-right: 1px solid var(--wc-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .wc-sidebar-header {
            background: var(--wc-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
        }

        .wc-sidebar-header .wc-header-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 500;
        }

        .wc-sidebar-header .wc-header-actions {
            display: flex;
            gap: 8px;
        }

        .wc-sidebar-header .wc-header-actions button {
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

        .wc-sidebar-header .wc-header-actions button:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Search Box */
        .wc-search-box {
            padding: 8px 12px;
            background: var(--wc-bg-sidebar);
            border-bottom: 1px solid var(--wc-border);
        }

        .wc-search-input-wrapper {
            background: #f4f4f5;
            border-radius: 22px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            height: 42px;
        }

        .wc-search-input-wrapper i {
            color: var(--wc-text-secondary);
            font-size: 16px;
        }

        .wc-search-input-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 0 12px;
            font-size: 14px;
            color: var(--wc-text-primary);
        }

        .wc-search-input-wrapper input::placeholder {
            color: var(--wc-text-secondary);
        }

        /* Visitor List */
        .wc-visitor-list {
            flex: 1;
            overflow-y: auto;
            background: var(--wc-bg-sidebar);
        }

        .wc-visitor-list::-webkit-scrollbar {
            width: 6px;
        }

        .wc-visitor-list::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .wc-visitor-item {
            display: flex;
            align-items: center;
            padding: 9px 13px;
            cursor: pointer;
            transition: background 0.15s;
            position: relative;
        }

        .wc-visitor-item:hover {
            background: var(--wc-hover);
        }

        .wc-visitor-item.active {
            background: var(--wc-active);
        }

        .wc-visitor-item.active .wc-visitor-name,
        .wc-visitor-item.active .wc-visitor-preview,
        .wc-visitor-item.active .wc-visitor-time,
        .wc-visitor-item.active .wc-visitor-location {
            color: #ffffff;
        }

        .wc-visitor-item .wc-avatar-wrapper {
            position: relative;
            margin-right: 12px;
        }

        .wc-visitor-item .wc-avatar {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .wc-visitor-item .wc-online-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 14px;
            height: 14px;
            background: var(--wc-online);
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .wc-visitor-item.active .wc-online-indicator {
            border-color: var(--wc-active);
        }

        .wc-visitor-item .wc-visitor-info {
            flex: 1;
            min-width: 0;
        }

        .wc-visitor-item .wc-visitor-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .wc-visitor-item .wc-visitor-name {
            font-size: 16px;
            font-weight: 500;
            color: var(--wc-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wc-visitor-item .wc-visitor-time {
            font-size: 12px;
            color: var(--wc-text-secondary);
            flex-shrink: 0;
            margin-left: 6px;
        }

        .wc-visitor-item .wc-visitor-middle {
            display: flex;
            align-items: center;
            margin-bottom: 2px;
        }

        .wc-visitor-item .wc-visitor-location {
            font-size: 12px;
            color: var(--wc-text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .wc-visitor-item .wc-visitor-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wc-visitor-item .wc-visitor-preview {
            font-size: 14px;
            color: var(--wc-text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .wc-visitor-item .wc-unread-badge {
            background: var(--wc-active);
            color: #ffffff;
            font-size: 12px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
        }

        .wc-visitor-item.active .wc-unread-badge {
            background: #ffffff;
            color: var(--wc-active);
        }

        /* Main Chat Area */
        .wc-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--wc-bg-chat);
            position: relative;
            min-width: 0;
        }

        .wc-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%23f5f7fb'/%3E%3Cpath d='M0 50h100M50 0v100' stroke='%23e6e6e6' stroke-width='0.5'/%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }

        .wc-chat-header {
            background: var(--wc-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
            z-index: 1;
        }

        .wc-chat-header .wc-chat-header-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .wc-chat-header .wc-avatar-wrapper {
            position: relative;
            margin-right: 12px;
        }

        .wc-chat-header .wc-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
        }

        .wc-chat-header .wc-online-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: var(--wc-online);
            border: 2px solid var(--wc-bg-header);
            border-radius: 50%;
        }

        .wc-chat-header .wc-header-name {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
        }

        .wc-chat-header .wc-header-status {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .wc-chat-header .wc-header-actions {
            display: flex;
            gap: 8px;
        }

        .wc-chat-header .wc-header-actions button {
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

        .wc-chat-header .wc-header-actions button:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Visitor Info Panel */
        .wc-visitor-panel {
            background: #ffffff;
            border-left: 1px solid var(--wc-border);
            width: 280px;
            padding: 20px;
            z-index: 1;
            overflow-y: auto;
        }

        .wc-visitor-panel h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--wc-text-secondary);
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .wc-visitor-panel .wc-info-item {
            margin-bottom: 12px;
        }

        .wc-visitor-panel .wc-info-label {
            font-size: 12px;
            color: var(--wc-text-secondary);
            margin-bottom: 2px;
        }

        .wc-visitor-panel .wc-info-value {
            font-size: 14px;
            color: var(--wc-text-primary);
            word-break: break-all;
        }

        /* Messages Area */
        .wc-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 10%;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .wc-messages::-webkit-scrollbar {
            width: 6px;
        }

        .wc-messages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .wc-message {
            max-width: 65%;
            margin-bottom: 4px;
            position: relative;
        }

        .wc-message.out {
            align-self: flex-end;
        }

        .wc-message.in {
            align-self: flex-start;
        }

        .wc-message .wc-bubble {
            padding: 7px 12px 8px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        .wc-message.out .wc-bubble {
            background: var(--wc-bubble-out);
            border-bottom-right-radius: 4px;
        }

        .wc-message.in .wc-bubble {
            background: var(--wc-bubble-in);
            border-bottom-left-radius: 4px;
        }

        .wc-message .wc-text {
            font-size: 15px;
            line-height: 21px;
            color: var(--wc-text-primary);
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .wc-message .wc-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 2px;
            float: right;
            margin-left: 12px;
        }

        .wc-message .wc-time {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.35);
        }

        .wc-message.out .wc-check {
            color: #4fae4e;
            font-size: 14px;
        }

        .wc-message .wc-sent-by {
            font-size: 11px;
            color: var(--wc-primary);
            font-weight: 500;
            margin-bottom: 2px;
        }

        /* Date Separator */
        .wc-date-separator {
            display: flex;
            justify-content: center;
            margin: 16px 0;
        }

        .wc-date-separator span {
            background: rgba(0, 0, 0, 0.12);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Input Area */
        .wc-input-area {
            background: var(--wc-bg-input);
            padding: 8px 10px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            z-index: 1;
            border-top: 1px solid var(--wc-border);
        }

        .wc-input-wrapper {
            flex: 1;
            background: #f4f4f5;
            border-radius: 21px;
            display: flex;
            align-items: flex-end;
            padding: 6px 12px;
            min-height: 42px;
        }

        .wc-input-wrapper textarea {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            font-size: 15px;
            color: var(--wc-text-primary);
            resize: none;
            max-height: 120px;
            line-height: 21px;
            padding: 5px 0;
        }

        .wc-input-wrapper textarea::placeholder {
            color: var(--wc-text-secondary);
        }

        .wc-input-area .wc-send-btn {
            width: 42px;
            height: 42px;
            border: none;
            background: var(--wc-active);
            border-radius: 50%;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .wc-input-area .wc-send-btn:hover {
            background: var(--wc-primary-dark);
        }

        .wc-input-area .wc-send-btn:disabled {
            background: #c4c4c4;
            cursor: not-allowed;
        }

        /* Empty State */
        .wc-empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .wc-empty-state i {
            font-size: 80px;
            color: #bdbdbd;
            margin-bottom: 20px;
        }

        .wc-empty-state h3 {
            font-size: 20px;
            color: var(--wc-text-primary);
            margin-bottom: 8px;
        }

        .wc-empty-state p {
            font-size: 14px;
            color: var(--wc-text-secondary);
        }

        /* Loading */
        .wc-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .wc-loading .spinner-border {
            width: 24px;
            height: 24px;
            border-width: 2px;
            color: var(--wc-active);
        }
    </style>

    <div class="d-flex h-100" style="width: 100%;">
        {{-- Sidebar --}}
        <div class="wc-sidebar">
            <div class="wc-sidebar-header">
                <span class="wc-header-title">
                    <i class="fa fa-comments me-2"></i>
                    Website Chat
                </span>
                <div class="wc-header-actions">
                    <button wire:click="refreshAll" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div class="wc-search-box">
                <div class="wc-search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="Cari visitor...">
                </div>
            </div>

            <div class="wc-visitor-list">
                @if (count($visitors) > 0)
                    @foreach ($visitors as $visitor)
                        <div class="wc-visitor-item {{ $selectedVisitorId == $visitor['id'] ? 'active' : '' }}"
                            wire:click="selectVisitor({{ $visitor['id'] }})">
                            <div class="wc-avatar-wrapper">
                                <img class="wc-avatar" src="{{ $visitor['avatar'] }}" alt="{{ $visitor['name'] }}">
                                @if ($visitor['is_online'])
                                    <div class="wc-online-indicator"></div>
                                @endif
                            </div>
                            <div class="wc-visitor-info">
                                <div class="wc-visitor-top">
                                    <span class="wc-visitor-name">{{ $visitor['name'] }}</span>
                                    <span class="wc-visitor-time">{{ $visitor['last_message_time'] }}</span>
                                </div>
                                <div class="wc-visitor-middle">
                                    <span class="wc-visitor-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $visitor['location'] ?: 'Unknown' }}
                                    </span>
                                </div>
                                <div class="wc-visitor-bottom">
                                    <span class="wc-visitor-preview">{{ $visitor['last_message'] }}</span>
                                    @if ($visitor['unread_count'] > 0)
                                        <span class="wc-unread-badge">{{ $visitor['unread_count'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <i class="fa fa-users fs-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada visitor</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Main Chat Area --}}
        <div class="wc-main">
            @if ($selectedVisitorData)
                <div class="wc-chat-header">
                    <div class="wc-chat-header-info">
                        <div class="wc-avatar-wrapper">
                            <img class="wc-avatar" src="{{ $selectedVisitorData['avatar'] }}"
                                alt="{{ $selectedVisitorData['name'] }}">
                            @if ($selectedVisitorData['is_online'])
                                <div class="wc-online-indicator"></div>
                            @endif
                        </div>
                        <div>
                            <div class="wc-header-name">{{ $selectedVisitorData['name'] }}</div>
                            <div class="wc-header-status">
                                @if ($selectedVisitorData['is_online'])
                                    Online
                                @else
                                    {{ $selectedVisitorData['last_seen'] }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="wc-header-actions">
                        <button wire:click="loadMessages" title="Refresh Messages">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button wire:click="deleteVisitor({{ $selectedVisitorData['id'] }})"
                            title="Hapus Visitor"
                            onclick="return confirm('Hapus visitor ini beserta semua pesannya?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-grow-1" style="min-height: 0;">
                    <div class="wc-messages flex-grow-1" id="wc-messages-container">
                        @if ($isLoading)
                            <div class="wc-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        @else
                            @php $lastDate = null; @endphp
                            @foreach ($messages as $message)
                                @if ($lastDate !== $message['date'])
                                    <div class="wc-date-separator">
                                        <span>{{ $message['date'] }}</span>
                                    </div>
                                    @php $lastDate = $message['date']; @endphp
                                @endif

                                <div class="wc-message {{ $message['direction'] === 'outgoing' ? 'out' : 'in' }}">
                                    <div class="wc-bubble">
                                        @if ($message['direction'] === 'outgoing' && $message['sent_by'])
                                            <div class="wc-sent-by">{{ $message['sent_by'] }}</div>
                                        @endif
                                        @if ($message['type'] === 'image' && $message['file_url'])
                                            <div class="mb-2">
                                                <img src="{{ $message['file_url'] }}" alt="Image"
                                                    style="max-width: 200px; border-radius: 8px;">
                                            </div>
                                        @elseif ($message['type'] === 'file' && $message['file_url'])
                                            <div class="mb-2">
                                                <a href="{{ $message['file_url'] }}" target="_blank" class="text-primary">
                                                    <i class="fas fa-file me-1"></i>{{ $message['file_name'] ?? 'Download File' }}
                                                </a>
                                            </div>
                                        @endif
                                        <span class="wc-text">{{ $message['message'] }}</span>
                                        <span class="wc-meta">
                                            <span class="wc-time">{{ $message['time'] }}</span>
                                            @if ($message['direction'] === 'outgoing')
                                                <i class="fas {{ $message['is_read'] ? 'fa-check-double' : 'fa-check' }} wc-check"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- Visitor Info Panel --}}
                    <div class="wc-visitor-panel">
                        <h4>Info Visitor</h4>
                        @if ($selectedVisitorData['email'])
                            <div class="wc-info-item">
                                <div class="wc-info-label">Email</div>
                                <div class="wc-info-value">{{ $selectedVisitorData['email'] }}</div>
                            </div>
                        @endif
                        @if ($selectedVisitorData['phone'])
                            <div class="wc-info-item">
                                <div class="wc-info-label">Phone</div>
                                <div class="wc-info-value">{{ $selectedVisitorData['phone'] }}</div>
                            </div>
                        @endif
                        <div class="wc-info-item">
                            <div class="wc-info-label">Lokasi</div>
                            <div class="wc-info-value">{{ $selectedVisitorData['location'] ?: 'Unknown' }}</div>
                        </div>
                        <div class="wc-info-item">
                            <div class="wc-info-label">Device</div>
                            <div class="wc-info-value">{{ $selectedVisitorData['device_info'] ?: 'Unknown' }}</div>
                        </div>
                        @if ($selectedVisitorData['current_page'])
                            <div class="wc-info-item">
                                <div class="wc-info-label">Halaman Terakhir</div>
                                <div class="wc-info-value">{{ $selectedVisitorData['current_page'] }}</div>
                            </div>
                        @endif
                        <div class="wc-info-item">
                            <div class="wc-info-label">Status</div>
                            <div class="wc-info-value">
                                @if ($selectedVisitorData['is_online'])
                                    <span class="badge bg-success">Online</span>
                                @else
                                    <span class="badge bg-secondary">Offline</span>
                                    <small class="d-block text-muted mt-1">{{ $selectedVisitorData['last_seen'] }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wc-input-area">
                    <div class="wc-input-wrapper">
                        <textarea wire:model="messageText" wire:keydown.enter.prevent="sendMessage" placeholder="Tulis pesan..." rows="1"></textarea>
                    </div>
                    <button class="wc-send-btn" wire:click="sendMessage" wire:loading.attr="disabled"
                        {{ $isSending ? 'disabled' : '' }}>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            @else
                <div class="wc-empty-state">
                    <i class="fa fa-comments"></i>
                    <h3>Website Chat</h3>
                    <p>Pilih visitor untuk mulai membalas pesan</p>
                </div>
            @endif
        </div>
    </div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('messagesUpdated', () => {
            setTimeout(() => {
                const container = document.getElementById('wc-messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        });
    });

    // Auto-resize textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('.wc-input-wrapper textarea');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }
    });
</script>
</div>
