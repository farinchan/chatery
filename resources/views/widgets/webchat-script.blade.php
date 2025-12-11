/**
 * Website Chat Embed Widget
 * Generated for widget: {{ $config['widgetId'] }}
 */

(function() {
    'use strict';

    // Configuration
    const ChatConfig = {
        widgetId: '{{ $config['widgetId'] }}',
        apiBaseUrl: '{{ $config['apiBaseUrl'] }}',
        title: '{{ $config['title'] }}',
        subtitle: '{{ $config['subtitle'] }}',
        welcomeMessage: '{{ $config['welcomeMessage'] ?? 'Halo! 👋 Ada yang bisa kami bantu?' }}',
        primaryColor: '{{ $config['primaryColor'] }}',
        secondaryColor: '{{ $config['secondaryColor'] }}',
        position: '{{ $config['position'] }}',
        requireName: {{ $config['requireName'] ? 'true' : 'false' }},
        requireEmail: {{ $config['requireEmail'] ? 'true' : 'false' }},
        quickReplies: {!! json_encode($config['quickReplies'] ?? []) !!}
    };

    // Chat Widget Class
    class WebChatWidget {
        constructor(config) {
            this.config = config;
            this.isOpen = false;
            this.isTyping = false;
            this.sessionId = this.getOrCreateSessionId();
            this.visitorId = null;
            this.visitorName = null;
            this.messages = [];
            this.lastMessageId = 0;
            this.pollingInterval = null;
            this.init();
        }

        getOrCreateSessionId() {
            let sessionId = localStorage.getItem('webchat_session_' + this.config.widgetId);
            if (!sessionId) {
                sessionId = 'sess_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
                localStorage.setItem('webchat_session_' + this.config.widgetId, sessionId);
            }
            return sessionId;
        }

        init() {
            this.injectStyles();
            this.createWidget();
            this.bindEvents();
        }

        injectStyles() {
            const styles = `
                .webchat-container {
                    all: revert !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
                    font-size: 16px !important;
                    line-height: 1.5 !important;
                    color: #333 !important;
                    position: fixed !important;
                    bottom: 20px !important;
                    ${this.config.position}: 20px !important;
                    z-index: 2147483647 !important;
                    box-sizing: border-box !important;
                }

                .webchat-container * {
                    box-sizing: border-box !important;
                }

                .webchat-toggle-btn {
                    all: revert !important;
                    width: 60px !important;
                    height: 60px !important;
                    border-radius: 50% !important;
                    background: linear-gradient(135deg, ${this.config.primaryColor}, ${this.config.secondaryColor}) !important;
                    border: none !important;
                    cursor: pointer !important;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    transition: all 0.3s ease !important;
                    position: relative !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    outline: none !important;
                }

                .webchat-toggle-btn:hover {
                    transform: scale(1.1) !important;
                }

                .webchat-toggle-btn svg {
                    width: 28px !important;
                    height: 28px !important;
                    fill: white !important;
                }

                .webchat-notification {
                    all: revert !important;
                    position: absolute !important;
                    top: -5px !important;
                    right: -5px !important;
                    width: 20px !important;
                    height: 20px !important;
                    background: #ff4757 !important;
                    border-radius: 50% !important;
                    color: white !important;
                    font-size: 12px !important;
                    font-weight: 600 !important;
                    display: none !important;
                    align-items: center !important;
                    justify-content: center !important;
                }

                .webchat-window {
                    all: revert !important;
                    position: absolute !important;
                    bottom: 80px !important;
                    ${this.config.position}: 0 !important;
                    width: 380px !important;
                    max-width: calc(100vw - 40px) !important;
                    height: 520px !important;
                    max-height: calc(100vh - 150px) !important;
                    background: white !important;
                    border-radius: 16px !important;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
                    display: none !important;
                    flex-direction: column !important;
                    overflow: hidden !important;
                }

                .webchat-window.open {
                    display: flex !important;
                }

                .webchat-header {
                    all: revert !important;
                    background: linear-gradient(135deg, ${this.config.primaryColor}, ${this.config.secondaryColor}) !important;
                    padding: 16px 20px !important;
                    color: white !important;
                    position: relative !important;
                }

                .webchat-header-title {
                    all: revert !important;
                    font-size: 18px !important;
                    font-weight: 600 !important;
                    margin: 0 0 4px 0 !important;
                    color: white !important;
                }

                .webchat-header-subtitle {
                    all: revert !important;
                    font-size: 13px !important;
                    opacity: 0.9 !important;
                    margin: 0 !important;
                    color: white !important;
                }

                .webchat-close-btn {
                    all: revert !important;
                    position: absolute !important;
                    top: 12px !important;
                    right: 12px !important;
                    width: 28px !important;
                    height: 28px !important;
                    border: none !important;
                    background: rgba(255, 255, 255, 0.2) !important;
                    border-radius: 50% !important;
                    cursor: pointer !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    color: white !important;
                    font-size: 18px !important;
                }

                .webchat-body {
                    all: revert !important;
                    flex: 1 !important;
                    padding: 16px !important;
                    overflow-y: auto !important;
                    background: #f5f7fb !important;
                    display: flex !important;
                    flex-direction: column !important;
                }

                .webchat-messages {
                    all: revert !important;
                    flex: 1 !important;
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 10px !important;
                }

                .webchat-message {
                    all: revert !important;
                    max-width: 80% !important;
                    padding: 10px 14px !important;
                    border-radius: 16px !important;
                    font-size: 14px !important;
                    line-height: 1.4 !important;
                    word-wrap: break-word !important;
                }

                .webchat-message.visitor {
                    background: linear-gradient(135deg, ${this.config.primaryColor}, ${this.config.secondaryColor}) !important;
                    color: white !important;
                    margin-left: auto !important;
                    border-bottom-right-radius: 4px !important;
                }

                .webchat-message.admin {
                    background: white !important;
                    color: #333 !important;
                    margin-right: auto !important;
                    border-bottom-left-radius: 4px !important;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
                }

                .webchat-message-time {
                    all: revert !important;
                    font-size: 11px !important;
                    opacity: 0.7 !important;
                    margin-top: 4px !important;
                    display: block !important;
                }

                .webchat-quick-replies {
                    all: revert !important;
                    display: flex !important;
                    flex-wrap: wrap !important;
                    gap: 8px !important;
                    margin-top: 12px !important;
                    padding-top: 12px !important;
                }

                .webchat-quick-reply-btn {
                    all: revert !important;
                    background: white !important;
                    border: 1px solid #e0e0e0 !important;
                    padding: 8px 12px !important;
                    border-radius: 16px !important;
                    font-size: 13px !important;
                    color: #333 !important;
                    cursor: pointer !important;
                    transition: all 0.2s !important;
                }

                .webchat-quick-reply-btn:hover {
                    background: ${this.config.primaryColor} !important;
                    border-color: ${this.config.primaryColor} !important;
                    color: white !important;
                }

                .webchat-footer {
                    all: revert !important;
                    padding: 12px 16px !important;
                    background: white !important;
                    border-top: 1px solid #eee !important;
                }

                .webchat-input-group {
                    all: revert !important;
                    display: flex !important;
                    gap: 8px !important;
                    align-items: center !important;
                }

                .webchat-input {
                    all: revert !important;
                    flex: 1 !important;
                    padding: 10px 16px !important;
                    border: 1px solid #e0e0e0 !important;
                    border-radius: 24px !important;
                    font-size: 14px !important;
                    outline: none !important;
                    background: #f5f7fb !important;
                }

                .webchat-input:focus {
                    border-color: ${this.config.primaryColor} !important;
                    background: white !important;
                }

                .webchat-send-btn {
                    all: revert !important;
                    width: 44px !important;
                    height: 44px !important;
                    border-radius: 50% !important;
                    background: linear-gradient(135deg, ${this.config.primaryColor}, ${this.config.secondaryColor}) !important;
                    border: none !important;
                    cursor: pointer !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }

                .webchat-send-btn svg {
                    width: 20px !important;
                    height: 20px !important;
                    fill: white !important;
                }

                .webchat-form-overlay {
                    all: revert !important;
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    background: white !important;
                    display: none !important;
                    flex-direction: column !important;
                    z-index: 10 !important;
                }

                .webchat-form-overlay.show {
                    display: flex !important;
                }

                .webchat-form-body {
                    all: revert !important;
                    flex: 1 !important;
                    padding: 24px 20px !important;
                    display: flex !important;
                    flex-direction: column !important;
                    justify-content: center !important;
                    overflow-y: auto !important;
                }

                .webchat-form-title {
                    all: revert !important;
                    font-size: 20px !important;
                    font-weight: 600 !important;
                    margin: 0 0 8px 0 !important;
                    color: #333 !important;
                }

                .webchat-form-subtitle {
                    all: revert !important;
                    font-size: 14px !important;
                    color: #666 !important;
                    margin: 0 0 24px 0 !important;
                }

                .webchat-form-group {
                    all: revert !important;
                    margin-bottom: 16px !important;
                    display: block !important;
                    width: 100% !important;
                }

                .webchat-form-group label {
                    all: revert !important;
                    display: block !important;
                    font-size: 14px !important;
                    font-weight: 500 !important;
                    margin-bottom: 6px !important;
                    color: #333 !important;
                }

                .webchat-form-group input {
                    all: revert !important;
                    display: block !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    padding: 12px 14px !important;
                    border: 1px solid #e0e0e0 !important;
                    border-radius: 8px !important;
                    font-size: 14px !important;
                    font-family: inherit !important;
                    outline: none !important;
                    background-color: #fff !important;
                    color: #333 !important;
                    box-sizing: border-box !important;
                    -webkit-appearance: none !important;
                    -moz-appearance: none !important;
                    appearance: none !important;
                    transition: border-color 0.2s ease !important;
                }

                .webchat-form-group input::placeholder {
                    color: #999 !important;
                    opacity: 1 !important;
                }

                .webchat-form-group input:focus {
                    border-color: ${this.config.primaryColor} !important;
                    box-shadow: 0 0 0 3px rgba(15, 74, 162, 0.1) !important;
                }

                .webchat-form-submit {
                    all: revert !important;
                    width: 100% !important;
                    padding: 14px 20px !important;
                    background: linear-gradient(135deg, ${this.config.primaryColor}, ${this.config.secondaryColor}) !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 8px !important;
                    font-size: 15px !important;
                    font-weight: 600 !important;
                    cursor: pointer !important;
                    margin-top: 16px !important;
                    transition: all 0.3s ease !important;
                    box-shadow: 0 4px 12px rgba(15, 74, 162, 0.3) !important;
                }

                .webchat-form-submit:hover {
                    transform: translateY(-2px) !important;
                    box-shadow: 0 6px 16px rgba(15, 74, 162, 0.4) !important;
                }

                .webchat-form-submit:active {
                    transform: translateY(0) !important;
                }

                .webchat-form-submit:disabled {
                    opacity: 0.7 !important;
                    cursor: not-allowed !important;
                    transform: none !important;
                }

                @media (max-width: 480px) {
                    .webchat-window {
                        width: calc(100vw - 30px) !important;
                        height: calc(100vh - 100px) !important;
                        bottom: 70px !important;
                    }

                    .webchat-toggle-btn {
                        width: 54px !important;
                        height: 54px !important;
                    }
                }
            `;

            const styleSheet = document.createElement('style');
            styleSheet.textContent = styles;
            document.head.appendChild(styleSheet);
        }

        createWidget() {
            const container = document.createElement('div');
            container.className = 'webchat-container';
            container.innerHTML = `
                <button class="webchat-toggle-btn" id="webchatToggleBtn">
                    <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
                    <span class="webchat-notification" id="webchatNotification">0</span>
                </button>

                <div class="webchat-window" id="webchatWindow">
                    <div class="webchat-header">
                        <button class="webchat-close-btn" id="webchatCloseBtn">&times;</button>
                        <h3 class="webchat-header-title">${this.config.title}</h3>
                        <p class="webchat-header-subtitle">${this.config.subtitle}</p>
                    </div>

                    <div class="webchat-body" id="webchatBody">
                        <div class="webchat-messages" id="webchatMessages"></div>
                        ${this.config.quickReplies.length > 0 ? `
                            <div class="webchat-quick-replies" id="webchatQuickReplies">
                                ${this.config.quickReplies.map(reply => `
                                    <button class="webchat-quick-reply-btn" data-message="${reply.message}">
                                        ${reply.text}
                                    </button>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>

                    <div class="webchat-footer">
                        <div class="webchat-input-group">
                            <input type="text" class="webchat-input" id="webchatInput" placeholder="Ketik pesan..." maxlength="500">
                            <button class="webchat-send-btn" id="webchatSendBtn">
                                <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                            </button>
                        </div>
                    </div>

                    ${(this.config.requireName || this.config.requireEmail) ? `
                        <div class="webchat-form-overlay" id="webchatFormOverlay">
                            <div class="webchat-header">
                                <h3 class="webchat-header-title">${this.config.title}</h3>
                                <p class="webchat-header-subtitle">${this.config.subtitle}</p>
                            </div>
                            <div class="webchat-form-body">
                                <h4 class="webchat-form-title">Mulai Percakapan</h4>
                                <p class="webchat-form-subtitle">Masukkan informasi Anda untuk memulai chat</p>
                                ${this.config.requireName ? `
                                    <div class="webchat-form-group">
                                        <label>Nama</label>
                                        <input type="text" id="webchatFormName" placeholder="Nama Anda">
                                    </div>
                                ` : ''}
                                ${this.config.requireEmail ? `
                                    <div class="webchat-form-group">
                                        <label>Email</label>
                                        <input type="email" id="webchatFormEmail" placeholder="email@example.com">
                                    </div>
                                ` : ''}
                                <button class="webchat-form-submit" id="webchatFormSubmit">Mulai Chat</button>
                            </div>
                        </div>
                    ` : ''}
                </div>
            `;

            document.body.appendChild(container);

            this.container = container;
            this.toggleBtn = container.querySelector('#webchatToggleBtn');
            this.chatWindow = container.querySelector('#webchatWindow');
            this.closeBtn = container.querySelector('#webchatCloseBtn');
            this.messagesContainer = container.querySelector('#webchatMessages');
            this.quickRepliesContainer = container.querySelector('#webchatQuickReplies');
            this.input = container.querySelector('#webchatInput');
            this.sendBtn = container.querySelector('#webchatSendBtn');
            this.notification = container.querySelector('#webchatNotification');
            this.formOverlay = container.querySelector('#webchatFormOverlay');
        }

        bindEvents() {
            this.toggleBtn.addEventListener('click', () => this.toggleChat());
            this.closeBtn.addEventListener('click', () => this.closeChat());
            this.sendBtn.addEventListener('click', () => this.sendMessage());
            this.input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.sendMessage();
            });

            if (this.quickRepliesContainer) {
                this.quickRepliesContainer.addEventListener('click', (e) => {
                    if (e.target.classList.contains('webchat-quick-reply-btn')) {
                        const message = e.target.getAttribute('data-message');
                        this.input.value = message;
                        this.sendMessage();
                    }
                });
            }

            if (this.formOverlay) {
                const formSubmit = this.formOverlay.querySelector('#webchatFormSubmit');
                formSubmit.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.submitForm();
                });

                // Allow Enter key to submit form
                const formInputs = this.formOverlay.querySelectorAll('input');
                formInputs.forEach(input => {
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.submitForm();
                        }
                    });
                });
            }
        }

        async toggleChat() {
            if (this.isOpen) {
                this.closeChat();
            } else {
                await this.openChat();
            }
        }

        async openChat() {
            this.isOpen = true;
            this.chatWindow.classList.add('open');
            this.notification.style.display = 'none';

            // Check if we need to show form or init session
            if (this.formOverlay && !this.visitorId) {
                this.formOverlay.classList.add('show');
            } else if (!this.visitorId) {
                await this.initSession();
            }

            this.input.focus();
            this.scrollToBottom();
        }

        closeChat() {
            this.isOpen = false;
            this.chatWindow.classList.remove('open');
        }

        async submitForm() {
            console.log('WebChat: submitForm called');

            const nameInput = this.formOverlay.querySelector('#webchatFormName');
            const emailInput = this.formOverlay.querySelector('#webchatFormEmail');
            const submitBtn = this.formOverlay.querySelector('#webchatFormSubmit');

            const name = nameInput ? nameInput.value.trim() : null;
            const email = emailInput ? emailInput.value.trim() : null;

            console.log('WebChat: Form data', { name, email, requireName: this.config.requireName, requireEmail: this.config.requireEmail });

            if (this.config.requireName && !name) {
                alert('Nama harus diisi');
                if (nameInput) nameInput.focus();
                return;
            }

            if (this.config.requireEmail && !email) {
                alert('Email harus diisi');
                if (emailInput) emailInput.focus();
                return;
            }

            // Show loading state
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Memulai...';
            submitBtn.disabled = true;

            try {
                console.log('WebChat: Calling initSession...');
                const success = await this.initSession(name, email);
                console.log('WebChat: initSession result:', success);

                if (success) {
                    this.formOverlay.classList.remove('show');
                    this.input.focus();
                    console.log('WebChat: Form overlay hidden, chat opened');
                } else {
                    alert('Gagal memulai chat. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Submit form error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        }

        async initSession(name = null, email = null) {
            try {
                console.log('WebChat: Initializing session...', { widgetId: this.config.widgetId, sessionId: this.sessionId, name, email });

                const response = await fetch(`${this.config.apiBaseUrl}/init`, {
                    method: 'POST',
                    mode: 'cors',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        widget_id: this.config.widgetId,
                        session_id: this.sessionId,
                        name: name,
                        email: email,
                        current_page: window.location.href,
                    }),
                });

                console.log('WebChat: Init response status:', response.status);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('WebChat init failed:', response.status, response.statusText, errorText);
                    return false;
                }

                const data = await response.json();
                console.log('WebChat: Init response data:', data);

                if (data.success) {
                    this.visitorId = data.data.visitor_id;
                    this.visitorName = data.data.visitor_name;
                    this.sessionId = data.data.session_id;

                    console.log('WebChat: Session initialized successfully', { visitorId: this.visitorId, visitorName: this.visitorName });

                    // Save session to localStorage
                    localStorage.setItem('webchat_session_' + this.config.widgetId, this.sessionId);
                    localStorage.setItem('webchat_visitor_' + this.config.widgetId, this.visitorId);

                    // Load existing messages
                    if (data.data.messages && data.data.messages.length > 0) {
                        data.data.messages.forEach(msg => {
                            this.addMessage(msg.message, msg.direction === 'incoming' ? 'visitor' : 'admin', msg.formatted_time);
                            this.lastMessageId = msg.id;
                        });
                    }

                    // Add welcome message if no messages
                    if (this.messagesContainer.children.length === 0 && data.data.welcome_message) {
                        this.addMessage(data.data.welcome_message, 'admin');
                    }

                    // Hide quick replies if messages exist
                    if (this.quickRepliesContainer && this.messagesContainer.children.length > 0) {
                        this.quickRepliesContainer.style.display = 'none';
                    }

                    // Start polling for new messages
                    this.startPolling();

                    return true;
                } else {
                    console.error('WebChat init failed:', data.message);
                    return false;
                }
            } catch (error) {
                console.error('WebChat init error:', error);
                return false;
            }
        }

        async sendMessage() {
            const message = this.input.value.trim();
            if (!message || this.isTyping) return;

            if (!this.visitorId) {
                await this.initSession();
                if (!this.visitorId) return;
            }

            this.input.value = '';
            this.addMessage(message, 'visitor');

            if (this.quickRepliesContainer) {
                this.quickRepliesContainer.style.display = 'none';
            }

            try {
                const response = await fetch(`${this.config.apiBaseUrl}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        widget_id: this.config.widgetId,
                        session_id: this.sessionId,
                        message: message,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    this.lastMessageId = data.data.id;
                }
            } catch (error) {
                console.error('WebChat send error:', error);
                this.addMessage('Gagal mengirim pesan. Silakan coba lagi.', 'admin');
            }
        }

        addMessage(text, sender = 'visitor', time = null) {
            const messageEl = document.createElement('div');
            messageEl.className = `webchat-message ${sender}`;
            messageEl.innerHTML = `
                ${text}
                <span class="webchat-message-time">${time || this.formatTime(new Date())}</span>
            `;
            this.messagesContainer.appendChild(messageEl);
            this.scrollToBottom();
        }

        startPolling() {
            if (this.pollingInterval) return;

            this.pollingInterval = setInterval(async () => {
                if (!this.isOpen || !this.visitorId) return;

                try {
                    const response = await fetch(`${this.config.apiBaseUrl}/messages?widget_id=${this.config.widgetId}&session_id=${this.sessionId}&last_message_id=${this.lastMessageId}`, {
                        headers: { 'Accept': 'application/json' },
                    });

                    const data = await response.json();

                    if (data.success && data.data.messages && data.data.messages.length > 0) {
                        data.data.messages.forEach(msg => {
                            if (msg.id > this.lastMessageId) {
                                // Only add admin messages (outgoing from server perspective is incoming for visitor)
                                if (msg.direction === 'outgoing') {
                                    this.addMessage(msg.message, 'admin', msg.formatted_time);
                                }
                                this.lastMessageId = msg.id;
                            }
                        });
                    }
                } catch (error) {
                    console.error('WebChat poll error:', error);
                }
            }, 3000);
        }

        scrollToBottom() {
            const body = document.getElementById('webchatBody');
            if (body) {
                body.scrollTop = body.scrollHeight;
            }
        }

        formatTime(date) {
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new WebChatWidget(ChatConfig);
        });
    } else {
        new WebChatWidget(ChatConfig);
    }
})();
