<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(243, 244, 246, 0.5);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.6);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(107, 114, 128, 0.8);
        }
    </style>
</head>
<body>
    <div x-data="cartPage()" x-init="init()" class="min-h-screen pb-6">
        <!-- Header -->
        <div class="max-w-4xl mx-auto px-4 pt-6 pb-4">
            <div class="flex items-center justify-between mb-6">
                <button 
                    onclick="smartBack()"
                    class="p-2 rounded-xl bg-white/80 backdrop-blur-xl shadow-lg hover:bg-white transition-all"
                >
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                
                <div class="w-10"></div>
            </div>
        </div>

        <!-- Cart Content -->
        <div class="max-w-4xl mx-auto px-4">
            <!-- Cart Empty State -->
            <template x-if="cartItems.length === 0">
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-12 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6">Looks like you haven't added anything to your cart yet.</p>
                    <a 
                        href="{{ route('dashboard') }}"
                        class="inline-block px-8 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold hover:from-orange-600 hover:to-red-600 transition-all shadow-lg"
                    >
                        Start Shopping
                    </a>
                </div>
            </template>

            <!-- Cart Items -->
            <div x-show="cartItems.length > 0" class="space-y-4">
                <!-- Items List -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        Cart Items (<span x-text="cartCount"></span>)
                    </h3>
                    
                    <div class="space-y-3 custom-scrollbar max-h-[500px] overflow-y-auto pr-2">
                        <template x-for="(item, index) in cartItems" :key="index">
                            <div class="flex gap-4 p-4 rounded-2xl bg-gradient-to-br from-white/60 to-white/40 backdrop-blur-lg border border-white/50 hover:shadow-lg transition-all">
                                <!-- Product Image -->
                                <div class="w-24 h-24 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                    <img 
                                        :src="item.image || 'https://dummyimage.com/96x96/f3f4f6/aaa&text=Product'" 
                                        :alt="item.name"
                                        class="w-full h-full object-cover"
                                    >
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-base mb-1" x-text="item.name"></h4>
                                    <p class="text-red-500 font-bold text-lg mb-3" x-text="'Rp ' + formatPrice(item.price)"></p>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-3">
                                        <button 
                                            @click="decreaseQuantity(index)"
                                            class="w-9 h-9 rounded-xl bg-white/80 hover:bg-white shadow-md flex items-center justify-center transition-all hover:scale-110"
                                        >
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <span class="text-base font-bold text-gray-900 w-10 text-center" x-text="item.quantity"></span>
                                        <button 
                                            @click="increaseQuantity(index)"
                                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 shadow-md flex items-center justify-center transition-all hover:scale-110"
                                        >
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                        
                                        <!-- Subtotal -->
                                        <span class="ml-auto text-gray-700 font-semibold">
                                            Rp <span x-text="formatPrice(item.price * item.quantity)"></span>
                                        </span>
                                        
                                        <!-- Remove Button -->
                                        <button 
                                            @click="removeItem(index)"
                                            class="w-9 h-9 rounded-xl bg-red-100 hover:bg-red-200 flex items-center justify-center transition-all hover:scale-110"
                                        >
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Voucher Section -->
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl shadow-xl p-6 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-white font-bold text-lg">🎁 Lucky Voucher</h3>
                        <span x-show="discount > 0" class="bg-white text-purple-600 px-3 py-1 rounded-full text-sm font-bold" x-text="discount + '% OFF'"></span>
                    </div>
                    
                    <div class="space-y-3">
                        <button 
                            @click="generateRandomVoucher()"
                            class="w-full py-3 rounded-xl bg-white text-purple-600 font-bold hover:bg-purple-50 transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg"
                        >
                            🎲 Get Random Discount!
                        </button>
                        
                        <div x-show="voucherCode" class="bg-white/20 backdrop-blur-sm rounded-xl p-3 text-center">
                            <p class="text-white text-sm mb-1">Your Voucher Code:</p>
                            <p class="text-white font-mono font-bold text-lg" x-text="voucherCode"></p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal (<span x-text="cartCount"></span> items)</span>
                            <span class="font-semibold" x-text="'Rp ' + formatPrice(totalPrice)"></span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Shipping</span>
                            <span class="font-semibold text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Tax (12%)</span>
                            <span class="font-semibold" x-text="'Rp ' + formatPrice(totalPrice * 0.12)"></span>
                        </div>
                        <div x-show="discount > 0" class="flex justify-between text-green-600 font-semibold">
                            <span>🎉 Discount (<span x-text="discount"></span>%)</span>
                            <span x-text="'- Rp ' + formatPrice(getDiscountAmount())"></span>
                        </div>
                        <hr class="border-gray-300">
                        <div class="flex justify-between text-xl font-bold text-gray-900">
                            <span>Total</span>
                            <span class="text-red-500" x-text="'Rp ' + formatPrice(getFinalTotal())"></span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a 
                        :href="'{{ route('checkout.create') }}?product_id=' + getFirstProductId()"
                        class="block w-full py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 text-white text-center font-bold text-lg shadow-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:scale-105 active:scale-95"
                    >
                        Proceed to Checkout
                    </a>
                    
                    <button 
                        onclick="smartBack()"
                        class="block w-full mt-3 py-3 rounded-2xl bg-white/60 text-gray-700 text-center font-semibold hover:bg-white transition-all"
                    >
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cartPage() {
            return {
                cartItems: [],
                cartCount: 0,
                totalPrice: 0,
                discount: 0,
                voucherCode: '',

                init() {
                    this.loadCart();
                    this.loadVoucher();
                    
                    // Listen untuk update
                    window.addEventListener('cartUpdated', () => {
                        this.loadCart();
                    });
                },

                loadCart() {
                    const stored = localStorage.getItem('cartItems');
                    this.cartItems = stored ? JSON.parse(stored) : [];
                    this.calculateTotal();
                },

                loadVoucher() {
                    const savedDiscount = localStorage.getItem('cartDiscount');
                    const savedVoucherCode = localStorage.getItem('voucherCode');
                    if (savedDiscount) {
                        this.discount = parseInt(savedDiscount);
                        this.voucherCode = savedVoucherCode || '';
                    }
                },

                saveCart() {
                    localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                    localStorage.setItem('cartCount', this.cartCount);
                    this.calculateTotal();
                    window.dispatchEvent(new CustomEvent('cartUpdated'));
                },

                calculateTotal() {
                    this.cartCount = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                    this.totalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                generateRandomVoucher() {
                    // Random discount: 5%, 10%, 15%, 20%, 25%, 30%, 35%, 40%, 50%
                    const discounts = [5, 10, 15, 20, 25, 30, 35, 40, 50];
                    const randomDiscount = discounts[Math.floor(Math.random() * discounts.length)];
                    
                    // Generate random voucher code
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let code = 'LUCKY-';
                    for (let i = 0; i < 6; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    
                    this.discount = randomDiscount;
                    this.voucherCode = code;
                    
                    // Save to localStorage
                    localStorage.setItem('cartDiscount', randomDiscount);
                    localStorage.setItem('voucherCode', code);
                    
                    // Show success animation
                    this.showVoucherSuccess(randomDiscount);
                },

                showVoucherSuccess(discount) {
                    // Create toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 animate-bounce';
                    toast.innerHTML = `
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🎉</span>
                            <div>
                                <p class="font-bold">Voucher Applied!</p>
                                <p class="text-sm">You got ${discount}% discount!</p>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                },

                getDiscountAmount() {
                    const subtotal = this.totalPrice * 1.12; // after tax
                    return subtotal * (this.discount / 100);
                },

                getFinalTotal() {
                    const subtotal = this.totalPrice * 1.12; // after tax
                    const discountAmount = this.getDiscountAmount();
                    return subtotal - discountAmount;
                },

                increaseQuantity(index) {
                    this.cartItems[index].quantity++;
                    this.saveCart();
                },

                decreaseQuantity(index) {
                    if (this.cartItems[index].quantity > 1) {
                        this.cartItems[index].quantity--;
                        this.saveCart();
                    } else {
                        this.removeItem(index);
                    }
                },

                removeItem(index) {
                    if (confirm('Remove this item from cart?')) {
                        this.cartItems.splice(index, 1);
                        this.saveCart();
                    }
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                },

                getFirstProductId() {
                    return this.cartItems.length > 0 ? this.cartItems[0].id : '';
                }
            }
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

    <!-- Live Chat Widget -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.chat-widget')

</body>
</html>
