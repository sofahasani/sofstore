{{-- 
    ========================================
    FLOATING CART COMPONENT - iOS 16 Style
    ========================================
    Komponen keranjang belanja floating dengan glassmorphism effect
    
    Features:
    - Floating icon di kanan atas dengan badge counter
    - Smooth animation slide-in dari kanan
    - iOS 16 glassmorphism design
    - Auto-close ketika klik di luar
    - Mobile-friendly responsive
    
    Usage:
    @include('components.cart-floating')
--}}

<!-- Alpine.js CDN (jika belum ada di layout utama) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="cartFloating()" x-init="init()" class="cart-floating-wrapper">
    {{-- Floating Cart Icon Button --}}
    <button 
        @click="toggleCart()"
        class="fixed top-4 right-4 z-50 group"
        :class="{ 'scale-95': isOpen }"
        style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);"
    >
        <!-- Glass Container untuk Icon -->
        <div class="relative p-3 rounded-2xl bg-white/80 backdrop-blur-xl shadow-lg border border-white/20 group-hover:scale-110 group-hover:bg-white/90 transition-all duration-300">
            <!-- Cart Icon SVG -->
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            
            <!-- Badge Counter -->
            <span 
                x-show="cartCount > 0" 
                x-text="cartCount"
                x-transition
                class="absolute -top-2 -right-2 bg-gradient-to-br from-orange-500 to-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg"
                style="transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);"
            ></span>
        </div>
    </button>

    {{-- Overlay Background dengan Blur --}}
    <div 
        x-show="isOpen"
        @click="closeCart()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40"
        style="display: none;"
    ></div>

    {{-- Floating Panel Cart (iOS Glassmorphism) --}}
    <div 
        x-show="isOpen"
        @click.outside="closeCart()"
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0 translate-x-full scale-95"
        x-transition:enter-end="opacity-100 translate-x-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0 scale-100"
        x-transition:leave-end="opacity-0 translate-x-full scale-95"
        class="fixed top-4 right-4 w-[380px] max-w-[calc(100vw-2rem)] max-h-[calc(100vh-2rem)] bg-white/70 backdrop-blur-3xl rounded-3xl shadow-2xl border border-white/30 overflow-hidden z-50"
        style="display: none; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);"
    >
        {{-- Header Panel --}}
        <div class="sticky top-0 bg-white/60 backdrop-blur-xl border-b border-white/30 px-6 py-4 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-lg">Shopping Cart</h3>
                    <p class="text-xs text-gray-600" x-text="cartCount + ' item' + (cartCount !== 1 ? 's' : '')"></p>
                </div>
            </div>
            
            <!-- Close Button -->
            <button 
                @click="closeCart()"
                class="w-8 h-8 rounded-full bg-gray-200/60 hover:bg-gray-300/80 flex items-center justify-center transition-all duration-200 hover:scale-110"
            >
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Cart Items List --}}
        <div class="overflow-y-auto max-h-[calc(100vh-250px)] px-6 py-4 space-y-3">
            <!-- Empty Cart State -->
            <template x-if="cartItems.length === 0">
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-gray-900 font-semibold text-lg mb-1">Your cart is empty</h4>
                    <p class="text-gray-500 text-sm mb-4">Start adding some products!</p>
                    <button 
                        @click="closeCart()"
                        class="px-6 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-medium hover:from-orange-600 hover:to-red-600 transition-all"
                    >
                        Continue Shopping
                    </button>
                </div>
            </template>

            <!-- Cart Items -->
            <template x-for="(item, index) in cartItems" :key="index">
                <div class="flex gap-3 p-3 rounded-2xl bg-white/50 backdrop-blur-xl border border-white/40 hover:bg-white/70 transition-all duration-200">
                    <!-- Product Image -->
                    <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                        <img 
                            :src="item.image || 'https://dummyimage.com/80x80/f3f4f6/aaa&text=Product'" 
                            :alt="item.name"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1 truncate" x-text="item.name"></h4>
                        <p class="text-red-500 font-bold text-sm mb-2" x-text="'Rp ' + formatPrice(item.price)"></p>
                        
                        <!-- Quantity Controls -->
                        <div class="flex items-center gap-2">
                            <button 
                                @click="decreaseQuantity(index)"
                                class="w-7 h-7 rounded-lg bg-gray-200/60 hover:bg-gray-300 flex items-center justify-center transition-all"
                            >
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="text-sm font-semibold text-gray-900 w-8 text-center" x-text="item.quantity"></span>
                            <button 
                                @click="increaseQuantity(index)"
                                class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-400 to-red-500 hover:from-orange-500 hover:to-red-600 flex items-center justify-center transition-all"
                            >
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            
                            <!-- Remove Button -->
                            <button 
                                @click="removeItem(index)"
                                class="ml-auto w-7 h-7 rounded-lg bg-red-100/60 hover:bg-red-200 flex items-center justify-center transition-all"
                            >
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Footer dengan Total & Checkout Button --}}
        <div 
            x-show="cartItems.length > 0"
            x-transition
            class="sticky bottom-0 bg-white/70 backdrop-blur-xl border-t border-white/30 px-6 py-4"
        >
            <!-- Total Price -->
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-600 font-medium">Total</span>
                <span class="text-2xl font-bold text-gray-900" x-text="'Rp ' + formatPrice(totalPrice)"></span>
            </div>

            <!-- Checkout Button -->
            <a 
                href="{{ route('cart.index') }}"
                @click="if(!{{ auth()->check() ? 'true' : 'false' }}) { $event.preventDefault(); showLoginModal(); }"
                class="block w-full py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 text-white text-center font-bold text-lg shadow-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:scale-105 active:scale-95"
            >
                Checkout Now
            </a>
        </div>
    </div>
