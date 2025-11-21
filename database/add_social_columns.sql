-- ==========================================
-- SQL Manual untuk Social Login
-- ==========================================
-- CARA PAKAI:
-- 1. Buka HeidiSQL atau phpMyAdmin
-- 2. Pilih database: projectwahab
-- 3. Klik tab Query
-- 4. Copy-paste query di bawah ini
-- 5. Klik Execute/Jalankan
-- ==========================================

-- Pilih database
USE projectwahab;

-- Tambah kolom provider, provider_id, dan avatar
ALTER TABLE `users` 
ADD COLUMN `provider` VARCHAR(255) NULL AFTER `password`,
ADD COLUMN `provider_id` VARCHAR(255) NULL AFTER `provider`,
ADD COLUMN `avatar` VARCHAR(255) NULL AFTER `provider_id`;

-- Cek apakah berhasil
DESCRIBE users;

-- Harusnya muncul kolom:
-- - provider (varchar 255, YES, NULL)
-- - provider_id (varchar 255, YES, NULL)
-- - avatar (varchar 255, YES, NULL)

-- Selesai! Sekarang coba login dengan Google/Facebook/LinkedIn
