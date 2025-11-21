<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modern Mobile Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    html { 
      box-sizing: border-box;
      scroll-behavior: smooth;
    }
    *, *:before, *:after { box-sizing: inherit; }
    body {
      font-family: 'SF Pro', 'Segoe UI', 'Roboto', 'Poppins', Arial, sans-serif;
      background: #f9fafb;
      color: #222;
      margin: 0;
      min-height: 100vh;
      transition: background 0.3s;
    }
    
    /* Scroll Progress Bar */
    #scrollProgress {
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 3px;
      background: linear-gradient(90deg, #ff7300, #ff9500);
      z-index: 9999;
      transition: width 0.1s ease;
      box-shadow: 0 0 10px rgba(255, 115, 0, 0.5);
    }
    @media (prefers-color-scheme: dark) {
      body { background: #18181b; color: #eee; }
      .flash-sale { box-shadow: 0 4px 24px rgba(255,115,0,0.12); }
      .product-card { background: #232326; color: #eee; }
    }
    .main-content { max-width: 1200px; margin: 0 auto; padding: 0 16px 32px; }
    .flash-sale {
      background: linear-gradient(135deg, #ff7300 0%, #ff9500 50%, #ffa500 100%);
      border-radius: 24px;
      color: #fff;
      box-shadow: 0 8px 32px rgba(255,115,0,0.25);
      padding: 32px 24px 24px 24px;
      margin: 24px auto 32px auto;
      max-width: 700px;
      text-align: center;
      position: relative;
      font-family: inherit;
      transition: all 0.3s ease;
      overflow: hidden;
      animation: floatIn 0.6s ease;
    }
    
    /* Floating particles animation */
    .flash-sale::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
      background-size: 50px 50px;
      animation: particleFloat 20s linear infinite;
      pointer-events: none;
    }
    
    @keyframes particleFloat {
      0% { transform: translate(0, 0); }
      100% { transform: translate(50px, 50px); }
    }
    
    @keyframes floatIn {
      from { 
        opacity: 0; 
        transform: translateY(-20px);
      }
      to { 
        opacity: 1; 
        transform: translateY(0);
      }
    }
    
    .flash-sale:hover {
      box-shadow: 0 12px 40px rgba(255,115,0,0.35);
      transform: translateY(-2px);
    }
    
    .flash-title {
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: 0.02em;
      margin-bottom: 16px;
      text-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: relative;
      z-index: 1;
    }
    
    .countdown {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-bottom: 12px;
      position: relative;
      z-index: 1;
    }
    
    .time-box {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      color: #ff7300;
      font-weight: 800;
      font-size: 1.25rem;
      border-radius: 12px;
      padding: 12px 18px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      min-width: 50px;
      transition: all 0.3s ease;
      animation: flipIn 0.6s ease;
    }
    
    .time-box:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    
    @keyframes flipIn {
      from {
        transform: rotateX(-90deg);
        opacity: 0;
      }
      to {
        transform: rotateX(0);
        opacity: 1;
      }
    }
    
    .flash-sale-text {
      font-size: 1.05rem;
      opacity: 0.98;
      margin-top: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      position: relative;
      z-index: 1;
    }
    .products-section {
      margin-top: 0;
      padding: 0;
    }
    .section-title {
      font-size: 1.15rem;
      font-weight: 600;
      color: #222;
      margin-bottom: 18px;
      text-align: left;
      letter-spacing: 0.01em;
    }
    .product-grid {
      display: grid;
      gap: 24px;
      width: 100%;
      margin-bottom: 24px;
      grid-template-columns: repeat(2, 1fr);
    }
    @media (min-width: 640px) {
      .product-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (min-width: 1024px) {
      .product-grid { grid-template-columns: repeat(4, 1fr); }
    }
    .product-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 24px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 16px 18px 16px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      animation: cardSlideUp 0.6s ease backwards;
    }
    
    @keyframes cardSlideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .product-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255,115,0,0.05), rgba(255,149,0,0.05));
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }
    
    .product-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 35px rgba(255,115,0,0.2), 0 0 0 1px rgba(255,115,0,0.1);
      border-color: rgba(255,115,0,0.3);
    }
    
    .product-card:hover::before {
      opacity: 1;
    }
    
    .product-card:active {
      transform: translateY(-4px) scale(1.01);
    }
      cursor: pointer;
      text-decoration: none;
      min-width: 0;
      position: relative;
    }
    .product-card:hover {
      box-shadow: 0 8px 32px rgba(0,0,0,0.13);
      transform: translateY(-4px) scale(1.03);
    }
    .product-image-container {
      width: 100%;
      aspect-ratio: 1 / 1;
      background: #f3f4f6;
      border-radius: 16px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    }
    .product-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 16px;
      transition: transform 0.3s;
      background: #f3f4f6;
    }
    .product-card:hover .product-image {
      transform: scale(1.06);
    }
    .product-name {
      font-size: 1rem;
      font-weight: 600;
      color: #222;
      text-align: center;
      margin-bottom: 8px;
      line-height: 1.3;
      font-family: inherit;
      letter-spacing: 0.01em;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 2.2em;
    }
    .product-price {
      color: #ff7300;
      font-weight: 700;
      font-size: 1.08rem;
      margin-bottom: 2px;
      text-align: center;
      font-family: inherit;
    }
    .product-desc {
      font-size: 0.95rem;
      color: #888;
      text-align: center;
      margin-bottom: 6px;
      font-family: inherit;
    }
    .product-stock {
      font-size: 0.85rem;
      color: #bbb;
      text-align: center;
      margin-bottom: 0;
      font-family: inherit;
    }
    @media (prefers-color-scheme: dark) {
      .product-card { background: #232326; color: #eee; }
      .product-image-container { background: #232326; }
      .product-name, .product-desc, .product-stock { color: #eee; }
      .product-price { color: #ff9500; }
    }

    /* === STYLE TETAP PUNYA KAMU (tidak dihapus, hanya dirapikan) === */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: "Poppins", sans-serif; background: #fff; color: #333; }
    .header { background: #fff; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 10002; }
    .header-left { display: flex; align-items: center; gap: 10px; position: relative; z-index: 10003; }
    
    /* Enhanced Menu Icon with Animation */
    .menu-icon { 
      width: 24px; 
      height: 24px; 
      cursor: pointer; 
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      z-index: 10001;
    }
    .menu-icon:hover { 
      transform: scale(1.15) rotate(90deg); 
    }
    .menu-icon:active {
      transform: scale(0.95);
    }
    
    .search-container { display: flex; align-items: center; background: #f2f2f2; border-radius: 25px; padding: 6px 12px; width: 180px; }
    .search-container input { border: none; background: none; outline: none; width: 100%; margin-left: 8px; font-size: 13px; }
    .header-right { display: flex; align-items: center; gap: 15px; }

    /* Enhanced Dropdown Menu with Glassmorphism */
    .dropdown { 
      position: absolute; 
      top: 48px; 
      left: 0; 
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 20px; 
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 115, 0, 0.1);
      width: 220px; 
      display: none; 
      flex-direction: column; 
      overflow: hidden; 
      z-index: 10000;
      animation: slideDownFade 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
      transform-origin: top left;
    }
    
    .dropdown.show {
      display: flex;
    }
    
    @keyframes slideDownFade { 
      from { 
        opacity: 0; 
        transform: translateY(-20px) scale(0.95); 
      } 
      to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
      } 
    }
    
    .dropdown a { 
      text-decoration: none; 
      color: #333; 
      padding: 14px 18px; 
      font-size: 14px; 
      font-weight: 500;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      display: flex; 
      align-items: center; 
      gap: 12px;
      position: relative;
      overflow: hidden;
    }
    
    .dropdown a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(135deg, #ff7300, #ff9500);
      transform: scaleY(0);
      transition: transform 0.3s ease;
    }
    
    .dropdown a:hover::before {
      transform: scaleY(1);
    }
    
    .dropdown a::after {
      content: '';
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background: linear-gradient(90deg, rgba(255, 115, 0, 0.08), transparent);
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .dropdown a:hover { 
      background: rgba(255, 115, 0, 0.05);
      color: #ff7300; 
      padding-left: 24px;
      transform: translateX(4px);
    }
    
    .dropdown a:hover::after {
      opacity: 1;
    }
    
    .dropdown a:active {
      transform: scale(0.98);
    }
    
    /* Emoji Icons Enhancement */
    .dropdown a span:first-child {
      font-size: 18px;
      transition: transform 0.3s ease;
      display: inline-block;
    }
    
    .dropdown a:hover span:first-child {
      transform: scale(1.2) rotate(10deg);
    }
    
    /* Dropdown Backdrop */
    .dropdown-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(2px);
      z-index: 9999;
      display: none;
      animation: fadeInBackdrop 0.3s ease;
    }
    
    .dropdown-backdrop.show {
      display: block;
    }
    
    @keyframes fadeInBackdrop {
      from { opacity: 0; }
      to { opacity: 1; }
    }

  .cart-icon { position: relative; cursor: pointer; transition: transform 0.2s ease; z-index: 9999; pointer-events: auto; }
  .cart-icon:hover { transform: scale(1.05); }
    .cart-count { position: absolute; top: -6px; right: -6px; background: #ff6b00; color: white; border-radius: 50%; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; font-size: 10px; }

    .main-content { margin-top: 15px; padding: 0 16px 60px; }

    .flash-sale { background: linear-gradient(135deg, #ff8800, #ff6b00); border-radius: 15px; padding: 16px; color: #fff; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(255,107,0,0.3); }
    .flash-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
    .flash-title { font-size: 18px; font-weight: 700; }
    .countdown { display: flex; gap: 4px; }
    .time-box { background: white; color: #ff6b00; padding: 4px 6px; border-radius: 5px; font-size: 12px; font-weight: bold; }

    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 4px; }
    .product-card { 
      background: #fff; 
      border-radius: 8px; 
      overflow: hidden;
      box-shadow: 0 1px 4px rgba(0,0,0,0.08); 
      position: relative; 
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      border: 1px solid rgba(0,0,0,0.04);
      text-decoration: none;
      color: inherit;
    }
    .product-card:hover { 
      transform: translateY(-4px) scale(1.02); 
      box-shadow: 0 12px 24px rgba(0,0,0,0.15); 
      border-color: rgba(255,66,78,0.2);
      text-decoration: none;
    }
    .product-image-container {
      position: relative;
      width: 100%;
      padding-top: 100%; /* Square aspect ratio */
      overflow: hidden;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    .product-image { 
      position: absolute;
      top: 0;
      left: 0;
      width: 100%; 
      height: 100%; 
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    .product-card:hover .product-image {
      transform: scale(1.08);
    }
    .discount-badge { 
      position: absolute; 
      top: 3px; 
      left: 3px; 
      background: linear-gradient(135deg, #ff3b3b 0%, #ff1744 100%);
      color: #fff; 
      padding: 1px 4px; 
      font-size: 9px; 
      border-radius: 3px; 
      font-weight: 700;
      box-shadow: 0 1px 3px rgba(255,23,68,0.4);
      z-index: 2;
    }
    .mall-badge {
      position: absolute;
      top: 3px;
      right: 3px;
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      color: #fff;
      padding: 1px 4px;
      font-size: 8px;
      border-radius: 2px;
      font-weight: 700;
      letter-spacing: 0.3px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.3);
      z-index: 2;
    }
    .stock-badge {
      position: absolute;
      bottom: 3px;
      right: 3px;
      background: rgba(0,0,0,0.75);
      backdrop-filter: blur(10px);
      color: #fff;
      padding: 1px 4px;
      font-size: 8px;
      border-radius: 2px;
      font-weight: 600;
      z-index: 2;
    }
    .product-info {
      padding: 12px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 6px;
      background: #fff;
    }
    .product-name { 
      font-size: 11px; 
      font-weight: 500;
      color: #1a1a1a;
      line-height: 1.2;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 26px;
    }
    .price-section {
      margin: 0;
    }
    .price-container {
      display: flex;
      align-items: center;
      gap: 3px;
      margin-bottom: 0;
    }
    .product-price { 
      color: #ff424e; 
      font-weight: 800; 
      font-size: 15px;
      letter-spacing: -0.3px;
    }
    .original-price {
      color: #9ca3af;
      font-size: 10px;
      text-decoration: line-through;
      font-weight: 500;
    }
    .discount-percent {
      background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
      color: #ff424e;
      padding: 1px 3px;
      border-radius: 2px;
      font-size: 8px;
      font-weight: 700;
      margin-left: auto;
    }
    .product-meta {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 4px;
      font-size: 10px;
      padding-top: 0;
      margin-top: 2px;
    }
    .meta-left {
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .rating-badge {
      display: flex;
      align-items: center;
      gap: 2px;
      background: #fffbeb;
      padding: 1px 3px;
      border-radius: 2px;
      border: 1px solid #fef3c7;
    }
    .star-icon {
      color: #f59e0b;
      font-size: 10px;
    }
    .rating-text {
      color: #92400e;
      font-weight: 600;
      font-size: 9px;
    }
    .sold-count {
      color: #6b7280;
      font-weight: 500;
      font-size: 9px;
    }
    .category-tag {
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      color: #4b5563;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 8px;
      font-weight: 600;
      margin-top: 1px;
      display: inline-block;
      width: fit-content;
    }
    .free-shipping {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 8px;
      font-weight: 700;
      margin-top: 1px;
      display: flex;
      align-items: center;
      gap: 2px;
      width: fit-content;
      box-shadow: 0 1px 2px rgba(16, 185, 129, 0.2);
    }
    
    /* Remove underline from all text in product card */
    .product-card,
    .product-card:hover,
    .product-card:visited,
    .product-card:active {
      text-decoration: none !important;
    }
    
    /* Keep line-through for original price */
    .product-card .original-price {
      text-decoration: line-through !important;
    }
    
    .sales-info { font-size: 11px; color: #777; margin-top: 3px; }
    
    /* Responsive Grid */
    @media (max-width: 480px) {
      .product-grid { 
        grid-template-columns: repeat(2, 1fr); 
        gap: 4px;
      }
      .product-card {
        border-radius: 6px;
      }
      .product-name {
        font-size: 10px;
        min-height: 24px;
      }
      .product-price {
        font-size: 13px;
      }
      .product-meta {
        font-size: 8px;
      }
      .product-info {
        padding: 5px;
        gap: 2px;
      }
    }
    
    @media (min-width: 481px) and (max-width: 768px) {
      .product-grid { 
        grid-template-columns: repeat(3, 1fr);
        gap: 4px;
      }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
      .product-grid { 
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
      }
    }
    
    @media (min-width: 1025px) {
      .product-grid { 
        grid-template-columns: repeat(5, 1fr);
        gap: 6px;
      }
    }
    
    @media (min-width: 1440px) {
      .product-grid { 
        grid-template-columns: repeat(6, 1fr);
        gap: 6px;
      }
    }

  .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.18); display: none; justify-content: center; align-items: center; z-index: 500; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); opacity: 0; transition: opacity 0.3s ease; pointer-events: none; }
    .modal { background: rgba(255,255,255,0.9); border-radius: 20px; padding: 20px; max-width: 360px; width: 90%; transform: translateY(50px); opacity: 0; transition: all 0.3s ease; }
    .modal.active { transform: translateY(0); opacity: 1; }

    .cart-modal { background: rgba(255,255,255,0.95); position: fixed; bottom: -100%; left: 0; width: 100%; height: 60%; border-radius: 20px 20px 0 0; box-shadow: 0 -4px 10px rgba(0,0,0,0.1); z-index: 1001; transition: bottom 0.4s ease; }
    .cart-modal.active { bottom: 0; }
    .cart-header { padding: 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; font-weight: 600; }

    .product-modal, .product-manage-modal { background: #fff; border-radius: 15px; padding: 20px; }
    .product-modal input, .product-modal textarea { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
    .product-modal button { padding: 8px 16px; border-radius: 4px; font-size: 14px; cursor: pointer; transition: all 0.2s ease; }

    /* ===== RECOMMENDATION SECTIONS ===== */
    .recommendation-section { 
      margin-bottom: 30px; 
      animation: fadeInSection 0.5s ease;
    }
    
    @keyframes fadeInSection {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .section-header { 
      display: flex; 
      align-items: center; 
      gap: 12px; 
      margin-bottom: 16px; 
      padding-bottom: 12px;
      border-bottom: 2px solid #f0f0f0;
    }
    
    .section-icon { 
      font-size: 28px; 
      filter: drop-shadow(0 2px 4px rgba(255,115,0,0.3));
      animation: pulse 2s ease infinite;
    }
    
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    
    .section-title { 
      font-size: 20px; 
      font-weight: 700; 
      color: #333;
      background: linear-gradient(135deg, #ff7300, #ff5500);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .section-subtitle { 
      font-size: 13px; 
      color: #666; 
      font-weight: 400;
      margin-left: auto;
      background: rgba(255,115,0,0.08);
      padding: 4px 12px;
      border-radius: 20px;
    }
    
    .recommendation-grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); 
      gap: 12px;
    }
    
    /* Skeleton Loader */
    .skeleton-card {
      background: #fff;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      overflow: hidden;
      position: relative;
    }
    
    .skeleton-loader {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
      border-radius: 8px;
    }
    
    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    .skeleton-loader.image {
      width: 100%;
      height: 130px;
      margin-bottom: 8px;
    }
    
    .skeleton-loader.title {
      width: 80%;
      height: 14px;
      margin-bottom: 8px;
    }
    
    .skeleton-loader.price {
      width: 50%;
      height: 12px;
    }
    
    /* Price Alerts Container */
    .price-alerts-container {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .price-alert-item {
      background: linear-gradient(135deg, rgba(255,115,0,0.08), rgba(255,85,0,0.05));
      border-radius: 12px;
      padding: 12px;
      display: flex;
      gap: 12px;
      align-items: center;
      border-left: 4px solid #ff7300;
      box-shadow: 0 2px 8px rgba(255,115,0,0.1);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    
    .price-alert-item:hover {
      transform: translateX(4px);
      box-shadow: 0 4px 12px rgba(255,115,0,0.2);
    }
    
    .price-alert-image {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
      background: #f0f0f0;
    }
    
    .price-alert-info {
      flex: 1;
    }
    
    .price-alert-name {
      font-size: 14px;
      font-weight: 600;
      color: #333;
      margin-bottom: 4px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .price-alert-prices {
      display: flex;
      gap: 8px;
      align-items: center;
      margin-bottom: 4px;
    }
    
    .original-price {
      font-size: 12px;
      color: #999;
      text-decoration: line-through;
    }
    
    .current-price {
      font-size: 15px;
      font-weight: 700;
      color: #ff7300;
    }
    
    .discount-badge-alert {
      background: linear-gradient(135deg, #ff3b3b, #ff1a1a);
      color: white;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(255,59,59,0.3);
    }
    
    /* Empty State */
    .empty-recommendations {
      text-align: center;
      padding: 40px 20px;
      color: #999;
    }
    
    .empty-recommendations .icon {
      font-size: 48px;
      margin-bottom: 12px;
      opacity: 0.5;
    }
    
    .empty-recommendations p {
      font-size: 14px;
      margin-bottom: 8px;
    }

    @media (min-width: 600px) {
      .search-container { width: 260px; }
      .product-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
    }
    
    /* Profile modal should be fixed and above the overlay */
    .profile-modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1002;
      min-width: 280px;
      max-width: 420px;
      width: 90%;
      background: #fff;
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      display: none;
      opacity: 0;
      transition: opacity 0.18s ease, transform 0.18s ease;
    }
    
    .profile-modal.active {
      display: block;
      opacity: 1;
      transform: translate(-50%, -50%) scale(1);
    }

    .glass {
      background: rgba(255,255,255,0.7);
      box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 28px;
      border: 1px solid rgba(255,255,255,0.18);
    }
    .cart-modal-ios {
      background: rgba(0,0,0,0.18);
      backdrop-filter: blur(2px);
      -webkit-backdrop-filter: blur(2px);
      transition: opacity 0.3s cubic-bezier(.4,0,.2,1);
      opacity: 0;
      z-index: 1200; /* modal sits above overlayClick (1100) but below cart-icon (9999) */
    }
    .cart-modal-ios.active {
      opacity: 1;
      display: flex !important;
    }
    @media (max-width: 640px) {
      .cart-sheet {
        border-radius: 28px 28px 0 0 !important;
        max-width: 100vw !important;
        width: 100vw !important;
        position: absolute;
        left: 0;
        bottom: 0;
        margin: 0;
        box-shadow: 0 -8px 32px 0 rgba(31,38,135,0.10);
        animation: slideUpCart 0.32s cubic-bezier(.4,0,.2,1);
      }
      @keyframes slideUpCart {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
      }
    }
    @media (min-width: 641px) {
      .cart-sheet {
        border-radius: 28px !important;
        max-width: 480px !important;
        margin: auto;
        animation: fadeInCart 0.32s cubic-bezier(.4,0,.2,1);
      }
      @keyframes fadeInCart {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
      }
    }
    .cart-item {
      box-shadow: 0 2px 8px rgba(31,38,135,0.08);
      border-radius: 20px;
      background: #fafafa;
    }
    /* badge on top-left for random labels */
    .random-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      padding: 4px 8px;
      font-size: 12px;
      font-weight: 700;
      border-radius: 999px;
      color: white;
      box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }
    .badge-ori { background: linear-gradient(90deg,#16a34a,#34d399); }
    .badge-mall { background: linear-gradient(90deg,#2563eb,#60a5fa); }
    .badge-flash { background: linear-gradient(90deg,#ff6b00,#ff3b30); }
    .badge-limited { background: linear-gradient(90deg,#7c3aed,#d8b4fe); color:#111; }
    .badge-new { background: linear-gradient(90deg,#06b6d4,#67e8f9); color:#053; }
    .badge-bestseller { background: linear-gradient(90deg,#f59e0b,#fbbf24); color:#111; }

    /* clickable overlay used to catch outside clicks, sits below modal but above content */
    .overlay-click {
      position: fixed; top:0; left:0; width:100%; height:100%; display:none; z-index:1100; background:transparent; pointer-events:auto;
    }
    
    /* ============ NEW ENHANCED FEATURES ============ */
    
    /* Category Chips */
    .category-section {
      margin: 24px auto 32px;
      max-width: 1200px;
      padding: 0 16px;
    }
    
    .category-scroll {
      display: flex;
      gap: 12px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 8px 0 16px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    
    .category-scroll::-webkit-scrollbar {
      display: none;
    }
    
    .category-chip {
      flex-shrink: 0;
      padding: 12px 24px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 2px solid transparent;
      white-space: nowrap;
      position: relative;
      overflow: hidden;
    }
    
    .category-chip::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }
    
    .category-chip:hover::before {
      left: 100%;
    }
    
    .category-chip.active {
      transform: scale(1.05);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .category-chip:hover {
      transform: translateY(-2px) scale(1.02);
    }
    
    .category-all {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .category-electronics {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
    }
    
    .category-fashion {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
    }
    
    .category-home {
      background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
    }
    
    .category-beauty {
      background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
    }
    
    .category-sports {
      background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(48, 207, 208, 0.4);
    }
    
    .category-toys {
      background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
      color: #333;
      box-shadow: 0 4px 15px rgba(168, 237, 234, 0.4);
    }
    
    .category-books {
      background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
      color: #333;
      box-shadow: 0 4px 15px rgba(255, 154, 158, 0.4);
    }
    
    /* Enhanced Search */
    .search-container {
      position: relative;
    }
    
    .search-container input:focus {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 0 0 3px rgba(255, 115, 0, 0.1), 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Scroll to Top Button */
    #scrollToTop {
      position: fixed;
      bottom: 80px;
      right: 20px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: linear-gradient(135deg, #ff7300, #ff9500);
      color: white;
      border: none;
      cursor: pointer;
      display: none;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 20px rgba(255, 115, 0, 0.4);
      z-index: 1000;
      transition: all 0.3s ease;
      animation: bounceIn 0.6s ease;
    }
    
    #scrollToTop:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 25px rgba(255, 115, 0, 0.5);
    }
    
    #scrollToTop:active {
      transform: translateY(-1px);
    }
    
    @keyframes bounceIn {
      0% { transform: scale(0); opacity: 0; }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); opacity: 1; }
    }
    
    /* Product Image Enhancement */
    .product-image {
      border-radius: 16px;
      transition: transform 0.4s ease;
    }
    
    .product-card:hover .product-image {
      transform: scale(1.05) rotate(2deg);
    }
    
    /* Loading Skeleton */
    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
      border-radius: 16px;
    }
    
    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    /* Notification Pulse */
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }
    
    .cart-count {
      animation: pulse 2s infinite;
    }
    
    /* Stagger Animation for Cards */
    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }
    .product-card:nth-child(5) { animation-delay: 0.5s; }
    .product-card:nth-child(6) { animation-delay: 0.6s; }
    .product-card:nth-child(7) { animation-delay: 0.7s; }
    .product-card:nth-child(8) { animation-delay: 0.8s; }

  </style>

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
  <!-- Scroll Progress Bar -->
  <div id="scrollProgress"></div>
  
  <!-- Dropdown Backdrop -->
  <div class="dropdown-backdrop" id="dropdownBackdrop"></div>

  <!-- ========== HEADER ========== -->
  <header class="header">
    <div class="header-left">
      <!-- Back Button -->
      <button onclick="smartBack()" style="background: none; border: none; padding: 8px; margin-right: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5">
          <path d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      
      <svg class="menu-icon" id="menuBtn" viewBox="0 0 24 24">
        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="#333" />
      </svg>

      <div class="dropdown" id="dropdownMenu">
        <a href="/dashboard"><span>🏠</span> Beranda</a>
        <a href="#" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href='/cart'; }"><span>🛒</span> Keranjang</a>
        <a href="#" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href='<?php echo e(route('orders.index')); ?>'; }"><span>📦</span> Pesanan Saya</a>
        <a href="#" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href='<?php echo e(route('wishlist.index')); ?>'; }"><span>❤️</span> Wishlist</a>
        <a href="#" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href='/profile'; }"><span>👤</span> Profile</a>
        <a href="<?php echo e(route('help.index')); ?>"><span>💬</span> Bantuan</a>
        <?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.dashboard')); ?>"><span>⚡</span> Admin Panel</a>
        <?php endif; ?>
        <?php if(auth()->check()): ?>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>🚪</span> Logout</a>
        <?php else: ?>
        <a href="<?php echo e(route('login')); ?>"><span>🔐</span> Masuk</a>
        <a href="<?php echo e(route('register')); ?>"><span>✨</span> Daftar</a>
        <?php endif; ?>
      </div>
      <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
      </form>

      <div class="search-container">
        <svg width="18" height="18" viewBox="0 0 24 24">
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 
          11.11 16 9.5 16 5.91 13.09 3 
          9.5 3S3 5.91 3 9.5 5.91 16 
          9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 
          4.99L20.49 19l-4.99-5z" fill="#666" />
        </svg>
        <input type="text" placeholder="Search" />
      </div>
    </div>

    <div class="header-right">
      <div class="cart-icon" id="cartBtn" style="cursor: pointer; position: relative;">
        <svg width="22" height="22" viewBox="0 0 24 24">
          <path d="M7 18c-1.1 0-1.99.9-1.99 
            2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 
            2v2h2l3.6 7.59-1.35 
            2.45c-.16.28-.25.61-.25.96 
            0 1.1.9 2 2 
            2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 
            0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 
            0-.55-.45-1-1-1H5.21l-.94-2H1zm16 
            16c-1.1 0-1.99.9-1.99 
            2s.89 2 1.99 2 2-.9 
            2-2-.9-2-2-2z"
            fill="#333"/>
        </svg>
        <span class="cart-count" id="dashboardCartBadge" style="position: absolute; top: -6px; right: -6px; background: #ff7300; color: #fff; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">0</span>
      </div>

      <a href="#" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href='/profile'; }" class="profile-icon" title="Profile">
        <svg width="22" height="22" viewBox="0 0 24 24">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" fill="#333"/>
        </svg>
      </a>
    </div>
  </header>

  <!-- Profile Completion Alert (only for authenticated users) -->
  <?php if(auth()->guard()->check()): ?>
  <?php if(!auth()->user()->phone || !auth()->user()->address): ?>
  <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffe7a0 100%); border-left: 4px solid #ff6b35; margin: 16px 16px 0 16px; padding: 12px 16px; border-radius: 12px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(255,107,53,0.15); animation: slideDown 0.5s ease;">
    <div style="color: #ff6b35; font-size: 24px; flex-shrink: 0;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
    </div>
    <div style="flex: 1;">
      <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px; color: #333;">Complete Your Profile</div>
      <div style="font-size: 12px; color: #666;">Add your personal info to secure your account and enhance your shopping experience</div>
    </div>
    <button onclick="window.location.href='<?php echo e(route('profile')); ?>'" style="background: #ff6b35; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; white-space: nowrap; transition: all 0.2s;" onmouseover="this.style.background='#ff5722'" onmouseout="this.style.background='#ff6b35'">
      Update Now
    </button>
  </div>
  <style>
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
  <?php endif; ?>
  <?php endif; ?>

  <!-- ========== MAIN ========== -->
  <main class="main-content">
    <div class="flash-sale">
      <div class="flash-title">🔥 PEAK DAY 10.10<br>BEST DEALS UP TO 80% OFF</div>
      <div class="countdown">
        <div class="time-box">0</div>
        <div class="time-box">6</div>
        <div class="time-box">2</div>
        <div class="time-box">8</div>
      </div>
      <div class="flash-sale-text">Flash Sales Now Live</div>
    </div>
    
    <!-- Category Chips -->
    <div class="category-section">
      <div class="category-scroll">
        <div class="category-chip category-all active" data-category="all">
          🌟 All Products
        </div>
        <div class="category-chip category-electronics" data-category="Electronics">
          📱 Electronics
        </div>
        <div class="category-chip category-fashion" data-category="Fashion">
          👕 Fashion
        </div>
        <div class="category-chip category-home" data-category="Home">
          🏠 Home & Living
        </div>
        <div class="category-chip category-beauty" data-category="Beauty">
          💄 Beauty
        </div>
        <div class="category-chip category-sports" data-category="Sports">
          ⚽ Sports
        </div>
        <div class="category-chip category-toys" data-category="Toys">
          🧸 Toys & Games
        </div>
        <div class="category-chip category-books" data-category="Books">
          📚 Books
        </div>
      </div>
    </div>
    
    <!-- RECOMMENDATION ENGINE SECTIONS -->
    
    <!-- Personalized Recommendations -->
    <div class="recommendation-section" id="personalizedSection" style="display: none;">
      <div class="section-header">
        <div class="section-title">
          <span class="section-icon">🎯</span>
          Rekomendasi Untuk Kamu
        </div>
        <div class="section-subtitle">Berdasarkan riwayat browsing kamu</div>
      </div>
      <div class="recommendation-grid" id="personalizedGrid">
        <!-- Loading skeleton -->
        <div class="skeleton-loader">
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
        </div>
      </div>
    </div>

    <!-- Trending Products -->
    <div class="recommendation-section" id="trendingSection" style="display: none;">
      <div class="section-header">
        <div class="section-title">
          <span class="section-icon">🔥</span>
          Trending Sekarang
        </div>
        <div class="section-subtitle">Paling banyak dilihat 24 jam terakhir</div>
      </div>
      <div class="recommendation-grid" id="trendingGrid">
        <!-- Loading skeleton -->
        <div class="skeleton-loader">
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
          <div class="skeleton-card"></div>
        </div>
      </div>
    </div>

    <!-- Price Drop Alerts -->
    <div class="recommendation-section" id="priceAlertsSection" style="display: none;">
      <div class="section-header">
        <div class="section-title">
          <span class="section-icon">💰</span>
          Diskon di Wishlist Kamu
        </div>
        <div class="section-subtitle">Harga turun, buruan beli!</div>
      </div>
      <div class="price-alerts-container" id="priceAlertsContainer">
        <!-- Price alerts will be inserted here -->
      </div>
    </div>
    
    <div class="products-section">
      <div class="section-title">Produk Terbaru</div>
      <div class="product-grid">
        <?php
          $products = \App\Models\Product::latest()->limit(20)->get();
        ?>
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e(route('products.show', $product->id)); ?>" class="product-card">
            <div class="product-image-container">
              <?php if($product->image): ?>
                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="product-image">
              <?php else: ?>
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                  <span style="font-size: 40px;">📦</span>
                </div>
              <?php endif; ?>
              
              <?php
                // Calculate discount
                $originalPrice = $product->price * 1.5;
                $discount = round((($originalPrice - $product->price) / $originalPrice) * 100);
                $hasDiscount = $discount > 0;
              ?>
              
              <?php if($hasDiscount): ?>
                <div class="discount-badge">-<?php echo e($discount); ?>%</div>
              <?php endif; ?>
              <div class="mall-badge">MALL</div>
              
              <?php if($product->stock): ?>
                <div class="stock-badge">Stok: <?php echo e($product->stock > 999 ? '999+' : $product->stock); ?></div>
              <?php endif; ?>
            </div>
            
            <div class="product-info">
              <div class="product-name"><?php echo e($product->name); ?></div>
              
              <div class="price-section">
                <div class="price-container">
                  <div class="product-price">Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                  <?php if($hasDiscount): ?>
                    <div class="discount-percent"><?php echo e($discount); ?>%</div>
                  <?php endif; ?>
                </div>
                <?php if($hasDiscount): ?>
                  <div class="original-price">Rp<?php echo e(number_format($originalPrice, 0, ',', '.')); ?></div>
                <?php endif; ?>
              </div>
              
              <div class="product-meta">
                <div class="meta-left">
                  <?php
                    $avgRating = $product->reviews()->avg('rating') ?? 0;
                    $totalSold = $product->orders()->where('status', 'delivered')->sum('quantity') ?? 0;
                  ?>
                  
                  <?php if($avgRating > 0): ?>
                    <div class="rating-badge">
                      <span class="star-icon">★</span>
                      <span class="rating-text"><?php echo e(number_format($avgRating, 1)); ?></span>
                    </div>
                  <?php endif; ?>
                  
                  <?php if($totalSold > 0): ?>
                    <div class="sold-count">
                      <?php echo e($totalSold > 1000 ? number_format($totalSold/1000, 1) . 'rb' : $totalSold); ?> terjual
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              
              <?php if($product->category): ?>
                <div class="category-tag"><?php echo e($product->category); ?></div>
              <?php endif; ?>
              
              <?php if($product->price >= 100000): ?>
                <div class="free-shipping">
                  <span>🚚</span>
                  <span>Gratis Ongkir</span>
                </div>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; opacity: 0.6;">
            <div style="font-size: 64px; margin-bottom: 16px;">🛍️</div>
            <div style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">Belum Ada Produk</div>
            <div style="font-size: 14px;">Silakan tambahkan produk melalui Admin Panel</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <!-- ========== MODALS ========== -->
  <div class="overlay" id="overlay"></div>
  <div class="overlay-click" id="overlayClick"></div>
  <div id="cartModal" class="cart-modal-ios fixed left-0 bottom-0 w-full h-full flex items-center justify-center" style="display:none;">
    <div class="cart-sheet bg-white bg-opacity-80 glass shadow-xl rounded-[36px] p-6 max-w-md w-full mx-auto transition-all duration-300 ease-[cubic-bezier(.4,0,.2,1)]" style="max-width:520px; border-radius:36px;">
      <div class="flex items-center justify-between mb-6">
        <span class="font-semibold text-lg text-gray-900" style="font-family:'Poppins', 'SF Pro', sans-serif;">Keranjang Produk</span>
        <button id="closeCart" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-all duration-300" style="box-shadow:0 2px 20px rgba(0,0,0,0.10); border-radius:24px;">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>
      <div class="space-y-4">
        <!-- Example cart items, replace with dynamic -->
        <div class="cart-item bg-white bg-opacity-90 rounded-[24px] shadow-md flex items-center px-4 py-3 gap-4 transition-all duration-300" style="box-shadow:0 4px 38px rgba(0,0,0,0.10); border-radius:24px;">
          <img src="/images/no-image.png" class="w-16 h-16 object-cover rounded-[20px] shadow" alt="Produk" style="border-radius:20px;">
          <div class="flex-1">
            <div class="font-semibold text-gray-900 text-base">Nama Produk</div>
            <div class="text-gray-500 text-sm">Rp15.000</div>
          </div>
          <div class="flex items-center gap-2">
            <button class="bg-gray-100 hover:bg-gray-200 rounded-full w-9 h-9 flex items-center justify-center transition-all duration-300" style="border-radius:20px; box-shadow:0 2px 20px rgba(0,0,0,0.08);">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
            </button>
            <span class="font-semibold text-gray-700">1</span>
            <button class="bg-gray-100 hover:bg-gray-200 rounded-full w-9 h-9 flex items-center justify-center transition-all duration-300" style="border-radius:20px; box-shadow:0 2px 20px rgba(0,0,0,0.08);">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </button>
          </div>
        </div>
        <!-- End example cart item -->
      </div>
      <div class="mt-8 flex flex-col gap-3">
        <button class="w-full py-3 rounded-[28px] bg-[#ff6b00] text-white font-semibold text-base shadow-md hover:bg-orange-500 transition-all duration-300" style="font-family:'Poppins', 'SF Pro', sans-serif; border-radius:28px; box-shadow:0 4px 28px rgba(0,0,0,0.10);">Checkout</button>
      </div>
    </div>
  </div>

  <!-- Modal Tambah/Edit Produk -->
  <div class="overlay" id="productOverlay">
    <div class="modal product-modal">
      <h2>Tambah Produk Baru</h2>
      <form id="productForm" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <label>Nama Produk</label>
        <input type="text" name="name" required>

        <label>Deskripsi</label>
        <textarea name="description" rows="3"></textarea>

        <label>Harga</label>
        <input type="number" name="price" required>

        <label>Stok</label>
        <input type="number" name="stock" required>

        <label>Kategori</label>
        <input type="text" name="category">

        <label>Gambar Produk</label>
        <input type="file" name="image" accept="image/*">

        <div class="flex justify-end space-x-3 mt-5" style="margin-top:15px;text-align:right;">
          <button type="button" onclick="closeProductModal()" class="px-4 py-2 border rounded-md text-gray-600">Batal</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Kelola Produk -->
  <div class="overlay" id="productManageOverlay">
    <div class="modal product-manage-modal">
      <h2>Kelola Produk</h2>
      <div id="productList"></div>
    </div>
  </div>

  <!-- profile is a separate page at /profile; modal removed -->

  <!-- ========== SCRIPT ========== -->
  <script>
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  const dropdownMenu = document.getElementById('dropdownMenu');
  const menuBtn = document.getElementById('menuBtn');
  menuBtn.onclick = (e)=>{e.stopPropagation();dropdownMenu.style.display=dropdownMenu.style.display==='flex'?'none':'flex';};
  document.body.addEventListener('click', e => { if (!dropdownMenu.contains(e.target) && e.target!==menuBtn) dropdownMenu.style.display='none'; });

  const overlay=document.getElementById("overlay");
  const overlayClick=document.getElementById("overlayClick");
  const cartModal=document.getElementById("cartModal");

  // Cart button - check authentication first
  document.getElementById("cartBtn").onclick=()=>{
    if (!isAuthenticated) {
      showLoginModal();
    } else {
      window.location.href = '/cart';
    }
  };
  
  document.getElementById("closeCart").onclick=closeAll;
  overlayClick.onclick=closeAll;
  function closeAll(){
    overlay.style.opacity="0";
    overlayClick.style.display = 'none';
    setTimeout(()=>overlay.style.display="none",300);
    cartModal.classList.remove("active");
  }

  const productOverlay=document.getElementById('productOverlay');
  const productForm=document.getElementById('productForm');
  const productGrid=document.querySelector('.product-grid');

  document.getElementById('openProductModal').addEventListener('click',e=>{
    e.preventDefault();
    productOverlay.style.display='flex';
    setTimeout(()=>{productOverlay.style.opacity='1';productOverlay.querySelector('.modal').classList.add('active');},10);
  });

  function closeProductModal(){
    productOverlay.style.opacity='0';
    productOverlay.querySelector('.modal').classList.remove('active');
    setTimeout(()=>productOverlay.style.display='none',300);
  }

  async function refreshProductGrid(){
    try{
      const res=await fetch('/products');
      const products=await res.json();
      const labels = ['Ori','Mall','Flash Sale','Limited','New','Best Seller'];
      function pickLabel(){ return labels[Math.floor(Math.random()*labels.length)]; }
      function badgeClass(label){
        switch(label){
          case 'Ori': return 'badge-ori';
          case 'Mall': return 'badge-mall';
          case 'Flash Sale': return 'badge-flash';
          case 'Limited': return 'badge-limited';
          case 'New': return 'badge-new';
          case 'Best Seller': return 'badge-bestseller';
          default: return 'badge-mall';
        }
      }
      productGrid.innerHTML=products.map(p=>{
        const lbl = pickLabel();
        return `
        <a href="/products/${p.id}" class="product-card" style="text-decoration: none; color: inherit; display: block;">
          <span class="random-badge ${badgeClass(lbl)}">${lbl}</span>
          <span class="discount-badge">${p.status==='active'?'Active':'Inactive'}</span>
          <img src="${p.image ? (p.image.startsWith('http') ? p.image : '/storage/' + p.image) : 'https://dummyimage.com/200x200/f3f4f6/aaa&text=No+Image'}" class="product-image">
          <div class="product-name">${p.name}</div>
          <div class="product-price">Rp ${Number(p.price).toLocaleString('id-ID')}</div>
          <div class="sales-info">${p.category||'Umum'} | Stok: ${p.stock || 0}</div>
        </a>`;
      }).join('');
    }catch(err){console.error(err);}
  }
  refreshProductGrid();

  productForm.addEventListener('submit',async e=>{
    e.preventDefault();
    const formData=new FormData(productForm);
    const res=await fetch('/products',{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken},body:formData});
    if(res.ok){alert('Produk berhasil disimpan');closeProductModal();refreshProductGrid();}
    else alert('Gagal menyimpan produk');
  });

  // profile handled on separate page (/profile)

  // ============ ENHANCED FEATURES SCRIPTS ============
  
  // Scroll Progress Bar
  window.addEventListener('scroll', function() {
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.getElementById('scrollProgress').style.width = scrolled + '%';
  });
  
  // Scroll to Top Button
  const scrollToTopBtn = document.getElementById('scrollToTop');
  
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      scrollToTopBtn.style.display = 'flex';
    } else {
      scrollToTopBtn.style.display = 'none';
    }
  });
  
  scrollToTopBtn.addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  
  // Category Filter
  const categoryChips = document.querySelectorAll('.category-chip');
  const productCards = document.querySelectorAll('.product-card');
  
  categoryChips.forEach(chip => {
    chip.addEventListener('click', function() {
      // Remove active class from all chips
      categoryChips.forEach(c => c.classList.remove('active'));
      
      // Add active class to clicked chip
      this.classList.add('active');
      
      const selectedCategory = this.getAttribute('data-category');
      
      // Filter products
      productCards.forEach(card => {
        const productCategory = card.querySelector('.sales-info')?.textContent.split('|')[0].trim();
        
        if (selectedCategory === 'all' || productCategory === selectedCategory) {
          card.style.display = 'flex';
          card.style.animation = 'cardSlideUp 0.6s ease backwards';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
  
  // Enhanced Search with real-time filter
  const searchInput = document.querySelector('.search-container input');
  
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      
      productCards.forEach(card => {
        const productName = card.querySelector('.product-name')?.textContent.toLowerCase();
        const productDesc = card.querySelector('.product-desc')?.textContent.toLowerCase();
        
        if (productName?.includes(searchTerm) || productDesc?.includes(searchTerm)) {
          card.style.display = 'flex';
          card.style.animation = 'cardSlideUp 0.6s ease backwards';
        } else {
          card.style.display = 'none';
        }
      });
      
      // Reset category filter jika search
      if (searchTerm !== '') {
        categoryChips.forEach(c => c.classList.remove('active'));
      } else {
        categoryChips[0].classList.add('active');
      }
    });
  }
  
  // Animated Countdown Timer
  function animateCountdown() {
    const timeBoxes = document.querySelectorAll('.time-box');
    setInterval(() => {
      timeBoxes.forEach((box, index) => {
        const currentValue = parseInt(box.textContent);
        const newValue = currentValue > 0 ? currentValue - 1 : 9;
        
        box.style.animation = 'flipIn 0.6s ease';
        setTimeout(() => {
          box.textContent = newValue;
        }, 300);
      });
    }, 1000);
  }
  
  // Start countdown animation
  animateCountdown();
  
  // Parallax effect on scroll for flash sale
  window.addEventListener('scroll', function() {
    const flashSale = document.querySelector('.flash-sale');
    if (flashSale) {
      const scrolled = window.pageYOffset;
      flashSale.style.transform = `translateY(${scrolled * 0.3}px)`;
    }
  });
  
  // Lazy load images with fade-in effect
  const images = document.querySelectorAll('.product-image');
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.6s ease';
        
        if (img.complete) {
          img.style.opacity = '1';
        } else {
          img.addEventListener('load', () => {
            img.style.opacity = '1';
          });
        }
        
        observer.unobserve(img);
      }
    });
  });
  
  images.forEach(img => imageObserver.observe(img));

  // Cart Badge Update (sync dengan localStorage)
  function updateDashboardCartBadge() {
    // Hitung dari cartItems langsung untuk akurasi
    const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
    const cartCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update localStorage cartCount juga
    localStorage.setItem('cartCount', cartCount);
    
    const badge = document.getElementById('dashboardCartBadge');
    if (badge) {
      badge.textContent = cartCount;
      badge.style.display = cartCount > 0 ? 'flex' : 'none';
    }
  }
  
  // Initialize cart badge saat halaman load
  updateDashboardCartBadge();
  
  // Listen untuk cart updates (custom event)
  window.addEventListener('cartUpdated', function() {
    updateDashboardCartBadge();
  });
  
  // Listen storage changes dari tab lain
  window.addEventListener('storage', function(e) {
    if (e.key === 'cartCount' || e.key === 'cartItems') {
      updateDashboardCartBadge();
    }
  });
  
  // Update badge setiap 500ms untuk memastikan sinkronisasi
  setInterval(updateDashboardCartBadge, 500);

  // ============ SMART RECOMMENDATION ENGINE ============
  
  // Helper: Render Product Card
  function renderProductCard(product) {
    const imageUrl = product.image 
      ? (product.image.startsWith('http') ? product.image : '/storage/' + product.image)
      : 'https://dummyimage.com/200x200/f3f4f6/aaa&text=No+Image';
    
    const price = Number(product.price || 0).toLocaleString('id-ID');
    const category = product.category || 'Umum';
    const stock = product.stock || 0;
    const discount = product.discount || 0;
    
    return `
      <a href="/products/${product.id}" class="product-card" style="text-decoration: none; color: inherit; display: block;" onclick="trackProductView(${product.id})">
        ${discount > 0 ? `<span class="discount-badge">-${discount}%</span>` : ''}
        <img src="${imageUrl}" class="product-image" alt="${product.name}" loading="lazy">
        <div class="product-name">${product.name}</div>
        <div class="product-price">Rp ${price}</div>
        <div class="sales-info">${category} | Stok: ${stock}</div>
      </a>
    `;
  }
  
  // Helper: Render Price Alert
  function renderPriceAlert(alert) {
    const imageUrl = alert.product.image 
      ? (alert.product.image.startsWith('http') ? alert.product.image : '/storage/' + alert.product.image)
      : 'https://dummyimage.com/200x200/f3f4f6/aaa&text=No+Image';
    
    const originalPrice = Number(alert.original_price || 0).toLocaleString('id-ID');
    const currentPrice = Number(alert.current_price || 0).toLocaleString('id-ID');
    const discount = Math.round(alert.discount_percentage || 0);
    
    return `
      <a href="/products/${alert.product.id}" class="price-alert-item" style="text-decoration: none; color: inherit;" onclick="trackProductView(${alert.product.id})">
        <img src="${imageUrl}" class="price-alert-image" alt="${alert.product.name}" loading="lazy">
        <div class="price-alert-info">
          <div class="price-alert-name">${alert.product.name}</div>
          <div class="price-alert-prices">
            <span class="original-price">Rp ${originalPrice}</span>
            <span class="current-price">Rp ${currentPrice}</span>
            <span class="discount-badge-alert">-${discount}%</span>
          </div>
        </div>
      </a>
    `;
  }
  
  // Track Product View
  async function trackProductView(productId) {
    try {
      await fetch(`/api/recommendations/track-view/${productId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Content-Type': 'application/json'
        }
      });
    } catch (error) {
      console.error('Failed to track view:', error);
    }
  }
  
  // Load Personalized Recommendations
  async function loadPersonalizedRecommendations() {
    try {
      const response = await fetch('/api/recommendations/personalized');
      const data = await response.json();
      
      if (data.success && data.data.length > 0) {
        const grid = document.getElementById('personalizedGrid');
        grid.innerHTML = data.data.map(product => renderProductCard(product)).join('');
        
        document.getElementById('personalizedSection').style.display = 'block';
      }
    } catch (error) {
      console.error('Failed to load personalized recommendations:', error);
    }
  }
  
  // Load Trending Products
  async function loadTrendingProducts() {
    try {
      const response = await fetch('/api/recommendations/trending');
      const data = await response.json();
      
      if (data.success && data.data.length > 0) {
        const grid = document.getElementById('trendingGrid');
        grid.innerHTML = data.data.map(product => renderProductCard(product)).join('');
        
        document.getElementById('trendingSection').style.display = 'block';
      }
    } catch (error) {
      console.error('Failed to load trending products:', error);
    }
  }
  
  // Load Price Drop Alerts
  async function loadPriceAlerts() {
    try {
      const response = await fetch('/api/recommendations/price-alerts');
      const data = await response.json();
      
      if (data.success && data.data.length > 0) {
        const container = document.getElementById('priceAlertsContainer');
        container.innerHTML = data.data.map(alert => renderPriceAlert(alert)).join('');
        
        document.getElementById('priceAlertsSection').style.display = 'block';
      }
    } catch (error) {
      // User not authenticated or no alerts - silently fail
      console.log('No price alerts available');
    }
  }
  
  // Initialize Recommendations on Page Load
  window.addEventListener('DOMContentLoaded', function() {
    // Load all recommendations asynchronously
    setTimeout(() => {
      loadPersonalizedRecommendations();
      loadTrendingProducts();
      loadPriceAlerts();
    }, 300); // Small delay for better UX
  });

  </script>

  
  <?php echo $__env->make('components.cart-floating', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  
  
  <style>
    .cart-floating-wrapper > button {
      display: none !important;
    }
  </style>
  
  <!-- Scroll to Top Button -->
  <button id="scrollToTop" title="Back to top">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <path d="M12 19V5M5 12l7-7 7 7"/>
    </svg>
  </button>

  <script>
    // Smart back navigation - Fixed version
    function smartBack() {
      if (window.history.length > 1 && document.referrer) {
        window.history.back();
      } else {
        window.location.href = '/';
      }
    }
  </script>

  <!-- Live Chat Widget -->
  <?php echo $__env->make('components.chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- Auth Check Component -->
  <?php echo $__env->make('components.auth-check', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/dashboard.blade.php ENDPATH**/ ?>