</div>

<!-- Include Auth Check Component -->
@include('components.auth-check')

{{-- Alpine.js Component Logic --}}
<script>
    function cartFloating() {
        return {
            isOpen: false,
            cartItems: [],
            cartCount: 0,
            totalPrice: 0,

            // Initialize: Load cart from localStorage
            init() {
                this.loadCart();
                
                // Listen untuk update dari detail page
                window.addEventListener('cartUpdated', (e) => {
                    this.loadCart();
                });

                // Sync dengan localStorage changes dari tab lain
                window.addEventListener('storage', (e) => {
                    if (e.key === 'cartItems') {
                        this.loadCart();
                    }
                });
            },

            // Load cart dari localStorage
            loadCart() {
                const stored = localStorage.getItem('cartItems');
                this.cartItems = stored ? JSON.parse(stored) : [];
                this.calculateTotal();
            },

            // Save cart ke localStorage
            saveCart() {
                localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                localStorage.setItem('cartCount', this.cartCount);
                this.calculateTotal();
                
                // Dispatch event untuk sync
                window.dispatchEvent(new CustomEvent('cartUpdated'));
            },

            // Calculate total harga dan jumlah item
            calculateTotal() {
                this.cartCount = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                this.totalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            // Toggle panel cart
            toggleCart() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            },

            // Close cart panel
            closeCart() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },

            // Increase quantity
            increaseQuantity(index) {
                this.cartItems[index].quantity++;
                this.saveCart();
            },

            // Decrease quantity
            decreaseQuantity(index) {
                if (this.cartItems[index].quantity > 1) {
                    this.cartItems[index].quantity--;
                    this.saveCart();
                } else {
                    this.removeItem(index);
                }
            },

            // Remove item dari cart
            removeItem(index) {
                this.cartItems.splice(index, 1);
                this.saveCart();
            },

            // Format harga dengan separator
            formatPrice(price) {
                return new Intl.NumberFormat('id-ID').format(price);
            },

            // Get first product ID untuk checkout
            getFirstProductId() {
                return this.cartItems.length > 0 ? this.cartItems[0].id : '';
            }
        }
    }
</script>

{{-- Custom Styles --}}
<style>
    /* Smooth scrollbar untuk cart items */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(243, 244, 246, 0.3);
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.7);
    }

    /* Glassmorphism enhancement */
    @supports (backdrop-filter: blur(20px)) {
        .backdrop-blur-3xl {
            backdrop-filter: blur(30px);
        }
    }

    /* Prevent body scroll saat cart open */
    body.cart-open {
        overflow: hidden;
    }
</style>
