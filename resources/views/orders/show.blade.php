<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - {{ $order->ref_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Clean Card */
        .card {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            gap: 20px;
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
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .order-ref {
            color: #78716c;
            font-size: 15px;
            font-weight: 600;
        }

        /* Main Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Map Container */
        .map-container {
            height: 450px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e7e7e5;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* Status Banner */
        .status-banner {
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #1c1917;
            border: 2px solid;
        }

        .status-processing {
            background: #fef3c7;
            border-color: #fde047;
            color: #92400e;
        }

        .status-shipped {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1e40af;
        }

        .status-delivered {
            background: #d1fae5;
            border-color: #86efac;
            color: #065f46;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e7e7e5;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }

        .timeline-icon {
            position: absolute;
            left: -27px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border: 2px solid #e7e7e5;
            background: white;
        }

        .timeline-icon.active {
            background: #1c1917;
            border-color: #1c1917;
            color: white;
            animation: pulse 2s ease-in-out infinite;
        }

        .timeline-icon.completed {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .timeline-content {
            background: #fafaf9;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
        }

        .timeline-title {
            color: #1c1917;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .timeline-desc {
            color: #78716c;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .timeline-time {
            color: #a8a29e;
            font-size: 12px;
            font-weight: 600;
        }

        /* Product Info */
        .product-info {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 20px;
            background: #fafaf9;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .product-image {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e7e7e5;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            color: #1c1917;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-price {
            color: #ea580c;
            font-size: 24px;
            font-weight: 700;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #fafaf9;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
        }

        .info-label {
            color: #78716c;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .info-value {
            color: #1c1917;
            font-size: 15px;
            font-weight: 600;
        }

        /* Delivery Info */
        .delivery-info {
            background: #fafaf9;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
        }

        .delivery-title {
            color: #1c1917;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .delivery-address {
            color: #44403c;
            font-size: 14px;
            line-height: 1.7;
        }

        .section-title {
            color: #1c1917;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 24px;
            letter-spacing: -0.01em;
        }

        @media (max-width: 1024px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            h1 {
                font-size: 22px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .map-container {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="card">
            <div class="header">
                <a href="{{ route('orders.index') }}" class="back-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1>📦 Lacak Pesanan</h1>
                    <p class="order-ref">{{ $order->ref_number }}</p>
                </div>
            </div>
        </div>

        <!-- Status Banner -->
        <div class="card">
            <div class="status-banner status-{{ $order->status }}">
                @if($order->tracking_status)
                    {{ $order->tracking_status }}
                @elseif($order->status == 'processing')
                    ⏳ Pesanan Anda sedang diproses
                @elseif($order->status == 'shipped')
                    🚚 Pesanan Anda dalam pengiriman!
                @elseif($order->status == 'delivered')
                    ✅ Pesanan berhasil diterima!
                @else
                    📦 {{ ucfirst($order->status) }}
                @endif
            </div>
            
            @if($order->tracking_notes)
            <div style="margin-top: 12px; padding: 16px; background: #f5f5f4; border-radius: 12px; border: 1px solid #e7e7e5;">
                <p style="color: #78716c; font-size: 12px; font-weight: 600; margin-bottom: 6px;">📝 INFORMASI PENGIRIMAN:</p>
                <p style="color: #44403c; font-size: 14px; line-height: 1.6;">{{ $order->tracking_notes }}</p>
                @if($order->status_updated_at)
                <p style="color: #a8a29e; font-size: 12px; margin-top: 8px;">Diupdate: {{ $order->status_updated_at->diffForHumans() }}</p>
                @endif
            </div>
            @endif
        </div>

        <!-- Main Grid -->
        <div class="main-grid">
            <!-- Left Column - Map & Product -->
            <div>
                <!-- Interactive Map -->
                <div class="card">
                    <div class="map-container">
                        <div id="map"></div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="card">
                    <div class="product-info">
                        @if($order->product_image)
                        <img src="{{ asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}" class="product-image">
                        @endif
                        <div class="product-details">
                            <div class="product-name">{{ $order->product_name }}</div>
                            <div style="color: #78716c; font-size: 14px; margin-bottom: 8px;">
                                Jumlah: {{ $order->quantity }}
                            </div>
                            <div class="product-price">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Tanggal Order</div>
                            <div class="info-value">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pembayaran</div>
                            <div class="info-value">{{ $order->payment_method == 'credit_card' ? 'Kartu Kredit' : 'COD' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estimasi Tiba</div>
                            <div class="info-value">{{ $order->created_at->addDays(3)->format('d M Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @if($order->status == 'processing') Diproses
                                @elseif($order->status == 'shipped') Dikirim
                                @elseif($order->status == 'delivered') Terkirim
                                @else {{ ucfirst($order->status) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Timeline & Delivery -->
            <div>
                <!-- Tracking Timeline -->
                <div class="card">
                    <h2 class="section-title">🚀 Timeline Pengiriman</h2>
                    
                    <div class="timeline">
                        <!-- Order Placed -->
                        <div class="timeline-item">
                            <div class="timeline-icon completed">✓</div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pesanan Dibuat</div>
                                <div class="timeline-desc">Pesanan Anda telah diterima</div>
                                <div class="timeline-time">{{ $order->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        <!-- Processing -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                @if(in_array($order->status, ['processing', 'shipped', 'delivered'])) ✓ @else ⏳ @endif
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Sedang Diproses</div>
                                <div class="timeline-desc">Pesanan sedang disiapkan</div>
                                <div class="timeline-time">
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        {{ $order->created_at->addHours(2)->format('d M Y, H:i') }}
                                    @else
                                        Menunggu
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Shipped -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['shipped', 'delivered']) ? 'active' : '' }}">
                                @if(in_array($order->status, ['shipped', 'delivered'])) 🚚 @else 📦 @endif
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Dikirim</div>
                                <div class="timeline-desc">Paket dalam perjalanan ke Anda</div>
                                <div class="timeline-time">
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        {{ $order->created_at->addDay()->format('d M Y, H:i') }}
                                    @else
                                        Menunggu pengiriman
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Out for Delivery -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                @if($order->status == 'delivered') ✓ @else 🚛 @endif
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Dalam Pengiriman</div>
                                <div class="timeline-desc">Paket sedang dikirim ke alamat</div>
                                <div class="timeline-time">
                                    @if($order->status == 'delivered')
                                        {{ $order->created_at->addDays(2)->format('d M Y, H:i') }}
                                    @else
                                        Estimasi: {{ $order->created_at->addDays(2)->format('d M Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Delivered -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                @if($order->status == 'delivered') 🎉 @else 📍 @endif
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Diterima</div>
                                <div class="timeline-desc">Paket berhasil diterima</div>
                                <div class="timeline-time">
                                    @if($order->status == 'delivered')
                                        {{ $order->created_at->addDays(3)->format('d M Y, H:i') }}
                                    @else
                                        Estimasi: {{ $order->created_at->addDays(3)->format('d M Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="card">
                    <div class="delivery-info">
                        <div class="delivery-title">📍 Alamat Pengiriman</div>
                        <div class="delivery-address">
                            <strong>{{ $order->cardholder_name }}</strong><br>
                            {{ $order->address }}<br>
                            {{ $order->locality }}, {{ $order->city }}<br>
                            {{ $order->state }} - {{ $order->pincode }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Map with Leaflet
        const map = L.map('map').setView([-6.2088, 106.8456], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Warehouse location (default Jakarta)
        const warehouseLocation = [-6.2088, 106.8456];
        const warehouseMarker = L.marker(warehouseLocation, {
            icon: L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: #ea580c; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-size: 18px;">🏢</div>',
                iconSize: [36, 36]
            })
        }).addTo(map);
        warehouseMarker.bindPopup('<b>📦 Gudang</b><br>Project Wahab Store<br>Jakarta');

        // Order status from server
        const orderStatus = '{{ $order->status }}';

        // Geocode customer address using Nominatim API
        const customerAddress = '{{ $order->address }}, {{ $order->locality }}, {{ $order->city }}, {{ $order->state }}, {{ $order->pincode }}';
        const geocodeUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(customerAddress)}`;

        fetch(geocodeUrl, {
            headers: {
                'User-Agent': 'ProjectWahab/1.0'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const customerLat = parseFloat(data[0].lat);
                const customerLon = parseFloat(data[0].lon);
                const customerLocation = [customerLat, customerLon];

                // Add customer marker
                const customerMarker = L.marker(customerLocation, {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: '<div style="background: #10b981; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-size: 18px;">🏠</div>',
                        iconSize: [36, 36]
                    })
                }).addTo(map);
                customerMarker.bindPopup('<b>🏠 Alamat Pengiriman</b><br>{{ $order->cardholder_name }}<br>{{ $order->city }}, {{ $order->state }}');

                // Show delivery truck if order is shipped or delivered
                if (orderStatus === 'shipped' || orderStatus === 'delivered') {
                    // Calculate midpoint for delivery truck position
                    const midLat = (warehouseLocation[0] + customerLat) / 2;
                    const midLon = (warehouseLocation[1] + customerLon) / 2;
                    const currentPosition = [midLat, midLon];

                    const deliveryMarker = L.marker(currentPosition, {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: '<div style="background: #1c1917; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 4px 12px rgba(28, 25, 23, 0.4); font-size: 20px; animation: bounce 1s infinite;">🚚</div>',
                            iconSize: [42, 42]
                        })
                    }).addTo(map);
                    deliveryMarker.bindPopup('<b>🚚 Dalam Pengiriman</b><br>Paket Anda sedang dalam perjalanan!');

                    // Draw route line with truck
                    L.polyline([warehouseLocation, currentPosition, customerLocation], {
                        color: '#1c1917',
                        weight: 3,
                        opacity: 0.6,
                        dashArray: '10, 5'
                    }).addTo(map);
                } else {
                    // Show route between warehouse and customer only
                    L.polyline([warehouseLocation, customerLocation], {
                        color: '#a8a29e',
                        weight: 3,
                        opacity: 0.4,
                        dashArray: '10, 5'
                    }).addTo(map);
                }

                // Fit map to show all markers
                map.fitBounds([warehouseLocation, customerLocation], { padding: [50, 50] });
            } else {
                // Fallback if geocoding fails
                console.log('Geocoding failed for address:', customerAddress);
                const fallbackLocation = [-6.2088, 106.8456];
                const customerMarker = L.marker(fallbackLocation, {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: '<div style="background: #10b981; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-size: 18px;">🏠</div>',
                        iconSize: [36, 36]
                    })
                }).addTo(map);
                customerMarker.bindPopup('<b>🏠 Alamat Pengiriman</b><br>{{ $order->cardholder_name }}<br>{{ $order->city }}');
            }
        })
        .catch(error => {
            console.error('Error geocoding address:', error);
        });

        // Add bounce animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
