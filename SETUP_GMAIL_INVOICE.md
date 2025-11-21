# 📧 Setup Gmail Invoice - Project Wahab

## Step 1: Setup Gmail App Password

### 1. Buka Gmail Account

-   Login ke `merbabuakun@gmail.com`

### 2. Aktifkan 2-Step Verification

-   Masuk: https://myaccount.google.com/security
-   Cari "2-Step Verification"
-   Klik "Get Started" dan ikuti langkah-langkahnya
-   Verifikasi dengan nomor HP

### 3. Generate App Password

-   Masuk: https://myaccount.google.com/apppasswords
-   Pilih "Mail" dari dropdown
-   Pilih "Windows Computer" atau "Other"
-   Klik "Generate"
-   **COPY password 16 digit** (contoh: abcd efgh ijkl mnop)

## Step 2: Update .env File

Tambahkan konfigurasi ini di file `.env`:

```env
# Mail Configuration for Invoice
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=merbabuakun@gmail.com
MAIL_PASSWORD=abcdefghijklmnop  # Paste App Password di sini (tanpa spasi)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=merbabuakun@gmail.com
MAIL_FROM_NAME="Project Wahab Store"
```

## Step 3: Clear Cache Laravel

Jalankan command ini di terminal:

```powershell
php artisan config:clear
php artisan cache:clear
```

## Step 4: Test Invoice

1. Checkout produk
2. Sampai di halaman success
3. Klik button "📧 Kirim Invoice ke Email"
4. Loading animation muncul
5. Cek email di inbox Gmail user

## Troubleshooting

### Email tidak terkirim?

-   Pastikan 2-Step Verification aktif
-   Pastikan App Password benar (16 digit, tanpa spasi)
-   Check firewall/antivirus tidak block port 587
-   Check .env sudah benar

### Email masuk spam?

-   Normal untuk first time sender
-   Minta user add merbabuakun@gmail.com ke contacts
-   Atau mark as "Not Spam"

## Security Note

⚠️ **JANGAN commit .env ke Git!**
App Password adalah credentials sensitif.

✅ File `.env` sudah di `.gitignore` by default.
