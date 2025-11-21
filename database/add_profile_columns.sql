-- Add missing columns to users table
-- Run this in phpMyAdmin or MySQL command line

ALTER TABLE `users` 
ADD COLUMN `phone` VARCHAR(20) NULL AFTER `email`;

ALTER TABLE `users` 
ADD COLUMN `address` TEXT NULL AFTER `phone`;

ALTER TABLE `users` 
ADD COLUMN `bio` TEXT NULL AFTER `address`;

ALTER TABLE `users` 
ADD COLUMN `username` VARCHAR(50) NULL AFTER `name`;

ALTER TABLE `users` 
ADD COLUMN `whatsapp` VARCHAR(20) NULL AFTER `bio`;

ALTER TABLE `users` 
ADD COLUMN `profile_picture` VARCHAR(255) NULL AFTER `whatsapp`;

-- Add unique constraint to username
ALTER TABLE `users` 
ADD UNIQUE KEY `users_username_unique` (`username`);
