@extends('admin.layouts.admin')

@section('page-title', 'Order Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Orders
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">📦 Order Details</h1>
                    <p class="mt-1 text-sm text-gray-600">Order #{{ $order->ref_number }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column - Order Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Product Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h2>
                    <div class="flex items-start gap-4">
                        <img src="{{ $order->product_image ? asset('storage/' . $order->product_image) : 'https://dummyimage.com/120x120/f3f4f6/aaa&text=No+Image' }}" 
                             alt="{{ $order->product_name }}" 
                             class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $order->product_name }}</h3>
                            @if($order->product_description)
                            <p class="text-sm text-gray-600 mt-1">{{ $order->product_description }}</p>
                            @endif
                            <div class="mt-3 flex items-center gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Unit Price</p>
                                    <p class="text-sm font-semibold text-gray-900">Rp{{ number_format($order->product_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Quantity</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->quantity }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-lg font-bold text-orange-600">{{ $order->formatted_total }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-900">{{ $order->cardholder_name }}</p>
                        <p class="text-sm text-gray-700 mt-2">{{ $order->address }}</p>
                        <p class="text-sm text-gray-700">{{ $order->locality }}, {{ $order->city }}</p>
                        <p class="text-sm text-gray-700">{{ $order->state }} - {{ $order->pincode }}</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                            {{ $order->address_type }}
                        </span>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Payment Method</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $order->payment_method == 'credit_card' ? '💳 Credit Card' : '💵 Cash on Delivery' }}
                            </span>
                        </div>
                        @if($order->card_number)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Card Number</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->card_number }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Payment Time</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->payment_time->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total Amount</span>
                                <span class="text-xl font-bold text-orange-600">{{ $order->formatted_total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Status & Actions -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Reference Number</p>
                            <p class="text-sm font-mono font-semibold text-gray-900">#{{ $order->ref_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Order Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Customer Info</p>
                            @if($order->user)
                                <p class="text-sm font-semibold text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-600">{{ $order->user->email }}</p>
                                <p class="text-xs text-gray-600">📱 {{ $order->user->phone ?? 'No phone' }}</p>
                                <a href="mailto:{{ $order->user->email }}" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                                    Send Email
                                </a>
                            @else
                                <p class="text-sm font-semibold text-gray-500">🛒 Guest Checkout</p>
                                <p class="text-xs text-gray-600">{{ $order->cardholder_name }}</p>
                                <p class="text-xs text-gray-600">{{ $order->customer_email ?? 'No email' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">🚚 Update Tracking</h2>
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Order Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>📦 Diproses</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Tracking Status</label>
                            <input 
                                type="text" 
                                name="tracking_status" 
                                value="{{ old('tracking_status', $order->tracking_status) }}"
                                placeholder="Contoh: Kurir sedang mengantar paket"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 text-sm"
                            >
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Tracking Notes</label>
                            <textarea 
                                name="tracking_notes" 
                                rows="3"
                                placeholder="Detail informasi tracking (opsional)"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 text-sm"
                            >{{ old('tracking_notes', $order->tracking_notes) }}</textarea>
                        </div>

                        @if($order->tracking_status || $order->tracking_notes)
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-xs font-medium text-blue-900 mb-1">Current Tracking:</p>
                            <p class="text-sm text-blue-800">{{ $order->tracking_status ?? 'No status' }}</p>
                            @if($order->tracking_notes)
                            <p class="text-xs text-blue-700 mt-1">{{ $order->tracking_notes }}</p>
                            @endif
                            @if($order->status_updated_at)
                            <p class="text-xs text-blue-600 mt-1">Updated: {{ $order->status_updated_at->diffForHumans() }}</p>
                            @endif
                        </div>
                        @endif

                        <button type="submit" class="w-full bg-orange-500 text-white font-semibold py-2.5 rounded-lg hover:bg-orange-600 transition">
                            💾 Update Tracking
                        </button>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        <a href="{{ route('admin.products.edit', $order->product_id) }}" class="block w-full text-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100 transition text-sm">
                            View Product
                        </a>
                        @if($order->user)
                        <button class="block w-full text-center px-4 py-2 bg-green-50 text-green-700 font-medium rounded-lg hover:bg-green-100 transition text-sm">
                            Contact Customer
                        </button>
                        @endif
                        <button onclick="window.print()" class="block w-full text-center px-4 py-2 bg-gray-50 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition text-sm">
                            Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
