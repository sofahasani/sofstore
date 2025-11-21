<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Success - Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'SF Pro', 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: #f9fafb;
        }
        .progress-line {
            position: relative;
            height: 2px;
            background: #e5e7eb;
            flex: 1;
        }
        .progress-line.active {
            background: #fbbf24;
        }
        .progress-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            position: relative;
            z-index: 2;
        }
        .progress-dot.active {
            background: #fbbf24;
            color: #fff;
        }
        .progress-dot.completed {
            background: #374151;
            color: #fff;
        }
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 100;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        .checkmark-circle {
            animation: scaleIn 0.5s ease-out;
        }
        .checkmark-check {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: checkmark 0.5s ease-out 0.3s forwards;
        }
        
        /* Print Styles for PDF */
        @media print {
            @page {
                margin: 0;
                size: A4;
            }
            body {
                background: white;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .print-content {
                display: block !important;
                max-width: 100%;
                padding: 40px;
                background: white;
            }
            .invoice-header {
                border-bottom: 3px solid #ff7300;
                padding-bottom: 20px;
                margin-bottom: 30px;
            }
            .invoice-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            .invoice-table th,
            .invoice-table td {
                padding: 12px;
                border-bottom: 1px solid #e5e7eb;
                text-align: left;
            }
            .invoice-table th {
                background: #f9fafb;
                font-weight: 600;
                color: #374151;
            }
            .total-section {
                background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
                color: white;
                padding: 20px;
                border-radius: 12px;
                margin-top: 20px;
            }
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 120px;
                opacity: 0.05;
                font-weight: 900;
                color: #ff7300;
                z-index: -1;
                pointer-events: none;
            }
        }
        
        @media screen {
            .print-content {
                display: none;
            }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #ff7300, #ff9500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: linear-gradient(135deg, rgba(255,115,0,0.1), rgba(255,149,0,0.1));
            border: 1px solid rgba(255,115,0,0.2);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #ff7300;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 z-10 px-5 py-4">
            <div class="flex items-center justify-between mb-4">
                <button onclick="window.location.href='{{ route('dashboard') }}'" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Checkout Details</h1>
                <div class="w-6"></div>
            </div>
            
            <!-- Progress Bar -->
            <div class="flex items-center justify-between mb-3">
                <div class="progress-dot completed">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                    </svg>
                </div>
                <div class="progress-line active"></div>
                <div class="progress-dot completed">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
                <div class="progress-line active"></div>
                <div class="progress-dot active">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            
            <div class="flex justify-between text-xs text-gray-500">
                <span>Bag</span>
                <span>Address</span>
                <span class="font-medium text-amber-500">Payment</span>
            </div>
        </div>

        <!-- Success Content -->
        <div class="px-5 py-12 pb-32 flex flex-col items-center">
            <!-- Success Icon -->
            <div class="mb-8 checkmark-circle">
                <svg class="w-24 h-24" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="#10b981" opacity="0.1"/>
                    <circle cx="50" cy="50" r="40" fill="#10b981" opacity="0.2"/>
                    <circle cx="50" cy="50" r="35" fill="#10b981"/>
                    <path class="checkmark-check" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M30 50 L42 62 L70 34"/>
                </svg>
            </div>

            <!-- Success Card -->
            <div class="w-full border-2 border-blue-400 rounded-3xl p-6 bg-white">
                <h2 class="text-xl font-bold text-gray-900 text-center mb-2">Payment Success!</h2>
                <p class="text-sm text-gray-500 text-center mb-6">Your payment has been successfully done.</p>
                
                <div class="space-y-4 mb-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-1">Total Payment</p>
                        <p class="text-3xl font-bold text-red-500">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Ref Number</p>
                        <p class="font-semibold text-gray-900">{{ $checkoutData['ref_number'] ?? '000085752257' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Payment Time</p>
                        <p class="font-semibold text-gray-900">{{ $checkoutData['payment_time'] ?? date('d M Y, H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                        <p class="font-semibold text-gray-900">{{ $checkoutData['payment_method'] == 'credit_card' ? 'Credit Card' : 'COD' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Sender Name</p>
                        <p class="font-semibold text-gray-900">{{ $checkoutData['cardholder_name'] ?? 'Customer' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="w-full mt-6 bg-gray-50 rounded-2xl p-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">Order Details</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/80x80/f3f4f6/aaa&text=No+Image' }}" 
                         alt="{{ $product->name }}" 
                         class="w-16 h-16 object-cover rounded-xl">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 text-sm">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Quantity: 1</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="w-full mt-4 bg-gray-50 rounded-2xl p-4">
                <h3 class="font-semibold text-gray-900 mb-2 text-sm">Shipping Address</h3>
                <p class="text-sm text-gray-700">
                    {{ $checkoutData['address'] ?? 'N/A' }}<br>
                    {{ $checkoutData['locality'] ?? '' }}, {{ $checkoutData['city'] ?? '' }}<br>
                    {{ $checkoutData['state'] ?? '' }} - {{ $checkoutData['pincode'] ?? '' }}
                </p>
            </div>
        </div>

        <!-- Fixed Bottom Button -->
        <div class="fixed bottom-0 left-0 right-0 bg-white px-5 py-5 max-w-md mx-auto border-t border-gray-200 no-print">
            <!-- Invoice Button dengan Loading Animation Mewah -->
            <button 
                id="sendInvoiceBtn"
                onclick="sendInvoiceEmail()"
                class="w-full bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-800 text-white font-bold py-4 rounded-xl shadow-2xl hover:shadow-purple-500/50 transition-all duration-300 active:scale-95 flex items-center justify-center gap-3 mb-3 relative overflow-hidden group"
                style="background-size: 200% 200%; animation: gradientShift 3s ease infinite;"
            >
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-700"></span>
                <svg id="emailIcon" class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span id="btnText" class="relative z-10 text-lg">📧 Kirim Invoice ke Email</span>
                
                <!-- Loading Spinner Mewah (Hidden by default) -->
                <div id="loadingSpinner" class="hidden">
                    <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
            
            <button 
                onclick="window.print()"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-4 rounded-xl shadow-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 active:scale-95 flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Download PDF Invoice
            </button>
            <div class="flex gap-3 mt-3">
                <button 
                    onclick="window.location.href='{{ route('dashboard') }}'"
                    class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 rounded-xl hover:bg-gray-200 transition text-sm"
                >
                    Back to Home
                </button>
                <button 
                    onclick="window.location.href='{{ route('dashboard') }}'"
                    class="flex-1 bg-blue-500 text-white font-medium py-3 rounded-xl hover:bg-blue-600 transition text-sm"
                >
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>

    <!-- Modern PDF Invoice Content (Hidden on Screen, Visible on Print) -->
    <div class="print-content">
        <!-- Watermark -->
        <div class="watermark">PAID</div>
        
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h1 style="font-size: 36px; font-weight: 800; margin: 0; background: linear-gradient(135deg, #ff7300, #ff9500); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        INVOICE
                    </h1>
                    <p style="font-size: 14px; color: #6b7280; margin-top: 8px;">
                        Official Payment Receipt
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 20px; margin-bottom: 12px;">
                        <svg style="width: 20px; height: 20px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span style="color: white; font-weight: 600; font-size: 14px;">PAID</span>
                    </div>
                    <p style="font-size: 13px; color: #6b7280; margin: 0;">Invoice #{{ $checkoutData['ref_number'] ?? '000085752257' }}</p>
                    <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Date: {{ $checkoutData['payment_time'] ?? date('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Company & Customer Info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
            <!-- From -->
            <div>
                <h3 style="font-size: 12px; font-weight: 700; color: #ff7300; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; border-bottom: 2px solid #ff7300; padding-bottom: 8px;">
                    From
                </h3>
                <h4 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">
                    ProjectWahab Store
                </h4>
                <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0;">
                    Jl. Raya Commerce No. 123<br>
                    Jakarta Selatan, DKI Jakarta<br>
                    Indonesia, 12345<br>
                    <br>
                    <strong>Phone:</strong> +62 821-1234-5678<br>
                    <strong>Email:</strong> support@projectwahab.com<br>
                    <strong>Website:</strong> www.projectwahab.com
                </p>
            </div>

            <!-- To -->
            <div>
                <h3 style="font-size: 12px; font-weight: 700; color: #ff7300; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; border-bottom: 2px solid #ff7300; padding-bottom: 8px;">
                    Bill To
                </h3>
                <h4 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">
                    {{ $checkoutData['cardholder_name'] ?? 'Customer Name' }}
                </h4>
                <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0;">
                    {{ $checkoutData['address'] ?? 'Customer Address' }}<br>
                    {{ $checkoutData['locality'] ?? 'Locality' }}, {{ $checkoutData['city'] ?? 'City' }}<br>
                    {{ $checkoutData['state'] ?? 'State' }} - {{ $checkoutData['pincode'] ?? 'Pincode' }}<br>
                    <br>
                    <strong>Phone:</strong> {{ $checkoutData['phone'] ?? '+62 XXX-XXXX-XXXX' }}<br>
                    <strong>Email:</strong> {{ $checkoutData['email'] ?? 'customer@email.com' }}
                </p>
            </div>
        </div>

        <!-- Payment Information -->
        <div style="background: linear-gradient(135deg, rgba(255,115,0,0.05), rgba(255,149,0,0.05)); border: 1px solid rgba(255,115,0,0.2); border-radius: 12px; padding: 20px; margin-bottom: 30px;">
            <h3 style="font-size: 14px; font-weight: 700; color: #111827; margin: 0 0 16px 0;">
                💳 Payment Information
            </h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div>
                    <p style="font-size: 11px; color: #6b7280; margin: 0 0 4px 0; text-transform: uppercase; font-weight: 600;">Payment Method</p>
                    <p style="font-size: 14px; font-weight: 600; color: #111827; margin: 0;">
                        {{ $checkoutData['payment_method'] == 'credit_card' ? 'Credit Card' : 'Cash on Delivery' }}
                    </p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #6b7280; margin: 0 0 4px 0; text-transform: uppercase; font-weight: 600;">Transaction ID</p>
                    <p style="font-size: 14px; font-weight: 600; color: #111827; margin: 0;">
                        #{{ $checkoutData['ref_number'] ?? '000085752257' }}
                    </p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #6b7280; margin: 0 0 4px 0; text-transform: uppercase; font-weight: 600;">Payment Date</p>
                    <p style="font-size: 14px; font-weight: 600; color: #111827; margin: 0;">
                        {{ date('d M Y') }}
                    </p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #6b7280; margin: 0 0 4px 0; text-transform: uppercase; font-weight: 600;">Status</p>
                    <p style="font-size: 14px; font-weight: 600; color: #10b981; margin: 0;">
                        ✓ Completed
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Details Table -->
        <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin: 0 0 16px 0;">
            📦 Order Details
        </h3>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">#</th>
                    <th>Product Description</th>
                    <th style="width: 100px; text-align: center;">Quantity</th>
                    <th style="width: 150px; text-align: right;">Unit Price</th>
                    <th style="width: 150px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: 600; color: #6b7280;">1</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/60x60/f3f4f6/aaa&text=No+Image' }}" 
                                 alt="{{ $product->name }}" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div>
                                <p style="font-weight: 600; color: #111827; margin: 0; font-size: 14px;">{{ $product->name }}</p>
                                <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">{{ $product->description ?? 'Premium Quality Product' }}</p>
                                @if($product->brand)
                                <p style="font-size: 11px; color: #9ca3af; margin: 2px 0 0 0;">Brand: {{ $product->brand }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #374151;">1</td>
                    <td style="text-align: right; font-weight: 600; color: #374151;">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td style="text-align: right; font-weight: 700; color: #111827;">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Pricing Summary -->
        <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
            <div style="width: 400px;">
                <div style="border-top: 2px solid #e5e7eb; padding-top: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="color: #6b7280; font-size: 14px;">Subtotal</span>
                        <span style="color: #374151; font-weight: 600; font-size: 14px;">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="color: #6b7280; font-size: 14px;">Shipping Fee</span>
                        <span style="color: #10b981; font-weight: 600; font-size: 14px;">FREE</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="color: #6b7280; font-size: 14px;">Tax (0%)</span>
                        <span style="color: #374151; font-weight: 600; font-size: 14px;">Rp0</span>
                    </div>
                    
                    <div class="total-section" style="margin-top: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; opacity: 0.9;">Total Amount</p>
                                <p style="margin: 4px 0 0 0; font-size: 28px; font-weight: 800;">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <svg style="width: 50px; height: 50px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Notes -->
        <div style="margin-top: 50px; padding-top: 30px; border-top: 2px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <div>
                    <h4 style="font-size: 13px; font-weight: 700; color: #111827; margin: 0 0 12px 0;">📝 Notes & Terms</h4>
                    <ul style="font-size: 12px; color: #6b7280; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>This is a computer-generated invoice and requires no signature</li>
                        <li>Payment has been successfully processed and confirmed</li>
                        <li>Please retain this invoice for your records</li>
                        <li>For any queries, contact our support team</li>
                        <li>All sales are subject to our terms and conditions</li>
                    </ul>
                </div>
                <div>
                    <h4 style="font-size: 13px; font-weight: 700; color: #111827; margin: 0 0 12px 0;">📞 Customer Support</h4>
                    <p style="font-size: 12px; color: #6b7280; line-height: 1.8; margin: 0;">
                        <strong>Need help?</strong> Our customer support team is available 24/7<br>
                        <strong>Email:</strong> support@projectwahab.com<br>
                        <strong>Phone:</strong> +62 821-1234-5678<br>
                        <strong>WhatsApp:</strong> +62 821-1234-5678<br>
                        <strong>Hours:</strong> Monday - Sunday, 24/7
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom Signature & Stamp -->
        <div style="margin-top: 50px; text-align: center; padding: 30px 0; border-top: 1px solid #e5e7eb;">
            <p style="font-size: 11px; color: #9ca3af; margin: 0 0 8px 0;">
                This is an electronically generated invoice and is valid without a signature or stamp
            </p>
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px;">
                <svg style="width: 20px; height: 20px; color: #ff7300;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span style="font-size: 12px; font-weight: 600; color: #ff7300;">Verified & Secured Transaction</span>
            </div>
            <p style="font-size: 10px; color: #9ca3af; margin: 16px 0 0 0;">
                © {{ date('Y') }} ProjectWahab Store. All rights reserved. | Generated on {{ date('d M Y H:i:s') }}
            </p>
        </div>
    </div>

    <!-- CSS Animations untuk Button -->
    <style>
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        #sendInvoiceBtn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        /* Loading Modal Mewah */
        #loadingModal {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .spinner-ring {
            animation: rotate 1s linear infinite;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .modal-content {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <!-- Loading Modal Mewah -->
    <div id="loadingModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl">
            <!-- Spinner Mewah -->
            <div class="mb-6 relative">
                <div class="spinner-ring w-20 h-20 mx-auto">
                    <svg class="w-20 h-20" viewBox="0 0 50 50">
                        <circle cx="25" cy="25" r="20" fill="none" stroke="#e5e7eb" stroke-width="4"></circle>
                        <circle cx="25" cy="25" r="20" fill="none" stroke="url(#gradient)" stroke-width="4" 
                                stroke-linecap="round" stroke-dasharray="31.4 31.4" stroke-dashoffset="0">
                        </circle>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#8B5CF6;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#6366F1;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-3xl">📧</span>
                    </div>
                </div>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Mengirim Invoice...</h3>
            <p class="text-gray-600 text-sm mb-4" id="loadingText">Mohon tunggu sebentar</p>
            
            <div class="flex items-center justify-center gap-1">
                <div class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk AJAX & Loading -->
    <script>
        const orderId = {{ session('order_id') ?? 'null' }};
        
        async function sendInvoiceEmail() {
            if (!orderId) {
                showNotification('❌ Order ID tidak ditemukan', 'error');
                return;
            }
            
            const button = document.getElementById('sendInvoiceBtn');
            const btnText = document.getElementById('btnText');
            const emailIcon = document.getElementById('emailIcon');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loadingModal = document.getElementById('loadingModal');
            
            // Disable button
            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
            
            // Show loading modal
            loadingModal.classList.remove('hidden');
            
            try {
                const response = await fetch(`/invoice/send/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                // Hide loading modal
                loadingModal.classList.add('hidden');
                
                if (data.success) {
                    // Success animation
                    button.classList.remove('from-purple-600', 'via-purple-700', 'to-indigo-800');
                    button.classList.add('from-green-600', 'via-green-700', 'to-emerald-800');
                    btnText.innerHTML = '✅ Invoice Terkirim!';
                    
                    showNotification(data.message, 'success');
                    
                    // Reset after 3 seconds
                    setTimeout(() => {
                        button.classList.remove('from-green-600', 'via-green-700', 'to-emerald-800');
                        button.classList.add('from-purple-600', 'via-purple-700', 'to-indigo-800');
                        btnText.innerHTML = '📧 Kirim Invoice ke Email';
                        button.disabled = false;
                        button.classList.remove('opacity-70', 'cursor-not-allowed');
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Gagal mengirim invoice');
                }
                
            } catch (error) {
                // Hide loading modal
                loadingModal.classList.add('hidden');
                
                // Error state
                button.classList.remove('from-purple-600', 'via-purple-700', 'to-indigo-800');
                button.classList.add('from-red-600', 'via-red-700', 'to-rose-800');
                btnText.innerHTML = '❌ Gagal Mengirim';
                
                showNotification(error.message || 'Terjadi kesalahan saat mengirim invoice', 'error');
                
                // Reset after 3 seconds
                setTimeout(() => {
                    button.classList.remove('from-red-600', 'via-red-700', 'to-rose-800');
                    button.classList.add('from-purple-600', 'via-purple-700', 'to-indigo-800');
                    btnText.innerHTML = '📧 Kirim Invoice ke Email';
                    button.disabled = false;
                    button.classList.remove('opacity-70', 'cursor-not-allowed');
                }, 3000);
            }
        }
        
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-[100] px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-gradient-to-r from-green-500 to-emerald-600' 
                    : 'bg-gradient-to-r from-red-500 to-rose-600'
            } text-white font-semibold max-w-md`;
            notification.style.animation = 'slideInRight 0.5s ease-out';
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease-out';
                setTimeout(() => notification.remove(), 500);
            }, 4000);
        }
        
        // Animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(400px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
