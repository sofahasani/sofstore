<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoiceNumber }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f7fa; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="650" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1); max-width: 650px;">
                    
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 50%, #FFB84D 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 10px;">🛍️</div>
                            <h1 style="color: #ffffff; font-size: 32px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">Invoice Pembelian</h1>
                            <p style="color: rgba(255,255,255,0.95); font-size: 16px; margin: 0;">Terima kasih telah berbelanja di Project Wahab!</p>
                            <div style="background: rgba(255,255,255,0.25); border: 2px solid rgba(255,255,255,0.4); padding: 12px 25px; border-radius: 50px; display: inline-block; margin-top: 20px;">
                                <span style="color: #ffffff; font-size: 16px; font-weight: 700; letter-spacing: 1px;">{{ $invoiceNumber }}</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Customer Info -->
                    <tr>
                        <td style="padding: 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" style="vertical-align: top; padding-right: 20px;">
                                        <h3 style="color: #2d3748; font-size: 14px; font-weight: 600; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">Invoice Untuk:</h3>
                                        <p style="color: #1a202c; font-size: 18px; font-weight: 700; margin: 0 0 8px 0;">{{ $order->cardholder_name }}</p>
                                        <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                                            {{ $order->address }}<br>
                                            {{ $order->locality }}, {{ $order->city }}<br>
                                            {{ $order->state }} - {{ $order->pincode }}
                                        </p>
                                    </td>
                                    <td width="50%" style="vertical-align: top; text-align: right;">
                                        <h3 style="color: #2d3748; font-size: 14px; font-weight: 600; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">Detail Invoice:</h3>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; padding: 4px 0; text-align: right;">Tanggal:</td>
                                                <td style="color: #1a202c; font-size: 14px; font-weight: 600; padding: 4px 0 4px 15px; text-align: right; white-space: nowrap;">{{ $orderDate }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; padding: 4px 0; text-align: right;">Ref Number:</td>
                                                <td style="color: #1a202c; font-size: 14px; font-weight: 600; padding: 4px 0 4px 15px; text-align: right;">{{ $order->ref_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; padding: 4px 0; text-align: right;">Payment:</td>
                                                <td style="color: #1a202c; font-size: 14px; font-weight: 600; padding: 4px 0 4px 15px; text-align: right;">{{ $order->payment_method == 'credit_card' ? 'Credit Card' : 'COD' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Order Items Table -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                                <!-- Table Header -->
                                <tr style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);">
                                    <th style="padding: 18px 20px; text-align: left; color: #2d3748; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #cbd5e0;">Produk</th>
                                    <th style="padding: 18px 20px; text-align: center; color: #2d3748; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #cbd5e0; width: 80px;">Qty</th>
                                    <th style="padding: 18px 20px; text-align: right; color: #2d3748; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #cbd5e0; width: 120px;">Harga</th>
                                    <th style="padding: 18px 20px; text-align: right; color: #2d3748; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #cbd5e0; width: 130px;">Total</th>
                                </tr>
                                <!-- Product Row -->
                                <tr>
                                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                @if($order->product_image)
                                                <td style="padding-right: 15px;">
                                                    <img src="{{ asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid #f7fafc; display: block;">
                                                </td>
                                                @endif
                                                <td style="vertical-align: top;">
                                                    <div style="color: #1a202c; font-size: 16px; font-weight: 600; margin-bottom: 4px;">{{ $order->product_name }}</div>
                                                    <div style="color: #718096; font-size: 13px; line-height: 1.4;">{{ Str::limit($order->product_description ?? '', 60) }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 20px; text-align: center; border-bottom: 1px solid #e2e8f0;">
                                        <span style="background: #f7fafc; padding: 6px 16px; border-radius: 20px; color: #2d3748; font-size: 14px; font-weight: 600;">{{ $order->quantity }}</span>
                                    </td>
                                    <td style="padding: 20px; text-align: right; color: #4a5568; font-size: 15px; font-weight: 500; border-bottom: 1px solid #e2e8f0; white-space: nowrap;">Rp{{ number_format($order->product_price, 0, ',', '.') }}</td>
                                    <td style="padding: 20px; text-align: right; color: #1a202c; font-size: 16px; font-weight: 700; border-bottom: 1px solid #e2e8f0; white-space: nowrap;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <!-- Subtotal -->
                                <tr>
                                    <td colspan="3" style="padding: 18px 20px; text-align: right; color: #4a5568; font-size: 15px; font-weight: 500;">Subtotal:</td>
                                    <td style="padding: 18px 20px; text-align: right; color: #1a202c; font-size: 15px; font-weight: 600; white-space: nowrap;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 12px 20px; text-align: right; color: #4a5568; font-size: 15px; font-weight: 500;">Ongkir:</td>
                                    <td style="padding: 12px 20px; text-align: right; color: #10b981; font-size: 15px; font-weight: 600;">Gratis</td>
                                </tr>
                                <!-- Grand Total -->
                                <tr style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);">
                                    <td colspan="3" style="padding: 20px; text-align: right; color: #ffffff; font-size: 18px; font-weight: 700;">TOTAL:</td>
                                    <td style="padding: 20px; text-align: right; color: #ffffff; font-size: 22px; font-weight: 800; white-space: nowrap;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Status Info -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #fff5eb 0%, #ffe8d6 100%); border: 2px solid #FFB84D; border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #FF6B35; font-size: 16px; font-weight: 700; margin: 0 0 15px 0;">📦 Status Pesanan</h3>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #4a5568; font-size: 14px; padding: 8px 0;">Status:</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <span style="background: #10b981; color: white; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ ucfirst($order->status) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #4a5568; font-size: 14px; padding: 8px 0;">Estimasi Pengiriman:</td>
                                                <td style="text-align: right; color: #1a202c; font-size: 14px; font-weight: 600; padding: 8px 0;">2-3 Hari Kerja</td>
                                            </tr>
                                        </table>
                                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #FFB84D;">
                                            <p style="color: #4a5568; font-size: 13px; line-height: 1.6; margin: 0;">
                                                📧 Anda akan menerima email konfirmasi pengiriman beserta nomor resi setelah pesanan Anda dikirim.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <a href="{{ url('/') }}" style="display: inline-block; background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%); color: white; padding: 16px 40px; text-decoration: none; border-radius: 50px; font-weight: 700; font-size: 15px; box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);">
                                🏪 Lihat Produk Lainnya
                            </a>
                        </td>
                    </tr>

                    <!-- Help Section -->
                    <tr>
                        <td style="padding: 30px 40px; background: #f7fafc; text-align: center;">
                            <h3 style="color: #2d3748; font-size: 16px; font-weight: 700; margin: 0 0 15px 0;">Butuh Bantuan?</h3>
                            <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                                Jika Anda memiliki pertanyaan tentang pesanan ini,<br>
                                jangan ragu untuk menghubungi kami.
                            </p>
                            <table cellpadding="0" cellspacing="0" style="margin: 20px auto 0;">
                                <tr>
                                    <td style="padding: 0 15px;">
                                        <a href="mailto:merbabuakun@gmail.com" style="color: #FF6B35; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            📧 Email Kami
                                        </a>
                                    </td>
                                    <td style="padding: 0 15px; border-left: 2px solid #cbd5e0;">
                                        <a href="https://wa.me/6281234567890" style="color: #FF6B35; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            💬 WhatsApp
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); padding: 40px; text-align: center;">
                            <div style="font-size: 32px; margin-bottom: 15px;">🛍️</div>
                            <h2 style="color: #ffffff; font-size: 20px; font-weight: 700; margin: 0 0 8px 0;">Project Wahab Store</h2>
                            <p style="color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.8; margin: 0 0 20px 0;">
                                Your Trusted Online Shopping Partner<br>
                                📍 Jakarta, Indonesia<br>
                                📧 merbabuakun@gmail.com | 📱 +62 812-3456-7890
                            </p>
                            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                                <p style="color: rgba(255,255,255,0.5); font-size: 12px; margin: 0;">
                                    © 2025 Project Wahab. All rights reserved.<br>
                                    Email ini dikirim otomatis, mohon tidak membalas email ini.
                                </p>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
