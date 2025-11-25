<div>
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
            <div class="card ">
                <div class="card-header py-7" id="kt_chat_contacts_header" style="background-color: #f3f6f9;">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px symbol-circle me-3">
                                <img alt="User"
                                    src="{{ $myProfile['picture'] ?? 'https://ui-avatars.com/api/?background=00a884&color=fff&name=' . urlencode($myProfile['name'] ?? 'User') }}" />
                            </div>
                            <div class="d-flex flex-column">
                                <h3 class="mb-0 fw-bold">{{ $myProfile['name'] ?? '' }}</h3>
                                <span class="text-muted fs-7">{{ $myProfile['id'] ?? '' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-icon btn-active-light-primary" type="button"
                                data-bs-toggle="tooltip" title="New Chat">
                                <i class="ki-duotone ki-message-add fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-active-light-primary" type="button"
                                data-bs-toggle="tooltip" title="Menu">
                                <i class="ki-duotone ki-setting-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5" id="kt_chat_contacts_body" style="position: relative;">

                    <div class="me-n5 pe-5 " style="overflow-y: auto; max-height: 800px; ">

                        @foreach ($ui as $u)
                            <div class="d-flex flex-stack py-4 {{ $selectedChatId === $u['id'] ? 'bg-light-primary' : '' }}"
                                wire:click="getChatMessages('{{ $u['id'] }}', '{{ $u['name'] }}', '{{ $u['picture'] }}')"
                                style="cursor: pointer; position: relative;" wire:loading.class="opacity-50"
                                wire:target="getChatMessages">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px symbol-circle">
                                        <img alt="Pic"
                                            src="{{ $u['picture'] ? $u['picture'] : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($u['name']) }}" />
                                    </div>
                                    <div class="ms-5">
                                        <a class="fs-5 fw-bold text-gray-900 mb-2">{{ $u['name'] }}</a>
                                        <div class="fw-semibold text-muted">
                                            {{ Str::limit($u['lastMessage']['body'], 20) }}</div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-end ms-2">
                                    @php
                                        $ts = $u['lastMessage']['timestamp'] ?? null;
                                        if ($ts) {
                                            $time =
                                                is_numeric($ts) && strlen((string) $ts) > 10
                                                    ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                    : \Carbon\Carbon::createFromTimestamp($ts);
                                        } else {
                                            $time = null;
                                        }
                                    @endphp
                                    <span
                                        class="text-muted fs-7 mb-1">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                </div>
                            </div>
                            <div class="separator separator-dashed d-none"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            @if ($messages && count($messages) > 0)
                <div class="card" id="kt_chat_messenger">
                    <div class="card-header" id="kt_chat_messenger_header">
                        <div class="card-title">
                            <div class="d-flex justify-content-center flex-column me-3">
                                <a href="#"
                                    class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ $selectedChatName }}</a>
                                <div class="mb-0 lh-1">
                                    <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                    <span class="fs-7 fw-semibold text-muted">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="me-n3">
                                <button class="btn btn-sm btn-icon btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-dots-square fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Contacts
                                        </div>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_users_search">Add Contact</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link flex-stack px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_invite_friends">Invite Contacts
                                            <span class="ms-2" data-bs-toggle="tooltip"
                                                title="Specify a contact email to send an invitation">
                                                <i class="ki-duotone ki-information fs-7">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span></a>
                                    </div>
                                    <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                        data-kt-menu-placement="right-start">
                                        <a href="#" class="menu-link px-3">
                                            <span class="menu-title">Groups</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                    title="Coming soon">Create Group</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                    title="Coming soon">Invite Members</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                    title="Coming soon">Settings</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="menu-item px-3 my-1">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                            title="Coming soon">Settings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="kt_chat_messenger_body"
                        style="position: relative; min-height: 400px;">

                        <div class="me-n5 pe-5" style="overflow-y: auto; max-height: 800px;"
                            wire:loading.class="opacity-25" wire:target="getChatMessages">
                            @foreach (array_reverse($messages) as $message)
                                @if ($message['fromMe'])
                                    <div class="d-flex justify-content-end mb-10">
                                        <div class="d-flex flex-column align-items-end">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-3">
                                                    @php
                                                        $ts = $message['timestamp'] ?? null;
                                                        if ($ts) {
                                                            $time =
                                                                is_numeric($ts) && strlen((string) $ts) > 10
                                                                    ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                                    : \Carbon\Carbon::createFromTimestamp($ts);
                                                        } else {
                                                            $time = null;
                                                        }
                                                    @endphp
                                                    <span
                                                        class="text-muted fs-7 mb-1">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                                    <a href="#"
                                                        class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                </div>

                                            </div>
                                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-start"
                                                data-kt-element="message-text">{!! nl2br(e($message['body'])) !!}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start mb-10">
                                        <div class="d-flex flex-column align-items-start">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="symbol symbol-35px symbol-circle">
                                                    <img alt="Pic"
                                                        src="{{ $message['from'] && Str::endsWith($message['from'], '@c.us') ? ($selectedChatPicture != '' ? $selectedChatPicture : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($selectedChatName)) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($message['from']) }}" />
                                                </div>
                                                <div class="ms-3">
                                                    <a href="#"
                                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">
                                                        @if ($message['from'] && Str::endsWith($message['from'], '@c.us'))
                                                            {{ $selectedChatName }}
                                                        @else
                                                            {{ $message['_data']['notifyName'] ?? '-' }}
                                                        @endif
                                                    </a>
                                                    <span
                                                        class="text-muted fs-7 mb-1">({{ isset($message['from']) ? substr($message['from'], 0, -5) : '-' }})</span>
                                                    @php
                                                        $ts = $message['timestamp'] ?? null;
                                                        if ($ts) {
                                                            $time =
                                                                is_numeric($ts) && strlen((string) $ts) > 10
                                                                    ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                                    : \Carbon\Carbon::createFromTimestamp($ts);
                                                        } else {
                                                            $time = null;
                                                        }
                                                    @endphp
                                                    <span
                                                        class="text-muted fs-7 mb-1">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start"
                                                data-kt-element="message-text">{!! nl2br(e($message['body'])) !!}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @error('messageText')
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
                            placeholder="Type a message" wire:model="messageText" wire:keydown.enter="sendMessage"></textarea>
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-2">
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                    data-bs-toggle="tooltip" title="Coming soon">
                                    <i class="ki-duotone ki-paper-clip fs-3"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                    data-bs-toggle="tooltip" title="Coming soon">
                                    <i class="ki-duotone ki-exit-up fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            </div>
                            <button class="btn btn-primary" type="button" data-kt-element="send"
                                wire:click="sendMessage" wire:loading.attr="disabled" wire:target="sendMessage">
                                <span wire:loading.remove wire:target="sendMessage">Send</span>
                                <span wire:loading wire:target="sendMessage" class="indicator-progress">
                                    Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                        style="height: 400px;">
                        <i class="ki-duotone ki-chat-1 fs-1tx text-muted">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <h3 class="mt-5 text-muted">Select a chat to start messaging</h3>
                    </div>
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

        // Livewire hook to maintain connection
        document.addEventListener('livewire:navigated', function() {
            if (!wahaWebSocket || wahaWebSocket.readyState !== WebSocket.OPEN) {
                connectWebSocket();
            }
        });
    </script>
@endpush
