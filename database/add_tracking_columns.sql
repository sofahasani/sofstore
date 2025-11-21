-- Jalankan query ini di phpMyAdmin atau MySQL

ALTER TABLE `orders` 
ADD COLUMN `tracking_status` VARCHAR(255) NULL AFTER `status`,
ADD COLUMN `tracking_notes` TEXT NULL AFTER `tracking_status`,
ADD COLUMN `status_updated_at` TIMESTAMP NULL AFTER `tracking_notes`;
