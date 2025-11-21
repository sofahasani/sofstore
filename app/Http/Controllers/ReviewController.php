<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display user's reviews
     */
    public function index()
    {
        $reviews = Review::where('user_id', auth()->id())
            ->with(['product', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verify order belongs to user and is delivered
        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('status', 'delivered')
            ->first();

        if (!$order) {
            return back()->with('error', 'Anda hanya bisa mengulas produk yang sudah Anda beli dan diterima!');
        }

        // Check if user already reviewed this order
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();
        
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini!');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewer_name' => auth()->user()->name,
            'is_verified_purchase' => true, // Always true since we verified the order
        ]);

        return back()->with('success', '✅ Terima kasih! Ulasan Anda berhasil ditambahkan.');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        // Only allow user to delete their own review or admin
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
