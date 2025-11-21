<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Chat - Kelola Semua Pesan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f0f2f5;
            height: 100vh;
            overflow: hidden;
        }

        .admin-chat-container {
            display: flex;
            height: 100vh;
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 50px rgba(0,0,0,0.1);
        }

        /* Sidebar - User List */
        .users-sidebar {
            width: 350px;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .sidebar-header {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 13px;
            opacity: 0.9;
        }

        .search-box {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }

        .users-list {
            flex: 1;
            overflow-y: auto;
        }

        .user-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .user-item:hover {
            background: #f9fafb;
        }

        .user-item.active {
            background: #fef3c7;
            border-left: 4px solid #ea580c;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 15px;
            color: #111827;
            margin-bottom: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .unread-badge {
            background: #ea580c;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }

        .last-message {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-time {
            font-size: 11px;
            color: #9ca3af;
        }

        /* Chat Area */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f9fafb;
        }

        .chat-header {
            background: white;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .selected-user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
        }

        .selected-user-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 3px;
        }

        .selected-user-info p {
            font-size: 13px;
            color: #6b7280;
        }

        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
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

        .message.admin {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 12px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .message.user .message-bubble,
        .message.bot .message-bubble {
            background: white;
            color: #1f2937;
            border-bottom-left-radius: 4px;
        }

        .message.admin .message-bubble {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .msg-time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 5px;
            display: block;
            text-align: right;
        }

        .user-badge {
            display: inline-block;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .bot-badge {
            display: inline-block;
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* Admin Input Area */
        .admin-input-area {
            background: white;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .admin-message-input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
            resize: none;
            min-height: 45px;
            max-height: 120px;
        }

        .admin-message-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }

        .admin-send-btn {
            width: 45px;
            height: 45px;
            border: none;
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(234, 88, 12, 0.4);
        }

        .admin-send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(234, 88, 12, 0.5);
        }

        .admin-send-btn:active {
            transform: scale(0.95);
        }

        /* Empty State */
        .empty-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            padding: 40px;
        }

        .empty-chat i {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
            color: #ea580c;
        }

        .empty-chat h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #6b7280;
        }

        .empty-chat p {
            font-size: 14px;
            text-align: center;
            max-width: 400px;
        }

        /* Scrollbar */
        .users-list::-webkit-scrollbar,
        .messages-area::-webkit-scrollbar {
            width: 6px;
        }

        .users-list::-webkit-scrollbar-track,
        .messages-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .users-list::-webkit-scrollbar-thumb,
        .messages-area::-webkit-scrollbar-thumb {
            background: rgba(234, 88, 12, 0.3);
            border-radius: 10px;
        }

        .users-list::-webkit-scrollbar-thumb:hover,
        .messages-area::-webkit-scrollbar-thumb:hover {
            background: rgba(234, 88, 12, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .users-sidebar {
                width: 100%;
            }

            .chat-area {
                display: none;
            }

            .chat-area.active {
                display: flex;
            }

            .users-sidebar.hidden {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="admin-chat-container">
        <!-- Sidebar - User List -->
        <div class="users-sidebar" id="usersSidebar">
            <div class="sidebar-header">
                <h2>💬 Chat Admin</h2>
                <p>Kelola pesan dari semua pelanggan</p>
            </div>

            <div class="search-box">
                <input type="text" class="search-input" placeholder="Cari pelanggan..." id="searchInput">
            </div>

            <div class="users-list" id="usersList">
                @if($users->count() > 0)
                    @foreach($users as $userData)
                        <div class="user-item" 
                             data-user-id="{{ $userData['user']->id }}"
                             onclick="selectUser({{ $userData['user']->id }}, '{{ $userData['user']->name }}', '{{ $userData['user']->email }}')">
                            <div class="user-avatar">
                                {{ strtoupper(substr($userData['user']->name, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">
                                    <span>{{ $userData['user']->name }}</span>
                                    @if($userData['unread_count'] > 0)
                                        <span class="unread-badge">{{ $userData['unread_count'] }}</span>
                                    @endif
                                </div>
                                <div class="last-message">
                                    @if($userData['last_message'])
                                        {{ Str::limit($userData['last_message']->message, 40) }}
                                    @else
                                        Belum ada pesan
                                    @endif
                                </div>
                                @if($userData['last_message'])
                                    <div class="message-time">
                                        {{ $userData['last_message']->created_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="padding: 40px 20px; text-align: center; color: #9ca3af;">
                        <i class="fas fa-inbox" style="font-size: 50px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>Belum ada pesan masuk</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area" id="chatArea">
            <div class="empty-chat">
                <i class="fas fa-comment-dots"></i>
                <h3>Pilih Pelanggan</h3>
                <p>Pilih pelanggan dari daftar di sebelah kiri untuk mulai chat dan melihat riwayat percakapan</p>
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;
        let currentUserName = '';
        let currentUserEmail = '';

        // Select user and load chat
        async function selectUser(userId, userName, userEmail) {
            currentUserId = userId;
            currentUserName = userName;
            currentUserEmail = userEmail;

            // Update active state
            document.querySelectorAll('.user-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-user-id="${userId}"]`).classList.add('active');

            // Load chat messages
            await loadUserMessages(userId);

            // For mobile - show chat area
            document.getElementById('chatArea').classList.add('active');
            document.getElementById('usersSidebar').classList.add('hidden');
        }

        // Load messages for specific user
        async function loadUserMessages(userId) {
            try {
                const response = await fetch(`/admin/chat/user/${userId}/messages`);
                const data = await response.json();

                if (data.success) {
                    renderChatArea(data.messages);
                }
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        }

        // Render chat area with messages
        function renderChatArea(messages) {
            const chatArea = document.getElementById('chatArea');
            const firstInitial = currentUserName.charAt(0).toUpperCase();

            chatArea.innerHTML = `
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="selected-user-avatar">${firstInitial}</div>
                    <div class="selected-user-info">
                        <h3>${currentUserName}</h3>
                        <p>${currentUserEmail}</p>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="messages-area" id="messagesArea">
                    ${messages.length > 0 ? renderMessages(messages) : '<div style="text-align: center; color: #9ca3af; padding: 40px;">Belum ada pesan</div>'}
                </div>

                <!-- Admin Input Area -->
                <div class="admin-input-area">
                    <textarea class="admin-message-input" 
                              id="adminMessageInput" 
                              placeholder="Ketik balasan Anda..."
                              onkeypress="handleAdminKeyPress(event)"></textarea>
                    <button class="admin-send-btn" onclick="sendAdminReply()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            `;

            scrollToBottom();
        }

        // Render messages HTML
        function renderMessages(messages) {
            return messages.map(msg => {
                const time = new Date(msg.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                let badge = '';
                
                if (msg.sender_type === 'user') {
                    badge = '<span class="user-badge">👤 User</span><br>';
                } else if (msg.sender_type === 'bot') {
                    badge = '<span class="bot-badge">🤖 Bot</span><br>';
                }

                return `
                    <div class="message ${msg.sender_type}">
                        <div class="message-bubble">
                            ${badge}
                            ${msg.message.replace(/\n/g, '<br>')}
                            <span class="msg-time">${time}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Handle Enter key for admin
        function handleAdminKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendAdminReply();
            }
        }

        // Send admin reply
        async function sendAdminReply() {
            if (!currentUserId) return;

            const input = document.getElementById('adminMessageInput');
            const message = input.value.trim();

            if (!message) return;

            input.disabled = true;

            try {
                const response = await fetch('{{ route("chat.admin.reply") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        user_id: currentUserId,
                        message: message
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Add message to UI
                    const messagesArea = document.getElementById('messagesArea');
                    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message admin';
                    messageDiv.innerHTML = `
                        <div class="message-bubble">
                            ${message.replace(/\n/g, '<br>')}
                            <span class="msg-time">${time}</span>
                        </div>
                    `;
                    
                    messagesArea.appendChild(messageDiv);
                    input.value = '';
                    scrollToBottom();
                }
            } catch (error) {
                console.error('Error sending reply:', error);
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            } finally {
                input.disabled = false;
                input.focus();
            }
        }

        // Scroll to bottom
        function scrollToBottom() {
            const messagesArea = document.getElementById('messagesArea');
            if (messagesArea) {
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }
        }

        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const userItems = document.querySelectorAll('.user-item');

            userItems.forEach(item => {
                const userName = item.querySelector('.user-name span').textContent.toLowerCase();
                const lastMessage = item.querySelector('.last-message').textContent.toLowerCase();

                if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Auto refresh messages every 5 seconds
        setInterval(() => {
            if (currentUserId) {
                loadUserMessages(currentUserId);
            }
        }, 5000);
    </script>
</body>
</html>
