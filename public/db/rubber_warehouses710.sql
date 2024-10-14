-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 07, 2024 lúc 05:19 AM
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
-- Cấu trúc bảng cho bảng `rubber_warehouses`
--

CREATE TABLE `rubber_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `weight_to_roll` bigint(20) NOT NULL,
  `handled` bigint(20) NOT NULL DEFAULT 0,
  `rubbers` varchar(255) DEFAULT NULL,
  `impurity_removing` text DEFAULT NULL,
  `date_curing` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `curing_house_id` bigint(20) UNSIGNED DEFAULT NULL,
  `curing_area_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rubber_warehouses`
--

INSERT INTO `rubber_warehouses` (`id`, `code`, `status`, `weight_to_roll`, `handled`, `rubbers`, `impurity_removing`, `date_curing`, `date`, `time`, `created_at`, `updated_at`, `curing_house_id`, `curing_area_id`) VALUES
(86, '1727789164', 0, 313916, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:21:00', '2024-09-30 23:26:04', '2024-09-30 23:26:04', 4, 4),
(87, '1727789392', 0, 327932, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:28:00', '2024-09-30 23:29:52', '2024-09-30 23:29:52', 5, 5),
(88, '1727789519', 0, 377330, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:30:00', '2024-09-30 23:31:59', '2024-09-30 23:31:59', 7, 7),
(89, '1727789557', 0, 417331, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:32:00', '2024-09-30 23:32:37', '2024-09-30 23:32:37', 8, 8),
(92, '1727961695', 0, 110148, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:20:00', '2024-10-03 13:21:35', '2024-10-03 13:21:35', 10, 10),
(93, '1727961755', 0, 229143, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:21:00', '2024-10-03 13:22:35', '2024-10-03 13:22:35', 9, 9),
(94, '1727961800', 0, 509119, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:22:00', '2024-10-03 13:23:20', '2024-10-03 13:23:20', 1, 1),
(95, '1727961819', 0, 441785, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:23:00', '2024-10-03 13:23:39', '2024-10-03 13:23:39', 2, 2),
(96, '1727961856', 0, 350729, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:23:00', '2024-10-03 13:24:16', '2024-10-03 13:24:16', 3, 3),
(97, '1727961870', 0, 473665, 0, NULL, NULL, '2024-09-30', '2024-10-01', '20:24:00', '2024-10-03 13:24:30', '2024-10-03 13:24:30', 6, 6);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubber_warehouses_curing_house_id_foreign` (`curing_house_id`),
  ADD KEY `rubber_warehouses_curing_area_id_foreign` (`curing_area_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  ADD CONSTRAINT `rubber_warehouses_curing_area_id_foreign` FOREIGN KEY (`curing_area_id`) REFERENCES `curing_areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rubber_warehouses_curing_house_id_foreign` FOREIGN KEY (`curing_house_id`) REFERENCES `curing_houses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
