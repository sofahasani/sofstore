<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat dengan Penjual</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow: hidden;
        }

        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            height: 100vh;
            background: white;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 50px rgba(0,0,0,0.3);
        }

        /* Header */
        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .back-btn {
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .back-btn:hover {
            transform: scale(1.1);
        }

        .seller-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #667eea;
            border: 3px solid rgba(255,255,255,0.3);
        }

        .seller-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .seller-status {
            font-size: 12px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Messages Area */
        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f0f2f5;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);
        }

        .message {
            display: flex;
            margin-bottom: 15px;
            animation: slideIn 0.3s ease-out;
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

        .message.user {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 12px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .message.admin .message-bubble,
        .message.bot .message-bubble {
            background: white;
            color: #1f2937;
            border-bottom-left-radius: 4px;
        }

        .message.user .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 5px;
            display: block;
            text-align: right;
        }

        .bot-badge {
            display: inline-block;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(234, 88, 12, 0.1);
            color: #ea580c;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 10px 15px;
            background: white;
            border-radius: 12px;
            width: fit-content;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .typing-indicator.show {
            display: block;
            animation: slideIn 0.3s ease-out;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dots span {
            width: 8px;
            height: 8px;
            background: #9ca3af;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Input Area */
        .input-area {
            background: white;
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .message-input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .message-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .send-btn {
            width: 45px;
            height: 45px;
            border: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        .send-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* Quick Replies */
        .quick-replies {
            display: flex;
            gap: 8px;
            padding: 10px 20px;
            overflow-x: auto;
            background: white;
            border-top: 1px solid #e5e7eb;
            scrollbar-width: none;
        }

        .quick-replies::-webkit-scrollbar {
            display: none;
        }

        .quick-reply-btn {
            padding: 8px 16px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s;
            color: #667eea;
            font-weight: 500;
        }

        .quick-reply-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 60px;
            color: #667eea;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #374151;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Scrollbar */
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.3);
            border-radius: 10px;
        }

        .messages-container::-webkit-scrollbar-thumb:hover {
            background: rgba(102, 126, 234, 0.5);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .chat-container {
                max-width: 100%;
            }

            .message-bubble {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <i class="fas fa-arrow-left back-btn" onclick="window.location.href='{{ route('profile') }}'"></i>
            <div class="seller-avatar">
                <i class="fas fa-store"></i>
            </div>
            <div class="seller-info">
                <h3>Toko Admin</h3>
                <div class="seller-status">
                    <span class="online-dot"></span>
                    Aktif
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="messages-container" id="messagesContainer">
            @if($messages->count() > 0)
                @foreach($messages as $message)
                    <div class="message {{ $message->sender_type }}">
                        <div class="message-bubble">
                            @if($message->sender_type === 'bot')
                                <span class="bot-badge">🤖 Bot</span><br>
                            @elseif($message->sender_type === 'admin')
                                <span class="admin-badge">👨‍💼 Admin</span><br>
                            @endif
                            {!! nl2br(e($message->message)) !!}
                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h3>Mulai Chat</h3>
                    <p>Tanya apa saja tentang produk kami!<br>Admin siap membantu Anda 😊</p>
                </div>
            @endif
            
            <!-- Typing Indicator -->
            <div class="typing-indicator" id="typingIndicator">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>

        <!-- Quick Replies -->
        <div class="quick-replies">
            <button class="quick-reply-btn" onclick="sendQuickReply('🎉 Ada promo apa hari ini?')">
                🎉 Promo
            </button>
            <button class="quick-reply-btn" onclick="sendQuickReply('📦 Gimana cara order?')">
                📦 Cara Order
            </button>
            <button class="quick-reply-btn" onclick="sendQuickReply('🚚 Berapa ongkirnya?')">
                🚚 Ongkir
            </button>
            <button class="quick-reply-btn" onclick="sendQuickReply('💳 Metode pembayaran apa saja?')">
                💳 Pembayaran
            </button>
            <button class="quick-reply-btn" onclick="sendQuickReply('📞 Kontak CS')">
                📞 Kontak
            </button>
        </div>

        <!-- Input Area -->
        <div class="input-area">
            <input type="text" 
                   class="message-input" 
                   id="messageInput" 
                   placeholder="Ketik pesan..."
                   onkeypress="handleKeyPress(event)">
            <button class="send-btn" id="sendBtn" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script>
        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const typingIndicator = document.getElementById('typingIndicator');
        const userId = {{ auth()->user()->id }};

        // Auto scroll to bottom
        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Initial scroll
        scrollToBottom();

        // Handle Enter key
        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        // Send quick reply
        function sendQuickReply(message) {
            messageInput.value = message;
            sendMessage();
        }

        // Send message function
        async function sendMessage() {
            const message = messageInput.value.trim();
            
            if (!message) return;

            // Disable input
            messageInput.disabled = true;
            sendBtn.disabled = true;

            // Add user message to UI immediately
            addMessageToUI('user', message);
            messageInput.value = '';

            // Show typing indicator
            typingIndicator.classList.add('show');
            scrollToBottom();

            try {
                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message,
                        user_id: userId,
                        sender_type: 'user'
                    })
                });

                const data = await response.json();

                // Hide typing indicator
                typingIndicator.classList.remove('show');

                if (data.success) {
                    // Add bot/admin response if exists
                    if (data.bot_message) {
                        setTimeout(() => {
                            addMessageToUI('bot', data.bot_message.message);
                        }, 500);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                typingIndicator.classList.remove('show');
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            } finally {
                // Enable input
                messageInput.disabled = false;
                sendBtn.disabled = false;
                messageInput.focus();
            }
        }

        // Add message to UI
        function addMessageToUI(senderType, message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${senderType}`;
            
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + 
                        now.getMinutes().toString().padStart(2, '0');
            
            let badge = '';
            if (senderType === 'bot') {
                badge = '<span class="bot-badge">🤖 Bot</span><br>';
            } else if (senderType === 'admin') {
                badge = '<span class="admin-badge">👨‍💼 Admin</span><br>';
            }
            
            messageDiv.innerHTML = `
                <div class="message-bubble">
                    ${badge}
                    ${message.replace(/\n/g, '<br>')}
                    <span class="message-time">${time}</span>
                </div>
            `;
            
            // Remove empty state if exists
            const emptyState = messagesContainer.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }
            
            messagesContainer.insertBefore(messageDiv, typingIndicator);
            scrollToBottom();
        }

        // Auto refresh messages every 3 seconds
        setInterval(async () => {
            try {
                const response = await fetch('{{ route("chat.messages") }}', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success && data.messages) {
                    // Check for new messages (simple implementation)
                    const currentMessageCount = messagesContainer.querySelectorAll('.message').length;
                    if (data.messages.length > currentMessageCount) {
                        // Reload page to show new messages (you can implement better solution)
                        location.reload();
                    }
                }
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }, 3000);

        // Mark messages as read
        fetch('{{ route("chat.read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    </script>
</body>
</html>
