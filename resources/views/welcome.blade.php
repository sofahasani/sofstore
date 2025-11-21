<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #FAFAFA;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .container {
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    h1 {
      font-size: 80px;
      font-weight: 800;
      background: linear-gradient(90deg, #8B5CF6 0%, #A78BFA 25%, #F97316 75%, #FB923C 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 40px;
      letter-spacing: -2px;
      animation: slideDown 0.6s ease;
    }

    .icon-wrapper {
      width: 80px;
      height: 80px;
      margin: 0 auto 50px;
      position: relative;
      animation: scaleUp 0.8s ease 0.2s both;
    }

    .icon-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, #F97316 0%, #8B5CF6 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
    }

    .icon-circle svg {
      width: 40px;
      height: 40px;
      fill: white;
    }

    .start-btn {
      border: 2px solid #6366F1;
      color: #6366F1;
      background: transparent;
      padding: 14px 50px;
      border-radius: 25px;
      font-weight: 600;
      font-size: 13px;
      letter-spacing: 1.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      animation: fadeIn 0.8s ease 0.4s both;
      font-family: 'Poppins', sans-serif;
    }

    .start-btn:hover {
      background: linear-gradient(135deg, #8B5CF6, #6366F1);
      color: white;
      border-color: transparent;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
    }

    .bottom-nav {
      position: absolute;
      bottom: 40px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 20px;
      animation: slideUp 0.8s ease 0.6s both;
    }

    .nav-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      border: 2px solid #E0E7FF;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .nav-icon:hover {
      border-color: #8B5CF6;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(139, 92, 246, 0.2);
    }

    .nav-icon svg {
      width: 22px;
      height: 22px;
      stroke: #8B5CF6;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideDown {
      from { 
        opacity: 0; 
        transform: translateY(-30px); 
      }
      to { 
        opacity: 1; 
        transform: translateY(0); 
      }
    }

    @keyframes slideUp {
      from { 
        opacity: 0; 
        transform: translateX(-50%) translateY(30px); 
      }
      to { 
        opacity: 1; 
        transform: translateX(-50%) translateY(0); 
      }
    }

    @keyframes scaleUp {
      from { 
        opacity: 0; 
        transform: scale(0.5); 
      }
      to { 
        opacity: 1; 
        transform: scale(1); 
      }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 64px;
      }
      
      .bottom-nav {
        gap: 15px;
        bottom: 30px;
      }
      
      .nav-icon {
        width: 44px;
        height: 44px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Hello</h1>

    <div class="icon-wrapper">
      <div class="icon-circle">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L2 7L12 12L22 7L12 2Z"/>
          <path d="M2 17L12 22L22 17"/>
          <path d="M2 12L12 17L22 12"/>
        </svg>
      </div>
    </div>

    <button class="start-btn" onclick="window.location.href='/dashboard'">Let's Start</button>
  </div>

  <div class="bottom-nav">
    <div class="nav-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <rect x="3" y="3" width="7" height="7" rx="1"/>
        <rect x="14" y="3" width="7" height="7" rx="1"/>
        <rect x="14" y="14" width="7" height="7" rx="1"/>
        <rect x="3" y="14" width="7" height="7" rx="1"/>
      </svg>
    </div>
    
    <div class="nav-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
      </svg>
    </div>
    
    <div class="nav-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
        <line x1="6" y1="1" x2="6" y2="4"/>
        <line x1="10" y1="1" x2="10" y2="4"/>
        <line x1="14" y1="1" x2="14" y2="4"/>
      </svg>
    </div>
    
    <div class="nav-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
    </div>
    
    <div class="nav-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
    </div>
  </div>
</body>
</html>
