<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <button onclick="smartBack('/checkout')" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Checkout Details</h1>
                <div class="w-6"></div>
            </div>
            
            <!-- Progress Bar -->
            <div class="flex items-center justify-between mb-3">
                <div class="progress-dot completed">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                    </svg>
                </div>
                <div class="progress-line active"></div>
                <div class="progress-dot active">
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
                <span>Bag</span>
                <span class="font-medium text-amber-500">Address</span>
                <span>Payment</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="px-5 py-6 pb-40">
            <!-- Product Info -->
            <div class="flex items-center gap-4 mb-6">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/120x120/f3f4f6/aaa&text=No+Image' }}" 
                     alt="{{ $product->name }}" 
                     class="w-20 h-20 object-cover rounded-xl">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $product->name }}</h3>
                    <div class="text-right">
                        <div id="displayPrice" class="text-2xl font-bold text-red-500">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">Including tax & discount</div>
                    </div>
                </div>
            </div>

            <!-- Price Summary -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-4 mb-6 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span id="subtotalPrice" class="font-semibold text-gray-900"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tax (12%)</span>
                    <span id="taxAmount" class="font-semibold text-gray-900"></span>
                </div>
                <div id="discountRow" class="flex justify-between text-sm text-green-600" style="display: none;">
                    <span>🎉 Discount (<span id="discountPercent"></span>%)</span>
                    <span id="discountAmount" class="font-semibold"></span>
                </div>
                <div id="voucherCodeRow" class="text-xs text-gray-500 italic" style="display: none;">
                    Code: <span id="voucherCodeDisplay" class="font-mono font-bold"></span>
                </div>
                <hr class="border-gray-300">
                <div class="flex justify-between">
                    <span class="font-bold text-gray-900">Total</span>
                    <span id="finalTotal" class="font-bold text-xl text-red-500"></span>
                </div>
            </div>

            <form method="POST" action="{{ route('checkout.store-payment') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Payment Method Toggle -->
                <div class="flex gap-3 mb-6">
                    <label class="flex-1">
                        <input type="radio" name="payment_method" value="credit_card" class="peer sr-only" checked onchange="togglePaymentMethod()">
                        <div class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 peer-checked:bg-amber-400 text-gray-700 peer-checked:text-gray-900 font-medium rounded-2xl cursor-pointer transition text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                            Credit card
                        </div>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="payment_method" value="cod" class="peer sr-only" onchange="togglePaymentMethod()">
                        <div class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 peer-checked:bg-amber-400 text-gray-700 peer-checked:text-gray-900 font-medium rounded-2xl cursor-pointer transition text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Cash on delivery
                        </div>
                    </label>
                </div>

                <!-- Credit Card Fields -->
                <div id="creditCardFields" class="space-y-4">
                    <!-- Card Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Card number</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="card_number" 
                                id="cardNumber"
                                maxlength="19"
                                value="{{ old('card_number') }}"
                                class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm pr-20"
                                placeholder="5261 4141 0151"
                            >
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                                <div class="w-8 h-6 bg-red-500 rounded opacity-80"></div>
                                <div class="w-8 h-6 bg-amber-400 rounded opacity-80 -ml-3"></div>
                                <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        @error('card_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cardholder Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Cardholder name</label>
                        <input 
                            type="text" 
                            name="cardholder_name" 
                            id="cardholderName"
                            value="{{ old('cardholder_name') }}"
                            class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                            placeholder="Sofa Hasani"
                        >
                        @error('cardholder_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry & CVV -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-2">Expiry date</label>
                            <input 
                                type="text" 
                                name="expiry_date" 
                                id="expiryDate"
                                maxlength="7"
                                value="{{ old('expiry_date') }}"
                                class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                                placeholder="MM / YYYY"
                            >
                            @error('expiry_date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-2 flex items-center gap-1">
                                CVV / CVC
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </label>
                            <input 
                                type="password" 
                                name="cvv" 
                                id="cvv"
                                maxlength="3"
                                value="{{ old('cvv') }}"
                                class="w-full px-4 py-3.5 bg-gray-100 border-0 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:bg-white outline-none transition text-sm"
                                placeholder="•••"
                            >
                            @error('cvv')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- COD Message (Hidden by default) -->
                <div id="codMessage" class="hidden">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-gray-700">
                        <p class="font-medium mb-1">Cash on Delivery</p>
                        <p class="text-xs text-gray-600">You will pay when the product is delivered to your address.</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Bottom Button -->
        <div class="fixed bottom-0 left-0 right-0 bg-white px-5 py-5 max-w-md mx-auto border-t border-gray-200">
            <button 
                type="submit" 
                form="paymentForm"
                class="w-full bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900 font-semibold py-4 rounded-full shadow-lg hover:from-amber-500 hover:to-amber-600 transition-all duration-200 active:scale-95"
            >
                Payment for Order
            </button>
            <p class="text-center text-xs text-gray-400 mt-3">
                We will send you an order details to your email<br>after the successful payment
            </p>
        </div>
    </div>

    <script>
        // Get product base price from Laravel
        const basePrice = {{ $product->price }};
        
        // Load discount from localStorage
        function loadAndApplyDiscount() {
            const discount = parseInt(localStorage.getItem('cartDiscount') || '0');
            const voucherCode = localStorage.getItem('voucherCode') || '';
            
            // Calculate prices
            const subtotal = basePrice;
            const tax = subtotal * 0.12;
            const subtotalWithTax = subtotal + tax;
            const discountAmount = subtotalWithTax * (discount / 100);
            const finalTotal = subtotalWithTax - discountAmount;
            
            // Update display
            document.getElementById('subtotalPrice').textContent = formatPrice(subtotal);
            document.getElementById('taxAmount').textContent = formatPrice(tax);
            document.getElementById('finalTotal').textContent = formatPrice(finalTotal);
            document.getElementById('displayPrice').textContent = formatPrice(finalTotal);
            
            // Show/hide discount row
            if (discount > 0) {
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('voucherCodeRow').style.display = 'block';
                document.getElementById('discountPercent').textContent = discount;
                document.getElementById('discountAmount').textContent = '- ' + formatPrice(discountAmount);
                document.getElementById('voucherCodeDisplay').textContent = voucherCode;
            } else {
                document.getElementById('discountRow').style.display = 'none';
                document.getElementById('voucherCodeRow').style.display = 'none';
            }
        }
        
        // Format price to IDR
        function formatPrice(price) {
            return 'Rp ' + Math.round(price).toLocaleString('id-ID');
        }
        
        // Initialize on page load
        loadAndApplyDiscount();
        
        // Listen for storage changes (if user changes discount in another tab)
        window.addEventListener('storage', function(e) {
            if (e.key === 'cartDiscount' || e.key === 'voucherCode') {
                loadAndApplyDiscount();
            }
        });
        
        // Format card number
        document.getElementById('cardNumber')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Format expiry date
        document.getElementById('expiryDate')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + ' / ' + value.substring(2, 6);
            }
            e.target.value = value;
        });

        // Toggle payment method
        function togglePaymentMethod() {
            const creditCardFields = document.getElementById('creditCardFields');
            const codMessage = document.getElementById('codMessage');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (paymentMethod === 'credit_card') {
                creditCardFields.classList.remove('hidden');
                codMessage.classList.add('hidden');
                // Make credit card fields required
                document.getElementById('cardNumber').required = true;
                document.getElementById('cardholderName').required = true;
                document.getElementById('expiryDate').required = true;
                document.getElementById('cvv').required = true;
            } else {
                creditCardFields.classList.add('hidden');
                codMessage.classList.remove('hidden');
                // Remove required from credit card fields
                document.getElementById('cardNumber').required = false;
                document.getElementById('cardholderName').required = false;
                document.getElementById('expiryDate').required = false;
                document.getElementById('cvv').required = false;
            }
        }
    </script>

    <script>
        // Smart back navigation - Fixed version
        function smartBack(defaultUrl) {
            if (window.history.length > 1 && document.referrer) {
                window.history.back();
            } else {
                window.location.href = defaultUrl || '{{ route("checkout.create") }}';
            }
        }
    </script>
</body>
</html>
