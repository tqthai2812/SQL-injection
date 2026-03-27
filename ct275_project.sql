DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (1,'Student','student@cit.ctu.edu.vn','$2y$10$Use.MHRzGdW3IVu0dqVNT.Wnmibj0eNPr8q7RFlclQlbAWNUQtvPu','admin','2016-10-08 15:20:51','2016-10-08 15:20:51');

UNLOCK TABLES;

-- Tạo bảng brands
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Đường dẫn hình ảnh thương hiệu',
  `name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE COMMENT 'Tên thương hiệu',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `brands` (`id`, `image`, `name`) VALUES
(1, '/uploads/1742325336_iphone_16_pro_max_desert_titan_3552a28ae0.png', 'Apple'),
(2, '/uploads/1742325360_1742288278_samsung_galaxy_s24_ultra_2f8a5ee174.png', 'Samsung'),
(3, '/uploads/1742328546_1742286919_2024_5_18_638516296640266598_xiaomi-14-ultra-trang-5.png', 'Xiaomi'),
(4, '/uploads/1742334728_oppo_cate_thumb_8e37da2939.png', 'OPPO'),
(6, '/uploads/1742388954_Realme_cate_thumb_1b49fe3fe6.png', 'Realme');

DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên điện thoại',
  `brand_id` INT(10) UNSIGNED NOT NULL COMMENT 'Mã thương hiệu',
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Giá điện thoại',
  `discount_percent` TINYINT(3) UNSIGNED DEFAULT 0 COMMENT 'Phần trăm giảm giá',
  `image` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Đường dẫn hình ảnh',
  `origin` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Xuất xứ',
  `release_date` DATE NOT NULL COMMENT 'Thời điểm ra mắt',
  `warranty` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Thời gian bảo hành',
  `processor` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Chip xử lý',
  `storage` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Dung lượng bộ nhớ',
  `color` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Màu sắc',
  `screen_size` FLOAT NOT NULL COMMENT 'Kích thước màn hình (inch)',
  `screen_technology` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Công nghệ màn hình',
  `resolution` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Độ phân giải màn hình',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày thêm vào hệ thống',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật gần nhất',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_phones_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `phones` WRITE;

INSERT INTO `phones` (`id`, `name`, `brand_id`, `price`, `discount_percent`, `image`, `origin`, `release_date`, `warranty`, `processor`, `storage`, `color`, `screen_size`, `screen_technology`, `resolution`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 16 Pro Max', 1, 30000000.00, 10, '/uploads/1742329221_iphone_16_pro_max_desert_titan_3552a28ae0.png', 'Mỹ', '2025-03-19', '12 tháng', 'Apple A18 Pro', '128GB', 'Titan Sa Mạc', 6.5, 'Dynamic AMOLED 2X', '2886 x 1320 Pixel', '2025-03-18 20:20:21', '2025-03-18 21:15:06'),
(2, 'SamSung Galaxy S24', 2, 40000000.00, 10, '/uploads/1742330050_1742288278_samsung_galaxy_s24_ultra_2f8a5ee174.png', 'Hàn Quốc', '2025-03-19', '12 tháng', 'Snapdragon 8 Elite', '1TB', 'Xám', 6.9, 'Dynamic AMOLED 2X', ' 3120 x 1440 Pixels', '2025-03-18 20:34:10', '2025-03-20 10:29:24'),
(3, 'oppo', 4, 12345670.00, 20, '/uploads/1742334944_oppo_cate_thumb_8e37da2939.png', 'China', '2025-03-19', '12 tháng', 'snap gen 8', '64GB', 'Trắng', 6.5, 'OLED', 'FullHD', '2025-03-18 21:55:44', '2025-03-18 21:55:44'),
(4, 'SamSung Galaxy S24', 2, 39000000.00, 15, '/uploads/1742466476_1742288278_samsung_galaxy_s24_ultra_2f8a5ee174.png', 'Hàn Quốc', '2025-03-19', '12 tháng', 'Snapdragon 8 Elite', '1TB', 'Trắng', 6.9, 'Dynamic AMOLED 2X', ' 3120 x 1440 Pixels', '2025-03-20 10:27:56', '2025-03-20 10:29:50'),
(5, 'iPhone 16 Pro Max', 1, 30000000.00, 10, '/uploads/1742479597_iphone_16_pro_max_black_titan_b3274fbf05.png', 'Mỹ', '2025-03-19', '12 tháng', 'Apple A18 Pro', '128GB', 'Titan Đen', 6.5, 'Dynamic AMOLED 2X', '2886 x 1320 Pixel', '2025-03-18 20:20:21', '2025-03-18 21:15:06'),
(6, 'iPhone 16 Pro Max', 1, 30000000.00, 10, '/uploads/1742479651_iphone_16_pro_max_natural_titan_1875852ac7.png', 'Mỹ', '2025-03-19', '12 tháng', 'Apple A18 Pro', '128GB', 'Titan Tự Nhiên', 6.5, 'Dynamic AMOLED 2X', '2886 x 1320 Pixel', '2025-03-18 20:20:21', '2025-03-18 21:15:06'),
(7, 'iPhone 16 Pro Max', 1, 30000000.00, 10, '/uploads/1742479715_iphone_16_pro_max_white_titan_ec6c800e82.png', 'Mỹ', '2025-03-19', '12 tháng', 'Apple A18 Pro', '128GB', 'Titan Trắng', 6.5, 'Dynamic AMOLED 2X', '2886 x 1320 Pixel', '2025-03-18 20:20:21', '2025-03-18 21:15:06');

UNLOCK TABLES;

-- Tạo bảng carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID người dùng',
  `total_price` BIGINT NOT NULL DEFAULT 0.00 COMMENT 'Tổng tiền của giỏ hàng',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo giỏ hàng',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật giỏ hàng',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tạo bảng cart_items
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID giỏ hàng',
  `product_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID sản phẩm',
  `price` BIGINT NOT NULL COMMENT 'Giá của sản phẩm',
  `quantity` INT(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Số lượng sản phẩm',
  `color` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Màu sắc sản phẩm',
  `storage` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Dung lượng bộ nhớ sản phẩm',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày thêm vào giỏ hàng',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật sản phẩm trong giỏ hàng',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`cart_id`) REFERENCES `carts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `phones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

