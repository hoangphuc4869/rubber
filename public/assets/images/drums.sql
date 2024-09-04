-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 04, 2024 lúc 08:40 AM
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
-- Cấu trúc bảng cho bảng `drums`
--

CREATE TABLE `drums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rolling_code` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_index` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `heated_date` date DEFAULT NULL,
  `heated_time` time DEFAULT NULL,
  `temp` int(11) DEFAULT NULL,
  `state` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `baled` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bale_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `drums`
--

INSERT INTO `drums` (`id`, `rolling_code`, `status`, `code`, `name`, `last_index`, `date`, `time`, `heated_date`, `heated_time`, `temp`, `state`, `created_at`, `updated_at`, `baled`, `batch_id`, `bale_id`) VALUES
(233, 4, 1, 'N1BU1_1724993174_001', '1', 1, '2024-08-30', '11:46:00', '2024-08-30', '11:46:00', 36, 'Sạch', '2024-08-30 04:46:14', '2024-08-30 04:46:44', 1, 3, NULL),
(234, 4, 1, 'N1BU1_1724993174_002', '2', 2, '2024-08-30', '11:46:00', '2024-08-30', '11:46:00', 36, 'Sạch', '2024-08-30 04:46:14', '2024-08-30 04:46:44', 1, 3, NULL),
(235, 5, 1, 'N1BU2_1725424253_001', '1', 1, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:42:23', 1, 4, NULL),
(236, 5, 1, 'N1BU2_1725424253_002', '2', 2, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:42:23', 1, 4, NULL),
(237, 5, 1, 'N1BU2_1725424253_003', '3', 3, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:42:23', 1, 4, NULL),
(238, 5, 1, 'N1BU2_1725424253_004', '4', 4, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:32:38', 1, NULL, NULL),
(239, 5, 1, 'N1BU2_1725424253_005', '5', 5, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:32:38', 1, NULL, NULL),
(240, 5, 1, 'N1BU2_1725424253_006', '6', 6, '2024-09-04', '11:30:00', '2024-09-04', '11:31:00', 36, 'Sạch', '2024-09-04 04:30:53', '2024-09-04 04:32:38', 1, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `drums`
--
ALTER TABLE `drums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drums_rolling_code_foreign` (`rolling_code`),
  ADD KEY `drums_batch_id_foreign` (`batch_id`),
  ADD KEY `drums_bale_id_foreign` (`bale_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `drums`
--
ALTER TABLE `drums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `drums`
--
ALTER TABLE `drums`
  ADD CONSTRAINT `drums_bale_id_foreign` FOREIGN KEY (`bale_id`) REFERENCES `bales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `drums_rolling_code_foreign` FOREIGN KEY (`rolling_code`) REFERENCES `rubber_warehouses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
