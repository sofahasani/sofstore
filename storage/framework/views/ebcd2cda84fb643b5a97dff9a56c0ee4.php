<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Modern Glassmorphism</title>
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

    .name-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-bottom: 20px;
    }

    .sign-up-button {
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
      margin-top: 10px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2), 0 0 0 2px rgba(255, 255, 255, 0.2) inset;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .sign-up-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }

    .sign-up-button:hover::before {
      left: 100%;
    }

    .sign-up-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3), 0 0 0 2px rgba(255, 255, 255, 0.3) inset;
    }

    .sign-up-button:active {
      transform: translateY(-1px);
    }

    .signin-link {
      text-align: center;
      font-size: 14px;
      color: #666666;
      font-weight: 500;
    }

    .signin-link a {
      color: #FF7300;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s;
      display: inline-block;
    }

    .signin-link a:hover {
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

    @media (max-width: 480px) {
      .container { width: 100%; }
      .glass-card { padding: 60px 30px 40px; border-radius: 0; }
      h1 { font-size: 28px; }
      .form-group input { padding: 14px 16px; }
      .name-grid { grid-template-columns: 1fr; gap: 20px; }
    }

    @media (min-width: 481px) {
      .glass-card {
        max-width: 450px;
        margin: 0 auto;
        border-radius: 30px;
        min-height: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
      }
      .container { padding: 20px; }
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .sign-up-button.loading::after {
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
  <div class="orange-wave-top"></div>
  <div class="bottom-accent"></div>

  <a href="<?php echo e(url('/')); ?>" class="back-button">
    <svg fill="none" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
  </a>

  <div class="container">
    <div class="glass-card">
      <h1>Create Account</h1>

      <?php if($errors->any()): ?>
        <div class="error-message" style="display: block;">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($error); ?><br>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>

      <?php if(session('status')): ?>
        <div style="display: block; background: rgba(52, 199, 89, 0.1); color: #34C759; border: 1px solid rgba(52, 199, 89, 0.2); padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 500;">
          <?php echo e(session('status')); ?>

        </div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
        <?php echo csrf_field(); ?>

        <div class="form-group">
          <input type="email" name="email" placeholder="Email Address" required value="<?php echo e(old('email')); ?>" />
        </div>

        <div class="name-grid">
          <div class="form-group">
            <input type="text" name="name" placeholder="Full Name" required value="<?php echo e(old('name')); ?>" />
          </div>
          <div class="form-group">
            <input type="text" name="whatsapp" placeholder="WhatsApp (Optional)" value="<?php echo e(old('whatsapp')); ?>" />
          </div>
        </div>

        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required minlength="8" />
        </div>

        <div class="form-group">
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required minlength="8" />
        </div>

        <button type="submit" class="sign-up-button">Create Account</button>
      </form>

      <div class="signin-link">
        Already Have Account? <a href="<?php echo e(route('login')); ?>">Login</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const button = this.querySelector('.sign-up-button');
      button.classList.add('loading');
      button.disabled = true;
    });

    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    confirmPassword.addEventListener('input', function() {
      if (this.value && this.value !== password.value) {
        this.style.borderColor = '#FF3B30';
        this.style.background = 'rgba(255, 59, 48, 0.05)';
      } else if (this.value === password.value && this.value.length > 0) {
        this.style.borderColor = '#34C759';
        this.style.background = 'rgba(52, 199, 89, 0.05)';
      } else {
        this.style.borderColor = '#E0E0E0';
        this.style.background = '#F5F5F5';
      }
    });

    password.addEventListener('input', function() {
      const strength = this.value.length;
      if (strength < 8) {
        this.style.borderColor = '#FF3B30';
      } else if (strength < 12) {
        this.style.borderColor = '#FF9500';
      } else {
        this.style.borderColor = '#34C759';
      }
    });
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/auth/register.blade.php ENDPATH**/ ?>