-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 05, 2024 lúc 08:36 AM
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
-- Cấu trúc bảng cho bảng `rubber`
--

CREATE TABLE `rubber` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `truck_id` bigint(20) UNSIGNED DEFAULT NULL,
  `farm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiving_place_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latex_type` varchar(255) NOT NULL,
  `material_age` varchar(255) NOT NULL,
  `fresh_weight` bigint(20) NOT NULL,
  `drc_percentage` float NOT NULL,
  `dry_weight` float NOT NULL,
  `material_condition` int(10) UNSIGNED NOT NULL,
  `impurity_type` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rubber`
--

INSERT INTO `rubber` (`id`, `status`, `date`, `time`, `truck_id`, `farm_id`, `receiving_place_id`, `latex_type`, `material_age`, `fresh_weight`, `drc_percentage`, `dry_weight`, `material_condition`, `impurity_type`, `grade`, `created_at`, `updated_at`, `name`) VALUES
(64, 0, '2024-01-01', '11:59:00', 3, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9850, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3712'),
(65, 0, '2024-01-01', '12:26:00', 4, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10420, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3404'),
(66, 0, '2024-01-01', '12:27:00', 5, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8760, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-1256'),
(67, 0, '2024-01-01', '12:44:00', 6, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 12290, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-6608'),
(68, 0, '2024-01-01', '12:48:00', 7, 2, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 4970, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(69, 0, '2024-01-01', '13:12:00', 7, 2, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10960, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(70, 0, '2024-01-01', '13:58:00', 7, 2, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7840, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(71, 0, '2024-01-01', '13:59:00', 3, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11190, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3712'),
(72, 0, '2024-01-01', '14:02:00', 4, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11650, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3404'),
(73, 0, '2024-01-01', '14:30:00', 5, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9120, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-1256'),
(74, 0, '2024-01-01', '14:30:00', 6, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11920, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-6608'),
(75, 0, '2024-01-01', '14:35:00', 3, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7460, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3712'),
(76, 0, '2024-01-01', '15:22:00', 7, 2, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 13340, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(77, 0, '2024-01-01', '15:48:00', 4, 1, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 5230, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3404'),
(78, 0, '2024-01-01', '15:56:00', 7, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9820, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(79, 0, '2024-01-01', '16:51:00', 3, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7130, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3712'),
(80, 0, '2024-01-01', '16:55:00', 7, 2, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9550, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-4673'),
(81, 0, '2024-01-01', '17:00:00', 5, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8320, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-1256'),
(82, 0, '2024-01-01', '17:05:00', 6, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7390, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-6608'),
(83, 0, '2024-01-01', '17:14:00', 4, 6, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 5600, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, NULL, '3A-3404'),
(84, 0, '2024-01-01', '11:42:00', 8, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7480, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-1085'),
(85, 0, '2024-01-01', '11:49:00', 9, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8100, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1817'),
(86, 0, '2024-01-01', '12:16:00', 10, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9890, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2023'),
(87, 0, '2024-01-01', '12:21:00', 11, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7800, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-5787'),
(88, 0, '2024-01-01', '12:29:00', 12, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8090, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1440'),
(89, 0, '2024-01-01', '12:29:00', 13, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9400, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1012'),
(90, 0, '2024-01-01', '12:32:00', 14, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9080, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1844'),
(91, 0, '2024-01-01', '12:47:00', 15, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8490, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1020'),
(92, 0, '2024-01-01', '13:07:00', 16, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10570, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2020'),
(93, 0, '2024-01-01', '13:14:00', 17, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 6630, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-1474'),
(94, 0, '2024-01-01', '13:37:00', 18, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 15040, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2330'),
(95, 0, '2024-01-01', '13:42:00', 9, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 5720, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1817'),
(96, 0, '2024-01-01', '13:54:00', 19, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8900, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1373'),
(97, 0, '2024-01-01', '14:12:00', 11, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7090, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-5787'),
(98, 0, '2024-01-01', '14:35:00', 20, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11200, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1335'),
(99, 0, '2024-01-01', '14:38:00', 13, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11470, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1012'),
(100, 0, '2024-01-01', '14:40:00', 14, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 8200, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1844'),
(101, 0, '2024-01-01', '14:42:00', 16, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 6930, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2020'),
(102, 0, '2024-01-01', '14:46:00', 10, 8, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 9740, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2023'),
(103, 0, '2024-01-01', '14:53:00', 12, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10630, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1440'),
(104, 0, '2024-01-01', '15:13:00', 19, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 5550, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1373'),
(105, 0, '2024-01-01', '15:35:00', 15, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 11010, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1020'),
(106, 0, '2024-01-01', '15:48:00', 17, 5, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 6750, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-1474'),
(107, 0, '2024-01-01', '15:54:00', 13, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7030, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1012'),
(108, 0, '2024-01-01', '16:05:00', 18, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10610, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2330'),
(109, 0, '2024-01-01', '16:26:00', 10, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 6660, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2023'),
(110, 0, '2024-01-01', '16:28:00', 16, 4, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7420, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-2020'),
(111, 0, '2024-01-01', '16:45:00', 14, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 4360, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1844'),
(112, 0, '2024-01-01', '16:48:00', 20, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10900, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1335'),
(113, 0, '2024-01-01', '16:49:00', 9, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 13200, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1817'),
(114, 0, '2024-01-01', '17:06:00', 11, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 7970, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3B-5787'),
(115, 0, '2024-01-01', '17:27:00', 12, 7, NULL, 'đông chén', 'Bốc chồng nhiều nhất', 10030, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-05 03:23:31', '3A-1440');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `rubber`
--
ALTER TABLE `rubber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubber_truck_id_foreign` (`truck_id`),
  ADD KEY `rubber_farm_id_foreign` (`farm_id`),
  ADD KEY `rubber_receiving_place_id_foreign` (`receiving_place_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `rubber`
--
ALTER TABLE `rubber`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `rubber`
--
ALTER TABLE `rubber`
  ADD CONSTRAINT `rubber_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rubber_receiving_place_id_foreign` FOREIGN KEY (`receiving_place_id`) REFERENCES `curing_areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rubber_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
