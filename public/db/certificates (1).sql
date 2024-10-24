-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th10 23, 2024 lúc 03:42 PM
-- Phiên bản máy phục vụ: 10.6.7-MariaDB-log
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sql_demo_chusek`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `certificates`
--

INSERT INTO `certificates` (`id`, `name`, `file_path`, `created_at`, `updated_at`) VALUES
(9, '1', '1729669106_certificate_page-1.jpg', '2024-10-23 07:38:26', '2024-10-23 07:40:19'),
(10, '2', '1729669115_certificate_page-2.jpg', '2024-10-23 07:38:35', '2024-10-23 07:38:35'),
(11, '3', '1729669120_certificate_page-3.jpg', '2024-10-23 07:38:40', '2024-10-23 07:38:40'),
(12, '4', '1729669129_certificate_page-4.jpg', '2024-10-23 07:38:49', '2024-10-23 07:38:49'),
(13, '5', '1729669134_certificate_page-5.jpg', '2024-10-23 07:38:54', '2024-10-23 07:38:54'),
(14, 'chungnhan1', '1729669169_chungnhan-1.jpg', '2024-10-23 07:39:29', '2024-10-23 07:39:29'),
(15, 'chungnhan2', '1729669182_chungnhan-2.jpg', '2024-10-23 07:39:42', '2024-10-23 07:39:42'),
(16, 'chungnhanphuhop', '1729669195_giaychungnhanphuhopPEFC.jpg', '2024-10-23 07:39:55', '2024-10-23 07:39:55'),
(17, 'ISO', '1729669248_ISO-1400-12015.jpg', '2024-10-23 07:40:04', '2024-10-23 07:40:48');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
