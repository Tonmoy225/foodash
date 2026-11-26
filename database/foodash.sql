-- ============================================================
-- FooDash Database Schema
-- Import this file into phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS `foodash` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `foodash`;

-- Users Table
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `role` ENUM('client','admin','delivery') DEFAULT 'client',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories Table
CREATE TABLE `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `icon` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products Table
CREATE TABLE `products` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `stock` INT DEFAULT 100,
  `is_available` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vouchers Table
CREATE TABLE `vouchers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `discount_type` ENUM('percent','fixed') DEFAULT 'percent',
  `discount_value` DECIMAL(10,2) NOT NULL,
  `min_order` DECIMAL(10,2) DEFAULT 0,
  `max_uses` INT DEFAULT 100,
  `used_count` INT DEFAULT 0,
  `expires_at` DATE DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders Table
CREATE TABLE `orders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `voucher_id` INT UNSIGNED DEFAULT NULL,
  `order_number` VARCHAR(50) NOT NULL UNIQUE,
  `status` ENUM('pending','confirmed','preparing','on_the_way','delivered','cancelled') DEFAULT 'pending',
  `subtotal` DECIMAL(10,2) NOT NULL,
  `discount` DECIMAL(10,2) DEFAULT 0,
  `delivery_fee` DECIMAL(10,2) DEFAULT 0,
  `total` DECIMAL(10,2) NOT NULL,
  `delivery_address` TEXT NOT NULL,
  `payment_method` ENUM('cash','card','bkash','nagad') DEFAULT 'cash',
  `payment_status` ENUM('pending','paid','failed') DEFAULT 'pending',
  `notes` TEXT DEFAULT NULL,
  `delivery_lat` DECIMAL(10,8) DEFAULT NULL,
  `delivery_lng` DECIMAL(11,8) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`voucher_id`) REFERENCES `vouchers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order Items Table
CREATE TABLE `order_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Delivery Locations Table (real-time simulation)
CREATE TABLE `delivery_locations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `lat` DECIMAL(10,8) NOT NULL,
  `lng` DECIMAL(11,8) NOT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sessions Table
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL PRIMARY KEY,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Seed Data
-- ============================================================

INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@foodash.com', '$2y$12$ZKUsXAiL0d8DJJyHIE9Ivuv8aZvm6O0UUhB119YhT/wFWf86Hc4hG', 'admin', NOW(), NOW()),
('Demo Client', 'client@foodash.com', '$2y$12$ZKUsXAiL0d8DJJyHIE9Ivuv8aZvm6O0UUhB119YhT/wFWf86Hc4hG', 'client', NOW(), NOW());
-- Default password is: password

INSERT INTO `categories` (`name`, `icon`, `created_at`, `updated_at`) VALUES
('Burgers', '🍔', NOW(), NOW()),
('Pizza', '🍕', NOW(), NOW()),
('Sushi', '🍣', NOW(), NOW()),
('Desserts', '🍰', NOW(), NOW()),
('Drinks', '🥤', NOW(), NOW()),
('Biryani', '🍛', NOW(), NOW());

INSERT INTO `products` (`category_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Classic Smash Burger', 'Double smashed beef patty with cheddar, pickles, and our secret sauce', 320.00, 'burger1.jpg', NOW(), NOW()),
(1, 'BBQ Bacon Burger', 'Smoky BBQ sauce, crispy bacon, caramelized onions', 380.00, 'burger2.jpg', NOW(), NOW()),
(2, 'Margherita Pizza', 'Classic tomato base, fresh mozzarella, basil', 480.00, 'pizza1.jpg', NOW(), NOW()),
(2, 'Pepperoni Feast', 'Loaded pepperoni, jalapeños, triple cheese', 560.00, 'pizza2.jpg', NOW(), NOW()),
(3, 'Salmon Nigiri (8pcs)', 'Fresh Atlantic salmon over seasoned rice', 650.00, 'sushi1.jpg', NOW(), NOW()),
(4, 'Chocolate Lava Cake', 'Warm chocolate cake with molten center, vanilla ice cream', 220.00, 'cake1.jpg', NOW(), NOW()),
(5, 'Fresh Mango Lassi', 'Creamy mango yogurt drink, chilled', 120.00, 'lassi1.jpg', NOW(), NOW()),
(6, 'Chicken Biryani', 'Aromatic basmati rice with tender chicken, saffron, fried onions', 350.00, 'biryani1.jpg', NOW(), NOW());

INSERT INTO `vouchers` (`code`, `discount_type`, `discount_value`, `min_order`, `max_uses`, `expires_at`, `created_at`, `updated_at`) VALUES
('WELCOME20', 'percent', 20, 200, 999, '2026-12-31', NOW(), NOW()),
('FLAT50', 'fixed', 50, 300, 500, '2026-12-31', NOW(), NOW()),
('NEWUSER', 'percent', 15, 0, 999, '2026-12-31', NOW(), NOW());
