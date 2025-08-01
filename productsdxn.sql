-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 يوليو 2025 الساعة 00:53
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productsdxn`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_cat` varchar(50) NOT NULL,
  `img_cat` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`id`, `name_cat`, `img_cat`) VALUES
(1, 'مشروبات و أغذية', 'الخلفية للاغذية.webp'),
(2, 'مستحضرات التجميل', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg'),
(3, 'العناية بالجسم والبشرة', 'خلفية العناية بالجسم.webp'),
(4, 'مكملات غذائية', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `customer_name` varchar(500) NOT NULL,
  `whatsapp` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `country` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` enum('جديد','جاري التجهيز','تم التوصيل') DEFAULT 'جديد'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`id_order`, `customer_name`, `whatsapp`, `email`, `country`, `city`, `order_date`, `status`) VALUES
(4, 'Amjad abdul hakim', '7466776', 'amjjjad120@gmail.com', 'Yemen', 'taiz', '2025-07-18 01:31:48', 'جديد'),
(5, 'Amjad abdul hakim', '7466776', 'amjjjad120@gmail.com', 'Yemen', 'taiz', '2025-07-18 01:34:43', 'جديد'),
(6, 'Amjad abdul hakim', '7466776', 'amjjjad120@gmail.com', 'Yemen', 'taiz', '2025-07-18 01:42:39', 'جديد'),
(7, 'ayman', '777777777', 'ayman@gmail', 'gf', 'df', '2025-07-23 17:28:32', 'تم التوصيل');

-- --------------------------------------------------------

--
-- بنية الجدول `order_items`
--

CREATE TABLE `order_items` (
  `id_item` int(11) NOT NULL,
  `id_pro` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `order_items`
--

INSERT INTO `order_items` (`id_item`, `id_pro`, `id_order`, `quantity`, `price`, `total`) VALUES
(4, 1, 4, 4, 50, 200),
(5, 11, 4, 5, 70, 350),
(6, 11, 5, 1, 70, 70),
(7, 11, 6, 3, 70, 210),
(8, 1, 7, 1, 50, 50);

-- --------------------------------------------------------

--
-- بنية الجدول `product`
--

CREATE TABLE `product` (
  `id_pro` int(11) NOT NULL,
  `name_pro` varchar(50) NOT NULL,
  `img_pro` varchar(2000) NOT NULL,
  `des_pro` varchar(1000) NOT NULL,
  `price` double NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `product`
--

INSERT INTO `product` (`id_pro`, `name_pro`, `img_pro`, `des_pro`, `price`, `id`) VALUES
(1, 'حليب', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg', 'كل شي', 50, 1),
(11, 'زيت الزيتون', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg', 'زيت', 70, 1),
(12, 'دهان', 'ا', 'ت', 79, 1),
(13, 'ماء', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg', 'ماء ', 2000, 2),
(14, 'ماء', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg', 'ماء', 1500, 2),
(15, 'قهوة', 'envato-labs-ai-c1b3f9f0-50e8-487a-8c23-8ad6071770ef.jpg', 'قهوة', 3000, 2),
(16, 'بودرة اللؤلؤ', 'بودرة اللؤلؤ.webp', 'بودرة اللؤلؤ', 12.36, 3),
(17, 'بودرة تالكوم', 'بودرة تالكوم.webp', 'بودرة تالكوم', 3860, 3),
(18, 'رغوة الجسم', 'رغوة الجسم.webp', 'رغوة الجسم', 4375, 3),
(19, 'زيت (تشوبي)زيت الأطفال', 'زيت (تشوبي)زيت الأطفال.webp', 'زيت (تشوبي)زيت الأطفال', 1276, 3),
(20, 'زيت المساج (جانو)', 'زيت المساج (جانو).webp', 'زيت المساج (جانو)', 4450, 3),
(21, 'زيت جوز الهند العضوي', 'زيت جوز الهند العضوي.webp', 'زيت جوز الهند العضوي', 9980, 3),
(22, 'شابو(جانوزي)', 'شابو(جانوزي).webp', 'شابو(جانوزي)', 4380, 3),
(23, 'صابون(جانوزي)', 'صابون(جانوزي).webp', 'صابون(جانوزي)', 2850, 3),
(24, 'عطر فيحاء لنساء', 'عطر فيحاء لنساء.webp', 'عطر فيحاء لنساء', 26100, 3),
(25, 'عطر فيزا للرجال', 'عطر فيزا للرجال.webp', 'عطر فيزا للرجال', 26100, 3),
(26, 'كريم (شجرة الشاي)', 'كريم (شجرة الشاي).webp', 'كريم (شجرة الشاي)', 1150, 3),
(27, 'معجون الأسنان(جانوزي)', 'معجون الأسنان(جانوزي).webp', 'معجون الأسنان(جانوزي)', 1150, 3),
(28, 'مقشر البابايا للبشرة', 'مقشر البابايا للبشرة.webp', 'مقشر البابايا للبشرة', 5100, 3),
(29, 'خل الأرز فيناقريتي', 'خل الأرز فيناقريتي.webp', 'خل الأرز فيناقريتي', 33660, 1),
(30, 'زهي منت (حلو النعناع)', 'زهي منت (حلو النعناع).webp', 'زهي منت (حلو النعناع)', 12000, 1),
(31, 'شاي لاتية', 'شاي لاتية.webp', 'شاي لاتية', 9800, 1),
(32, 'شاي لمونزي', 'شاي لمونزي.webp', 'شاي لمونزي', 6100, 1),
(33, 'شاي لنيجزي', 'شاي لنيجزي.webp', 'شاي لنيجزي', 5800, 1),
(34, 'عصير الكيوي المركز', 'عصير الكيوي المركز.webp', 'عصير الكيوي المركز', 9700, 1),
(35, 'عصير المورينزايم', 'عصير المورينزايم.webp', 'عصير المورينزايم', 5600, 1),
(36, 'عصير الموينزي', 'عصير الموينزي.webp', 'عصير الموينزي', 17100, 1),
(37, 'عصير كورديباين', 'عصير كورديباين.webp', 'عصير كورديباين', 10600, 1),
(38, 'قهوة الكريمة', 'قهوة الكريمة.webp', 'قهوة الكريمة', 7300, 1),
(39, 'قهوة الكورديسبس', 'قهوة الكورديسبس.webp', 'قهوة الكورديسبس', 7500, 1),
(40, 'قهوة لينجزي السوداء', 'قهوة لينجزي السوداء.webp', 'قهوة لينجزي السوداء', 5900, 1),
(41, 'قهوه لايت', 'قهوه لايت.webp', 'قهوه لايت', 5900, 1),
(42, 'مربي الاناناس', 'مربي الاناناس.webp', 'مربي الاناناس', 3200, 1),
(43, 'مشروب كوكوزي', 'مشروب كوكوزي.webp', 'مشروب كوكوزي', 7700, 1),
(44, 'ملح الهيمالايا', 'ملح الهيمالايا.webp', 'ملح الهيمالايا', 3900, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_pro` (`id_pro`,`id_order`),
  ADD KEY `order_items_ibfk_2` (`id_order`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_pro`),
  ADD UNIQUE KEY `id_pro` (`id_pro`,`id`),
  ADD KEY `product_ibfk_1` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id_pro`) REFERENCES `product` (`id_pro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
