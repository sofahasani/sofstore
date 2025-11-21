<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Send invoice email to customer
     */
    public function send(Request $request, $orderId)
    {
        try {
            // Find order
            $order = Order::with('product')->findOrFail($orderId);
            
            // Validate email
            if (!$order->customer_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email pelanggan tidak ditemukan'
                ], 400);
            }
            
            // Send email
            Mail::to($order->customer_email)->send(new InvoiceMail($order));
            
            // Log success
            Log::info('Invoice sent successfully', [
                'order_id' => $order->id,
                'customer_email' => $order->customer_email
            ]);
            
            return response()->json([
                'success' => true,
                'message' => '✅ Invoice berhasil dikirim ke ' . $order->customer_email
            ]);
            
        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to send invoice', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal mengirim invoice: ' . $e->getMessage()
            ], 500);
        }
    }
}
