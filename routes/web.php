<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReviewController;

// Welcome & Home pages
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome.page');

// Home route (alias to dashboard)
Route::get('/home', [ProductController::class, 'index'])->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Social Authentication Routes
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');
Route::get('/auth/{provider}/mock', [SocialAuthController::class, 'handleMockCallback'])->name('social.callback.mock');

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return back()->with('status', 'Password reset link sent!');
})->name('password.email');

// Profile routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/username', [ProfileController::class, 'updateUsername'])->name('profile.update.username');
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture');
    
    // Settings Page
    Route::get('/settings', function() {
        return view('settings');
    })->name('settings');
});

// Dashboard & Shop Routes - Public (no login required)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/shop', function () {
    return view('dashboard');
})->name('shop');

// Product CRUD resource route
Route::resource('products', ProductController::class);

// Report Routes
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Cart Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

// Checkout Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::get('/checkout/address', function() {
        return redirect()->route('checkout.create');
    });
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.store-address');
    Route::get('/checkout/payment', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'storePayment'])->name('checkout.store-payment');
});

// Search Route - Public
Route::get('/search', function () {
    return request('query');
})->name('search');

// Orders Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Wishlist Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/wishlist/check/{product_id}', [WishlistController::class, 'check'])->name('wishlist.check');
});

// Help Routes - Public
Route::get('/help', [HelpController::class, 'index'])->name('help.index');

// Chat Routes
Route::middleware(['auth'])->group(function () {
    // User Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/read', [ChatController::class, 'markAsRead'])->name('chat.read');
    
    // Admin Chat Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/chat', [ChatController::class, 'adminIndex'])->name('chat.admin.index');
        Route::get('/admin/chat/user/{userId}/messages', [ChatController::class, 'getUserMessages'])->name('chat.admin.user.messages');
        Route::post('/admin/chat/reply', [ChatController::class, 'adminReply'])->name('chat.admin.reply');
    });
});

// Recommendation Engine Routes
Route::get('/api/recommendations/personalized', [RecommendationController::class, 'getPersonalizedRecommendations'])->name('recommendations.personalized');
Route::get('/api/recommendations/trending', [RecommendationController::class, 'getTrendingProducts'])->name('recommendations.trending');
Route::get('/api/recommendations/similar/{productId}', [RecommendationController::class, 'getSimilarProducts'])->name('recommendations.similar');
Route::get('/api/recommendations/frequently-bought/{productId}', [RecommendationController::class, 'getFrequentlyBoughtTogether'])->name('recommendations.frequently');
Route::get('/api/recommendations/price-alerts', [RecommendationController::class, 'getPriceDropAlerts'])->name('recommendations.alerts');
Route::post('/api/recommendations/track-view/{productId}', [RecommendationController::class, 'trackView'])->name('recommendations.track');

// Admin Routes - Protected by AdminMiddleware
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/stats', [AdminController::class, 'getStats'])->name('admin.stats');
    Route::get('/sales-chart', [AdminController::class, 'getSalesChart'])->name('admin.sales-chart');
    Route::get('/top-categories', [AdminController::class, 'getTopCategories'])->name('admin.top-categories');
    Route::get('/recent-products', [AdminController::class, 'getRecentProducts'])->name('admin.recent-products');
    Route::get('/top-products', [AdminController::class, 'getTopProducts'])->name('admin.top-products');
    Route::get('/reports-overview', [AdminController::class, 'getReportsOverview'])->name('admin.reports-overview');
    
    // Orders Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
});

// User Order Routes - Protected by Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::post('/my-orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
});

// Invoice Routes - Protected by Auth
Route::middleware(['auth'])->group(function () {
    Route::post('/invoice/send/{orderId}', [InvoiceController::class, 'send'])->name('invoice.send');
});

// Review Routes - Protected by Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
