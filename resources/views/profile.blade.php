<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - {{ config('app.name') }}</title>
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
            color: #333;
            padding-bottom: 60px;
        }

        /* Header Shopee Style */
        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 500;
        }

        .header-right {
            display: flex;
            gap: 20px;
        }

        .header-icon {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #fff;
            color: #ff6b35;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            padding: 0 16px 16px 16px;
            color: white;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            color: #ff6b35;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 600;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.5);
            cursor: pointer;
            position: relative;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 8px;
            padding: 2px;
            text-align: center;
        }

        .profile-details {
            flex: 1;
        }

        .profile-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(255,215,0,0.3);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            border: 1px solid rgba(255,215,0,0.5);
        }

        .profile-stats {
            display: flex;
            gap: 16px;
            font-size: 13px;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* VIP Banner */
        .vip-banner {
            background: linear-gradient(90deg, #ffd700 0%, #ffed4e 100%);
            margin: 8px 16px;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(255,215,0,0.3);
        }

        .vip-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vip-icon {
            font-size: 24px;
        }

        .vip-text {
            flex: 1;
        }

        .vip-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .vip-subtitle {
            font-size: 11px;
            color: #666;
        }

        .vip-arrow {
            color: #666;
        }

        /* Update Username Banner */
        .update-banner {
            background: white;
            margin: 8px 16px;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #f0f0f0;
        }

        .update-icon {
            color: #ff6b35;
            font-size: 20px;
        }

        .update-text {
            flex: 1;
            font-size: 13px;
            color: #333;
        }

        .update-link {
            color: #1e90ff;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }

        .close-btn {
            color: #999;
            font-size: 16px;
            cursor: pointer;
        }

        /* Section */
        .section {
            background: white;
            margin: 8px 16px;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .section-link {
            font-size: 12px;
            color: #ff6b35;
            text-decoration: none;
        }

        /* Order Grid */
        .order-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding: 12px 0;
        }

        .order-item {
            text-align: center;
            padding: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            position: relative;
        }

        .order-icon {
            font-size: 28px;
            color: #ff6b35;
            margin-bottom: 6px;
        }

        .order-label {
            font-size: 11px;
            color: #666;
        }

        .order-badge {
            position: absolute;
            top: 4px;
            right: 20px;
            background: #ff6b35;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: 600;
        }

        /* Wallet Grid */
        .wallet-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding: 12px 0;
        }

        .wallet-item {
            text-align: center;
            padding: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            position: relative;
        }

        .wallet-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            border-radius: 8px;
        }

        .wallet-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 2px;
        }

        .wallet-amount {
            font-size: 10px;
            color: #ff6b35;
            font-weight: 600;
        }

        .wallet-badge {
            position: absolute;
            top: 4px;
            right: 20px;
            background: #ff0000;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: 600;
        }

        /* Finance Grid */
        .finance-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 12px 0;
        }

        .finance-item {
            text-align: center;
            padding: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .finance-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border-radius: 8px;
        }

        .finance-label {
            font-size: 11px;
            color: #666;
        }

        .finance-new {
            background: #ff0000;
            color: white;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 4px;
            font-weight: 600;
        }

        /* Menu List */
        .menu-list {
            padding: 0;
        }

        .menu-item {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 18px;
            color: #666;
        }

        .menu-content {
            flex: 1;
        }

        .menu-title {
            font-size: 13px;
            color: #333;
        }

        .menu-arrow {
            color: #ccc;
            font-size: 14px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .nav-item {
            padding: 8px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            color: #999;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            position: relative;
        }

        .nav-item.active {
            color: #ff6b35;
        }

        .nav-icon {
            font-size: 22px;
        }

        .nav-label {
            font-size: 10px;
        }

        .nav-badge {
            position: absolute;
            top: 2px;
            right: 20px;
            background: #ff0000;
            color: white;
            border-radius: 10px;
            padding: 2px 5px;
            font-size: 9px;
            font-weight: 600;
            min-width: 16px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: flex-end;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 20px 20px 0 0;
            padding: 24px;
            max-height: 85vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b35;
        }

        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-height: 80px;
            resize: vertical;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #ff6b35;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary:active {
            background: #ff5722;
        }

        .avatar-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            font-weight: 600;
            overflow: hidden;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-upload {
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        /* Toast */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 2000;
            display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .toast.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <i class="fas fa-store"></i>
            Mulai Jual
        </div>
        <div class="header-right">
            <button class="header-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                <i class="fas fa-cog"></i>
            </button>
            <button class="header-icon" onclick="window.location.href='{{ route('cart.index') }}'">
            <button class="header-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                <i class="fas fa-shopping-cart"></i>
                @if(auth()->user()->carts && auth()->user()->carts->count() > 0)
                <span class="badge">{{ auth()->user()->carts->count() }}</span>
                @endif
            </button>
            <button class="header-icon" onclick="window.location.href='{{ route('chat.index') }}'">
                <i class="fas fa-comment-dots"></i>
            </button>
            <button class="header-icon" onclick="showSettings()">
                <i class="fas fa-cog"></i>
            </button>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-info">
            <div class="profile-avatar" onclick="openModal('editModal')">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email, 0, 1)) }}
                @endif
                <div class="avatar-edit">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="profile-details">
                <div class="profile-name">
                    {{ auth()->user()->name ?? explode('@', auth()->user()->email)[0] }}
                    <span class="profile-badge">
                        <i class="fas fa-crown" style="color: gold;"></i> Gold
                    </span>
                </div>
                <div class="profile-stats">
                    <div class="stat">
                        <i class="fas fa-user-friends"></i>
                        <span>{{ auth()->user()->orders ? auth()->user()->orders->count() : 0 }} Pengikut</span>
                    </div>
                    <div class="stat">
                        <i class="fas fa-heart"></i>
                        <span>{{ auth()->user()->wishlists ? auth()->user()->wishlists->count() : 0 }} Mengikuti</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIP Banner -->
    <div class="vip-banner">
        <div class="vip-content">
            <div class="vip-icon">👑</div>
            <div class="vip-text">
                <div class="vip-title">Dapatkan Extra Diskon 20% Setiap Hari</div>
                <div class="vip-subtitle">Upgrade ke VIP sekarang</div>
            </div>
        </div>
        <i class="fas fa-chevron-right vip-arrow"></i>
    </div>

    <!-- Update Username Banner -->
    @if(!auth()->user()->phone || !auth()->user()->address)
    <div class="update-banner" id="updateBanner">
        <i class="fas fa-user-edit update-icon"></i>
        <div class="update-text">Update your username.</div>
        <a href="#" onclick="event.preventDefault(); openModal('editModal')" class="update-link">Update Now</a>
        <i class="fas fa-times close-btn" onclick="document.getElementById('updateBanner').style.display='none'"></i>
    </div>
    @endif

    <!-- Pesanan Saya -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Pesanan Saya</div>
            <a href="{{ route('orders.index') }}" class="section-link">Lihat Riwayat Pesanan <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="order-grid">
            <a href="{{ route('orders.index') }}?status=pending" class="order-item">
                <div class="order-icon">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="order-label">Belum Bayar</div>
                @php
                    $pendingCount = auth()->user()->orders ? auth()->user()->orders->where('status', 'pending')->count() : 0;
                @endphp
                @if($pendingCount > 0)
                <span class="order-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index') }}?status=processing" class="order-item">
                <div class="order-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="order-label">Dikemas</div>
                @php
                    $processingCount = auth()->user()->orders ? auth()->user()->orders->where('status', 'processing')->count() : 0;
                @endphp
                @if($processingCount > 0)
                <span class="order-badge">{{ $processingCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index') }}?status=shipped" class="order-item">
                <div class="order-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="order-label">Dikirim</div>
                @php
                    $shippedCount = auth()->user()->orders ? auth()->user()->orders->where('status', 'shipped')->count() : 0;
                @endphp
                @if($shippedCount > 0)
                <span class="order-badge">{{ $shippedCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.index') }}?status=completed" class="order-item">
                <div class="order-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="order-label">Beri Penilaian</div>
                @php
                    $reviewCount = auth()->user()->reviews ? auth()->user()->reviews->count() : 0;
                @endphp
                @if($reviewCount > 0)
                <span class="order-badge">{{ $reviewCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Pulsa, Tagihan & Tiket -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-mobile-alt" style="color: #ff6b35;"></i>
                Pulsa, Tagihan & Tiket
            </div>
            <span class="section-link" style="background: #ff6b35; color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;">Diskon Pengguna Baru 38%</span>
        </div>
    </div>

    <!-- ShopeeFood -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-utensils" style="color: #ff6b35;"></i>
                ShopeeFood
            </div>
            <span class="section-link">Gratis Ongkir <i class="fas fa-chevron-right"></i></span>
        </div>
    </div>

    <!-- Dompet Saya -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Dompet Saya</div>
        </div>
        <div class="wallet-grid">
            <a href="#" class="wallet-item">
                <div class="wallet-icon" style="background: #e3f2fd; color: #1976d2;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="wallet-label">ShopeePay</div>
                <div class="wallet-amount">Rp68</div>
            </a>
            <a href="#" class="wallet-item">
                <div class="wallet-icon" style="background: #fff3e0; color: #f57c00;">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="wallet-label">Koin Shopee</div>
                <div class="wallet-amount">Gratis 25RB!</div>
                <span class="wallet-badge">1</span>
            </a>
            <a href="#" class="wallet-item">
                <div class="wallet-icon" style="background: #fce4ec; color: #c2185b;">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="wallet-label">Voucher Saya</div>
                <div class="wallet-amount">50+ Voucher</div>
                <span class="wallet-badge">1</span>
            </a>
            <a href="#" class="wallet-item">
                <div class="wallet-icon" style="background: #e8f5e9; color: #388e3c;">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="wallet-label">App ShopeePay</div>
                <div class="wallet-amount">Klaim 50.000</div>
                <span class="wallet-badge" style="background: #ff0000;">Baru</span>
            </a>
        </div>
    </div>

    <!-- Keuangan -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Keuangan</div>
            <a href="#" class="section-link">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="finance-grid">
            <a href="#" class="finance-item">
                <div class="finance-icon" style="background: #e3f2fd; color: #1976d2;">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="finance-label">SPayLater</div>
                <div style="font-size: 9px; color: #ff6b35;">Cicilan Pasti 0% + Bonus 500RB</div>
            </a>
            <a href="#" class="finance-item">
                <div class="finance-icon" style="background: #fff3e0; color: #f57c00;">
                    <i class="fas fa-percent"></i>
                </div>
                <div class="finance-label">SPinjam</div>
                <div style="font-size: 9px; color: #ff6b35;">Hingga 100JT
                    <span class="finance-new">Baru</span>
                </div>
            </a>
            <a href="#" class="finance-item">
                <div class="finance-icon" style="background: #e3f2fd; color: #1565c0;">
                    <i class="fas fa-university"></i>
                </div>
                <div class="finance-label">SeaBank</div>
                <div style="font-size: 9px; color: #ff6b35;">Gratis Transfer Antar Bank</div>
            </a>
        </div>
    </div>

    <!-- Asuransi -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-shield-alt" style="color: #ff6b35;"></i>
                Asuransi
            </div>
            <i class="fas fa-chevron-right" style="color: #ccc;"></i>
        </div>
    </div>

    <!-- Aktivitas Saya -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Aktivitas Saya</div>
            <a href="#" class="section-link">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="menu-list">
            <a href="{{ route('wishlist.index') }}" class="menu-item">
                <i class="fas fa-heart menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Produk Yang Disukai</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="{{ route('orders.index') }}" class="menu-item">
                <i class="fas fa-eye menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Terakhir Dilihat</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="{{ route('reviews.index') }}" class="menu-item">
                <i class="fas fa-star menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Ulasan Saya</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </div>
    </div>

    <!-- Pengaturan Akun -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Pengaturan Akun</div>
        </div>
        <div class="menu-list">
            <a href="#" onclick="event.preventDefault(); openModal('editModal')" class="menu-item">
                <i class="fas fa-user-edit menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Akun Saya</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-map-marker-alt menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Alamat Saya</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-credit-card menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Rekening Bank & Kartu</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-bell menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Notifikasi</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-lock menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Pengaturan Privasi</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-question-circle menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Pusat Bantuan</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit()" class="menu-item">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <div class="menu-content">
                    <div class="menu-title">Keluar</div>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </div>
    </div>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item">
            <i class="fas fa-home nav-icon"></i>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-fire nav-icon"></i>
            <span class="nav-label">Trending</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-play-circle nav-icon"></i>
            <span class="nav-label">Live & Video</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-bell nav-icon"></i>
            <span class="nav-label">Notifikasi</span>
            @php
                $totalNotif = (auth()->user()->orders ? auth()->user()->orders->where('status', 'pending')->count() : 0) + 
                              (auth()->user()->orders ? auth()->user()->orders->where('status', 'shipped')->count() : 0);
            @endphp
            @if($totalNotif > 0)
            <span class="nav-badge">{{ $totalNotif }}</span>
            @endif
        </a>
        <a href="{{ route('profile') }}" class="nav-item active">
            <i class="fas fa-user nav-icon"></i>
            <span class="nav-label">Saya</span>
        </a>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Profile</h3>
                <button class="modal-close" onclick="closeModal('editModal')">&times;</button>
            </div>
            
            <form id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="avatar-upload">
                    <div class="avatar-preview" id="avatarPreview">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email, 0, 1)) }}
                        @endif
                    </div>
                    <input type="file" id="profilePicture" name="profile_picture" accept="image/*" style="display:none" onchange="previewImage(this)">
                    <button type="button" class="btn-upload" onclick="document.getElementById('profilePicture').click()">
                        <i class="fas fa-camera"></i> Change Photo
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" value="{{ auth()->user()->name ?? explode('@', auth()->user()->email)[0] }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ auth()->user()->email }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" class="form-input" value="{{ auth()->user()->phone }}" placeholder="+62">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="address" class="form-textarea" placeholder="Masukkan alamat lengkap">{{ auth()->user()->address }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea" placeholder="Ceritakan tentang diri Anda">{{ auth()->user()->bio }}</textarea>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Handle Edit Form Submit
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ route("profile.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Profile berhasil diperbarui!');
                    closeModal('editModal');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Gagal memperbarui profile');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.');
            }
        });

        // Close modal on backdrop click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Show Settings Function
        function showSettings() {
            window.location.href = '{{ route("settings") }}';
        }
    </script>
</body>
</html>
