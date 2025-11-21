<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Project Wahab</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fafaf9;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Clean Header */
        .header {
            background: white;
            border-radius: 16px;
            padding: 24px 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #f0f0f0;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 12px;
        }

        .back-btn {
            width: 44px;
            height: 44px;
            background: #f5f5f4;
            border: 1px solid #e7e7e5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #44403c;
        }

        .back-btn:hover {
            background: #e7e7e5;
            transform: translateX(-3px);
        }

        h1 {
            color: #1c1917;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .subtitle {
            color: #78716c;
            font-size: 15px;
            font-weight: 500;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .stat-label {
            color: #78716c;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .stat-value {
            color: #1c1917;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Orders Grid */
        .orders-grid {
            display: grid;
            gap: 16px;
        }

        .order-card {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 24px;
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .order-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            border-color: #e7e7e5;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f5f5f4;
        }

        .order-number {
            color: #1c1917;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .order-date {
            color: #78716c;
            font-size: 13px;
            font-weight: 500;
        }

        .order-status {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .status-processing {
            background: #fef3c7;
            color: #92400e;
        }

        .status-shipped {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-body {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #f0f0f0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            color: #1c1917;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .product-meta {
            color: #78716c;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .product-price {
            color: #ea580c;
            font-size: 20px;
            font-weight: 700;
        }

        .order-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #f5f5f4;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #1c1917;
            color: white;
        }

        .btn-primary:hover {
            background: #292524;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f5f5f4;
            color: #44403c;
            border: 1px solid #e7e7e5;
        }

        .btn-secondary:hover {
            background: #e7e7e5;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 16px;
            padding: 60px 40px;
            text-align: center;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .empty-title {
            color: #1c1917;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .empty-text {
            color: #78716c;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            h1 {
                font-size: 26px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .order-body {
                flex-direction: column;
                align-items: flex-start;
            }

            .product-image {
                width: 100%;
                height: 180px;
            }

            .order-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-top">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1>Pesanan Saya</h1>
                    <p class="subtitle">Kelola dan lacak pesanan Anda</p>
                </div>
            </div>
        </div>

        @if($orders->count() > 0)
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">{{ $orders->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Dalam Proses</div>
                    <div class="stat-value">{{ $orders->where('status', 'processing')->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Terkirim</div>
                    <div class="stat-value">{{ $orders->where('status', 'delivered')->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Belanja</div>
                    <div class="stat-value">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Orders Grid -->
            <div class="orders-grid">
                @foreach($orders as $order)
                <div class="order-card" onclick="window.location.href='{{ route('orders.show', $order->id) }}'">
                    <div class="order-header">
                        <div>
                            <div class="order-number">{{ $order->ref_number }}</div>
                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="order-status status-{{ $order->status }}">
                            @if($order->status == 'processing')
                                Diproses
                            @elseif($order->status == 'shipped')
                                Dikirim
                            @elseif($order->status == 'delivered')
                                Terkirim
                            @else
                                {{ ucfirst($order->status) }}
                            @endif
                        </span>
                    </div>

                    <div class="order-body">
                        @if($order->product_image)
                        <img src="{{ asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}" class="product-image">
                        @endif
                        <div class="product-details">
                            <div class="product-name">{{ $order->product_name }}</div>
                            <div class="product-meta">
                                Jumlah: {{ $order->quantity }} • {{ $order->payment_method == 'credit_card' ? 'Kartu Kredit' : 'COD' }}
                            </div>
                            <div class="product-price">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary" onclick="event.stopPropagation()">
                            Lacak Pesanan
                        </a>
                        @if($order->status == 'delivered')
                            @php
                                $hasReviewed = $order->reviews()->where('user_id', auth()->id())->exists();
                            @endphp
                            @if($hasReviewed)
                                <button class="btn btn-secondary" style="opacity: 0.6; cursor: not-allowed;" disabled>
                                    ✓ Sudah Diulas
                                </button>
                            @else
                                <button class="btn btn-secondary" onclick="event.stopPropagation(); openReviewModal({{ $order->product_id }}, {{ $order->id }}, '{{ $order->product->name ?? 'Produk' }}')">
                                    Beri Ulasan
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2 class="empty-title">Belum Ada Pesanan</h2>
                <p class="empty-text">
                    Anda belum memiliki pesanan apapun.<br>
                    Mulai berbelanja dan temukan produk favorit Anda!
                </p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    {{-- Include Review Modal Component --}}
    @include('components.review-modal')
</body>
</html>
