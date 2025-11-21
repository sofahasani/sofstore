<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::with(['product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display single order details
     */
    public function show(Order $order)
    {
        // Check if order belongs to user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('product');

        return view('user.orders.show', compact('order'));
    }

    /**
     * Cancel order (only if status is pending or processing)
     */
    public function cancel(Order $order)
    {
        // Check if order belongs to user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancel if not yet shipped
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Cannot cancel order that is already ' . $order->status);
        }

        $order->update(['status' => 'cancelled']);

        // Restore stock
        $order->product->increment('stock', $order->quantity);
        $order->product->decrement('total_sold', $order->quantity);

        return redirect()->back()->with('success', 'Order cancelled successfully. Stock has been restored.');
    }
}
