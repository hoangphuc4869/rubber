-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 16, 2024 lúc 05:41 PM
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
-- Cấu trúc bảng cho bảng `bales`
--

CREATE TABLE `bales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `press_temperature` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `number_of_bales` int(11) NOT NULL,
  `cut_check` int(11) DEFAULT NULL,
  `evaluation` varchar(255) DEFAULT NULL,
  `expected_grade` varchar(255) DEFAULT NULL,
  `sample_cut_number` int(11) DEFAULT NULL,
  `packaging_type` varchar(255) DEFAULT NULL,
  `storage_location` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `warehouses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `drum_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bales`
--

INSERT INTO `bales` (`id`, `number_of_bales`) VALUES
(165, 27),
(166, 27),
(167, 27),
(168, 27),
(169, 27),
(170, 26),
(171, 27),
(172, 27),
(173, 27),
(174, 26),
(175, 26),
(176, 26),
(177, 26),
(178, 26),
(179, 27),
(180, 27),
(181, 27),
(182, 27),
(183, 27),
(184, 27),
(185, 27),
(186, 27),
(187, 27),
(188, 27),
(189, 27),
(190, 27),
(191, 27),
(192, 27),
(193, 27),
(194, 27),
(195, 27),
(196, 27),
(197, 27),
(198, 27),
(199, 27),
(200, 27),
(201, 27),
(202, 27),
(203, 27),
(204, 27),
(205, 27),
(206, 27),
(207, 27),
(208, 27),
(209, 27),
(210, 27),
(211, 27),
(212, 27),
(213, 27),
(214, 27),
(215, 27),
(216, 27),
(217, 27),
(218, 27),
(219, 27),
(220, 27),
(221, 27),
(222, 27),
(223, 27),
(224, 27);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bales`
--
ALTER TABLE `bales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bales_drum_id_foreign` (`drum_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bales`
--
ALTER TABLE `bales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bales`
--
ALTER TABLE `bales`
  ADD CONSTRAINT `bales_drum_id_foreign` FOREIGN KEY (`drum_id`) REFERENCES `drums` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
