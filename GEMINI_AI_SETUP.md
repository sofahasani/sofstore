# 🤖 Gemini AI Setup - SofaDev Bot

## 📝 Apa yang Sudah Dikerjakan?

✅ **ChatController** sudah di-upgrade dengan Gemini AI!
✅ Bot sekarang bisa jawab pertanyaan APAPUN secara PINTAR!
✅ Sistem hybrid: Keyword (cepat) + AI (pintar)

---

## 🔥 Cara Dapetin API Key Gemini (100% GRATIS!)

### Step 1: Buka Google AI Studio

1. Buka browser, kunjungi: **https://makersuite.google.com/app/apikey**
2. Login pakai akun Gmail kamu

### Step 2: Generate API Key

1. Klik tombol **"Create API Key"** atau **"Get API Key"**
2. Pilih project atau buat project baru (contoh: "SofaDev Bot")
3. Klik **"Create API key in new project"**
4. **COPY** API key yang muncul (format: AIzaSy...)

⚠️ **PENTING:** Simpan API key ini, jangan share ke orang lain!

### Step 3: Masukkan ke Code

1. Buka file: `app/Http/Controllers/ChatController.php`
2. Cari baris ini (sekitar line 11):
    ```php
    private $geminiApiKey = 'AIzaSyDemoKey123'; // GANTI dengan API key kamu nanti
    ```
3. **Ganti** `AIzaSyDemoKey123` dengan API key yang tadi kamu copy
4. Contoh hasil edit:
    ```php
    private $geminiApiKey = 'AIzaSyC1234567890abcdefghijklmnop'; // API key asli kamu
    ```
5. **Save** file (Ctrl+S)

### Step 4: Test Bot!

1. Buka website kamu
2. Klik icon chat 💬
3. Coba tanya:
    - "Rekomendasi laptop gaming budget 10 juta"
    - "Bedanya iPhone 14 sama 15?"
    - "Gimana cara rawat sepatu kulit biar awet?"
    - "Kenapa langit biru?" (random question!)

🎉 **Bot kamu sekarang PINTAR pakai AI!**

---

## ⚡ Bagaimana Sistem Bekerja?

### 1️⃣ **Keyword Pattern (Priority)**

-   Bot cek dulu apakah ada keyword yang cocok (halo, order, ongkir, promo, dll)
-   Kalau ada → **langsung jawab** (response instant!)
-   Ini bikin bot lebih CEPAT untuk pertanyaan umum

### 2️⃣ **Gemini AI (Smart Fallback)**

-   Kalau gak ada keyword yang cocok → **tanya ke Gemini AI**
-   AI bakal kasih jawaban yang PINTAR & RELEVAN
-   AI udah dikasih context tentang toko kamu (nama, promo, ongkir, dll)

### 3️⃣ **Fallback Response (Safety Net)**

-   Kalau AI error/internet mati → **response manual fallback**
-   Bot tetap bisa jawab dengan FAQ list
-   Sistem gak bakal crash!

---

## 🎨 Apa yang AI Bisa Jawab?

✅ **Rekomendasi produk** (misal: "Laptop gaming bagus apa ya?")
✅ **Perbandingan produk** (misal: "Beda iPhone vs Samsung?")
✅ **Tips & trik** (misal: "Cara rawat sepatu kulit?")
✅ **Pertanyaan random** (misal: "Kenapa langit biru?")
✅ **Informasi toko** (order, ongkir, promo, payment, dll)
✅ **Saran & rekomendasi** (misal: "Gift buat pacar budget 500rb?")
✅ **Penjelasan produk** (misal: "Apa itu mechanical keyboard?")

---

## 🔧 Kustomisasi AI Personality

Buka `ChatController.php`, cari bagian `$systemContext` (sekitar line 108):

```php
$systemContext = "Kamu adalah SofaDev, asisten virtual yang ramah dan membantu...";
```

**Edit bagian ini untuk:**

-   Ganti nama toko: `Nama toko: Toko Kami` → `Nama toko: Sofa Store`
-   Update promo: Sesuaikan kode voucher & diskon
-   Ubah jam CS: Sesuai jam operasional toko kamu
-   Tambah/kurangi kategori produk
-   Ganti style jawaban: formal/santai/friendly/profesional

