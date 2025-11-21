<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Get statistics for dashboard cards
     */
    public function getStats()
    {
        // Daily Sales (simulated - you can replace with actual orders table)
        $dailySales = Product::whereDate('created_at', Carbon::today())
            ->sum('total_sold') ?? 0;

        // Monthly Revenue (simulated based on products sold)
        $monthlyRevenue = Product::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum(DB::raw('price * total_sold')) ?? 0;

        // New Orders (products created today - replace with actual orders)
        $newOrders = Product::whereDate('created_at', Carbon::today())->count();

        // Total Products Sold
        $productsSold = Product::sum('total_sold') ?? 0;

        // Total Active Products
        $totalProducts = Product::where('is_active', true)->count();

        // Pending Reports
        $pendingReports = Report::where('status', 'pending')->count();

        return response()->json([
            'dailySales' => number_format($dailySales, 0, ',', '.'),
            'monthlyRevenue' => 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'),
            'newOrders' => $newOrders,
            'productsSold' => number_format($productsSold, 0, ',', '.'),
            'totalProducts' => $totalProducts,
            'pendingReports' => $pendingReports,
        ]);
    }

    /**
     * Get sales chart data (line chart - sales per day for last 7 days)
     */
    public function getSalesChart()
    {
        $salesData = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D, M j'); // Mon, Jan 1

            // Sum of products sold on that day (replace with actual order totals)
            $daySales = Product::whereDate('created_at', $date)
                ->sum(DB::raw('price * total_sold')) ?? 0;
            
            $salesData[] = $daySales;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $salesData,
        ]);
    }

    /**
     * Get top products/categories for bar chart
     */
    public function getTopCategories()
    {
        $categories = Product::select('category', DB::raw('COUNT(*) as count'))
            ->where('is_active', true)
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $labels = $categories->pluck('category')->toArray();
        $data = $categories->pluck('count')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Get recent products (simulating orders)
     */
    public function getRecentProducts()
    {
        $products = Product::with('reports')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category ?? 'Tidak Ada Kategori',
                    'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'stock' => $product->stock ?? 0,
                    'status' => $product->is_active ? 'Aktif' : 'Nonaktif',
                    'total_sold' => $product->total_sold ?? 0,
                    'created_at' => $product->created_at->diffForHumans(),
                ];
            });

        return response()->json($products);
    }

    /**
     * Get top selling products
     */
    public function getTopProducts()
    {
        $products = Product::where('is_active', true)
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'category' => $product->category ?? 'Lainnya',
                    'sold' => $product->total_sold ?? 0,
                    'revenue' => 'Rp ' . number_format(($product->price * ($product->total_sold ?? 0)), 0, ',', '.'),
                ];
            });

        return response()->json($products);
    }

    /**
     * Get reports overview
     */
    public function getReportsOverview()
    {
        $pending = Report::where('status', 'pending')->count();
        $reviewed = Report::where('status', 'reviewed')->count();
        $resolved = Report::where('status', 'resolved')->count();
        $dismissed = Report::where('status', 'dismissed')->count();

        return response()->json([
            'pending' => $pending,
            'reviewed' => $reviewed,
            'resolved' => $resolved,
            'dismissed' => $dismissed,
            'total' => $pending + $reviewed + $resolved + $dismissed,
        ]);
    }

    /**
     * Display orders list
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'product'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ref_number', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('cardholder_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display single order
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status and tracking
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_status' => 'nullable|string|max:255',
            'tracking_notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_status' => $request->tracking_status,
            'tracking_notes' => $request->tracking_notes,
            'status_updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}

