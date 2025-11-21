<!-- Live Chat Widget - iOS 18 Style with Glassmorphism -->
<div id="chatWidget">
    <!-- Floating Button -->
    <button id="chatButton" class="chat-floating-btn">
        <svg class="chat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
    </button>

    <!-- Chat Window -->
    <div id="chatWindow" class="chat-window">
        <!-- Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="bot-avatar">🤖</div>
                <div>
                    <div class="chat-title">SofaDev</div>
                    <div class="chat-status">
                        <span class="status-dot"></span>
                        Online 24/7
                    </div>
                </div>
            </div>
            <div class="chat-actions">
                <button class="chat-action-btn" id="minimizeChat">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
                <button class="chat-action-btn" id="closeChat">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="chat-messages" id="chatMessages">
            <!-- Welcome Message -->
            <div class="chat-message bot-message">
                <div class="message-avatar">🤖</div>
                <div class="message-content">
                    <div class="message-bubble">
                        <p>👋 Halo! Selamat datang!</p>
                        <p>Saya <strong>SofaDev</strong>, asisten virtual yang siap membantu kamu 24/7! 🤖</p>
                        <p>Ada yang bisa saya bantu hari ini? 😊</p>
                    </div>
                    <div class="message-time">Baru saja</div>
                </div>
            </div>

            <!-- Quick Replies -->
            <div class="quick-replies">
                <div class="quick-reply-label">💡 Pertanyaan Cepat:</div>
                <button class="quick-reply-btn" data-message="Cara order">📦 Cara Order</button>
                <button class="quick-reply-btn" data-message="Ongkir">🚚 Ongkir</button>
                <button class="quick-reply-btn" data-message="Promo">🎉 Promo</button>
                <button class="quick-reply-btn" data-message="Pembayaran">💳 Pembayaran</button>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator" style="display: none;">
            <div class="message-avatar">🤖</div>
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chat-input-area">
            <form id="chatForm">
                <input 
                    type="text" 
                    id="chatInput" 
                    class="chat-input" 
                    placeholder="Ketik pesan..." 
                    autocomplete="off"
                    maxlength="1000"
                >
                <button type="submit" class="chat-send-btn" id="sendBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* iOS 18 Style Chat Widget - Glassmorphism Soft */
#chatWidget {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
}

/* Floating Button - iOS Style */
.chat-floating-btn {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.95) 0%, rgba(255, 149, 0, 0.95) 100%);
    border: none;
    box-shadow: 
        0 8px 32px rgba(255, 115, 0, 0.35),
        0 4px 16px rgba(255, 115, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    backdrop-filter: blur(20px);
}

.chat-floating-btn:hover {
    transform: scale(1.1) translateY(-2px);
    box-shadow: 
        0 12px 48px rgba(255, 115, 0, 0.45),
        0 6px 24px rgba(255, 115, 0, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
}

.chat-floating-btn:active {
    transform: scale(0.95);
}

.chat-icon {
    width: 28px;
    height: 28px;
    color: white;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.chat-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 12px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Chat Window - iOS 18 Glassmorphism */
.chat-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 380px;
    height: 600px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(40px) saturate(180%);
    -webkit-backdrop-filter: blur(40px) saturate(180%);
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 
        0 24px 64px rgba(0, 0, 0, 0.15),
        0 12px 32px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    display: none;
    flex-direction: column;
    overflow: hidden;
    transform-origin: bottom right;
    animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.chat-window.show {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Header - Gradient Orange Soft */
.chat-header {
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.15) 0%, rgba(255, 149, 0, 0.15) 100%);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 115, 0, 0.2);
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bot-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.2), rgba(255, 149, 0, 0.2));
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(255, 115, 0, 0.2);
}

.chat-title {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    letter-spacing: -0.3px;
}

.chat-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6b7280;
    margin-top: 2px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #059669);
    box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
    animation: statusBlink 2s infinite;
}

@keyframes statusBlink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.chat-actions {
    display: flex;
    gap: 8px;
}

.chat-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.06);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.chat-action-btn:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: scale(1.05);
}

.chat-action-btn svg {
    width: 16px;
    height: 16px;
    color: #6b7280;
}

/* Messages Area */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: rgba(255, 115, 0, 0.2);
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 115, 0, 0.3);
}

/* Message Bubbles */
.chat-message {
    display: flex;
    gap: 10px;
    animation: messageSlide 0.3s ease;
}

@keyframes messageSlide {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bot-message {
    align-items: flex-start;
}

.user-message {
    flex-direction: row-reverse;
    align-items: flex-end;
}

.message-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.15), rgba(255, 149, 0, 0.15));
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(255, 115, 0, 0.1);
}

.message-content {
    max-width: 70%;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.user-message .message-content {
    align-items: flex-end;
}

.message-bubble {
    padding: 14px 16px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.5;
    word-wrap: break-word;
}

.bot-message .message-bubble {
    background: rgba(249, 250, 251, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.05);
    color: #374151;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.user-message .message-bubble {
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.9), rgba(255, 149, 0, 0.9));
    backdrop-filter: blur(10px);
    color: white;
    box-shadow: 0 4px 12px rgba(255, 115, 0, 0.3);
}

