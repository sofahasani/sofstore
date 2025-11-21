<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Display chat interface for User
     */
    public function index(Request $request)
    {
        $sessionId = 'user_' . $request->user()->id . '_' . date('Ymd');
        
        // Get all messages for this user session
        $messages = ChatMessage::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('chat.user', compact('messages', 'sessionId'));
    }

    /**
     * Display admin chat interface (All users)
     */
    public function adminIndex()
    {
        // Get all users who have sent messages
        $users = ChatMessage::with('user')
            ->whereNotNull('user_id')
            ->select('user_id')
            ->distinct()
            ->get()
            ->map(function($message) {
                $user = $message->user;
                $lastMessage = ChatMessage::where('user_id', $user->id)
                    ->latest()
                    ->first();
                $unreadCount = ChatMessage::where('user_id', $user->id)
                    ->where('sender_type', 'user')
                    ->whereNull('read_at')
                    ->count();
                
                return [
                    'user' => $user,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            });
            
        return view('chat.admin', compact('users'));
    }

    /**
     * Get messages for specific user (Admin view)
     */
    public function getUserMessages(Request $request, $userId)
    {
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Mark user messages as read by admin
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'user')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    // Super Smart Pattern Matching AI - No API Key Required! 🚀
    private $botResponses = [
        // Promo & Discount (CHECK FIRST - Most specific)
        'promo|diskon|voucher|kupon|sale|cashback|potongan' => [
            'response' => "🎉 *Promo Bulan Ini:*\n\n🏷️ Diskon 20% untuk pembelian pertama\n   Kode: *NEWUSER20*\n\n🚚 Gratis ongkir min. belanja 100k\n   Kode: *FREEONGKIR*\n\n⚡ Flash Sale setiap Jumat!\n\nPakai kode saat checkout ya! �"
        ],
        
        // Order & Checkout
        'order|checkout|beli|cara beli|gimana beli|pesan' => [
            'response' => "📦 *Cara Order Produk:*\n\n1. Pilih produk yang kamu suka\n2. Klik *\"Tambah ke Keranjang\"* 🛒\n3. Klik icon keranjang di kanan atas\n4. Review pesananmu\n5. Klik *\"Checkout\"*\n6. Isi alamat pengiriman\n7. Pilih metode pembayaran\n8. Selesai! 🎉\n\nMudah kan? Ada yang masih bingung?"
        ],
        
        // Payment
        'pembayaran|bayar|payment|metode|cara bayar|transfer|cod|e-wallet|kartu kredit' => [
            'response' => "💳 *Metode Pembayaran:*\n\n1. Transfer Bank (BCA, Mandiri, BNI)\n2. E-Wallet (GoPay, OVO, Dana, ShopeePay)\n3. COD (Cash on Delivery)\n4. Kartu Kredit/Debit\n\nSemua metode aman & terpercaya! 🔒\n\nPilih yang paling nyaman buat kamu ya!"
        ],
        
        // Shipping
        'ongkir|ongkos kirim|biaya kirim|pengiriman' => [
            'response' => "🚚 *Biaya Ongkir:*\n\n• Jakarta & sekitarnya: Rp 10.000\n• Pulau Jawa: Rp 15.000\n• Luar Jawa: Rp 25.000 - 50.000\n\n💡 Biaya ongkir pasti akan muncul otomatis saat checkout sesuai lokasi kamu!\n\n🎁 *GRATIS ONGKIR* untuk belanja min. 100k!"
        ],
        
        // Tracking
        'tracking|lacak|cek pesanan|status pesanan|resi|nomor resi|mana pesanan' => [
            'response' => "📍 *Lacak Pesanan:*\n\n1. Masuk ke menu *\"Pesanan Saya\"* 📦\n2. Pilih pesanan yang ingin dilacak\n3. Klik *\"Lacak Pesanan\"*\n4. Lihat status real-time pengirimanmu!\n\nAtau bisa cek langsung di website ekspedisi dengan nomor resi yang diberikan 😊"
        ],
        
        // Return & Refund
        'return|refund|retur|pengembalian|barang rusak|komplain|klaim|garansi|tukar|ganti' => [
            'response' => "↩️ *Kebijakan Pengembalian:*\n\n✅ Garansi 7 hari untuk produk rusak/tidak sesuai\n✅ Gratis biaya return\n✅ Refund 100% ke rekening kamu\n\n📋 *Syarat:*\n• Produk masih dalam kondisi baik\n• Kemasan lengkap\n• Bukti foto/video unboxing\n\nHubungi admin untuk proses return ya! 👨‍💼"
        ],
        
        // Stock
        'stok|ready|ada gak|tersedia|habis|kosong|restock' => [
            'response' => "📊 *Cek Stok Produk:*\n\nUntuk cek ketersediaan stok produk tertentu, kamu bisa:\n\n1. Lihat di halaman produk (ada tulisan \"Stok: X\")\n2. Kalau tulisan \"Habis\" berarti lagi kosong\n3. Klik \"Notify Me\" untuk info restock\n4. Atau tanya langsung ke admin\n\nProduk mana yang ingin kamu tanyakan? 😊"
        ],
        
        // Contact
        'kontak|hubungi|admin|customer service|cs|whatsapp|wa|telp|telepon|email' => [
            'response' => "📞 *Hubungi Kami:*\n\n👨‍💼 Customer Service\n📱 WhatsApp: 0812-3456-7890\n📧 Email: cs@tokokami.com\n\n🕐 *Jam Operasional:*\nSenin - Jumat: 08.00 - 17.00 WIB\nSabtu: 09.00 - 15.00 WIB\nMinggu: Libur\n\nChat aja langsung, fast response! ⚡"
        ],
        
        // Categories
        'kategori|jenis produk|produk apa|jual apa|ada apa' => [
            'response' => "🛍️ *Kategori Produk Kami:*\n\n📱 Elektronik\n👕 Fashion\n🍔 Makanan & Minuman\n💄 Kesehatan & Kecantikan\n🏠 Rumah Tangga\n⚽ Olahraga\n🚗 Otomotif\n🎨 Hobi & Koleksi\n\nMau lihat kategori yang mana? Tinggal klik di menu kategori ya! 😊"
        ],
        
        // Greetings (CHECK LAST - Most generic)
        'halo|hai|hi|hello|hey|helo' => [
            'response' => "👋 Halo! Selamat datang!\n\nSaya *SofaDev*, asisten virtual yang siap membantu kamu 24/7! 🤖\n\nAda yang bisa saya bantu hari ini? 😊"
        ],
        
        // Thanks
        'terima kasih|thanks|thank you|makasih|tengkyu|thx|tq' => [
            'response' => "Sama-sama! 😊🙏\n\nSenang bisa membantu kamu!\n\nKalau ada pertanyaan lain, jangan ragu untuk chat lagi ya! 💬"
        ],
        
        // Laptop Recommendation
        'laptop|komputer|pc|notebook|rekomendasi laptop|laptop gaming|laptop kerja' => [
            'response' => "💻 *Rekomendasi Laptop:*\n\n🎮 *Gaming (10-15 juta):*\n• ASUS ROG / TUF Series\n• Lenovo Legion\n• MSI Katana / Bravo\n\n💼 *Kerja/Kuliah (5-8 juta):*\n• ASUS VivoBook\n• Lenovo IdeaPad\n• HP Pavilion\n\nBudget kamu berapa? Biar aku kasih rekomendasi lebih spesifik! 😊"
        ],
        
        // Phone Recommendation
        'hp|handphone|smartphone|iphone|samsung|xiaomi|oppo|vivo|rekomendasi hp' => [
            'response' => "📱 *Rekomendasi Smartphone:*\n\n💎 *Flagship (10-20 juta):*\n• iPhone 14/15 Series\n• Samsung Galaxy S23/S24\n\n⚡ *Mid-Range (3-6 juta):*\n• Samsung Galaxy A Series\n• Xiaomi Note Series\n• POCO F Series\n\n💰 *Budget (1-3 juta):*\n• Redmi Series\n• Realme Series\n\nBuat apa nih HP nya? Gaming, foto, atau kerja?"
        ],
        
        // Product Ingredients (for food/cosmetics)
        'bahan|kandungan|komposisi|terbuat dari|ingredients' => [
            'response' => "📋 *Info Bahan/Komposisi:*\n\nKomposisi lengkap produk ada di:\n\n1️⃣ *Deskripsi Produk* - Cek detail di halaman produk\n2️⃣ *Kemasan* - Semua tercantum jelas\n3️⃣ *Sertifikat* - BPOM/Halal (untuk produk makanan/kosmetik)\n\nProduk apa yang mau kamu tanyain? Aku bantu jelasin! 😊\n\nKalau ada alergi tertentu, jangan lupa cek dulu ya!"
        ],
        
        // General Comparison
        'beda|bedanya|vs|versus|mana yang bagus|pilih mana|lebih bagus' => [
            'response' => "🔍 *Mau Bandingkan Produk?*\n\nBiar aku bantu! Sebutin 2 produk yang mau dibandingin ya!\n\nContoh:\n• \"Beda iPhone 14 vs 15\"\n• \"Samsung A54 vs Xiaomi Note 12\"\n• \"ASUS ROG vs Lenovo Legion\"\n\nAtau kamu bisa cek review & spesifikasi di halaman produk! 😊"
        ],
        
        // Delivery Time
        'lama|berapa lama|sampai kapan|estimasi|pengiriman berapa hari|lama gak' => [
            'response' => "⏱️ *Estimasi Pengiriman:*\n\n📦 *Jakarta & sekitarnya:* 1-2 hari kerja\n📦 *Pulau Jawa:* 2-4 hari kerja\n📦 *Luar Jawa:* 3-7 hari kerja\n\n💡 Waktu dihitung setelah pesanan diproses ya!\n\nBisa lebih cepat kalau pakai ekspedisi express! 🚀"
        ],
        
        // Price & Budget
        'harga|berapa|mahal|murah|budget|uang|rupiah|juta|ribu' => [
            'response' => "💰 *Info Harga:*\n\nHarga semua produk udah tertera jelas di halaman produk ya!\n\n💡 *Tips Hemat:*\n• Manfaatin promo & voucher\n• Cek flash sale tiap Jumat\n• Bundling produk lebih hemat\n• Follow sosmed buat info diskon\n\nBudget kamu berapa? Aku bantu cariin produk yang cocok! 🛍️"
        ],
        
        // Quality
        'asli|ori|original|kw|palsu|kualitas|bagus|jelek' => [
            'response' => "✅ *Jaminan Kualitas:*\n\n💎 100% ORIGINAL & BERGARANSI!\n\n🔒 *Kami Jamin:*\n• Produk asli dari distributor resmi\n• Garansi resmi brand\n• Bisa cek sertifikat keaslian\n• Uang kembali 100% kalau palsu\n\nTenang aja, kami hanya jual produk berkualitas! 💪"
        ],
        
        // Account
        'akun|login|daftar|register|lupa password|ganti password|profil' => [
            'response' => "👤 *Akun & Login:*\n\n🔐 *Lupa Password?* Klik \"Lupa Password\"\n📝 *Belum Punya Akun?* Daftar gratis!\n⚙️ *Edit Profil:* Menu Profil > Edit\n\n💡 Dengan akun, kamu bisa:\n• Tracking pesanan\n• Simpan wishlist\n• Dapet notif promo! 🎁"
        ],
    ];

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Save user/admin message
        $message = ChatMessage::create([
            'user_id' => $request->user_id ?? $request->user()->id,
            'sender_type' => $request->sender_type ?? 'user',
            'message' => $request->message,
        ]);

        // If user message, generate bot response (optional - admin can reply manually)
        if ($request->sender_type === 'user' && !$request->has('no_bot_response')) {
            $botResponse = $this->getBotResponse($request->message);

            $botMessage = ChatMessage::create([
                'user_id' => $request->user_id ?? $request->user()->id,
                'sender_type' => 'bot',
                'message' => $botResponse,
            ]);

            return response()->json([
                'success' => true,
                'user_message' => $message,
                'bot_message' => $botMessage,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Admin sends reply to user
     */
    public function adminReply(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'user_id' => $request->user_id,
            'sender_type' => 'admin',
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function getMessages(Request $request)
    {
        $messages = ChatMessage::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function markAsRead(Request $request)
    {
        ChatMessage::where('user_id', $request->user()->id)
            ->where('sender_type', '!=', 'user')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Get Smart Bot Response based on keyword patterns
     */
    private function getBotResponse(string $message): string
    {
        $message_lower = strtolower(trim($message));
        
        // Remove extra spaces
        $message_lower = preg_replace('/\s+/', ' ', $message_lower);

        // Check patterns in order of specificity (most specific first)
        foreach ($this->botResponses as $pattern => $data) {
            // Split pattern by | to get individual keywords
            $keywords = explode('|', $pattern);
            
            // Check if any keyword matches as a whole word or is contained
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                
                // Match whole word or as part of word
                if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/i', $message_lower) || 
                    stripos($message_lower, $keyword) !== false) {
                    return $data['response'];
                }
            }
        }

        // Fallback for unrecognized messages
        return $this->getSmartFallback($message_lower);
    }

    /**
     * Smart fallback response with context detection
     */
    private function getSmartFallback(string $message): string
    {
        // Detect some common intents even without exact keyword match
        if (preg_match('/(mau|cari|butuh|pengen|ingin|perlu)/i', $message)) {
            return "🛍️ Wah, lagi cari sesuatu nih?\n\nCoba kasih tau lebih detail ya:\n• Nama produk yang dicari\n• Kategori produk\n• Budget kamu\n\nAtau bisa langsung cek di halaman kategori! 😊\n\nAku siap bantu cariin! 💪";
        }

        if (preg_match('/(gimana|bagaimana|caranya|tolong|bantu)/i', $message)) {
            return "💡 Butuh bantuan nih?\n\nAku bisa bantu dengan:\n• Cara order & checkout\n• Info ongkir & promo\n• Metode pembayaran\n• Lacak pesanan\n• Kebijakan return\n• Rekomendasi produk\n\nMau tanya yang mana? 😊";
        }

        if (preg_match('/(ada|punya|jual|tersedia)/i', $message)) {
            return "� Lagi cari produk tertentu?\n\nYuk, cek di halaman toko atau kasih tau aku:\n• Nama produk yang dicari\n• Kategori yang diinginkan\n\nAtau langsung search di kotak pencarian! �\n\nKami punya 8 kategori produk lengkap loh! 🛍️";
        }

        // Generic friendly fallback
        return "Hmm, aku kurang paham maksud kamu 😅\n\nCoba tanya dengan kata lain atau pilih dari menu bantuan:\n\n📦 Cara Order\n🚚 Info Ongkir\n🎉 Promo & Diskon\n💳 Metode Bayar\n📍 Lacak Pesanan\n↩️ Return & Refund\n📞 Kontak CS\n\nAtau ketik pertanyaan kamu dengan lebih spesifik ya! 💬";
    }
}

