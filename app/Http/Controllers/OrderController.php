<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orWhere(function($query) {
                // For guest orders, match by email if logged in user email matches
                $query->whereNull('user_id')
                      ->where('customer_email', auth()->user()->email);
            })
            ->with(['product', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show order detail with tracking
     */
    public function show($id)
    {
        $order = Order::with('product')->findOrFail($id);
        
        // Check if order belongs to current user
        if ($order->user_id !== auth()->id() && $order->customer_email !== auth()->user()->email) {
            abort(403, 'Unauthorized');
        }
        
        return view('orders.show', compact('order'));
    }
}