.message-bubble p {
    margin: 0;
    margin-bottom: 8px;
}

.message-bubble p:last-child {
    margin-bottom: 0;
}

.message-bubble strong {
    font-weight: 600;
}

.message-time {
    font-size: 11px;
    color: #9ca3af;
    padding: 0 4px;
    letter-spacing: -0.2px;
}

/* Quick Replies */
.quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 12px;
    background: rgba(255, 250, 245, 0.5);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255, 115, 0, 0.1);
}

.quick-reply-label {
    width: 100%;
    font-size: 12px;
    font-weight: 600;
    color: #ff7300;
    margin-bottom: 4px;
}

.quick-reply-btn {
    padding: 8px 14px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 115, 0, 0.2);
    border-radius: 12px;
    font-size: 13px;
    color: #ff7300;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.quick-reply-btn:hover {
    background: rgba(255, 115, 0, 0.1);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 115, 0, 0.15);
}

/* Typing Indicator */
.typing-indicator {
    display: flex;
    gap: 10px;
    padding: 0 20px 12px;
    align-items: center;
}

.typing-dots {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: rgba(249, 250, 251, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 18px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ff7300;
    opacity: 0.4;
    animation: typingBounce 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingBounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
    30% { transform: translateY(-8px); opacity: 1; }
}

/* Input Area - iOS Style */
.chat-input-area {
    padding: 16px 20px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.chat-input-area form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.chat-input {
    flex: 1;
    padding: 12px 16px;
    background: rgba(249, 250, 251, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 20px;
    font-size: 14px;
    color: #1f2937;
    transition: all 0.3s ease;
    font-family: inherit;
}

.chat-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.95);
    border-color: rgba(255, 115, 0, 0.3);
    box-shadow: 0 0 0 4px rgba(255, 115, 0, 0.08);
}

.chat-input::placeholder {
    color: #9ca3af;
}

.chat-send-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255, 115, 0, 0.95), rgba(255, 149, 0, 0.95));
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(255, 115, 0, 0.3);
}

.chat-send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(255, 115, 0, 0.4);
}

.chat-send-btn:active {
    transform: scale(0.95);
}

.chat-send-btn svg {
    width: 20px;
    height: 20px;
    color: white;
}

/* Mobile Responsive */
@media (max-width: 480px) {
    #chatWidget {
        bottom: 16px;
        right: 16px;
    }

    .chat-window {
        width: calc(100vw - 32px);
        height: calc(100vh - 100px);
        bottom: 72px;
        right: -8px;
    }

    .chat-floating-btn {
        width: 56px;
        height: 56px;
    }

    .chat-icon {
        width: 24px;
        height: 24px;
    }
}
</style>

<script>
// Chat Widget JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const minimizeChat = document.getElementById('minimizeChat');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    const chatBadge = document.getElementById('chatBadge');
    
    // Generate unique session ID
    let sessionId = localStorage.getItem('chat_session_id');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('chat_session_id', sessionId);
    }

    // Toggle chat window
    chatButton.addEventListener('click', function() {
        chatWindow.classList.toggle('show');
        if (chatWindow.classList.contains('show')) {
            chatInput.focus();
            markMessagesAsRead();
        }
    });

    closeChat.addEventListener('click', function() {
        chatWindow.classList.remove('show');
    });

    minimizeChat.addEventListener('click', function() {
        chatWindow.classList.remove('show');
    });

    // Quick reply buttons
    document.querySelectorAll('.quick-reply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const message = this.getAttribute('data-message');
            chatInput.value = message;
            chatForm.dispatchEvent(new Event('submit'));
        });
    });

    // Send message
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;

        // Add user message to UI
        addMessage(message, 'user');
        chatInput.value = '';

        // Show typing indicator
        showTyping();

        // Send to server
        fetch('<?php echo e(route("chat.send")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            hideTyping();
            if (data.success && data.bot_message) {
                addMessage(data.bot_message.message, 'bot');
            }
        })
        .catch(error => {
            hideTyping();
            console.error('Error:', error);
            addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
        });
    });

    // Add message to UI
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}-message`;
        
        const now = new Date();
        const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                          now.getMinutes().toString().padStart(2, '0');
        
        messageDiv.innerHTML = `
            <div class="message-avatar">${sender === 'bot' ? '🤖' : '👤'}</div>
            <div class="message-content">
                <div class="message-bubble">
                    ${text.split('\n').map(line => `<p>${line}</p>`).join('')}
                </div>
                <div class="message-time">${timeString}</div>
            </div>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Typing indicator
    function showTyping() {
        typingIndicator.style.display = 'flex';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTyping() {
        setTimeout(() => {
            typingIndicator.style.display = 'none';
        }, 500);
    }

    // Mark messages as read
    function markMessagesAsRead() {
        fetch('<?php echo e(route("chat.read")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                session_id: sessionId
            })
        });
        
        chatBadge.style.display = 'none';
    }
});
</script>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/components/chat-widget.blade.php ENDPATH**/ ?>