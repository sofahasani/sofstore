<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In - Modern Glassmorphism</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Orange Wave Background at Top */
    .orange-wave-top {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 50%;
      background: linear-gradient(135deg, #FF7300 0%, #FF9500 100%);
      z-index: 0;
    }

    .orange-wave-top::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 150px;
      background: #ffffff;
      border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }

    /* Bottom right curved accent */
    .bottom-accent {
      position: absolute;
      bottom: -50px;
      right: -50px;
      width: 350px;
      height: 350px;
      background: linear-gradient(135deg, rgba(255, 115, 0, 0.15), rgba(255, 149, 0, 0.1));
      border-radius: 50%;
      z-index: 0;
      animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-20px, -20px); }
    }

    .container {
      width: 100%;
      max-width: 100%;
      height: 100vh;
      position: relative;
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
    }

    @keyframes slideUp {
      from { 
        opacity: 0; 
        transform: translateY(60px) scale(0.9);
      }
      to { 
        opacity: 1; 
        transform: translateY(0) scale(1);
      }
    }

    /* Glassmorphism Card */
    .glass-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 0;
      border: none;
      padding: 60px 35px 40px;
      box-shadow: none;
      position: relative;
      overflow: visible;
      width: 100%;
      max-width: 100%;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .glass-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -50%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 115, 0, 0.05), transparent);
      transform: skewX(-20deg);
      animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
      0% { left: -50%; }
      100% { left: 150%; }
    }

    /* Profile Avatar */
    .avatar-container {
      position: relative;
      width: 120px;
      height: 120px;
      margin: 0 auto 30px;
      z-index: 2;
    }

    .avatar {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: linear-gradient(135deg, #E8E8E8, #D0D0D0);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08),
                  0 0 0 8px rgba(255, 255, 255, 0.9);
      animation: pulse 3s ease-in-out infinite;
      border: none;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .avatar svg {
      width: 60px;
      height: 60px;
      fill: #FFFFFF;
    }

    h1 {
      font-size: 32px;
      font-weight: 800;
      color: #000000;
      text-align: center;
      margin-bottom: 35px;
      letter-spacing: -0.5px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-wrapper {
      position: relative;
      transition: all 0.3s ease;
    }

    .form-group input {
      width: 100%;
      padding: 16px 18px;
      border: 2px solid #E0E0E0;
      border-radius: 16px;
      font-size: 15px;
      outline: none;
      transition: all 0.3s ease;
      background: #F5F5F5;
      color: #333333;
      font-weight: 500;
      letter-spacing: 0.3px;
    }

    .form-group input::placeholder {
      color: #999999;
      font-weight: 400;
    }

    .form-group input:focus {
      border-color: #FF7300;
      background: #FFFFFF;
      box-shadow: 0 0 0 4px rgba(255, 115, 0, 0.1);
      transform: translateY(-2px);
    }

    .forgot-password {
      text-align: right;
      margin-bottom: 25px;
      margin-top: -8px;
    }

    .forgot-password a {
      font-size: 13px;
      color: #666666;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 500;
      display: inline-block;
    }

    .forgot-password a:hover {
      color: #FF7300;
      transform: translateX(3px);
    }

    .sign-in-button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #FF7300, #FF9500);
      color: white;
      border: none;
      border-radius: 16px;
      font-size: 17px;
      font-weight: 700;
      cursor: pointer;
      margin-bottom: 25px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2),
                  0 0 0 2px rgba(255, 255, 255, 0.2) inset;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .sign-in-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }

    .sign-in-button:hover::before {
      left: 100%;
    }

    .sign-in-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3),
                  0 0 0 2px rgba(255, 255, 255, 0.3) inset;
    }

    .sign-in-button:active {
      transform: translateY(-1px);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 25px 0;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1.5px solid #E0E0E0;
    }

    .divider span {
      margin: 0 15px;
      color: #666666;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .social-login {
      display: flex;
      justify-content: center;
      gap: 18px;
      margin-bottom: 25px;
    }

    .social-button {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: #FFFFFF;
      border: 2px solid #E0E0E0;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .social-button::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 115, 0, 0.1);
      transition: width 0.6s, height 0.6s, top 0.6s, left 0.6s;
    }

    .social-button:hover::before {
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    }

    .social-button:hover {
      background: #FFFFFF;
      border-color: #FF7300;
      transform: translateY(-5px) scale(1.1);
      box-shadow: 0 10px 25px rgba(255, 115, 0, 0.2);
    }

    .social-button svg {
      width: 26px;
      height: 26px;
      position: relative;
      z-index: 1;
      transition: transform 0.3s;
    }

    .social-button:hover svg {
      transform: scale(1.1) rotate(5deg);
    }

    /* Google Icon - keep original colors */
    .social-button:nth-child(1) svg path:nth-child(1) { fill: #4285F4; }
    .social-button:nth-child(1) svg path:nth-child(2) { fill: #34A853; }
    .social-button:nth-child(1) svg path:nth-child(3) { fill: #FBBC05; }
    .social-button:nth-child(1) svg path:nth-child(4) { fill: #EA4335; }
    
    /* Facebook Icon */
    .social-button:nth-child(2) svg path { fill: #1877F2; }
    
    /* LinkedIn Icon */
    .social-button:nth-child(3) svg path { fill: #0A66C2; }

    .signup-link {
      text-align: center;
      font-size: 14px;
      color: #666666;
      font-weight: 500;
    }

    .signup-link a {
      color: #FF7300;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s;
      display: inline-block;
    }

    .signup-link a:hover {
      color: #FF9500;
      transform: scale(1.05);
    }

    .error-message {
      background: rgba(255, 59, 48, 0.1);
      backdrop-filter: blur(10px);
      color: #FF3B30;
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 13px;
      display: none;
      border: 1px solid rgba(255, 59, 48, 0.2);
      font-weight: 500;
      animation: shake 0.5s;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      75% { transform: translateX(10px); }
    }

    /* Back Button */
    .back-button {
      position: fixed;
      top: 25px;
      left: 25px;
      z-index: 1000;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(0, 0, 0, 0.08);
      padding: 12px;
      border-radius: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .back-button:hover {
      background: #FFFFFF;
      border-color: #FF7300;
      transform: translateX(-5px);
      box-shadow: 0 6px 20px rgba(255, 115, 0, 0.15);
    }

    .back-button svg {
      width: 24px;
      height: 24px;
      stroke: #333333;
      stroke-width: 2.5;
    }

    .back-button:hover svg {
      stroke: #FF7300;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .container {
        width: 100%;
      }
      
      .glass-card {
        padding: 60px 30px 40px;
        border-radius: 0;
      }
      
      .avatar-container {
        width: 100px;
        height: 100px;
        margin: 0 auto 25px;
      }
      
      h1 {
        font-size: 28px;
      }

      .form-group input {
        padding: 14px 16px;
      }
    }

    @media (min-width: 481px) {
      .glass-card {
        max-width: 450px;
        margin: 0 auto;
        border-radius: 30px;
        min-height: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
      }

      .container {
        padding: 20px;
      }
    }

    /* Loading Animation */
    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .sign-in-button.loading::after {
      content: '';
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
  </style>
</head>
<body>
  <!-- Orange Wave Background at Top -->
  <div class="orange-wave-top"></div>

  <!-- Bottom Accent -->
  <div class="bottom-accent"></div>

  <!-- Back Button -->
  <button class="back-button" onclick="smartBack()">
    <svg fill="none" viewBox="0 0 24 24">
      <path d="M15 19l-7-7 7-7"/>
    </svg>
  </button>

  <div class="container">
    <div class="glass-card">
      <!-- Profile Avatar -->
      <div class="avatar-container">
        <div class="avatar">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </div>
      </div>

      <h1>Sign In</h1>

      <!-- Success Message -->
      <?php if(session('success')): ?>
      <div class="error-message" style="display: block; background: rgba(16, 185, 129, 0.1); color: #10b981; border-color: rgba(16, 185, 129, 0.2);">
        ✓ <?php echo e(session('success')); ?>

      </div>
      <?php endif; ?>

      <!-- Error Message -->
      <?php if(session('error')): ?>
      <div class="error-message" style="display: block;">
        ⚠️ <?php echo e(session('error')); ?>

      </div>
      <?php endif; ?>

      <div class="error-message" id="error-message">
        ⚠️ Please fill in all fields correctly.
      </div>

      <form id="login-form" method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
          <div class="input-wrapper">
            <input type="email" id="email" name="email" placeholder="Email" required value="<?php echo e(old('email')); ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <input type="password" id="password" name="password" placeholder="Password" required>
          </div>
        </div>

        <div class="forgot-password">
          <a href="#">Forgot your password?</a>
        </div>

        <button type="submit" class="sign-in-button" id="signInBtn">Sign In</button>
      </form>

      <div class="divider"><span>Or</span></div>

      <div class="social-login">
        <!-- Google -->
        <a href="<?php echo e(route('social.redirect', 'google')); ?>" class="social-button">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
        </a>
        <!-- Facebook -->
        <a href="<?php echo e(route('social.redirect', 'facebook')); ?>" class="social-button">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
        </a>
        <!-- LinkedIn -->
        <a href="<?php echo e(route('social.redirect', 'linkedin')); ?>" class="social-button">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="#0A66C2" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
          </svg>
        </a>
      </div>

      <div class="signup-link">
        Don't Have An Account? <a href="<?php echo e(route('register')); ?>">Sign Up</a>
      </div>
    </div>
  </div>

  <script>
    const form = document.getElementById('login-form');
    const errorMsg = document.getElementById('error-message');
    const btn = document.getElementById('signInBtn');

    // Show errors from Laravel
    <?php if($errors->any()): ?>
      errorMsg.style.display = 'block';
      errorMsg.innerHTML = '⚠️ <?php echo e($errors->first()); ?>';
      setTimeout(() => errorMsg.style.display = 'none', 4000);
    <?php endif; ?>

    form.addEventListener('submit', (e) => {
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      if (email === '' || password === '') {
        e.preventDefault();
        errorMsg.style.display = 'block';
        errorMsg.innerHTML = '⚠️ Please fill in all fields correctly.';
        setTimeout(() => errorMsg.style.display = 'none', 3000);
        return;
      }

      btn.classList.add('loading');
      btn.innerHTML = 'Signing in...';
      btn.disabled = true;
    });

    // Add input animation
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
      });
    });

    // Smart back navigation - Fixed version
    function smartBack() {
      if (window.history.length > 1 && document.referrer) {
        window.history.back();
      } else {
        window.location.href = '/';
      }
    }
  </script>

</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/auth/login.blade.php ENDPATH**/ ?>