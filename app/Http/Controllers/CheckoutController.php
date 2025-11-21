<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;

class CheckoutController extends Controller
{
    /**
     * Get cart identifier
     */
    private function getCartIdentifier()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id()];
        }
        return ['session_id' => session('cart_session_id')];
    }

    /**
     * Show checkout page - support both single product and cart
     */
    public function create(Request $request)
    {
        // Check if buying from cart or direct product
        $fromCart = $request->query('from_cart', false);
        
        if ($fromCart) {
            // Get all cart items
            $identifier = $this->getCartIdentifier();
            $cartItems = Cart::with('product')->where($identifier)->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty');
            }
            
            $total = $cartItems->sum('subtotal');
            
            return view('checkout.step1-address', compact('cartItems', 'total', 'fromCart'));
        } else {
            // Direct buy single product (old flow)
            $productId = $request->query('product_id');
            
            if (!$productId) {
                return redirect()->route('dashboard')->with('error', 'Product not found');
            }
            
            $product = Product::findOrFail($productId);
            
            // Check stock
            if ($product->stock < 1) {
                return redirect()->back()->with('error', 'Product is out of stock');
            }
            
            return view('checkout.step1-address', compact('product'));
        }
    }
    
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'address_type' => 'required|in:Home,Office,Other',
        ]);
        
        // Store address data in session
        session(['checkout_data' => $validated]);
        
        // Redirect to payment page (GET request) to avoid refresh issues
        return redirect()->route('checkout.payment', ['product_id' => $request->product_id]);
    }
    
    public function showPayment(Request $request)
    {
        // Get product_id from query or session
        $productId = $request->query('product_id');
        
        if (!$productId) {
            // Try to get from session
            $checkoutData = session('checkout_data');
            $productId = $checkoutData['product_id'] ?? null;
        }
        
        if (!$productId) {
            return redirect()->route('checkout.create')->with('error', 'Please complete address step first');
        }
        
        $product = Product::findOrFail($productId);
        
        return view('checkout.step2-payment', compact('product'));
    }
    
    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required|in:credit_card,cod',
            'card_number' => 'required_if:payment_method,credit_card',
            'cardholder_name' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
        ]);
        
        // Get address data from session
        $checkoutData = session('checkout_data', []);
        
        // Merge payment data
        $checkoutData = array_merge($checkoutData, $validated);
        
        // Generate order reference number
        $refNumber = str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
        $checkoutData['ref_number'] = $refNumber;
        $checkoutData['payment_time'] = now()->format('d M Y, H:i');
        
        // Store complete data in session
        session(['checkout_data' => $checkoutData]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Reduce product stock and increment total_sold after successful payment
        if ($product->stock > 0) {
            $product->decrement('stock', 1);
        }
        $product->increment('total_sold', 1);
        
        // Save order to database
        $order = Order::create([
            'ref_number' => $refNumber,
            'user_id' => auth()->id(), // null if guest checkout
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'product_price' => $product->price,
            'product_image' => $product->image,
            'quantity' => 1,
            'total_amount' => $product->price,
            'customer_email' => $checkoutData['email'],
            'address' => $checkoutData['address'],
            'locality' => $checkoutData['locality'],
            'city' => $checkoutData['city'],
            'state' => $checkoutData['state'],
            'pincode' => $checkoutData['pincode'],
            'address_type' => $checkoutData['address_type'],
            'payment_method' => $validated['payment_method'],
            'cardholder_name' => $validated['cardholder_name'] ?? 'Guest',
            'card_number' => isset($validated['card_number']) ? 'xxxx-' . substr($validated['card_number'], -4) : null,
            'payment_time' => now(),
            'status' => 'processing',
        ]);
        
        // Store order_id in session for invoice email
        session(['order_id' => $order->id]);
        
        return view('checkout.step3-success', compact('product', 'checkoutData'));
    }
}
