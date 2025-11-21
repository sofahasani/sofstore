<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get cart identifier (user_id or session_id)
     */
    private function getCartIdentifier()
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }
        
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => uniqid('cart_', true)]);
        }
        
        return ['session_id' => session('cart_session_id')];
    }

    /**
     * Get cart items
     */
    public function index()
    {
        $identifier = $this->getCartIdentifier();
        $cartItems = Cart::with('product')
            ->where($identifier)
            ->get();
        
        $total = $cartItems->sum('subtotal');
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock availability
        if ($product->stock < ($request->quantity ?? 1)) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak mencukupi. Tersedia: ' . $product->stock
            ], 400);
        }

        $identifier = $this->getCartIdentifier();
        $quantity = $request->quantity ?? 1;

        $cartItem = Cart::where($identifier)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity if item already in cart
            $newQuantity = $cartItem->quantity + $quantity;
            
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stock tersedia (' . $product->stock . ')'
                ], 400);
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item to cart
            Cart::create(array_merge($identifier, [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]));
        }

        $cartCount = Cart::where($identifier)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        // Check if user owns this cart item
        $identifier = $this->getCartIdentifier();
        $userCart = Cart::where($identifier)->where('id', $cart->id)->first();
        
        if (!$userCart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Check stock
        if ($request->quantity > $cart->product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak mencukupi. Tersedia: ' . $cart->product->stock
            ], 400);
        }

        $cart->update(['quantity' => $request->quantity]);

        $cartItems = Cart::with('product')->where($identifier)->get();
        $total = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'subtotal' => $cart->formatted_subtotal,
            'total' => 'Rp' . number_format($total, 0, ',', '.')
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Cart $cart)
    {
        // Check if user owns this cart item
        $identifier = $this->getCartIdentifier();
        $userCart = Cart::where($identifier)->where('id', $cart->id)->first();
        
        if (!$userCart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cart->delete();

        $cartCount = Cart::where($identifier)->sum('quantity');
        $cartItems = Cart::with('product')->where($identifier)->get();
        $total = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cartCount' => $cartCount,
            'total' => 'Rp' . number_format($total, 0, ',', '.')
        ]);
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        $identifier = $this->getCartIdentifier();
        Cart::where($identifier)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }

    /**
     * Get cart count (for badge)
     */
    public function count()
    {
        $identifier = $this->getCartIdentifier();
        $count = Cart::where($identifier)->sum('quantity');

        return response()->json([
            'count' => $count
        ]);
    }
}
