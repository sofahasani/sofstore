<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* bagian atas oranye bergelombang */
        .top-bg {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #ff6b00, #ff8800);
            border-bottom-left-radius: 60% 20%;
            border-bottom-right-radius: 60% 20%;
            position: relative;
        }

        .forgot-container {
            width: 90%;
            max-width: 360px;
            background: #fff;
            margin-top: -100px;
            text-align: center;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .description {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background-color: #f0f0f0;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            background-color: #e8e8e8;
            box-shadow: 0 0 0 2px #ff8800;
        }

        .reset-button {
            width: 100%;
            padding: 12px;
            background-color: #ff8800;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }

        .reset-button:hover {
            background-color: #ff7700;
        }

        .back-to-login {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }

        .back-to-login a {
            color: #ff8800;
            text-decoration: none;
            font-weight: 500;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .status-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }

        .status-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="top-bg"></div>

    <!-- Back Button (Floating di kiri atas) -->
    <button onclick="smartBack('/login')" style="position: fixed; top: 20px; left: 20px; z-index: 1000; background: rgba(255, 255, 255, 0.9); border: 1px solid #e5e7eb; padding: 10px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onmouseover="this.style.background='#fff'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5">
        <path d="M15 19l-7-7 7-7"/>
      </svg>
    </button>

    <div class="forgot-container">
        <h1>Forgot Password</h1>
        <p class="description">Enter your email address and we'll send you a link to reset your password.</p>

        @if (session('status'))
            <div class="status-message show">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="reset-button">Send Reset Link</button>
        </form>

        <div class="back-to-login">
            Remember your password? <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>

    <script>
        // Smart back navigation - Fixed version
        function smartBack(defaultUrl) {
            if (window.history.length > 1 && document.referrer) {
                window.history.back();
            } else {
                window.location.href = defaultUrl || '{{ route("login") }}';
            }
        }
    </script>
</body>
</html>