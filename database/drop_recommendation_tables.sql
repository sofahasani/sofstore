-- Drop Recommendation Engine Tables
-- Jalankan di phpMyAdmin (Tab SQL)

-- Drop semua table recommendation engine
DROP TABLE IF EXISTS `price_alerts`;
DROP TABLE IF EXISTS `product_recommendations`;
DROP TABLE IF EXISTS `product_views`;

-- Setelah ini, jalankan di Laragon Terminal:
-- php artisan migrate
