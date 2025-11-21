@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🛒 Shopping Cart</h1>
            <p class="text-gray-600 mt-1">{{ $cartItems->count() }} item(s) in your cart</p>
        </div>

        @if($cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Start shopping to add items to your cart</p>
                <a href="{{ route('dashboard') }}" class="inline-block bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6" data-cart-item="{{ $item->id }}">
                        <div class="flex gap-4">
                            <!-- Product Image -->
                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://dummyimage.com/120x120/f3f4f6/aaa' }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-24 h-24 object-cover rounded-xl">
                            
                            <!-- Product Info -->
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $item->product->category ?? 'Uncategorized' }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Stock: {{ $item->product->stock }}</p>
                                    </div>
                                    <button onclick="removeFromCart({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateQuantity({{ $item->id }}, -1)" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="{{ $item->product->stock }}"
                                               class="w-16 text-center border border-gray-300 rounded-lg py-1"
                                               data-item-id="{{ $item->id }}"
                                               onchange="updateQuantityDirect({{ $item->id }}, this.value)">
                                        <button onclick="updateQuantity({{ $item->id }}, 1)" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-orange-600" data-subtotal="{{ $item->id }}">
                                            {{ $item->formatted_subtotal }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ number_format($item->product->final_price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                <span id="subtotal-display">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium">FREE</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-orange-600" id="total-display">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.create', ['from_cart' => true]) }}" class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition shadow-lg mb-3">
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('dashboard') }}" class="block w-full bg-gray-100 text-gray-700 text-center font-medium py-3 rounded-xl hover:bg-gray-200 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Update quantity
async function updateQuantity(cartId, change) {
    const input = document.querySelector(`input[data-item-id="${cartId}"]`);
    const currentQty = parseInt(input.value);
    const newQty = currentQty + change;
    
    if (newQty < 1) return;
    if (newQty > parseInt(input.max)) {
        alert('Quantity exceeds available stock');
        return;
    }
    
    input.value = newQty;
    await updateCart(cartId, newQty);
}

// Update quantity direct input
async function updateQuantityDirect(cartId, newQty) {
    newQty = parseInt(newQty);
    if (newQty < 1) {
        newQty = 1;
        document.querySelector(`input[data-item-id="${cartId}"]`).value = 1;
    }
    
    await updateCart(cartId, newQty);
}

// Update cart via API
async function updateCart(cartId, quantity) {
    try {
        const response = await fetch(`/cart/${cartId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ quantity })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update subtotal
            document.querySelector(`[data-subtotal="${cartId}"]`).textContent = data.subtotal;
            // Update total
            document.getElementById('total-display').textContent = data.total;
            document.getElementById('subtotal-display').textContent = data.total;
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update cart');
    }
}

// Remove from cart
async function removeFromCart(cartId) {
    if (!confirm('Remove this item from cart?')) return;
    
    try {
        const response = await fetch(`/cart/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove item from DOM
            document.querySelector(`[data-cart-item="${cartId}"]`).remove();
            
            // Update totals
            document.getElementById('total-display').textContent = data.total;
            document.getElementById('subtotal-display').textContent = data.total;
            
            // Reload if cart is empty
            if (data.cartCount === 0) {
                location.reload();
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove item');
    }
}
</script>
@endsection
