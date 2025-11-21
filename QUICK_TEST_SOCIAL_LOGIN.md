# 🚀 CARA AKTIFKAN SOCIAL LOGIN (TESTING MODE)

## ✅ Status Saat Ini:

-   ✓ Controller sudah dibuat
-   ✓ Routes sudah ditambahkan
-   ✓ Migration file sudah ada
-   ✓ Login page sudah terintegrasi
-   ✓ Mock mode untuk testing (tidak perlu API key dulu)

## 🔧 Yang Perlu Dilakukan:

### Step 1: Jalankan Migration

Buka Terminal/Command Prompt di Laragon dan jalankan:

```bash
# Via Laragon Menu:
Laragon → Terminal → Run:
php artisan migrate

# Atau manual via Command Prompt:
cd C:\laragon\www\projectwahab
C:\laragon\bin\php\php-8.x.x-Win32-vs16-x64\php.exe artisan migrate
```

### Step 2: Test Social Login (Mock Mode)

1. Buka browser → http://localhost/projectwahab/login
2. Klik icon **Google** / **Facebook** / **LinkedIn**
3. Akan otomatis login dengan user mock:
    - **Google**: user@gmail.com
    - **Facebook**: user@facebook.com
    - **LinkedIn**: user@linkedin.com

### Step 3: Cek Database

Setelah klik social login, cek table `users`:

-   User baru akan otomatis dibuat
-   Kolom `provider` terisi: google/facebook/linkedin
-   Kolom `provider_id` terisi: id unik
-   Kolom `avatar` terisi: URL avatar
-   Email auto-verified

## 🎯 Cara Kerja Mock Mode:

1. User klik icon Google/Facebook/LinkedIn
2. System redirect ke `/auth/{provider}/mock`
3. System create/login user otomatis
4. Redirect ke dashboard dengan pesan sukses

## 📝 Catatan:

**Mock Mode** = Testing tanpa perlu API key dari Google/Facebook/LinkedIn

Setelah yakin working, baru install Socialite dan setup API keys untuk production!

## ⚡ Quick Command (Copy-Paste di Laragon Terminal):

```bash
php artisan migrate
```

Selesai! Coba klik icon Google/Facebook/LinkedIn di login page! 🎉