**Contoh custom prompt:**

```php
$systemContext = "Kamu adalah SofaDev, bot super friendly dari Sofa Store! " .
                "Jawab pakai bahasa gaul anak muda, banyakin emoji 🔥, " .
                "dan bikin customer happy! Kalau ditanya produk, " .
                "langsung kasih rekomendasi dengan confident! 💪";
```

---

## 📊 AI Configuration Parameters

Di `callGeminiAPI()` ada parameter yang bisa di-tweak:

```php
'generationConfig' => [
    'temperature' => 0.7,      // Kreativitas AI (0.0-1.0)
    'maxOutputTokens' => 500,  // Panjang max jawaban
    'topP' => 0.8,             // Diversity (0.0-1.0)
    'topK' => 40               // Alternative selection
]
```

### 🎛️ **Temperature:**

-   `0.3` = Konservatif, jawaban konsisten
-   `0.7` = Balanced (recommended)
-   `1.0` = Kreatif, jawaban bervariasi

### 📝 **Max Output Tokens:**

-   `200` = Jawaban pendek
-   `500` = Balanced (recommended)
-   `1000` = Jawaban panjang & detail

---

## 🚀 Upgrade Ideas

### 1️⃣ **Database Integration**

Buat AI bisa cek produk real dari database:

```php
// Contoh: ambil 5 produk terbaru
$products = Product::latest()->take(5)->get();
$productList = $products->pluck('name')->join(', ');

$systemContext .= "\n\nProduk terbaru di toko: $productList";
```

### 2️⃣ **User History**

AI bisa ingat chat sebelumnya untuk jawaban lebih personal:

```php
$previousChats = ChatMessage::forSession($sessionId)
    ->latest()->take(5)->get();
```

### 3️⃣ **Sentiment Analysis**

Deteksi customer marah/bingung, auto-forward ke admin:

```php
if (preg_match('/(marah|kesel|komplain)/i', $message)) {
    // Notify admin via WhatsApp/Email
}
```

### 4️⃣ **Multi-language**

Support bahasa Inggris/Indonesia otomatis:

```php
$systemContext = "Answer in the same language as the question...";
```

---

## 🐛 Troubleshooting

### ❌ **Error: "API key not valid"**

-   Pastikan API key udah benar (copy-paste dengan benar)
-   Cek di https://makersuite.google.com/app/apikey
-   Generate ulang API key baru

### ❌ **Bot gak respon / loading lama**

-   Cek koneksi internet
-   Gemini API mungkin lagi slow, tunggu sebentar
-   Coba refresh page

### ❌ **Jawaban AI aneh/gak relevan**

-   Edit `$systemContext` buat kasih context lebih jelas
-   Turunin `temperature` jadi 0.5 untuk jawaban lebih konsisten
-   Tambahin contoh Q&A di system prompt

### ❌ **"Resource exhausted" error**

-   Kamu udah exceed limit (unlikely karena Gemini unlimited)
-   Wait 1-2 menit terus coba lagi
-   Generate API key baru

---

## 💡 Tips & Best Practices

✅ **Jangan expose API key** - Simpan di `.env` file (production)
✅ **Monitor usage** - Cek di Google AI Studio dashboard
✅ **Update context regular** - Sesuaikan info promo/produk terbaru
✅ **Test conversation flow** - Simulasi berbagai skenario chat
✅ **Backup keyword responses** - Fallback tetap penting!

---

## 📚 Resources

-   **Gemini API Docs:** https://ai.google.dev/docs
-   **Get API Key:** https://makersuite.google.com/app/apikey
-   **Pricing:** FREE unlimited (as of 2024)
-   **Support:** Google AI Developer Forum

---

## 🎉 Next Steps

1. ✅ Generate Gemini API key
2. ✅ Paste ke `ChatController.php`
3. ✅ Run: `php artisan migrate` (kalau belum)
4. ✅ Test chat dengan berbagai pertanyaan
5. ✅ Customize `$systemContext` sesuai toko kamu
6. ✅ Enjoy your SMART AI bot! 🤖🔥

---

**Happy Coding! 🚀**  
Your bot is now SUPER SMART with Google Gemini AI! 🧠✨
