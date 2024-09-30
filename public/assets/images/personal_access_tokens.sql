-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 15, 2024 lúc 06:23 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `rubber_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Token Name', '4ee0d9cfc163de75f9ca44da75b5999c1bce93063efd08ed6eec59d138688194', '[\"*\"]', NULL, NULL, '2024-09-13 05:41:18', '2024-09-13 05:41:18'),
(2, 'App\\Models\\User', 1, 'Token Name', 'e843078f6387e8d8a87a98ea6299572c17a7ad43723209c78697167745d17568', '[\"*\"]', NULL, NULL, '2024-09-13 05:46:55', '2024-09-13 05:46:55'),
(3, 'App\\Models\\User', 1, 'Login', '16dacfb8f4b70a61ec6a9a0ed1e74156d80c2d5a288507a2b93e95811eae4146', '[\"*\"]', NULL, NULL, '2024-09-13 05:47:34', '2024-09-13 05:47:34'),
(4, 'App\\Models\\User', 1, 'Login', '92550dacbf59aa5d87229692a74607491d0d7444f627993d5e77b49bc540e69c', '[\"*\"]', NULL, NULL, '2024-09-13 05:49:41', '2024-09-13 05:49:41'),
(5, 'App\\Models\\User', 1, 'Login', 'ac9d40f9af3ff25268c47abd70acbd46a0386a4ccf39fb5582a09ee465f631c8', '[\"*\"]', NULL, NULL, '2024-09-13 08:33:20', '2024-09-13 08:33:20'),
(6, 'App\\Models\\User', 1, 'Login', '4408cafd993b210b530b2500fa7b3e468b621ac27cca27fa260c9813659e5a94', '[\"*\"]', NULL, NULL, '2024-09-13 14:08:12', '2024-09-13 14:08:12'),
(7, 'App\\Models\\User', 1, 'Login', '1d9af7692ac1814db3d4d3a7fc84855122e9a0177297817966f17df2b9b19122', '[\"*\"]', NULL, NULL, '2024-09-13 14:35:27', '2024-09-13 14:35:27'),
(8, 'App\\Models\\User', 1, 'Login', 'c10129941fbfad87a7406ac42958a3d8f58a8a2c1df5a1c0319c4d57cbce6c8a', '[\"*\"]', NULL, NULL, '2024-09-13 14:53:36', '2024-09-13 14:53:36'),
(9, 'App\\Models\\User', 1, 'Login', '483b58e24ad27c739c92cdcf172ec4b046aa81e21c15642dd4de9850c24f097f', '[\"*\"]', NULL, NULL, '2024-09-14 15:31:00', '2024-09-14 15:31:00'),
(10, 'App\\Models\\User', 1, 'Login', '447ca416dc7fb06d7c946b9008e3c911984f1ec068a18c119580643e2cc0a8f3', '[\"*\"]', NULL, NULL, '2024-09-14 16:05:28', '2024-09-14 16:05:28'),
(11, 'App\\Models\\User', 1, 'Login', '34d682be1682af22c9dc88b9beb3afe6b34d34051021fd07c7662489637a4af0', '[\"*\"]', NULL, NULL, '2024-09-14 17:22:14', '2024-09-14 17:22:14'),
(12, 'App\\Models\\User', 1, 'Login', 'd1eb22db75b6b9b0f18c886d1ed333d6fe2e3bc24fe939ddd148a1f4bf9123a8', '[\"*\"]', '2024-09-15 03:31:33', NULL, '2024-09-14 17:27:36', '2024-09-15 03:31:33'),
(13, 'App\\Models\\User', 1, 'Login', 'd3a83aacf550eff7d34470e3e2193f33909644141bcc1b6a56f20e1d821b2d6f', '[\"*\"]', NULL, NULL, '2024-09-14 17:32:27', '2024-09-14 17:32:27'),
(14, 'App\\Models\\User', 1, 'Login', '49935791a6465d8dcdc7410086d218183d9dd3ad04e761171670c24013dbb075', '[\"*\"]', NULL, NULL, '2024-09-15 03:27:40', '2024-09-15 03:27:40');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
