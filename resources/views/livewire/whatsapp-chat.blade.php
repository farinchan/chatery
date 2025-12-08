<div class="wa-container">
    {{-- WhatsApp Web Style CSS --}}
    <style>
        :root {
            --wa-green: #00a884;
            --wa-green-dark: #008069;
            --wa-green-light: #d9fdd3;
            --wa-bg-chat: #efeae2;
            --wa-bg-sidebar: #ffffff;
            --wa-bg-header: #f0f2f5;
            --wa-bg-input: #ffffff;
            --wa-border: #e9edef;
            --wa-text-primary: #111b21;
            --wa-text-secondary: #667781;
            --wa-bubble-out: #d9fdd3;
            --wa-bubble-in: #ffffff;
            --wa-hover: #f5f6f6;
            --wa-active: #2a3942;
        }

        .wa-container {
            height: calc(100vh - 120px);
            min-height: 600px;
            display: flex;
            background-color: var(--wa-bg-chat);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.06), 0 2px 5px 0 rgba(0,0,0,.2);
            width: 100%;
        }

        /* Sidebar */
        .wa-sidebar {
            width: 30%;
            min-width: 300px;
            max-width: 420px;
            background: var(--wa-bg-sidebar);
            border-right: 1px solid var(--wa-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .wa-sidebar-header {
            background: var(--wa-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
        }

        .wa-sidebar-header .wa-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .wa-sidebar-header .wa-header-actions {
            display: flex;
            gap: 8px;
        }

        .wa-sidebar-header .wa-header-actions button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #54656f;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .wa-sidebar-header .wa-header-actions button:hover {
            background: rgba(0,0,0,0.05);
        }

        /* Search Box */
        .wa-search-box {
            padding: 8px 12px;
            background: var(--wa-bg-header);
        }

        .wa-search-input-wrapper {
            background: var(--wa-bg-input);
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            height: 35px;
        }

        .wa-search-input-wrapper i {
            color: #54656f;
            font-size: 14px;
        }

        .wa-search-input-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 0 12px;
            font-size: 14px;
            color: var(--wa-text-primary);
        }

        .wa-search-input-wrapper input::placeholder {
            color: #667781;
        }

        /* Chat List */
        .wa-chat-list {
            flex: 1;
            overflow-y: auto;
            background: var(--wa-bg-sidebar);
        }

        .wa-chat-list::-webkit-scrollbar {
            width: 6px;
        }

        .wa-chat-list::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        .wa-chat-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            cursor: pointer;
            transition: background 0.15s, opacity 0.2s;
            border-bottom: 1px solid var(--wa-border);
            position: relative;
        }

        .wa-chat-item:hover {
            background: var(--wa-hover);
        }

        .wa-chat-item.active {
            background: #f0f2f5;
        }

        .wa-chat-item .wa-avatar {
            width: 49px;
            height: 49px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .wa-chat-item .wa-chat-info {
            flex: 1;
            min-width: 0;
        }

        .wa-chat-item .wa-chat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3px;
        }

        .wa-chat-item .wa-chat-name {
            font-size: 16px;
            font-weight: 400;
            color: var(--wa-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wa-chat-item .wa-chat-time {
            font-size: 12px;
            color: var(--wa-text-secondary);
            flex-shrink: 0;
            margin-left: 6px;
        }

        .wa-chat-item .wa-chat-preview {
            font-size: 14px;
            color: var(--wa-text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
        }

        .wa-chat-item .wa-chat-preview i {
            margin-right: 4px;
            color: #53bdeb;
        }

        /* Main Chat Area */
        .wa-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--wa-bg-chat);
            position: relative;
            min-width: 0;
        }

        .wa-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23d4d4d4' fill-opacity='0.08' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.4;
            pointer-events: none;
            z-index: 0;
        }

        .wa-chat-header {
            background: var(--wa-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
            z-index: 1;
        }

        .wa-chat-header .wa-chat-header-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .wa-chat-header .wa-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .wa-chat-header .wa-header-name {
            font-size: 16px;
            font-weight: 500;
            color: var(--wa-text-primary);
        }

        .wa-chat-header .wa-header-status {
            font-size: 13px;
            color: var(--wa-text-secondary);
        }

        .wa-chat-header .wa-header-actions {
            display: flex;
            gap: 8px;
        }

        .wa-chat-header .wa-header-actions button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #54656f;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .wa-chat-header .wa-header-actions button:hover {
            background: rgba(0,0,0,0.05);
        }

        /* Messages Area */
        .wa-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 5%;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .wa-messages::-webkit-scrollbar {
            width: 6px;
        }

        .wa-messages::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        .wa-message {
            max-width: 65%;
            margin-bottom: 2px;
            position: relative;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .wa-message.out {
            align-self: flex-end;
        }

        .wa-message.in {
            align-self: flex-start;
        }

        .wa-message .wa-bubble {
            padding: 6px 7px 8px 9px;
            border-radius: 7.5px;
            position: relative;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
            word-wrap: break-word;
        }

        .wa-message.out .wa-bubble {
            background: var(--wa-bubble-out);
            border-top-right-radius: 0;
        }

        .wa-message.in .wa-bubble {
            background: var(--wa-bubble-in);
            border-top-left-radius: 0;
        }

        .wa-message .wa-bubble::before {
            content: '';
            position: absolute;
            top: 0;
            width: 8px;
            height: 13px;
        }

        .wa-message.out .wa-bubble::before {
            right: -8px;
            background: linear-gradient(to bottom right, var(--wa-bubble-out) 50%, transparent 50%);
        }

        .wa-message.in .wa-bubble::before {
            left: -8px;
            background: linear-gradient(to bottom left, var(--wa-bubble-in) 50%, transparent 50%);
        }

        .wa-message .wa-text {
            font-size: 14.2px;
            line-height: 19px;
            color: var(--wa-text-primary);
            white-space: pre-wrap;
        }

        .wa-message .wa-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 3px;
            margin-top: 2px;
            float: right;
            margin-left: 10px;
            position: relative;
            top: 5px;
        }

        .wa-message .wa-time {
            font-size: 11px;
            color: rgba(0,0,0,0.45);
        }

        .wa-message.out .wa-check {
            color: #53bdeb;
            font-size: 14px;
        }

        .wa-message .wa-sender-name {
            font-size: 12.5px;
            font-weight: 500;
            color: #e67e22;
            margin-bottom: 2px;
        }

        /* Date Separator */
        .wa-date-separator {
            display: flex;
            justify-content: center;
            margin: 12px 0;
        }

        .wa-date-separator span {
            background: #e1f2fb;
            padding: 5px 12px;
            border-radius: 7.5px;
            font-size: 12.5px;
            color: #54656f;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
        }

        /* Input Area */
        .wa-input-area {
            background: var(--wa-bg-header);
            padding: 10px 16px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            z-index: 1;
        }

        .wa-input-actions {
            display: flex;
            gap: 4px;
        }

        .wa-input-actions button {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #54656f;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .wa-input-actions button:hover {
            background: rgba(0,0,0,0.05);
        }

        .wa-input-wrapper {
            flex: 1;
            background: var(--wa-bg-input);
            border-radius: 8px;
            display: flex;
            align-items: flex-end;
            padding: 9px 12px;
            min-height: 42px;
            max-height: 150px;
        }

        .wa-input-wrapper textarea {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            line-height: 20px;
            color: var(--wa-text-primary);
            resize: none;
            max-height: 130px;
        }

        .wa-input-wrapper textarea::placeholder {
            color: #667781;
        }

        .wa-send-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 50%;
            color: #54656f;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .wa-send-btn:hover {
            background: rgba(0,0,0,0.05);
        }

        .wa-send-btn.active {
            color: var(--wa-green);
        }

        /* Empty State */
        .wa-empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f0f2f5;
            z-index: 1;
            border-bottom: 6px solid var(--wa-green);
            overflow: hidden;
        }

        .wa-empty-state .wa-logo {
            width: 250px;
            max-width: 80%;
            height: auto;
            margin-bottom: 40px;
            opacity: 0.8;
        }

        .wa-empty-state h2 {
            font-size: 32px;
            font-weight: 300;
            color: #41525d;
            margin-bottom: 20px;
            text-align: center;
            padding: 0 20px;
        }

        .wa-empty-state p {
            font-size: 14px;
            color: #667781;
            text-align: center;
            max-width: 450px;
            width: 90%;
            line-height: 20px;
            padding: 0 20px;
        }

        /* Loading State */
        .wa-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(237, 237, 237, 0.95);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .wa-spinner {
            width: 45px;
            height: 45px;
            border: 3px solid #e0e0e0;
            border-top: 3px solid var(--wa-green);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        .wa-loading-text {
            margin-top: 12px;
            font-size: 13px;
            color: var(--wa-text-secondary);
            font-weight: 400;
        }

        /* Chat item loading */
        .wa-chat-item.loading {
            opacity: 0.6;
            pointer-events: none;
            background: #f5f5f5;
        }

        .wa-chat-item.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            width: 18px;
            height: 18px;
            margin-top: -9px;
            border: 2px solid #e0e0e0;
            border-top: 2px solid var(--wa-green);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        /* Messages loading overlay */
        .wa-messages-loading {
            position: absolute;
            top: 59px;
            left: 0;
            right: 0;
            bottom: 62px;
            background: rgba(239, 234, 226, 0.92);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 50;
            backdrop-filter: blur(2px);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .wa-sidebar {
                width: 35%;
                min-width: 280px;
            }
            .wa-messages {
                padding: 20px 3%;
            }
        }

        @media (max-width: 992px) {
            .wa-sidebar {
                width: 40%;
                min-width: 260px;
            }
            .wa-messages {
                padding: 20px 15px;
            }
            .wa-message {
                max-width: 80%;
            }
        }

        @media (max-width: 768px) {
            .wa-container {
                height: calc(100vh - 80px);
            }
            .wa-sidebar {
                width: 100%;
                max-width: none;
            }
            .wa-main {
                display: none;
            }
            .wa-container.chat-active .wa-sidebar {
                display: none;
            }
            .wa-container.chat-active .wa-main {
                display: flex;
            }
            .wa-message {
                max-width: 85%;
            }
        }
    </style>

    <div class="d-flex h-100" style="width: 100%;">
        {{-- Sidebar --}}
        <div class="wa-sidebar">
            {{-- Sidebar Header --}}
            <div class="wa-sidebar-header">
                <img class="wa-avatar"
                    src="{{ $myProfile['picture'] ?? 'https://ui-avatars.com/api/?background=dfe5e7&color=54656f&name=' . urlencode($myProfile['name'] ?? 'User') }}"
                    alt="Profile" />
                <div class="wa-header-actions">
                    <button type="button" data-bs-toggle="tooltip" title="Communities">
                        <i class="ki-duotone ki-people fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </button>
                    <button type="button" data-bs-toggle="tooltip" title="Status">
                        <i class="ki-duotone ki-update-file fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                    <button type="button" data-bs-toggle="tooltip" title="Channels">
                        <i class="ki-duotone ki-notification-circle fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                    <button type="button" data-bs-toggle="tooltip" title="New Chat">
                        <i class="ki-duotone ki-message-add fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </button>
                    <button type="button" data-bs-toggle="tooltip" title="Menu">
                        <i class="ki-duotone ki-dots-vertical fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </button>
                </div>
            </div>

            {{-- Search Box --}}
            <div class="wa-search-box">
                <div class="wa-search-input-wrapper">
                    <i class="ki-duotone ki-magnifier">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" placeholder="Search or start new chat" />
                </div>
            </div>

            {{-- Chat List --}}
            <div class="wa-chat-list" style="position: relative;">
                {{-- Loading overlay for chat list --}}
                <div wire:loading.flex wire:target="refreshChats" class="wa-loading" style="position: absolute; background: rgba(255,255,255,0.8);">
                    <div class="wa-spinner"></div>
                </div>

                @if(count($ui) == 0)
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 p-4">
                        <i class="ki-duotone ki-message-text-2 fs-3x text-muted mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <p class="text-muted text-center">No chats yet</p>
                    </div>
                @endif

                @foreach ($ui as $u)
                    @php
                        $ts = $u['lastMessage']['timestamp'] ?? null;
                        if ($ts) {
                            $time =
                                is_numeric($ts) && strlen((string) $ts) > 10
                                    ? \Carbon\Carbon::createFromTimestampMs($ts)
                                    : \Carbon\Carbon::createFromTimestamp($ts);
                            $isToday = $time->isToday();
                            $isYesterday = $time->isYesterday();
                            $timeDisplay = $isToday
                                ? $time->format('H:i')
                                : ($isYesterday ? 'Yesterday' : $time->format('d/m/Y'));
                        } else {
                            $timeDisplay = '';
                        }
                    @endphp
                    <div class="wa-chat-item {{ $selectedChatId === $u['id'] ? 'active' : '' }} {{ $isLoading && $selectedChatId === $u['id'] ? 'loading' : '' }}"
                        wire:click="getChatMessages('{{ $u['id'] }}', '{{ addslashes($u['name']) }}', '{{ $u['picture'] }}')">
                        <img class="wa-avatar"
                            src="{{ $u['picture'] ?: 'https://ui-avatars.com/api/?background=dfe5e7&color=54656f&name=' . urlencode($u['name']) }}"
                            alt="{{ $u['name'] }}" />
                        <div class="wa-chat-info">
                            <div class="wa-chat-top">
                                <span class="wa-chat-name">{{ $u['name'] }}</span>
                                <span class="wa-chat-time">{{ $timeDisplay }}</span>
                            </div>
                            <div class="wa-chat-preview">
                                @if (isset($u['lastMessage']['fromMe']) && $u['lastMessage']['fromMe'])
                                    <i class="ki-duotone ki-check-circle fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                @endif
                                {{ Str::limit($u['lastMessage']['body'] ?? '', 35) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Main Chat Area --}}
        <div class="wa-main">
            @if ($messages && count($messages) > 0)
                {{-- Chat Header --}}
                <div class="wa-chat-header">
                    <div class="wa-chat-header-info">
                        <img class="wa-avatar"
                            src="{{ $selectedChatPicture ?: 'https://ui-avatars.com/api/?background=dfe5e7&color=54656f&name=' . urlencode($selectedChatName) }}"
                            alt="{{ $selectedChatName }}" />
                        <div>
                            <div class="wa-header-name">{{ $selectedChatName }}</div>
                            <div class="wa-header-status">click here for contact info</div>
                        </div>
                    </div>
                    <div class="wa-header-actions">
                        <button type="button" data-bs-toggle="tooltip" title="Video Call">
                            <i class="ki-duotone ki-faceid fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="Voice Call">
                            <i class="ki-duotone ki-phone fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="Search">
                            <i class="ki-duotone ki-magnifier fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="Menu">
                            <i class="ki-duotone ki-dots-vertical fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </button>
                    </div>
                </div>

                {{-- Loading Overlay for Messages --}}
                @if($isLoading)
                    <div class="wa-messages-loading">
                        <div class="wa-spinner"></div>
                        <div class="wa-loading-text">Loading messages...</div>
                    </div>
                @endif

                {{-- Messages --}}
                <div class="wa-messages" id="wa-messages-container" style="{{ $isLoading ? 'opacity: 0.5;' : '' }}">
                    @php
                        $lastDate = null;
                    @endphp
                    @foreach (array_reverse($messages) as $message)
                        @php
                            $ts = $message['timestamp'] ?? null;
                            if ($ts) {
                                $time =
                                    is_numeric($ts) && strlen((string) $ts) > 10
                                        ? \Carbon\Carbon::createFromTimestampMs($ts)
                                        : \Carbon\Carbon::createFromTimestamp($ts);
                                $msgDate = $time->format('Y-m-d');
                                $timeStr = $time->format('H:i');
                                $dateLabel = $time->isToday()
                                    ? 'TODAY'
                                    : ($time->isYesterday() ? 'YESTERDAY' : $time->format('d/m/Y'));
                            } else {
                                $msgDate = null;
                                $timeStr = '';
                                $dateLabel = '';
                            }
                        @endphp

                        {{-- Date Separator --}}
                        @if ($msgDate && $msgDate !== $lastDate)
                            <div class="wa-date-separator">
                                <span>{{ $dateLabel }}</span>
                            </div>
                            @php
                                $lastDate = $msgDate;
                            @endphp
                        @endif

                        <div class="wa-message {{ $message['fromMe'] ? 'out' : 'in' }}">
                            <div class="wa-bubble">
                                @if (!$message['fromMe'] && !Str::endsWith($message['from'] ?? '', '@c.us'))
                                    <div class="wa-sender-name">
                                        {{ $message['_data']['notifyName'] ?? (isset($message['from']) ? substr($message['from'], 0, -5) : '-') }}
                                    </div>
                                @endif
                                <span class="wa-text">{!! nl2br(e($message['body'] ?? '')) !!}</span>
                                <span class="wa-meta">
                                    <span class="wa-time">{{ $timeStr }}</span>
                                    @if ($message['fromMe'])
                                        <i class="ki-duotone ki-double-check wa-check">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Input Area --}}
                <div class="wa-input-area">
                    <div class="wa-input-actions">
                        <button type="button" data-bs-toggle="tooltip" title="Emoji">
                            <i class="ki-duotone ki-emoji-happy fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="Attach">
                            <i class="ki-duotone ki-paper-clip fs-3"></i>
                        </button>
                    </div>
                    <div class="wa-input-wrapper">
                        <textarea rows="1" placeholder="Type a message" wire:model="messageText"
                            wire:keydown.enter.prevent="sendMessage"
                            {{ $isSending ? 'disabled' : '' }}></textarea>
                    </div>
                    <button type="button" class="wa-send-btn {{ $messageText ? 'active' : '' }}"
                        wire:click="sendMessage" {{ $isSending ? 'disabled' : '' }}>
                        @if($isSending)
                            <div class="wa-spinner" style="width: 20px; height: 20px; border-width: 2px;"></div>
                        @else
                            <i class="ki-duotone ki-send fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        @endif
                    </button>
                </div>

                {{-- Success/Error Messages --}}
                @if (session()->has('success') || session()->has('error') || $errors->has('messageText'))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @error('messageText')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @enderror
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="wa-empty-state">
                    <svg class="wa-logo" viewBox="0 0 303 172" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M229.565 160.229C262.212 149.245 286.931 118.241 283.39 73.4194C278.009 5.31929 212.365 -11.5738 171.472 8.48874C115.998 35.4098 108.972 40.1424 68.8945 45.1115C-11.5581 55.0476 -14.4271 115.441 18.5765 146.128C51.5765 176.812 234.733 179.063 229.565 160.229Z"
                            fill="#DAF7F3" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M131.589 68.9422C131.593 66.4823 129.618 64.5765 127.158 64.5765H85.6789C83.2185 64.5765 81.2422 66.4861 81.2422 68.9464V115.238C81.2422 115.238 81.2422 121.338 86.6389 121.338H127.158C129.619 121.338 131.593 119.39 131.589 116.93L131.589 68.9422Z"
                            fill="white" />
                        <path
                            d="M100.573 91.2783C100.573 92.7946 99.3262 94.0268 97.7863 94.0268C96.2464 94.0268 95 92.7946 95 91.2783C95 89.762 96.2464 88.5298 97.7863 88.5298C99.3262 88.5298 100.573 89.762 100.573 91.2783Z"
                            fill="#42CBA5" />
                        <path
                            d="M109.715 91.2783C109.715 92.7946 108.469 94.0268 106.929 94.0268C105.389 94.0268 104.143 92.7946 104.143 91.2783C104.143 89.762 105.389 88.5298 106.929 88.5298C108.469 88.5298 109.715 89.762 109.715 91.2783Z"
                            fill="#42CBA5" />
                        <path
                            d="M118.857 91.2783C118.857 92.7946 117.611 94.0268 116.071 94.0268C114.531 94.0268 113.285 92.7946 113.285 91.2783C113.285 89.762 114.531 88.5298 116.071 88.5298C117.611 88.5298 118.857 89.762 118.857 91.2783Z"
                            fill="#42CBA5" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M230.018 64.1724C229.992 61.7087 227.997 59.792 225.533 59.8164L166.146 60.3984C163.682 60.4228 161.731 62.383 161.757 64.8467L162.166 103.75C162.192 106.214 164.187 108.131 166.651 108.106L225.793 107.526C228.257 107.502 230.208 105.585 230.182 103.121L230.018 64.1724Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M177.392 90.1378C180.717 90.1014 183.396 87.3568 183.359 84.0315C183.323 80.7062 180.578 78.0269 177.253 78.0633C173.928 78.0997 171.248 80.8443 171.285 84.1696C171.321 87.4949 174.066 90.1742 177.392 90.1378Z"
                            fill="#42CBA5" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M217.389 89.7539C220.714 89.7175 223.393 86.9729 223.357 83.6476C223.32 80.3223 220.576 77.643 217.25 77.6794C213.925 77.7158 211.246 80.4604 211.282 83.7857C211.319 87.111 214.063 89.7903 217.389 89.7539Z"
                            fill="#42CBA5" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M197.482 89.9498C200.807 89.9134 203.486 87.1688 203.45 83.8435C203.414 80.5182 200.669 77.8389 197.344 77.8753C194.018 77.9117 191.339 80.6563 191.376 83.9816C191.412 87.3069 194.157 89.9862 197.482 89.9498Z"
                            fill="#42CBA5" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M168.009 123.546C168.009 123.546 186.462 95.6037 206.142 105.932L217.037 95.0553C217.037 95.0553 207.669 82.3683 192.309 88.7019C176.95 95.0355 168.009 123.546 168.009 123.546Z"
                            fill="#EEFEFA" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M228.78 123.106C228.78 123.106 212.393 109.28 197.476 123.727L184.003 115.595C184.003 115.595 196.689 101.072 213.654 106.497C230.619 111.921 228.78 123.106 228.78 123.106Z"
                            fill="#EEFEFA" />
                    </svg>
                    <h2>WhatsApp Web</h2>
                    <p>Send and receive messages without keeping your phone online.<br />
                        Use WhatsApp on up to 4 linked devices and 1 phone at the same time.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script>
        let wahaWebSocket = null;
        let reconnectInterval = null;
        const WAHA_WS_URL = '{{ env('WAHA_SOCKET_URL') }}';
        const WAHA_API_KEY = '{{ env('WAHA_API_KEY') }}';
        const SESSION_NAME = 'TORKATA_RESEARCH';

        // Auto scroll to bottom of messages
        function scrollToBottom() {
            const messagesContainer = document.getElementById('wa-messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }

        // Auto-resize textarea
        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 130) + 'px';
        }

        function connectWebSocket() {
            try {
                // Close existing connection if any
                if (wahaWebSocket) {
                    wahaWebSocket.close();
                }

                const queryParams = new URLSearchParams({
                    'x-api-key': WAHA_API_KEY,
                    session: SESSION_NAME,
                    events: 'message'
                });

                // Connect to WAHA WebSocket
                wahaWebSocket = new WebSocket(`${WAHA_WS_URL}?${queryParams.toString()}`);

                wahaWebSocket.onopen = function(event) {
                    console.log('✅ Connected to WAHA WebSocket');

                    // Clear reconnect interval if connected
                    if (reconnectInterval) {
                        clearInterval(reconnectInterval);
                        reconnectInterval = null;
                    }

                };

                wahaWebSocket.onmessage = function(event) {
                    try {
                        const data = JSON.parse(event.data);

                        // Handle different event types
                        if (data.event === 'message') {
                            console.log('New message received:', data.payload);

                            // Refresh chat list to show new message
                            @this.call('refreshChats');

                            // Show toastr notification for new message
                            if (typeof toastr !== 'undefined') {
                                const senderName = data.payload?._data?.notifyName ||
                                    data.payload?.from?.split('@')[0] ||
                                    'Someone';
                                const messageBody = data.payload?.body || 'New message';
                                const truncatedBody = messageBody.length > 50 ?
                                    messageBody.substring(0, 50) + '...' :
                                    messageBody;

                                toastr.info(`${senderName}: ${truncatedBody}`, 'Pesan Baru', {
                                    closeButton: true,
                                    progressBar: true,
                                    timeOut: 5000,
                                    onclick: function() {
                                        // Get chat ID from the message
                                        const chatId = data.payload?.chatId || data.payload?.from;
                                        const senderName = data.payload?._data?.notifyName ||
                                            data.payload?.from?.split('@')[0] || 'Someone';
                                        const senderPicture = data.payload?._data?.picture || '';

                                        // Call Livewire method to open the chat
                                        @this.call('getChatMessages', chatId, senderName, senderPicture);
                                    }
                                });
                            }

                            // If the message is for the currently open chat, refresh messages
                            const currentChatId = @this.get('selectedChatId');
                            const messageChatId = data.payload?.chatId || data.payload?.from;

                            if (currentChatId && messageChatId === currentChatId) {
                                @this.call('refreshMessages');
                                console.log('Refreshed messages for chat:', currentChatId);
                                // Scroll to bottom after new message
                                setTimeout(scrollToBottom, 100);
                            }
                        }
                    } catch (error) {
                        console.error('Error parsing WebSocket message:', error);
                    }
                };

                wahaWebSocket.onerror = function(error) {
                    console.error('❌ WebSocket error:', error);
                };

                wahaWebSocket.onclose = function(event) {
                    console.log('🔌 WebSocket disconnected. Code:', event.code, 'Reason:', event.reason);

                    // Attempt to reconnect after 5 seconds
                    if (!reconnectInterval) {
                        reconnectInterval = setTimeout(() => {
                            console.log('🔄 Attempting to reconnect...');
                            connectWebSocket();
                        }, 5000);
                    }
                };
            } catch (error) {
                console.error('Failed to connect to WebSocket:', error);
            }
        }

        // Connect when page loads
        document.addEventListener('DOMContentLoaded', function() {
            connectWebSocket();
            scrollToBottom();

            // Setup textarea auto-resize
            const textarea = document.querySelector('.wa-input-wrapper textarea');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    autoResizeTextarea(this);
                });
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (wahaWebSocket) {
                wahaWebSocket.close();
            }
            if (reconnectInterval) {
                clearTimeout(reconnectInterval);
            }
        });

        // Livewire hooks
        document.addEventListener('livewire:navigated', function() {
            if (!wahaWebSocket || wahaWebSocket.readyState !== WebSocket.OPEN) {
                connectWebSocket();
            }
        });

        // Scroll to bottom when messages are loaded
        Livewire.on('messagesUpdated', () => {
            setTimeout(scrollToBottom, 100);
        });

        // Handle Livewire updates
        document.addEventListener('livewire:update', function() {
            setTimeout(scrollToBottom, 100);
        });
    </script>
@endpush
