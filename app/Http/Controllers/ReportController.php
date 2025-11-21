<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|in:fake,scam,inappropriate,prohibited,misleading,copyright,other',
            'description' => 'nullable|string|max:500',
        ]);

        $report = Report::create([
            'product_id' => $validated['product_id'],
            'user_id' => Auth::id(), // nullable, bisa guest
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
            'reporter_ip' => $request->ip(),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim. Terima kasih!',
            'report_id' => $report->id,
        ]);
    }

    /**
     * Display all reports (admin only)
     */
    public function index()
    {
        $reports = Report::with(['product', 'reporter', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show report detail
     */
    public function show(Report $report)
    {
        $report->load(['product', 'reporter', 'reviewer']);
        
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Update report status
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diupdate',
        ]);
    }

    /**
     * Delete report
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dihapus',
        ]);
    }

    /**
     * Get statistics
     */
    public function stats()
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'reviewed' => Report::where('status', 'reviewed')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
            'today' => Report::whereDate('created_at', today())->count(),
            'this_week' => Report::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return response()->json($stats);
    }
}
