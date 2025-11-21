<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Chat - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .chat-header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .back-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
        }

        .chat-user {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: #ff6b35;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .chat-info {
            flex: 1;
        }

        .chat-name {
            font-size: 16px;
            font-weight: 600;
        }

        .chat-status {
            font-size: 12px;
            opacity: 0.9;
        }

        .chat-status.online {
            color: #4caf50;
        }

        /* Messages Container */
        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background: #e5ddd5;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect fill="%23e5ddd5" width="100" height="100"/><path d="M0 0 L50 50 L0 100" stroke="%23d4ccc4" stroke-width="1" fill="none"/></svg>');
        }

        .message {
            display: flex;
            margin-bottom: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 8px 12px;
            border-radius: 8px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        .message.received .message-bubble {
            background: white;
            border-radius: 0 8px 8px 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .message.sent .message-bubble {
            background: #dcf8c6;
            border-radius: 8px 0 8px 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .message-time {
            font-size: 10px;
            color: #666;
            margin-top: 4px;
            text-align: right;
        }

        .message.received .message-time {
            text-align: left;
        }

        .bot-badge {
            display: inline-block;
            background: #ff6b35;
            color: white;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 6px;
            font-weight: 600;
        }

        /* Input Area */
        .chat-input-area {
            background: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input {
            flex: 1;
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
        }

        .chat-input:focus {
            border-color: #ff6b35;
        }

        .send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff6b35;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .send-btn:hover {
            background: #ff5722;
            transform: scale(1.1);
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        /* Quick Replies */
        .quick-replies {
            padding: 12px 16px;
            background: white;
            border-top: 1px solid #e0e0e0;
            overflow-x: auto;
            white-space: nowrap;
        }

        .quick-reply-btn {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 8px;
            background: #f0f0f0;
            border: 1px solid #e0e0e0;
            border-radius: 16px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-reply-btn:hover {
            background: #ff6b35;
            color: white;
            border-color: #ff6b35;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            width: 60px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .typing-indicator.show {
            display: block;
        }

        .typing-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #999;
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }

        /* Scrollbar */
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="chat-header">
        <button class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="chat-user">
            <div class="chat-avatar">
                <i class="fas fa-headset"></i>
            </div>
            <div class="chat-info">
                <div class="chat-name">Customer Service</div>
                <div class="chat-status online">● Online</div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="messages-container" id="messagesContainer">
        <div class="message received">
            <div class="message-content">
                <div class="message-bubble">
                    👋 Halo! Selamat datang!
                    <span class="bot-badge">BOT</span>
                    <br><br>
                    Saya <strong>SofaDev</strong>, asisten virtual yang siap membantu kamu 24/7! 🤖
                    <br><br>
                    Ada yang bisa saya bantu hari ini? 😊
                </div>
                <div class="message-time">{{ now()->format('H:i') }}</div>
            </div>
        </div>
        
        <!-- Typing Indicator -->
        <div class="message received">
            <div class="typing-indicator" id="typingIndicator">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>
    </div>

    <!-- Quick Replies -->
    <div class="quick-replies">
        <button class="quick-reply-btn" onclick="sendQuickReply('Ada promo apa hari ini?')">🎉 Promo</button>
        <button class="quick-reply-btn" onclick="sendQuickReply('Cara order gimana?')">📦 Cara Order</button>
        <button class="quick-reply-btn" onclick="sendQuickReply('Cek status pesanan')">📍 Lacak Pesanan</button>
        <button class="quick-reply-btn" onclick="sendQuickReply('Metode pembayaran apa aja?')">💳 Pembayaran</button>
        <button class="quick-reply-btn" onclick="sendQuickReply('Hubungi CS')">📞 Kontak CS</button>
    </div>

    <!-- Input Area -->
    <div class="chat-input-area">
        <input type="text" class="chat-input" id="messageInput" placeholder="Ketik pesan..." onkeypress="handleKeyPress(event)">
        <button class="send-btn" onclick="sendMessage()">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

    <script>
        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const typingIndicator = document.getElementById('typingIndicator');

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function formatTime() {
            const now = new Date();
            return now.getHours().toString().padStart(2, '0') + ':' + 
                   now.getMinutes().toString().padStart(2, '0');
        }

        function addMessage(message, isSent = false, isBot = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
            
            const bubble = document.createElement('div');
            bubble.className = 'message-content';
            
            const text = document.createElement('div');
            text.className = 'message-bubble';
            text.innerHTML = message + (isBot ? '<span class="bot-badge">BOT</span>' : '');
            
            const time = document.createElement('div');
            time.className = 'message-time';
            time.textContent = formatTime();
            
            bubble.appendChild(text);
            bubble.appendChild(time);
            messageDiv.appendChild(bubble);
            
            // Insert before typing indicator
            const typingMsg = typingIndicator.parentElement;
            messagesContainer.insertBefore(messageDiv, typingMsg);
            
            scrollToBottom();
        }

        function showTyping() {
            typingIndicator.classList.add('show');
            scrollToBottom();
        }

        function hideTyping() {
            typingIndicator.classList.remove('show');
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, true);
            messageInput.value = '';

            // Show typing
            showTyping();

            try {
                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                // Simulate typing delay
                setTimeout(() => {
                    hideTyping();
                    if (data.reply) {
                        addMessage(data.reply, false, true);
                    }
                }, 1000);

            } catch (error) {
                console.error('Error:', error);
                hideTyping();
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', false, true);
            }
        }

        function sendQuickReply(message) {
            messageInput.value = message;
            sendMessage();
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        // Auto focus input
        messageInput.focus();
        scrollToBottom();
    </script>
</body>
</html>
