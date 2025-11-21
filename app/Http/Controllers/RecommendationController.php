<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use App\Models\ProductRecommendation;
use App\Models\PriceAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RecommendationController extends Controller
{
    /**
     * Get personalized recommendations for dashboard
     */
    public function getPersonalizedRecommendations(Request $request)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();
        
        $cacheKey = $userId ? "recommendations_user_{$userId}" : "recommendations_session_{$sessionId}";
        
        $recommendations = Cache::remember($cacheKey, 3600, function () use ($userId, $sessionId) {
            return $this->calculatePersonalizedRecommendations($userId, $sessionId);
        });

        return response()->json([
            'success' => true,
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Get trending products (last 24 hours)
     */
    public function getTrendingProducts()
    {
        $trending = Cache::remember('trending_products', 1800, function () {
            return ProductView::select('product_id', DB::raw('COUNT(*) as view_count'))
                ->where('created_at', '>=', now()->subDay())
                ->groupBy('product_id')
                ->orderByDesc('view_count')
                ->limit(8)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    $product = $item->product;
                    if (!$product) return null;
                    
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image ? asset('storage/' . $product->image) : null,
                        'category' => $product->category,
                        'rating' => 4.8, // Default rating
                        'views' => $item->view_count,
                    ];
                })
                ->filter()
                ->values();
        });

        return response()->json([
            'success' => true,
            'trending' => $trending,
        ]);
    }

    /**
     * Get similar products for product detail page
     */
    public function getSimilarProducts($productId)
    {
        $cacheKey = "similar_products_{$productId}";
        
        $similar = Cache::remember($cacheKey, 3600, function () use ($productId) {
            $product = Product::find($productId);
            if (!$product) return [];

            // Get similar products by category and brand
            return Product::where('id', '!=', $productId)
                ->where(function ($query) use ($product) {
                    $query->where('category', $product->category)
                          ->orWhere('brand', $product->brand);
                })
                ->where('price', '>=', $product->price * 0.7)
                ->where('price', '<=', $product->price * 1.3)
                ->inRandomOrder()
                ->limit(4)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'image' => $item->image ? asset('storage/' . $item->image) : null,
                        'category' => $item->category,
                        'brand' => $item->brand,
                        'rating' => 4.7,
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'similar' => $similar,
        ]);
    }

    /**
     * Get frequently bought together products
     */
    public function getFrequentlyBoughtTogether($productId)
    {
        $cacheKey = "frequently_bought_{$productId}";
        
        $frequently = Cache::remember($cacheKey, 3600, function () use ($productId) {
            // Simulated data - In real app, analyze order history
            return Product::where('id', '!=', $productId)
                ->inRandomOrder()
                ->limit(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'image' => $item->image ? asset('storage/' . $item->image) : null,
                        'discount' => 10, // 10% bundle discount
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'frequently' => $frequently,
        ]);
    }

    /**
     * Get price drop alerts for user
     */
    public function getPriceDropAlerts()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        $alerts = PriceAlert::where('user_id', Auth::id())
            ->unnotified()
            ->significantDiscount(5)
            ->with('product')
            ->orderByDesc('discount_percentage')
            ->get()
            ->map(function ($alert) {
                return [
                    'id' => $alert->id,
                    'product' => [
                        'id' => $alert->product->id,
                        'name' => $alert->product->name,
                        'image' => $alert->product->image ? asset('storage/' . $alert->product->image) : null,
                    ],
                    'original_price' => $alert->original_price,
                    'current_price' => $alert->current_price,
                    'discount_percentage' => $alert->discount_percentage,
                    'savings' => $alert->original_price - $alert->current_price,
                ];
            });

        return response()->json([
            'success' => true,
            'alerts' => $alerts,
        ]);
    }

    /**
     * Track product view
     */
    public function trackView(Request $request, $productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false], 404);
        }

        ProductView::create([
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'product_id' => $productId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Calculate personalized recommendations
     */
    private function calculatePersonalizedRecommendations($userId, $sessionId)
    {
        // Get user's recent views
        $recentViews = ProductView::forUserOrSession($userId, $sessionId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->pluck('product_id');

        if ($recentViews->isEmpty()) {
            // Return popular products for new users
            return Product::inRandomOrder()->limit(8)->get()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                    'category' => $product->category,
                    'rating' => 4.7,
                ];
            });
        }

        // Get categories and brands from viewed products
        $viewedProducts = Product::whereIn('id', $recentViews)->get();
        $categories = $viewedProducts->pluck('category')->unique();
        $brands = $viewedProducts->pluck('brand')->unique()->filter();

        // Get recommended products
        return Product::whereNotIn('id', $recentViews)
            ->where(function ($query) use ($categories, $brands) {
                $query->whereIn('category', $categories);
                if ($brands->isNotEmpty()) {
                    $query->orWhereIn('brand', $brands);
                }
            })
            ->inRandomOrder()
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                    'category' => $product->category,
                    'brand' => $product->brand,
                    'rating' => 4.7,
                ];
            });
    }
}
