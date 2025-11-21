# Laravel Vercel Deployment Guide

## 📝 Persiapan Sebelum Deploy

### 1. Install Vercel CLI

```bash
npm install -g vercel
```

### 2. Login ke Vercel

```bash
vercel login
```

### 3. Optimize Laravel

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🚀 Deploy ke Vercel

### Method 1: Via CLI

```bash
# Di root project
vercel

# Untuk production
vercel --prod
```

### Method 2: Via GitHub (Recommended)

1. Push project ke GitHub
2. Buka https://vercel.com
3. Import repository dari GitHub
4. Vercel akan auto-detect Laravel
5. Set environment variables di Vercel Dashboard

## ⚙️ Environment Variables di Vercel

Tambahkan di **Vercel Dashboard → Settings → Environment Variables**:

```
APP_NAME=ProjectWahab
APP_KEY=base64:your-app-key-here
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-project.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME=ProjectWahab
```

## 🗄️ Database Options untuk Vercel

Karena Vercel adalah serverless, gunakan database cloud:

1. **PlanetScale** (MySQL - Free tier tersedia)

    - https://planetscale.com
    - MySQL compatible
    - Free 5GB storage

2. **Railway** (PostgreSQL/MySQL)

    - https://railway.app
    - Free $5/month credit

3. **Supabase** (PostgreSQL)

    - https://supabase.com
    - Free tier generous

4. **AWS RDS** (Production ready)
    - Paid service

## 📁 File Storage di Vercel

Vercel adalah read-only filesystem. Untuk file upload:

1. **Cloudinary** (Recommended)

```bash
composer require cloudinary/cloudinary_php
```

2. **AWS S3**

```bash
composer require league/flysystem-aws-s3-v3
```

3. **Update config/filesystems.php**

```php
'default' => env('FILESYSTEM_DISK', 'cloudinary'),
```

## ⚠️ Catatan Penting

1. **Vercel Free Tier Limitations:**

    - 100GB bandwidth/bulan
    - Serverless Functions timeout: 10 detik
    - Tidak cocok untuk long-running tasks

2. **Alternative untuk Laravel:**
    - **Laravel Forge + DigitalOcean** (Recommended untuk production)
    - **Heroku** (Mudah tapi paid)
    - **Railway** (Bagus untuk Laravel, ada free tier)
    - **Fly.io** (Modern, support Laravel)

## 🔧 Troubleshooting

### Error: "Function exceeded timeout"

-   Optimize queries
-   Use eager loading
-   Cache results

### Error: "Storage not writable"

-   Use cloud storage (S3, Cloudinary)
-   Logs → use `LOG_CHANNEL=stderr`

### Error: Database connection failed

-   Pastikan database cloud accessible
-   Cek IP whitelist di database provider

## 📚 Resources

-   Vercel Docs: https://vercel.com/docs
-   Laravel Deployment: https://laravel.com/docs/deployment
-   PlanetScale Laravel: https://planetscale.com/docs/tutorials/connect-laravel-app

## ✅ Checklist Sebelum Deploy

-   [ ] `.env` sudah dikonfigurasi untuk production
-   [ ] `APP_KEY` sudah di-generate
-   [ ] Database cloud sudah siap
-   [ ] File storage sudah setup (S3/Cloudinary)
-   [ ] Environment variables sudah di set di Vercel
-   [ ] `composer install --no-dev` sudah dijalankan
-   [ ] Cache cleared: `php artisan optimize:clear`
