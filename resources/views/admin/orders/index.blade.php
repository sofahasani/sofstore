@extends('admin.layouts.admin')

@section('page-title', 'Orders Management')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📦 Orders Management</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola semua pesanan yang masuk</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                        <p class="text-xs text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ref, Product, Customer..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'search']))
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>
                @endif
            </form>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">#{{ $order->ref_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Qty: {{ $order->quantity }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $order->product_image ? asset('storage/' . $order->product_image) : 'https://dummyimage.com/48x48/f3f4f6/aaa&text=No+Image' }}" 
                                         alt="{{ $order->product_name }}" 
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($order->product_name, 30) }}</p>
                                        <p class="text-xs text-gray-500">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    @if($order->user)
                                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                    @else
                                        <p class="text-sm font-medium text-gray-500">Guest</p>
                                        <p class="text-xs text-gray-400">{{ $order->cardholder_name }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $order->city }}, {{ $order->state }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $order->payment_method == 'credit_card' ? '💳 Credit Card' : '💵 COD' }}
                                    </p>
                                    @if($order->card_number)
                                    <p class="text-xs text-gray-500">{{ $order->card_number }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_color }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded px-2 py-1">
                                            <option value="">Update Status</option>
                                            <option value="pending">Menunggu</option>
                                            <option value="processing">Diproses</option>
                                            <option value="shipped">Dikirim</option>
                                            <option value="delivered">Selesai</option>
                                            <option value="cancelled">Dibatalkan</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-lg font-semibold">Tidak ada pesanan</p>
                                    <p class="text-sm mt-1">Belum ada pesanan yang masuk</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
