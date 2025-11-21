<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fff;
            overflow-x: hidden;
            max-width: 100vw;
        }
        .container {
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            position: relative;
        }
        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 100;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        /* Dropdown Menu Styles */
        .dropdown-menu {
            position: absolute;
            top: 45px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
            font-size: 14px;
            color: #333;
        }
        
        .dropdown-item:hover {
            background: #f5f5f5;
        }
        
        .dropdown-item svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        
        .cart-container {
            position: relative;
        }
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ff9500;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }
        /* Image Section */
        .image-section {
            width: 100%;
            background: #f8f9fa;
            padding: 20px 0;
            position: relative;
            min-height: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .product-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            min-height: 300px;
            display: block;
            object-fit: contain;
            margin: 0 auto;
        }
        /* Carousel Dots */
        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d1d5db;
            cursor: pointer;
        }
        .dot.active {
            background: #3b82f6;
        }
        /* Product Info */
        .product-info {
            padding: 20px 20px 100px 20px;
        }
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        .product-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            flex: 1;
        }
        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            margin-left: 12px;
            transition: transform 0.2s;
        }
        .like-btn:active {
            transform: scale(1.2);
        }
        .like-btn svg {
            width: 28px;
            height: 28px;
        }
        .price {
            font-size: 18px;
            font-weight: 700;
            color: #ef4444;
            margin-bottom: 16px;
        }
        /* Meta Info */
        .meta-row {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
        }
        .meta-item .value {
            font-weight: 600;
            color: #1f2937;
        }
        .meta-item .label {
            color: #6b7280;
        }
        .star {
            color: #fbbf24;
        }
        /* Stock Progress */
        .stock-section {
            margin-bottom: 20px;
        }
        .stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .stock-label {
            font-size: 13px;
            color: #6b7280;
        }
        .stock-count {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }
        .stock-count.low {
            color: #ef4444;
        }
        .stock-progress {
            width: 100%;
            height: 8px;
            background: #f3f4f6;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        .stock-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 20px;
            transition: width 0.3s ease;
        }
        .stock-progress-bar.low {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }
        .stock-progress-bar.medium {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        .free-shipping {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #10b981;
            font-weight: 500;
        }
        .free-shipping svg {
            flex-shrink: 0;
        }
        .shipping-note {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .bookmark-btn {
            background: none;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 4px 8px;
            cursor: pointer;
        }
        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }
        /* Tabs Navigation */
        .tabs-nav {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #f3f4f6;
            margin-bottom: 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .tabs-nav::-webkit-scrollbar {
            display: none;
        }
        .tab-btn {
            padding: 12px 20px;
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: #9ca3af;
            cursor: pointer;
            white-space: nowrap;
            position: relative;
            transition: all 0.3s;
        }
        .tab-btn.active {
            color: #ff7300;
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff7300, #ff9500);
            border-radius: 3px 3px 0 0;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { 
                opacity: 0; 
                transform: translateY(-20px); 
                max-height: 0;
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
                max-height: 1000px;
            }
        }
        /* Product Details */
        .details-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }
        .description-text {
            font-size: 14px;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 16px;
        }
        .details-table {
            width: 100%;
        }
        .details-table tr {
            border-bottom: 1px solid #f3f4f6;
        }
        .details-table td {
            padding: 12px 0;
            font-size: 14px;
        }
        .details-table .label {
            color: #6b7280;
            width: 30%;
        }
        .details-table .value {
            color: #1f2937;
            font-weight: 500;
            text-align: right;
        }
        /* Delivery Info */
        .delivery-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
        }
        .delivery-title {
            font-size: 14px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .delivery-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }
        .delivery-item:last-child {
            margin-bottom: 0;
        }
        .delivery-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .delivery-text {
            flex: 1;
        }
        .delivery-text strong {
            font-size: 13px;
            color: #166534;
            display: block;
            margin-bottom: 2px;
        }
        .delivery-text span {
            font-size: 12px;
            color: #15803d;
        }
        /* Trust Badges */
        .trust-badges {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        .trust-badge {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            transition: all 0.2s;
        }
        .trust-badge:hover {
            border-color: #ff7300;
            box-shadow: 0 4px 12px rgba(255, 115, 0, 0.1);
        }
        .trust-badge-icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 8px;
        }
        .trust-badge-text {
            font-size: 11px;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.3;
        }
        /* Related Products */
        .related-section {
            margin-top: 30px;
            padding: 20px;
            background: #fafafa;
            margin-left: -20px;
            margin-right: -20px;
        }
        .related-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .related-products {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch;
        }
        .related-products::-webkit-scrollbar {
            height: 4px;
        }
        .related-products::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        .related-product-card {
            flex-shrink: 0;
            width: 140px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
        }
        .related-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }
        .related-product-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: #f3f4f6;
        }
        .related-product-info {
            padding: 10px;
        }
        .related-product-name {
            font-size: 12px;
            color: #1f2937;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        .related-product-price {
            font-size: 14px;
            font-weight: 700;
            color: #ef4444;
        }
        /* Reviews Section */
        .review-item {
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .review-item:last-child {
            border-bottom: none;
        }
        .review-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .review-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff7300, #ff9500);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .review-user-info {
            flex: 1;
        }
        .review-username {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }
        .review-date {
            font-size: 11px;
            color: #9ca3af;
        }
        .review-stars {
            display: flex;
            gap: 2px;
        }
        .review-text {
            font-size: 13px;
            line-height: 1.6;
            color: #4b5563;
            margin-top: 8px;
        }
        /* Bottom Actions */
        .bottom-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 16px 20px;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 12px;
            max-width: 430px;
            margin: 0 auto;
        }
        .add-to-cart-btn {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        .add-to-cart-btn:active {
            transform: scale(0.95);
        }
        .order-btn {
            flex: 1;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #ff9500 0%, #ff7300 100%);
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .order-btn:active {
            transform: scale(0.98);
        }
        /* Flying Animation */
        .flying-dot {
            position: fixed;
            width: 12px;
            height: 12px;
            background: #ff9500;
            border-radius: 50%;
            z-index: 9999;
            pointer-events: none;
            box-shadow: 0 2px 8px rgba(255, 149, 0, 0.6);
        }
        @keyframes flyToCart {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(0.3);
                opacity: 0.3;
            }
        }

        /* Share Modal - TikTok Shop Style */
        .share-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .share-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .share-modal {
            background: #fff;
            border-radius: 24px;
            max-width: 390px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .share-modal-overlay.active .share-modal {
            transform: scale(1) translateY(0);
        }

        .share-modal-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid #f3f4f6;
            position: relative;
        }

        .share-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            text-align: center;
            margin: 0;
        }

        .share-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f3f4f6;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .share-modal-close:hover {
            background: #e5e7eb;
            transform: rotate(90deg);
        }

        .share-product-card {
            margin: 20px;
            padding: 16px;
            background: linear-gradient(135deg, #fff5eb 0%, #ffe8d6 100%);
            border-radius: 16px;
            display: flex;
            gap: 12px;
            border: 1px solid rgba(255, 147, 0, 0.1);
        }

        .share-product-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            background: #fff;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .share-product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .share-product-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .share-product-price {
            font-size: 18px;
            font-weight: 800;
            color: #ff7300;
            margin-bottom: 4px;
        }

        .share-product-stock {
            font-size: 12px;
            color: #6b7280;
        }

        .share-options {
            padding: 0 20px 20px;
        }

        .share-options-title {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .share-buttons-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .share-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            padding: 12px 8px;
            border-radius: 12px;
            background: transparent;
            border: none;
        }

        .share-button:active {
            transform: scale(0.95);
        }

        .share-button-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .share-button:hover .share-button-icon {
            transform: scale(1.1);
        }

        .share-button-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .whatsapp-icon { background: linear-gradient(135deg, #25D366, #128C7E); }
        .facebook-icon { background: linear-gradient(135deg, #1877F2, #0C63D4); }
        .twitter-icon { background: linear-gradient(135deg, #1DA1F2, #0C8BD9); }
        .telegram-icon { background: linear-gradient(135deg, #0088cc, #006699); }
        .copy-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .email-icon { background: linear-gradient(135deg, #ea4335, #c5221f); }
        .linkedin-icon { background: linear-gradient(135deg, #0A66C2, #004182); }
        .messenger-icon { background: linear-gradient(135deg, #00B2FF, #0078FF); }

        .share-link-section {
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
            margin: 0 20px 20px;
        }

        .share-link-label {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .share-link-input-wrapper {
            display: flex;
            gap: 8px;
        }

        .share-link-input {
            flex: 1;
            padding: 12px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            color: #6b7280;
            background: #fff;
            outline: none;
        }

        .share-copy-btn {
            padding: 12px 20px;
            background: linear-gradient(135deg, #ff9500, #ff7300);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
            white-space: nowrap;
        }

        .share-copy-btn:active {
            transform: scale(0.95);
        }

        .share-copy-btn.copied {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Toast Notification - Enhanced */
        .toast-notification {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #10b981;
            color: #fff;
            padding: 16px 24px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 500;
            z-index: 10001;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            max-width: 90%;
            min-width: 280px;
        }

        .toast-notification.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        
        .toast-notification span {
            line-height: 1.5;
        }
        
        /* Spin animation for loading */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Report Modal - TikTok/Shopee Style */
        .report-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .report-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .report-modal {
            background: #fff;
            border-radius: 24px;
            max-width: 420px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .report-modal-overlay.active .report-modal {
            transform: scale(1) translateY(0);
        }

        .report-modal-header {
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 10;
            border-radius: 24px 24px 0 0;
        }

        .report-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .report-modal-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .report-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f3f4f6;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .report-modal-close:hover {
            background: #e5e7eb;
            transform: rotate(90deg);
        }

        .report-reasons {
            padding: 20px;
        }

        .report-reason-item {
            padding: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 12px;
            cursor: pointer !important;
            transition: all 0.2s;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            pointer-events: auto !important;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .report-reason-item:hover {
            border-color: #ff7300;
            background: #fff5eb;
        }

        .report-reason-item.selected {
            border-color: #ff7300;
            background: #fff5eb;
            box-shadow: 0 0 0 3px rgba(255, 115, 0, 0.1);
        }

        .report-reason-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .report-reason-item.selected .report-reason-radio {
            border-color: #ff7300;
        }

        .report-reason-radio::after {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ff7300;
            transform: scale(0);
            transition: transform 0.2s;
        }

        .report-reason-item.selected .report-reason-radio::after {
            transform: scale(1);
        }

        .report-reason-content {
            flex: 1;
        }

        .report-reason-title {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .report-reason-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .report-textarea-wrapper {
            padding: 0 20px 20px;
        }

        .report-textarea-label {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            display: block;
        }

        .report-textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s;
        }

        .report-textarea:focus {
            border-color: #ff7300;
        }

        .report-textarea::placeholder {
            color: #9ca3af;
        }

        .report-modal-footer {
            padding: 16px 20px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            gap: 12px;
            position: sticky;
            bottom: 0;
            background: #fff;
            border-radius: 0 0 24px 24px;
        }

        .report-cancel-btn {
            flex: 1;
            padding: 14px;
            border: 2px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .report-cancel-btn:hover {
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .report-submit-btn {
            flex: 1;
            padding: 14px;
            border: none;
            background: linear-gradient(135deg, #ff9500, #ff7300);
            color: #fff;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .report-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 115, 0, 0.3);
        }

        .report-submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .report-submit-btn:active:not(:disabled) {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <button class="icon-btn" onclick="smartBack()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            </div>
            <div class="header-right">
                <button class="icon-btn" id="shareBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2">
                        <path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/>
                        <polyline points="16 6 12 2 8 6"/>
                        <line x1="12" y1="2" x2="12" y2="15"/>
                    </svg>
                </button>
                <div class="cart-container">
                    <button class="icon-btn" onclick="window.location.href='{{ route('cart.index') }}'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span class="cart-badge" id="cartBadge">0</span>
                    </button>
                </div>
                
                <!-- Three Dots Menu Button -->
                <div style="position: relative;">
                    <button class="icon-btn" id="moreBtn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="5" r="2" fill="#000"/>
                            <circle cx="12" cy="12" r="2" fill="#000"/>
                            <circle cx="12" cy="19" r="2" fill="#000"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu" id="dropdownMenu">
                        <button class="dropdown-item" onclick="openReportModal()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                            </svg>
                            Laporkan Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Section -->
        <div class="image-section">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400/f8f9fa/ff7300?text=' . urlencode($product->name ?? 'Produk') }}" 
                 alt="{{ $product->name }}" 
                 class="product-image"
                 id="productImage"
                 onerror="this.src='https://via.placeholder.com/400x400/f8f9fa/ff7300?text=Product+Image'">
            
            <!-- Carousel Dots -->
            <div class="carousel-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <div class="product-header">
                <h1 class="product-title">{{ $product->name }}</h1>
                <button class="like-btn" id="likeBtn" data-liked="false" data-product-id="{{ $product->id }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ff1493" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            </div>

            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            <!-- Stock Info -->
            <div class="stock-section">
                <div class="stock-header">
                    <span class="stock-label">Stok Tersedia</span>
                    <span class="stock-count {{ $product->stock < 10 ? 'low' : '' }}">
                        {{ $product->stock ?? 50 }} unit
                    </span>
                </div>
                <div class="stock-progress">
                    <div class="stock-progress-bar {{ $product->stock < 10 ? 'low' : ($product->stock < 30 ? 'medium' : '') }}" 
                         style="width: {{ min(($product->stock / 100) * 100, 100) }}%">
                    </div>
                </div>
            </div>

            <!-- Meta Info Row -->
            <div class="meta-row">
                <div class="meta-item">
                    <span class="star">★</span>
                    <span class="value">4.9</span>
                    <span class="label">Ratings</span>
                </div>
                <div class="meta-item">
                    <span class="value">10.1k</span>
                    <span class="label">Terjual</span>
                </div>
                <div class="meta-item free-shipping">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    <span>Gratis Ongkir</span>
                </div>
            </div>

            <div class="shipping-note" style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                🚚 Pembelian di atas Rp 90.000
            </div>

            <hr class="divider">

            <!-- Tabs Navigation -->
            <div class="tabs-nav">
                <button class="tab-btn active" data-tab="description">Deskripsi</button>
                <button class="tab-btn" data-tab="specs">Spesifikasi</button>
                <button class="tab-btn" data-tab="reviews">Ulasan (2.4k)</button>
                <button class="tab-btn" data-tab="delivery">Pengiriman</button>
            </div>

            <!-- Tab Content: Description -->
            <div class="tab-content active" id="tab-description">
                <h3 class="details-title">Tentang Produk Ini</h3>
                <p class="description-text">
                    {{ $product->description ?? 'Produk berkualitas tinggi dengan desain modern dan performa maksimal. Cocok untuk penggunaan sehari-hari maupun profesional. Dilengkapi dengan fitur-fitur canggih yang memudahkan aktivitas Anda.' }}
                </p>
                
                <!-- Trust Badges -->
                <div class="trust-badges">
                    <div class="trust-badge">
                        <svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="trust-badge-text">100% Original</div>
                    </div>
                    <div class="trust-badge">
                        <svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                            <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <div class="trust-badge-text">COD Available</div>
                    </div>
                    <div class="trust-badge">
                        <svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <div class="trust-badge-text">7 Hari Retur</div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Specifications -->
            <div class="tab-content" id="tab-specs">
                <h3 class="details-title">Spesifikasi Lengkap</h3>
                <table class="details-table">
                    <tr>
                        <td class="label">Category</td>
                        <td class="value">{{ $product->category ?? 'Electronic / Accessories' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Brand</td>
                        <td class="value">{{ $product->brand ?? 'DJI' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Model</td>
                        <td class="value">{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Weight</td>
                        <td class="value">500 gram</td>
                    </tr>
                    <tr>
                        <td class="label">Dimensions</td>
                        <td class="value">15 x 10 x 5 cm</td>
                    </tr>
                    <tr>
                        <td class="label">Warranty</td>
                        <td class="value">1 Tahun Garansi Resmi</td>
                    </tr>
                    <tr>
                        <td class="label">Kondisi</td>
                        <td class="value">Baru</td>
                    </tr>
                </table>
            </div>

            <!-- Tab Content: Reviews -->
            <div class="tab-content" id="tab-reviews">
                <h3 class="details-title">Ulasan Pembeli</h3>
                
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-avatar">A</div>
                        <div class="review-user-info">
                            <div class="review-username">Ahmad Rizki</div>
                            <div class="review-date">3 hari lalu</div>
                        </div>
                        <div class="review-stars">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="review-text">Produknya bagus banget! Kualitas premium, packaging rapi, pengiriman cepat. Recommended seller!</p>
                </div>

                <div class="review-item">
                    <div class="review-header">
                        <div class="review-avatar">S</div>
                        <div class="review-user-info">
                            <div class="review-username">Siti Nurhaliza</div>
                            <div class="review-date">1 minggu lalu</div>
                        </div>
                        <div class="review-stars">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#d1d5db">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="review-text">Sesuai dengan deskripsi. Harga worth it dengan kualitas yang didapat. Seller responsif.</p>
                </div>

                <div class="review-item">
                    <div class="review-header">
                        <div class="review-avatar">B</div>
                        <div class="review-user-info">
                            <div class="review-username">Budi Santoso</div>
                            <div class="review-date">2 minggu lalu</div>
                        </div>
                        <div class="review-stars">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="review-text">Mantap! Barang original, packing bubble wrap tebal, sampai dengan selamat. Terima kasih!</p>
                </div>
            </div>

            <!-- Tab Content: Delivery -->
            <div class="tab-content" id="tab-delivery">
                <h3 class="details-title">Informasi Pengiriman</h3>
                
                <!-- Delivery Info Section -->
                <div class="delivery-section">
                    <div class="delivery-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2">
                            <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                        Estimasi Pengiriman
                    </div>
                    
                    <div class="delivery-item">
                        <svg class="delivery-icon" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="delivery-text">
                            <strong>Regular</strong>
                            <span>3-5 hari kerja • GRATIS ongkir min. 90rb</span>
                        </div>
                    </div>
                    
                    <div class="delivery-item">
                        <svg class="delivery-icon" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <div class="delivery-text">
                            <strong>Express (Same Day)</strong>
                            <span>Terima hari ini • Rp 15.000</span>
                        </div>
                    </div>
                    
                    <div class="delivery-item">
                        <svg class="delivery-icon" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <div class="delivery-text">
                            <strong>Ambil di Toko</strong>
                            <span>Pickup gratis • Siap dalam 2 jam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section - Minimal Professional -->
            <div class="reviews-section" style="margin-top: 40px; margin-bottom: 40px;">
                <!-- Section Header -->
                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #1c1917; margin: 0;">
                        Ulasan Pelanggan
                    </h3>
                </div>
                
                <!-- Review Stats - Minimal Card -->
                <div style="background: #fafaf9; border: 1px solid #e7e7e5; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 32px;">
                        <!-- Rating Display -->
                        <div style="text-align: center; min-width: 120px;">
                            <div style="font-size: 36px; font-weight: 700; color: #1c1917; margin-bottom: 4px;">
                                {{ number_format($product->average_rating, 1) }}
                            </div>
                            <div style="font-size: 20px; margin-bottom: 4px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= round($product->average_rating) ? '#fbbf24' : '#e5e7eb' }};">★</span>
                                @endfor
                            </div>
                            <div style="color: #78716c; font-size: 13px;">{{ $product->total_reviews }} ulasan</div>
                        </div>

                        <!-- Rating Distribution -->
                        <div style="flex: 1;">
                            @php
                                $ratings = [5,4,3,2,1];
                            @endphp
                            @foreach($ratings as $star)
                                @php
                                    $count = $product->reviews()->where('rating', $star)->count();
                                    $percentage = $product->total_reviews > 0 ? ($count / $product->total_reviews) * 100 : 0;
                                @endphp
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                    <span style="min-width: 45px; font-size: 13px; color: #78716c;">{{ $star }} ★</span>
                                    <div style="flex: 1; background: #e7e7e5; height: 6px; border-radius: 3px; overflow: hidden;">
                                        <div style="background: #fbbf24; height: 100%; width: {{ $percentage }}%; transition: width 0.3s ease;"></div>
                                    </div>
                                    <span style="min-width: 30px; text-align: right; font-size: 12px; color: #a8a29e;">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="reviews-list">
                    @forelse($product->reviews as $review)
                    <div style="background: white; border: 1px solid #e7e7e5; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
                        <!-- Review Header -->
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                    <div style="width: 36px; height: 36px; background: #1c1917; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                        {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1c1917; font-size: 14px;">
                                            {{ $review->reviewer_name }}
                                            @if($review->is_verified_purchase)
                                            <span style="background: #d1fae5; color: #065f46; font-size: 11px; padding: 2px 6px; border-radius: 4px; margin-left: 6px; font-weight: 600;">✓ Verified</span>
                                            @endif
                                        </div>
                                        <div style="color: #a8a29e; font-size: 12px;">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div style="font-size: 16px;">
                                @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $review->rating ? '#fbbf24' : '#e5e7eb' }};">★</span>
                                @endfor
                            </div>
                        </div>

                        <!-- Review Comment -->
                        @if($review->comment)
                        <p style="color: #57534e; font-size: 14px; line-height: 1.6; margin: 0 0 12px 0;">{{ $review->comment }}</p>
                        @endif
                        
                        <!-- Review Actions -->
                        @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc2626; font-size: 13px; font-weight: 600; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px; background: #fafaf9; border-radius: 12px; border: 1px solid #e7e7e5;">
                        <div style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;">📝</div>
                        <p style="font-size: 14px; font-weight: 600; color: #78716c; margin: 0;">Belum ada ulasan untuk produk ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="related-section">
                <h3 class="related-title">Produk Terkait</h3>
                <div class="related-products">
                    @php
                        // Get related products (same category or random)
                        $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
                            ->when($product->category, function($query) use ($product) {
                                $query->where('category', $product->category);
                            })
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();
                        
                        // If no related products found, get random products
                        if($relatedProducts->isEmpty()) {
                            $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
                                ->inRandomOrder()
                                ->limit(4)
                                ->get();
                        }
                    @endphp
                    
                    @forelse($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->id) }}" class="related-product-card" style="text-decoration: none; color: inherit;">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="related-product-image">
                        @else
                            <img src="https://dummyimage.com/140x140/f3f4f6/999&text={{ urlencode(substr($related->name, 0, 1)) }}" alt="{{ $related->name }}" class="related-product-image">
                        @endif
                        <div class="related-product-info">
                            <div class="related-product-name">{{ Str::limit($related->name, 40) }}</div>
                            <div class="related-product-price">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #78716c; font-size: 14px;">
                        Tidak ada produk terkait
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Actions -->
        <div class="bottom-actions">
            <button class="add-to-cart-btn" id="addToCartBtn" onclick="handleAddToCart(event)">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span style="position: absolute; top: 8px; right: 8px; background: #ff9500; color: #fff; border-radius: 50%; width: 16px; height: 16px; display: none; align-items: center; justify-content: center; font-size: 10px; font-weight: 700;" id="cartBadgeBtn">0</span>
            </button>
            <a href="{{ route('checkout.create', ['product_id' => $product->id]) }}" class="order-btn" onclick="event.preventDefault(); if(!isAuthenticated) { showLoginModal(); } else { window.location.href = this.href; }" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                Buat Pesanan
            </a>
        </div>
    </div>

    <!-- Include Auth Check Component -->
    @include('components.auth-check')

    <script>
        let cartCount = parseInt(localStorage.getItem('cartCount') || '0');
        const cartBadge = document.getElementById('cartBadge');
        const cartBadgeBtn = document.getElementById('cartBadgeBtn');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const likeBtn = document.getElementById('likeBtn');
        const bookmarkBtn = document.getElementById('bookmarkBtn');
        const shareBtn = document.getElementById('shareBtn');
        const moreBtn = document.getElementById('moreBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Initialize cart count
        updateCartBadge();
        
        // Toggle Dropdown Menu
        if (moreBtn && dropdownMenu) {
            moreBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!moreBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        function updateCartBadge() {
            cartBadge.textContent = cartCount;
            cartBadgeBtn.textContent = cartCount;
            if (cartCount > 0) {
                cartBadgeBtn.style.display = 'flex';
            }
        }

        // Handle Add to Cart (check authentication first)
        function handleAddToCart(event) {
            if (!isAuthenticated) {
                event.preventDefault();
                showLoginModal();
                return false;
            }
            // Continue with normal add to cart
            return true;
        }

        // Add to Cart with Flying Animation + Save to localStorage
        addToCartBtn.addEventListener('click', function(e) {
            // Auth check is done via onclick handler
            
            // Get product data
            const productData = {
                id: {{ $product->id }},
                name: '{{ addslashes($product->name) }}',
                price: {{ $product->price }},
                image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}',
                quantity: 1
            };

            // Get existing cart items
            let cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
            
            // Check if product already exists
            const existingIndex = cartItems.findIndex(item => item.id === productData.id);
            
            if (existingIndex > -1) {
                // Increment quantity
                cartItems[existingIndex].quantity++;
            } else {
                // Add new item
                cartItems.push(productData);
            }
            
            // Save to localStorage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            
            // Update cart count
            cartCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cartCount', cartCount);
            updateCartBadge();

            // Dispatch event untuk update floating cart
            window.dispatchEvent(new CustomEvent('cartUpdated'));
            
            // Flying animation
            const btnRect = addToCartBtn.getBoundingClientRect();
            const cartRect = cartBadge.getBoundingClientRect();
            
            const dot = document.createElement('div');
            dot.className = 'flying-dot';
            dot.style.left = btnRect.left + btnRect.width / 2 + 'px';
            dot.style.top = btnRect.top + btnRect.height / 2 + 'px';
            
            document.body.appendChild(dot);

            // Calculate translation
            const tx = cartRect.left + cartRect.width / 2 - (btnRect.left + btnRect.width / 2);
            const ty = cartRect.top + cartRect.height / 2 - (btnRect.top + btnRect.height / 2);

            dot.style.setProperty('--tx', tx + 'px');
            dot.style.setProperty('--ty', ty + 'px');

            // Start animation
            setTimeout(() => {
                dot.style.animation = 'flyToCart 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards';
            }, 10);

            // Remove dot after animation
            setTimeout(() => {
                dot.remove();
                // Scale animation on cart badge
                cartBadge.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    cartBadge.style.transform = 'scale(1)';
                }, 200);
            }, 800);

            // Button feedback
            addToCartBtn.style.background = '#f3f4f6';
            setTimeout(() => {
                addToCartBtn.style.background = '#fff';
            }, 200);
        });

        // Like Button - Connected to Wishlist
        likeBtn.addEventListener('click', function() {
            // Check if user is authenticated
            if (!isAuthenticated) {
                showLoginModal();
                return;
            }
            
            const productId = this.getAttribute('data-product-id');
            const liked = this.getAttribute('data-liked') === 'true';
            const svg = this.querySelector('svg');
            const btn = this;
            
            // Optimistic UI update
            if (liked) {
                svg.setAttribute('fill', 'none');
                btn.setAttribute('data-liked', 'false');
            } else {
                svg.setAttribute('fill', '#ff1493');
                btn.setAttribute('data-liked', 'true');
                
                // Heart animation
                btn.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 200);
            }
            
            // Send to server
            fetch('{{ route("wishlist.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI based on server response
                    btn.setAttribute('data-liked', data.liked ? 'true' : 'false');
                    if (data.liked) {
                        svg.setAttribute('fill', '#ff1493');
                    } else {
                        svg.setAttribute('fill', 'none');
                    }
                    
                    // Show toast notification
                    showToast(data.message, data.liked ? 'success' : 'info');
                } else {
                    // Revert on error
                    btn.setAttribute('data-liked', liked ? 'true' : 'false');
                    if (liked) {
                        svg.setAttribute('fill', '#ff1493');
                    } else {
                        svg.setAttribute('fill', 'none');
                    }
                    showToast('Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert on error
                btn.setAttribute('data-liked', liked ? 'true' : 'false');
                if (liked) {
                    svg.setAttribute('fill', '#ff1493');
                } else {
                    svg.setAttribute('fill', 'none');
                }
                showToast('Terjadi kesalahan', 'error');
            });
        });
        
        // Check if product is already in wishlist on load
        if (isAuthenticated) {
            const productId = likeBtn.getAttribute('data-product-id');
            fetch(`/wishlist/check/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.liked) {
                        likeBtn.setAttribute('data-liked', 'true');
                        likeBtn.querySelector('svg').setAttribute('fill', '#ff1493');
                    }
                })
                .catch(error => console.error('Error checking wishlist:', error));
        }
        
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 80px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #6366f1, #4f46e5)'};
                color: white;
                padding: 14px 24px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.2);
                z-index: 100000;
                font-size: 15px;
                font-weight: 600;
                animation: slideUp 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideDown 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        // Bookmark Button (if exists)
        if (bookmarkBtn) {
            bookmarkBtn.addEventListener('click', function() {
                const saved = this.getAttribute('data-saved') === 'true';
                const svg = this.querySelector('svg');
                
                if (saved) {
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('stroke', '#6b7280');
                    this.setAttribute('data-saved', 'false');
                    this.style.background = 'transparent';
                } else {
                    svg.setAttribute('fill', '#fbbf24');
                    svg.setAttribute('stroke', '#fbbf24');
                    this.setAttribute('data-saved', 'true');
                    this.style.background = '#fef3c7';
                    
                    // Scale animation
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        }

        // Share Button
        shareBtn.addEventListener('click', function() {
            document.getElementById('shareModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Tabs Functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding content
                document.getElementById(`tab-${targetTab}`).classList.add('active');
                
                // Smooth scroll to tabs section
                setTimeout(() => {
                    this.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            });
        });

        // Close Share Modal
        document.getElementById('closeShareModal').addEventListener('click', closeShareModal);
        document.getElementById('shareModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeShareModal();
            }
        });

        function closeShareModal() {
            document.getElementById('shareModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Share Via Functions
        function shareVia(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $product->name }}');
            const text = encodeURIComponent('Check out this amazing product: {{ $product->name }} - Rp {{ number_format($product->price, 0, ",", ".") }}');
            
            let shareUrl = '';
            
            switch(platform) {
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${text}%0A${url}`;
                    break;
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
                    break;
                case 'telegram':
                    shareUrl = `https://t.me/share/url?url=${url}&text=${text}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${title}&body=${text}%0A${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'messenger':
                    shareUrl = `fb-messenger://share/?link=${url}`;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
                showToast(`Sharing via ${platform.charAt(0).toUpperCase() + platform.slice(1)}`);
            }
        }

        // Copy Link Function
        function copyLink() {
            const linkInput = document.getElementById('productLink');
            const copyBtn = document.getElementById('copyLinkBtn');
            
            linkInput.select();
            linkInput.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(linkInput.value).then(() => {
                copyBtn.textContent = 'Copied!';
                copyBtn.classList.add('copied');
                showToast('Link copied to clipboard!');
                
                setTimeout(() => {
                    copyBtn.textContent = 'Copy';
                    copyBtn.classList.remove('copied');
                }, 2000);
            });
        }

        // Toast Notification Function - Enhanced
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            
            // Set icon based on type
            let icon = '';
            let bgColor = '';
            
            if (type === 'success') {
                icon = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="margin-right: 10px; flex-shrink: 0;">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>`;
                bgColor = '#10b981'; // Green
            } else if (type === 'error') {
                icon = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="margin-right: 10px; flex-shrink: 0;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>`;
                bgColor = '#ef4444'; // Red
            }
            
            toast.innerHTML = icon + '<span>' + message + '</span>';
            toast.style.background = bgColor;
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }

        // Carousel dots (simple interaction)
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                dots.forEach(d => d.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Report Modal Functions
        function openReportModal() {
            const reportModalOverlay = document.getElementById('reportModalOverlay');
            const dropdown = document.getElementById('dropdownMenu');
            
            if (reportModalOverlay) {
                reportModalOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            if (dropdown) {
                dropdown.classList.remove('show');
            }
            
            // Initialize reason selection after modal opens
            setTimeout(function() {
                initReportReasonSelection();
            }, 100);
        }

        function closeReportModal() {
            const reportModalOverlay = document.getElementById('reportModalOverlay');
            
            if (reportModalOverlay) {
                reportModalOverlay.classList.remove('active');
            }
            
            document.body.style.overflow = '';
            
            // Reset form
            const reasonItems = document.querySelectorAll('.report-reason-item');
            reasonItems.forEach(item => item.classList.remove('selected'));
            
            const selectedReasonInput = document.getElementById('selectedReason');
            const reportDescription = document.getElementById('reportDescription');
            const reportSubmitBtn = document.getElementById('reportSubmitBtn');
            
            if (selectedReasonInput) selectedReasonInput.value = '';
            if (reportDescription) reportDescription.value = '';
            if (reportSubmitBtn) reportSubmitBtn.disabled = true;
        }

        // Close modal when clicking close button
        const closeReportModalBtn = document.getElementById('closeReportModal');
        if (closeReportModalBtn) {
            closeReportModalBtn.addEventListener('click', closeReportModal);
        }

        // Close modal when clicking overlay
        const reportModalOverlay = document.getElementById('reportModalOverlay');
        if (reportModalOverlay) {
            reportModalOverlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeReportModal();
                }
            });
        }

        // Initialize report reason selection
        function initReportReasonSelection() {
            const reasonItems = document.querySelectorAll('.report-reason-item');
            const submitBtn = document.getElementById('reportSubmitBtn');
            const selectedReasonInput = document.getElementById('selectedReason');

            if (!reasonItems.length || !submitBtn || !selectedReasonInput) {
                console.log('Report elements not found');
                return;
            }

            reasonItems.forEach(item => {
                // Remove existing listeners
                const newItem = item.cloneNode(true);
                item.parentNode.replaceChild(newItem, item);
            });

            // Re-query after cloning
            const newReasonItems = document.querySelectorAll('.report-reason-item');
            
            newReasonItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    console.log('Reason clicked:', this.getAttribute('data-reason'));
                    
                    // Remove selected from all
                    newReasonItems.forEach(r => r.classList.remove('selected'));
                    
                    // Add selected to clicked item
                    this.classList.add('selected');
                    
                    // Set hidden input value
                    const reason = this.getAttribute('data-reason');
                    selectedReasonInput.value = reason;
                    
                    // Enable submit button
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                    
                    console.log('Selected reason:', reason);
                });
            });
        }

        // Call init on page load
        setTimeout(initReportReasonSelection, 100);

        // Report form submission
        const reportForm = document.getElementById('reportForm');
        if (reportForm) {
            reportForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = document.getElementById('reportSubmitBtn');
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; display: inline-block; margin-right: 8px;">
                        <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                        <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                    </svg>
                    Mengirim Laporan...
                `;
                submitButton.style.opacity = '0.7';
                
                // Simulate minimum loading time for better UX
                const minLoadingTime = new Promise(resolve => setTimeout(resolve, 1000));
                
                Promise.all([
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                        }
                    }),
                    minLoadingTime
                ])
                .then(([response]) => response.json())
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.success) {
                        // Close modal first
                        closeReportModal();
                        
                        // Show success notification after modal closed
                        setTimeout(() => {
                            console.log('Calling showToast...');
                            const toast = document.getElementById('toastNotification');
                            
                            if (toast) {
                                // Direct toast implementation as fallback
                                const icon = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="margin-right: 10px; flex-shrink: 0;">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>`;
                                
                                toast.innerHTML = icon + '<span>Terima kasih! Laporan Anda telah kami terima dan sedang ditinjau oleh tim kami.</span>';
                                toast.style.background = '#10b981';
                                toast.style.display = 'flex';
                                toast.style.alignItems = 'center';
                                toast.classList.add('show');
                                
                                setTimeout(() => {
                                    toast.classList.remove('show');
                                }, 4000);
                            } else {
                                console.error('Toast element not found!');
                            }
                        }, 300);
                    } else {
                        alert('Gagal mengirim laporan. Silakan coba lagi.');
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Kirim Laporan';
                        submitButton.style.opacity = '1';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Kirim Laporan';
                    submitButton.style.opacity = '1';
                });
            });
        }
    </script>

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

    {{-- Include Floating Cart Component --}}
    @include('components.cart-floating')

    {{-- Share Modal - TikTok Shop Style --}}
    <div class="share-modal-overlay" id="shareModalOverlay">
        <div class="share-modal">
            <div class="share-modal-header">
                <h3 class="share-modal-title">Share Product</h3>
                <button class="share-modal-close" id="closeShareModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="share-product-card">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}" class="share-product-image">
                <div class="share-product-info">
                    <div class="share-product-name">{{ $product->name }}</div>
                    <div class="share-product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="share-product-stock">Stock: {{ $product->stock }}</div>
                </div>
            </div>

            <div class="share-options">
                <div class="share-options-title">Share Via</div>
                <div class="share-buttons-grid">
                    <button class="share-button" onclick="shareVia('whatsapp')">
                        <div class="share-button-icon whatsapp-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">WhatsApp</span>
                    </button>

                    <button class="share-button" onclick="shareVia('facebook')">
                        <div class="share-button-icon facebook-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Facebook</span>
                    </button>

                    <button class="share-button" onclick="shareVia('twitter')">
                        <div class="share-button-icon twitter-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Twitter</span>
                    </button>

                    <button class="share-button" onclick="shareVia('telegram')">
                        <div class="share-button-icon telegram-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Telegram</span>
                    </button>

                    <button class="share-button" onclick="shareVia('email')">
                        <div class="share-button-icon email-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Email</span>
                    </button>

                    <button class="share-button" onclick="shareVia('linkedin')">
                        <div class="share-button-icon linkedin-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">LinkedIn</span>
                    </button>

                    <button class="share-button" onclick="shareVia('messenger')">
                        <div class="share-button-icon messenger-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M12 0C5.373 0 0 4.975 0 11.111c0 3.498 1.744 6.614 4.469 8.654V24l4.088-2.242c1.092.3 2.246.464 3.443.464 6.627 0 12-4.974 12-11.11C24 4.975 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.963 3.26L10.732 8l3.131 3.259L19.752 8l-6.561 6.963z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Messenger</span>
                    </button>

                    <button class="share-button" onclick="copyLink()">
                        <div class="share-button-icon copy-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                        </div>
                        <span class="share-button-label">Copy Link</span>
                    </button>
                </div>

                <div class="share-link-section">
                    <div class="share-link-label">Product Link</div>
                    <div class="share-link-input-wrapper">
                        <input type="text" class="share-link-input" id="productLink" value="{{ url()->current() }}" readonly>
                        <button class="share-copy-btn" id="copyLinkBtn" onclick="copyLink()">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Modal - TikTok/Shopee Style --}}
    <div class="report-modal-overlay" id="reportModalOverlay">
        <div class="report-modal">
            <div class="report-modal-header">
                <h3 class="report-modal-title">Laporkan Produk</h3>
                <p class="report-modal-subtitle">Bantu kami menjaga keamanan marketplace</p>
                <button class="report-modal-close" id="closeReportModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="reportForm" action="{{ route('reports.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="reason" id="selectedReason">
                
                <div class="report-reasons">
                    <div class="report-reason-item" data-reason="fake">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Produk Palsu/Tiruan</div>
                            <div class="report-reason-desc">Produk ini adalah barang palsu atau replika ilegal</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="scam">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Penipuan</div>
                            <div class="report-reason-desc">Harga tidak wajar atau tanda-tanda penipuan</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="inappropriate">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Konten Tidak Pantas</div>
                            <div class="report-reason-desc">Gambar atau deskripsi mengandung konten tidak pantas</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="prohibited">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Barang Terlarang</div>
                            <div class="report-reason-desc">Produk yang dilarang untuk diperjualbelikan</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="misleading">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Informasi Menyesatkan</div>
                            <div class="report-reason-desc">Deskripsi tidak sesuai dengan produk sebenarnya</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="copyright">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Pelanggaran Hak Cipta</div>
                            <div class="report-reason-desc">Menggunakan gambar/merek tanpa izin</div>
                        </div>
                    </div>

                    <div class="report-reason-item" data-reason="other">
                        <div class="report-reason-radio"></div>
                        <div class="report-reason-content">
                            <div class="report-reason-title">Lainnya</div>
                            <div class="report-reason-desc">Alasan lain yang ingin dilaporkan</div>
                        </div>
                    </div>
                </div>

                <div class="report-textarea-wrapper">
                    <label class="report-textarea-label" for="reportDescription">Detail Laporan (Opsional)</label>
                    <textarea 
                        class="report-textarea" 
                        id="reportDescription" 
                        name="description" 
                        placeholder="Jelaskan lebih detail tentang masalah yang Anda temukan..."
                        maxlength="500"
                    ></textarea>
                </div>

                <div class="report-modal-footer">
                    <button type="button" class="report-cancel-btn" onclick="closeReportModal()">Batal</button>
                    <button type="submit" class="report-submit-btn" id="reportSubmitBtn" disabled>Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div class="toast-notification" id="toastNotification"></div>

    <script>
        // Star Rating System
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                document.getElementById('ratingInput').value = rating;
                
                // Update stars visual
                document.querySelectorAll('.star').forEach((s, index) => {
                    s.style.color = (index < rating) ? '#fbbf24' : '#e5e7eb';
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                document.querySelectorAll('.star').forEach((s, index) => {
                    s.style.color = (index < rating) ? '#fbbf24' : '#e5e7eb';
                });
            });
        });

        document.querySelector('.star-rating')?.addEventListener('mouseleave', function() {
            const currentRating = document.getElementById('ratingInput').value;
            document.querySelectorAll('.star').forEach((s, index) => {
                s.style.color = (index < currentRating) ? '#fbbf24' : '#e5e7eb';
            });
        });
    </script>
</body>
</html>
