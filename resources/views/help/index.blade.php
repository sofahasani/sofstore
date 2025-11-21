<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan & FAQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header dengan Gradient Orange */
        .page-header {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            padding: 40px 30px;
            border-radius: 24px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(255, 115, 0, 0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .back-btn {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-4px);
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 16px;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: #1f2937;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-input:focus {
            outline: none;
            background: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        /* FAQ Section - Background Putih */
        .faq-section {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon {
            font-size: 24px;
        }

        .faq-item {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            margin-bottom: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: #ff9500;
            box-shadow: 0 4px 12px rgba(255, 115, 0, 0.1);
        }

        .faq-question {
            padding: 18px 24px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #1f2937;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: #fef3e7;
            color: #ff7300;
        }

        .faq-icon {
            font-size: 20px;
            transition: transform 0.3s ease;
            color: #ff7300;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            color: #6b7280;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 24px 20px 24px;
        }

        /* Contact Section - Background Putih */
        .contact-section {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .contact-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .contact-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1f2937;
        }

        .contact-text {
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .contact-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff7300, #ff9500);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(255, 115, 0, 0.3);
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(255, 115, 0, 0.5);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }

            .section-title {
                font-size: 18px;
            }

            .page-header {
                padding: 30px 20px;
            }

            .faq-section,
            .contact-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header dengan Gradient Orange -->
        <div class="page-header">
            <div class="header-content">
                <a href="{{ route('dashboard') }}" class="back-btn">←</a>
                <h1>💬 Bantuan & FAQ</h1>
            </div>
            
            <div class="search-box">
                <input type="text" class="search-input" placeholder="🔍 Cari pertanyaan..." id="searchInput">
            </div>
        </div>

        <!-- FAQ Sections -->
        <div class="faq-section">
            <div class="section-title">
                <span class="section-icon">🛍️</span>
                Tentang Pemesanan
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Bagaimana cara memesan produk?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Pilih produk yang Anda inginkan, klik "Tambah ke Keranjang", lalu lanjutkan ke halaman checkout untuk menyelesaikan pemesanan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Apakah bisa membatalkan pesanan?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Ya, pesanan dapat dibatalkan selama masih berstatus "Pending" atau "Processing". Hubungi customer service kami untuk bantuan pembatalan.
                </div>
            </div>
        </div>

        <div class="faq-section">
            <div class="section-title">
                <span class="section-icon">💳</span>
                Pembayaran
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Metode pembayaran apa saja yang tersedia?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Kami menerima transfer bank, e-wallet (GoPay, OVO, Dana), dan kartu kredit/debit.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Berapa lama batas waktu pembayaran?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Batas waktu pembayaran adalah 24 jam setelah pesanan dibuat. Jika melewati batas waktu, pesanan akan otomatis dibatalkan.
                </div>
            </div>
        </div>

        <div class="faq-section">
            <div class="section-title">
                <span class="section-icon">🚚</span>
                Pengiriman
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Berapa lama estimasi pengiriman?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Estimasi pengiriman 2-5 hari kerja untuk wilayah Jawa, dan 3-7 hari kerja untuk luar Jawa.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Bagaimana cara melacak pesanan?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Anda dapat melacak pesanan melalui menu "Pesanan Saya" dengan nomor resi yang diberikan setelah produk dikirim.
                </div>
            </div>
        </div>

        <div class="faq-section">
            <div class="section-title">
                <span class="section-icon">↩️</span>
                Pengembalian & Refund
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Apakah ada garansi pengembalian?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Ya, kami memberikan garansi pengembalian 7 hari untuk produk yang rusak atau tidak sesuai deskripsi.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Bagaimana proses refund?</span>
                    <span class="faq-icon">▼</span>
                </div>
                <div class="faq-answer">
                    Setelah pengembalian disetujui, dana akan dikembalikan ke rekening Anda dalam 3-7 hari kerja.
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="contact-section">
            <div class="contact-icon">📞</div>
            <div class="contact-title">Masih Ada Pertanyaan?</div>
            <div class="contact-text">
                Tim customer service kami siap membantu Anda!<br>
                Hubungi kami melalui WhatsApp atau email.
            </div>
            <a href="https://wa.me/628988128603" class="contact-btn">💬 Hubungi WhatsApp</a>
        </div>
    </div>

    <script>
        // Toggle FAQ
        function toggleFAQ(element) {
            const faqItem = element.parentElement;
            const allItems = document.querySelectorAll('.faq-item');
            
            // Close all other items
            allItems.forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                }
            });
            
            // Toggle current item
            faqItem.classList.toggle('active');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                    if (searchTerm.length > 2) {
                        item.classList.add('active');
                    }
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
