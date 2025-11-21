<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Address</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body {
            font-family: 'SF Pro', 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: #f9fafb;
        }
        .progress-line {
            position: relative;
            height: 2px;
            background: #e5e7eb;
            flex: 1;
        }
        .progress-line.active {
            background: #fbbf24;
        }
        .progress-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            position: relative;
            z-index: 2;
        }
        .progress-dot.active {
            background: #fbbf24;
            color: #fff;
        }
        .progress-dot.completed {
            background: #374151;
            color: #fff;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 z-10 px-5 py-4">
            <div class="flex items-center justify-between mb-4">
                <button onclick="smartBack('/cart')" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Checkout Details</h1>
                <div class="w-6"></div>
            </div>
            
            <!-- Progress Bar -->
            <div class="flex items-center justify-between mb-3">
                <div class="progress-dot active">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                    </svg>
                </div>
                <div class="progress-line"></div>
                <div class="progress-dot">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
                <div class="progress-line"></div>
                <div class="progress-dot">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            
            <div class="flex justify-between text-xs text-gray-500">
                <span class="font-medium text-amber-500">Bag</span>
                <span>Address</span>
                <span>Payment</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="px-5 py-6 pb-32">
            <h2 class="text-lg font-semibold text-gray-900 mb-5">Address</h2>
            
            <form method="POST" action="{{ route('checkout.store-address') }}" id="addressForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <input 
                            type="email" 
                            name="email" 
                            required
                            value="{{ old('email', auth()->user()->email ?? '') }}"
                            class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                            placeholder="Email Address for Invoice"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <input 
                            type="text" 
                            name="address" 
                            id="addressInput"
                            required
                            value="{{ old('address') }}"
                            class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                            placeholder="Address (House No. Building Street Area)"
                        >
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Locality / Town -->
                    <div>
                        <input 
                            type="text" 
                            name="locality" 
                            id="localityInput"
                            required
                            value="{{ old('locality') }}"
                            class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                            placeholder="Locality / Town"
                        >
                        @error('locality')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <input 
                            type="text" 
                            name="state" 
                            id="stateInput"
                            required
                            value="{{ old('state') }}"
                            class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                            placeholder="State"
                        >
                        @error('state')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City & Pincode -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <input 
                                type="text" 
                                name="city" 
                                id="cityInput"
                                required
                                value="{{ old('city') }}"
                                class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                                placeholder="City/District"
                            >
                            @error('city')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input 
                                type="text" 
                                name="pincode" 
                                id="pincodeInput"
                                required
                                value="{{ old('pincode') }}"
                                class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                                placeholder="Pincode"
                            >
                            @error('pincode')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Map Preview -->
                    <div class="mt-4">
                        <div class="bg-gray-100 rounded-2xl overflow-hidden border-2 border-gray-200" style="height: 250px;">
                            <div id="checkoutMap" style="width: 100%; height: 100%;"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-center">📍 Map akan update otomatis sesuai alamat</p>
                    </div>

                    <!-- Save Address as -->
                    <div class="mt-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">Save Address as</h3>
                        <div class="flex gap-3">
                            <label class="flex-1">
                                <input type="radio" name="address_type" value="Home" class="peer sr-only" checked>
                                <div class="px-5 py-2.5 bg-amber-400 peer-checked:bg-amber-400 bg-opacity-0 peer-checked:bg-opacity-100 text-gray-700 peer-checked:text-gray-900 font-medium rounded-full text-center cursor-pointer transition border-2 border-transparent peer-checked:border-amber-400 text-sm">
                                    Home
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="address_type" value="Office" class="peer sr-only">
                                <div class="px-5 py-2.5 bg-gray-100 peer-checked:bg-amber-400 text-gray-700 peer-checked:text-gray-900 font-medium rounded-full text-center cursor-pointer transition text-sm">
                                    Office
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="address_type" value="Other" class="peer sr-only">
                                <div class="px-5 py-2.5 bg-gray-100 peer-checked:bg-amber-400 text-gray-700 peer-checked:text-gray-900 font-medium rounded-full text-center cursor-pointer transition text-sm">
                                    Other
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Bottom Button -->
        <div class="fixed bottom-0 left-0 right-0 bg-white px-5 py-5 max-w-md mx-auto">
            <button 
                type="submit" 
                form="addressForm"
                class="w-full bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900 font-semibold py-4 rounded-full shadow-lg hover:from-amber-500 hover:to-amber-600 transition-all duration-200 active:scale-95"
            >
                Confirmasi
            </button>
            <p class="text-center text-xs text-gray-400 mt-3">
                We will send you an order details to your email<br>after the successful payment
            </p>
        </div>
    </div>

    <script>
        // Smart back navigation - Fixed version
        function smartBack(defaultUrl) {
            if (window.history.length > 1 && document.referrer) {
                window.history.back();
            } else {
                window.location.href = defaultUrl || '{{ route("cart") }}';
            }
        }

        // Initialize Map
        const map = L.map('checkoutMap').setView([-6.2088, 106.8456], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([-6.2088, 106.8456], {
            icon: L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: #fbbf24; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3); font-size: 16px;">📍</div>',
                iconSize: [32, 32]
            })
        }).addTo(map);

        let geocodeTimeout;
        function updateMapLocation() {
            clearTimeout(geocodeTimeout);
            geocodeTimeout = setTimeout(() => {
                const address = document.getElementById('addressInput').value;
                const locality = document.getElementById('localityInput').value;
                const city = document.getElementById('cityInput').value;
                const state = document.getElementById('stateInput').value;
                const pincode = document.getElementById('pincodeInput').value;

                if (city && state) {
                    const fullAddress = [address, locality, city, state, pincode].filter(v => v).join(', ');
                    const geocodeUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}`;

                    fetch(geocodeUrl, {
                        headers: { 'User-Agent': 'ProjectWahab/1.0' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            const newPos = [lat, lon];
                            
                            marker.setLatLng(newPos);
                            map.setView(newPos, 14);
                        }
                    })
                    .catch(err => console.error('Geocoding error:', err));
                }
            }, 1000);
        }

        // Listen to input changes
        ['addressInput', 'localityInput', 'cityInput', 'stateInput', 'pincodeInput'].forEach(id => {
            document.getElementById(id).addEventListener('input', updateMapLocation);
        });
    </script>
</body>
</html>
