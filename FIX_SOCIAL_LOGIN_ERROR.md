# 🔧 CARA MENAMBAHKAN KOLOM SOCIAL LOGIN

## ⚠️ ERROR yang Terjadi:

```
Column not found: 1054 Unknown column 'provider' in 'field list'
```

Artinya: Table `users` belum punya kolom `provider`, `provider_id`, dan `avatar`

## ✅ SOLUSI (Pilih salah satu):

---

### 🎯 CARA 1: Via HeidiSQL/phpMyAdmin (TERCEPAT!)

1. **Buka HeidiSQL** atau **phpMyAdmin**
2. **Pilih database**: `projectwahab`
3. **Klik tab "Query"**
4. **Copy-paste query ini**:

```sql
ALTER TABLE `users`
ADD COLUMN `provider` VARCHAR(255) NULL AFTER `password`,
ADD COLUMN `provider_id` VARCHAR(255) NULL AFTER `provider`,
ADD COLUMN `avatar` VARCHAR(255) NULL AFTER `provider_id`;
```

5. **Klik Execute/Jalankan**
6. **Selesai!** ✅

---

### 🎯 CARA 2: Via Laragon Terminal

1. **Buka Laragon**
2. **Klik kanan project "projectwahab"** → **Terminal**
3. **Jalankan command**:

```bash
php artisan migrate
```

4. Jika muncul error "php not recognized", coba:

```bash
C:\laragon\bin\php\php-8.3.11-Win32-vs16-x64\php.exe artisan migrate
```

5. **Selesai!** ✅

---

### 🎯 CARA 3: Via File SQL Manual

1. **Buka folder**: `C:\laragon\www\projectwahab\database\`
2. **Buka file**: `add_social_columns.sql`
3. **Copy semua isinya**
4. **Paste di HeidiSQL/phpMyAdmin Query**
5. **Execute**
6. **Selesai!** ✅

---

## 🧪 CEK APAKAH BERHASIL:

Setelah menjalankan salah satu cara di atas, cek dengan query:

```sql
DESCRIBE users;
```

Harusnya ada kolom baru:

-   ✓ `provider` (varchar 255, nullable)
-   ✓ `provider_id` (varchar 255, nullable)
-   ✓ `avatar` (varchar 255, nullable)

---

## 🚀 SETELAH SELESAI:

1. **Refresh halaman login**: http://localhost/projectwahab/login
2. **Klik icon Google/Facebook/LinkedIn**
3. **Otomatis login!** 🎉

---

## 💡 CATATAN:

Jika masih error "Column not found", berarti kolom belum ditambahkan.

**SOLUSI PALING MUDAH = CARA 1** (HeidiSQL/phpMyAdmin Query)

Butuh bantuan? Screenshot error dan kirim! 😊
