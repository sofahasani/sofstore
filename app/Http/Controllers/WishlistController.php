<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add product to wishlist (toggle)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user_id = auth()->id();
        $product_id = $request->product_id;

        // Check if already in wishlist
        $existing = Wishlist::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($existing) {
            // Remove from wishlist (unlike)
            $existing->delete();
            return response()->json([
                'success' => true,
                'liked' => false,
                'message' => 'Produk dihapus dari wishlist'
            ]);
        } else {
            // Add to wishlist (like)
            Wishlist::create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
            
            return response()->json([
                'success' => true,
                'liked' => true,
                'message' => 'Produk ditambahkan ke wishlist'
            ]);
        }
    }

    /**
     * Remove from wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();
            
        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Produk dihapus dari wishlist');
        }
        
        return back()->with('error', 'Produk tidak ditemukan');
    }
    
    /**
     * Check if product is in wishlist (for frontend)
     */
    public function check($product_id)
    {
        $isLiked = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product_id)
            ->exists();
            
        return response()->json(['liked' => $isLiked]);
    }
}

