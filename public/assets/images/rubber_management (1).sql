-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 18, 2024 lúc 04:14 PM
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

INSERT INTO `bales` (`id`, `press_temperature`, `weight`, `number_of_bales`, `cut_check`, `evaluation`, `expected_grade`, `sample_cut_number`, `packaging_type`, `storage_location`, `date`, `time`, `created_at`, `updated_at`, `warehouses_id`, `drum_id`) VALUES
(416, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:30:54', '2024-09-18 10:30:54', NULL, 896),
(417, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:30:54', '2024-09-18 10:30:54', NULL, 897),
(418, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:30:54', '2024-09-18 10:30:54', NULL, 898),
(419, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:30:54', '2024-09-18 10:30:54', NULL, 899),
(420, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:30:54', '2024-09-18 10:30:54', NULL, 900),
(421, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:30:00', '2024-09-18 10:31:01', '2024-09-18 10:31:01', NULL, 901),
(422, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:08', '2024-09-18 10:31:08', NULL, 902),
(423, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:08', '2024-09-18 10:31:08', NULL, 903),
(424, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:08', '2024-09-18 10:31:08', NULL, 904),
(425, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:13', '2024-09-18 10:31:13', NULL, 905),
(426, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 906),
(427, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 907),
(428, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 908),
(429, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 909),
(430, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 910),
(431, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 911),
(432, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 912),
(433, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 913),
(434, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 914),
(435, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '17:31:00', '2024-09-18 10:31:17', '2024-09-18 10:31:17', NULL, 915),
(436, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:13:00', '2024-09-18 11:14:53', '2024-09-18 11:14:53', NULL, 916),
(437, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:13:00', '2024-09-18 11:14:53', '2024-09-18 11:14:53', NULL, 917),
(438, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:13:00', '2024-09-18 11:14:53', '2024-09-18 11:14:53', NULL, 918),
(439, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:13:00', '2024-09-18 11:14:53', '2024-09-18 11:14:53', NULL, 919),
(440, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:14:00', '2024-09-18 11:15:05', '2024-09-18 11:15:05', NULL, 920),
(441, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:14', '2024-09-18 11:15:14', NULL, 921),
(442, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:14', '2024-09-18 11:15:14', NULL, 922),
(443, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:14', '2024-09-18 11:15:14', NULL, 923),
(444, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:14', '2024-09-18 11:15:14', NULL, 924),
(445, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:14', '2024-09-18 11:15:14', NULL, 925),
(446, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:23', '2024-09-18 11:15:23', NULL, 926),
(447, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:23', '2024-09-18 11:15:23', NULL, 927),
(448, 38, 35, 26, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:23', '2024-09-18 11:15:23', NULL, 928),
(449, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 929),
(450, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 930),
(451, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 931),
(452, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 932),
(453, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 933),
(454, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 934),
(455, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 935),
(456, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 936),
(457, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 937),
(458, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 938),
(459, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 939),
(460, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 940),
(461, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 941),
(462, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 942),
(463, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 943),
(464, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 944),
(465, 38, 35, 27, 7, 'Chín đều', NULL, NULL, NULL, NULL, '2024-09-18', '18:15:00', '2024-09-18 11:15:29', '2024-09-18 11:15:29', NULL, 945);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expected_grade` varchar(255) DEFAULT NULL,
  `batch_number` int(11) DEFAULT NULL,
  `batch_code` text NOT NULL,
  `exported` int(11) NOT NULL DEFAULT 0,
  `checked` int(11) NOT NULL DEFAULT 0,
  `export_location` text DEFAULT NULL,
  `date_export` date DEFAULT NULL,
  `sample_cut_number` int(11) DEFAULT NULL,
  `packaging_type` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `storage_location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `shipment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `batches`
--

INSERT INTO `batches` (`id`, `expected_grade`, `batch_number`, `batch_code`, `exported`, `checked`, `export_location`, `date_export`, `sample_cut_number`, `packaging_type`, `date`, `time`, `storage_location`, `created_at`, `updated_at`, `warehouse_id`, `company_id`, `shipment_id`) VALUES
(92, 'CSR10', 1, '241391', 1, 1, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '17:33:00', NULL, '2024-09-18 10:34:17', '2024-09-18 10:44:46', 1455, 2, 35),
(93, 'CSR10', 2, '241392', 1, 1, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '17:33:00', NULL, '2024-09-18 10:34:17', '2024-09-18 11:27:59', 1443, 2, 36),
(94, 'CSR10', 3, '241393', 1, 1, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '17:33:00', NULL, '2024-09-18 10:34:17', '2024-09-18 11:27:59', 1441, 2, 36),
(95, 'CSR10', 4, '241394', 1, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:27:59', 1451, 2, 36),
(96, 'CSR10', 5, '241395', 0, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:21:14', 1445, 2, NULL),
(97, 'CSR10', 6, '241396', 0, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:17:29', NULL, 2, NULL),
(98, 'CSR10', 7, '241397', 0, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:21:33', 1448, 2, NULL),
(99, 'CSR10', 8, '241398', 0, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:17:29', NULL, 2, NULL),
(100, 'CSR10', 9, '241399', 0, 0, NULL, NULL, 7, 'pallet sắt', '2024-09-18', '18:15:00', NULL, '2024-09-18 11:17:29', '2024-09-18 11:17:29', NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `batch_drum`
--

CREATE TABLE `batch_drum` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `drum_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `bale_count` int(11) NOT NULL,
  `bale_remaining` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `batch_drum`
--

INSERT INTO `batch_drum` (`id`, `drum_id`, `batch_id`, `bale_count`, `bale_remaining`, `created_at`, `updated_at`) VALUES
(435, 896, 92, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(436, 897, 92, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(437, 898, 92, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(438, 899, 92, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(439, 900, 92, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(440, 901, 92, 9, 17, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(441, 901, 93, 17, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(442, 902, 93, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(443, 903, 93, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(444, 904, 93, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(445, 905, 93, 26, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(446, 906, 93, 20, 7, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(447, 906, 94, 7, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(448, 907, 94, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(449, 908, 94, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(450, 909, 94, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(451, 910, 94, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(452, 911, 94, 27, 0, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(453, 912, 94, 2, 25, '2024-09-18 10:34:17', '2024-09-18 10:34:17'),
(454, 912, 95, 25, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(455, 913, 95, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(456, 914, 95, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(457, 915, 95, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(458, 916, 95, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(459, 917, 95, 11, 16, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(460, 917, 96, 16, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(461, 918, 96, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(462, 919, 96, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(463, 920, 96, 26, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(464, 921, 96, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(465, 922, 96, 21, 6, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(466, 922, 97, 6, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(467, 923, 97, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(468, 924, 97, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(469, 925, 97, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(470, 926, 97, 26, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(471, 927, 97, 26, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(472, 928, 97, 5, 21, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(473, 928, 98, 21, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(474, 929, 98, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(475, 930, 98, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(476, 931, 98, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(477, 932, 98, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(478, 933, 98, 15, 12, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(479, 933, 99, 12, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(480, 934, 99, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(481, 935, 99, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(482, 936, 99, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(483, 937, 99, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(484, 938, 99, 24, 3, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(485, 938, 100, 3, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(486, 939, 100, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(487, 940, 100, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(488, 941, 100, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(489, 942, 100, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(490, 943, 100, 27, 0, '2024-09-18 11:17:29', '2024-09-18 11:17:29'),
(491, 944, 100, 6, 21, '2024-09-18 11:17:29', '2024-09-18 11:17:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `companies`
--

INSERT INTO `companies` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Công ty TNHH TMDV BHCK', 'BHCK', '2024-09-07 02:07:27', '2024-09-07 03:32:21'),
(2, 'CÔNG TY PHÁT TRIỂN CAO SU C.R.C.K', 'CRCK2', '2024-09-07 02:08:13', '2024-09-09 03:10:19'),
(3, 'CÔNG TY TÂY NINH SIÊM RIỆP PHÁT TRIỂN CAO SU', 'TNSR', '2024-09-07 02:09:39', '2024-09-07 02:09:39'),
(4, 'THU MUA', 'THUMUA', '2024-09-07 02:09:53', '2024-09-09 02:43:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contract`
--

CREATE TABLE `contract` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_type_id` int(9) DEFAULT NULL,
  `so_ngay_hd` varchar(255) DEFAULT NULL,
  `contract_number` varchar(50) DEFAULT NULL,
  `count_contract` varchar(191) DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `hd_goc_so` varchar(255) DEFAULT NULL,
  `thang_giao_hang` varchar(255) DEFAULT NULL,
  `customer_id` int(9) DEFAULT NULL,
  `so_luong` float DEFAULT NULL,
  `san_pham` varchar(50) DEFAULT NULL,
  `ngay_giao_hang` date DEFAULT NULL,
  `ngay_dong_cont` date DEFAULT NULL,
  `loai_pallet` varchar(255) DEFAULT NULL,
  `lenh_xuat_hang` varchar(255) DEFAULT NULL,
  `thi_truong` varchar(255) DEFAULT NULL,
  `don_vi_xuat_thuong_mai` varchar(255) DEFAULT NULL,
  `supplier` varchar(191) DEFAULT NULL,
  `ban_cho_ben_thu_3` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contract`
--

INSERT INTO `contract` (`id`, `contract_type_id`, `so_ngay_hd`, `contract_number`, `count_contract`, `contract_date`, `hd_goc_so`, `thang_giao_hang`, `customer_id`, `so_luong`, `san_pham`, `ngay_giao_hang`, `ngay_dong_cont`, `loai_pallet`, `lenh_xuat_hang`, `thi_truong`, `don_vi_xuat_thuong_mai`, `supplier`, `ban_cho_ben_thu_3`, `created_at`, `updated_at`) VALUES
(136, 3, NULL, '123', '123', '2024-09-18', '123', '01', 13, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2024-09-18', '2024-09-18'),
(137, 3, NULL, '123', '1233', '2024-09-05', '123', '01', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2024-09-18', '2024-09-18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contract_type`
--

CREATE TABLE `contract_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contract_type`
--

INSERT INTO `contract_type` (`id`, `type`, `code`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Hợp đồng Dài hạn', 'CRCK2', 'LONG-TERM CONTRACT', '2023-05-31', '2023-10-23'),
(4, 'Hợp đồng Bán chuyến', 'CRCK2', 'SALES CONTRACT', '2023-06-17', '2023-10-23'),
(5, 'Hợp đồng Nguyên tắc', 'CRCK2', 'CONTRACT PRINCIPLES', '2023-08-05', '2023-10-23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `curing_areas`
--

CREATE TABLE `curing_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `containing` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `farm_id` int(11) DEFAULT NULL,
  `latex_type` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `curing_areas`
--

INSERT INTO `curing_areas` (`id`, `name`, `code`, `containing`, `created_at`, `updated_at`, `farm_id`, `latex_type`) VALUES
(1, 'Nguyên liệu nông trường 1', 'NLNT1', 0, '2024-09-05 06:50:41', '2024-09-18 09:57:11', 1, 'Mủ đông chén'),
(2, 'Nguyên liệu nông trường 2', 'NLNT2', 0, '2024-09-05 06:51:08', '2024-09-18 07:44:39', 2, 'Mủ đông chén'),
(3, 'Nguyên liệu nông trường 3', 'NLNT3', 0, '2024-09-05 06:51:59', '2024-09-18 10:05:52', 3, 'Mủ đông chén'),
(4, 'Nguyên liệu nông trường 4', 'NLNT4', 0, '2024-09-05 06:52:21', '2024-09-18 07:44:46', 4, 'Mủ đông chén'),
(5, 'Nguyên liệu nông trường 5', 'NLNT5', 0, '2024-09-05 06:54:46', '2024-09-18 07:44:49', 5, 'Mủ đông chén'),
(6, 'Nguyên liệu nông trường 6', 'NLNT6', 0, '2024-09-05 06:55:06', '2024-09-18 07:44:52', 6, 'Mủ đông chén'),
(7, 'Nguyên liệu nông trường 7', 'NLNT7', 0, '2024-09-05 06:55:53', '2024-09-18 07:45:09', 7, 'Mủ đông chén'),
(8, 'Nguyên liệu nông trường 8', 'NLNT8', 0, '2024-09-05 06:56:05', '2024-09-18 08:19:23', 8, 'Mủ đông chén'),
(9, 'Nguyên liệu Tây Nguyên', 'NLTNSR', 0, '2024-09-05 06:56:43', '2024-09-18 07:58:14', 10, 'Mủ đông chén'),
(10, 'Nguyên liệu thu mua mủ đông chén', 'NLTM', 0, '2024-09-05 06:57:39', '2024-09-18 07:47:23', 9, 'Mủ đông chén'),
(11, 'Nguyên liệu mủ dây', 'MDCR', 0, '2024-09-05 06:58:45', '2024-09-18 07:47:07', 14, 'Mủ dây'),
(21, 'Nguyên liệu thu mua mủ dây', 'NLTMMD', 0, '2024-09-18 07:46:48', '2024-09-18 07:46:48', 9, 'Mủ dây');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `curing_houses`
--

CREATE TABLE `curing_houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `containing` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `curing_area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `curing_houses`
--

INSERT INTO `curing_houses` (`id`, `name`, `code`, `containing`, `created_at`, `updated_at`, `curing_area_id`) VALUES
(1, 'Nguyên liệu cán vắt nông trường 1', 'NLCVNT1', 0, '2024-09-05 07:00:33', '2024-09-18 09:59:02', 1),
(2, 'Nguyên liệu cán vắt nông trường 2', 'NLCVNT2', 0, '2024-09-05 07:01:00', '2024-09-10 10:33:02', 2),
(3, 'Nguyên liệu cán vắt nông trường 3', 'NLCVNT3', 19800, '2024-09-05 07:01:22', '2024-09-18 11:13:05', 3),
(4, 'Nguyên liệu cán vắt nông trường 4', 'NLCVNT4', 0, '2024-09-05 07:01:39', '2024-09-10 04:29:43', 4),
(5, 'Nguyên liệu cán vắt nông trường 5', 'NLCVNT5', 0, '2024-09-05 07:01:58', '2024-09-14 17:35:34', 5),
(6, 'Nguyên liệu cán vắt nông trường 6', 'NLCVNT6', 0, '2024-09-05 07:02:21', '2024-09-10 04:29:57', 6),
(7, 'Nguyên liệu cán vắt nông trường 7', 'NLCVNT7', 0, '2024-09-05 07:02:58', '2024-09-10 04:30:08', 7),
(8, 'Nguyên liệu cán vắt nông trường 8', 'NLCVNT8', 0, '2024-09-05 07:03:27', '2024-09-18 08:20:22', 8),
(9, 'Nguyên liệu cán vắt Tây Nguyên', 'NLCVTNSR', 0, '2024-09-05 07:04:22', '2024-09-10 04:30:32', 9),
(10, 'Nguyên liệu cán vắt thu mua', 'NLCVTM', 0, '2024-09-05 07:05:12', '2024-09-10 04:30:39', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(9) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `phone`, `type`, `description`, `created_at`, `updated_at`) VALUES
(9, 'SINTEX CHEMICAL CORP', NULL, '886-2-27058001', 'KH Dài hạn', 'Address: C/O 10F-2, No. 306, Sec. 4, Hsin Yi Road, Taipei Taiwan.', '2023-06-17', '2023-06-17'),
(10, 'HK RUBBER KAMPONG THOM CO., LTD', 'hkkrubber@gmail.com', '(+855) 883 399 790', 'KH Ngắn hạn', 'Tax Code: B106-902105918 ; Represented by MRS. DINH THI KIM LIEN - Director (Giám đốc) ; Address: Thmor Samleang village, Krayea Commune, Santuk district, Kampong Thom province, Cambodia.', '2023-06-17', '2023-06-17'),
(11, '(VRG) VIETNAM RUBBER GROUP - JOINT STOCK COMPANY', NULL, '+84 2839326021', 'KH Dài hạn', 'Represented by MR TRAN THANH PHUNG - Deputy General Director  ; Address: 236 Nam Ky Khoi Nghia. Vo Thi Sau Ward, District 3, HCM City, Viet Nam.', '2023-06-17', '2023-08-10'),
(12, 'CART TIRE CO., LTD', NULL, '0312759898', 'KH Ngắn hạn', 'Represented by MR LI XIAODONG - Director; Add: Qilu SEZ, National Road 1, Sangkat Svay Teu, Krong Svay Rieng, Svay Rieng Province, Kingdom of Cambodia', '2023-06-17', '2023-06-17'),
(13, 'LIEN ANH PRODUCTION RUBBER CO.,LTD', 'lienanhrubber@lienanhrubber.com', '+84-2763 816325', 'KH Dài hạn', 'Rep by: DOAN VAN LUC address: No.466 Tran Van Tra, KinhTe Hamlet, Binh Minh Commune, Tay Ninh city, Tay Ninh Province, VietNam', '2023-08-01', '2023-08-15'),
(14, 'SAILUN (VIETNAM) CO., LTD', NULL, '0084-66- 3534223', 'KH Dài hạn', 'Tax code: 3901064759 ; Address: Lot 37-1...41-20a, D11 Road, Phuoc Dong Industrial Park,Phuoc Dong Ward, Go Dau County, Tay Ninh Province ,Vietnam.', '2023-09-14', '2023-09-14'),
(17, 'HOANG KIM RUBBER COMMERCIAL LTD', 'hoangkimrubber@gmail.com', '0703 916 808', 'KH Ngắn hạn', 'Address:  Ngo Quyen, Ba Ngoi Ward, Cam Ranh City, Khanh Hoa Province, Viet Nam - Tax Code: 0316636994 -', '2023-10-17', '2023-10-17'),
(18, 'HUANGJIN RUBBER PTE.LTD', 'huangjinrubber@gmail.com', NULL, 'KH Dài hạn', 'Represented by: Ms. Nguyen Thi Hanh Diem, Add: 10 Anson Road #33-02 International Plaza Singapore 079903', '2024-01-30', '2024-01-30'),
(19, 'HIEP THANH RUBBER INDUSTRIES CORPORATION', 'ctyhiepthanhxnk@gmail.com', '0274 221 2821', 'KH Ngắn hạn', 'Land slot No. 409, Map sheet 41, Bau Bang Hamlet, Lai Uyen Town,  Bau Bang District, Binh Duong Province, Vietnam', '2024-04-04', '2024-04-04'),
(23, 'phúc', 'phuc3@gmail.com12313', '123123123', 'KH Ngắn hạn', '123123123123', '2024-09-06', '2024-09-06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `delivery_dates`
--

CREATE TABLE `delivery_dates` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_id` int(10) UNSIGNED NOT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `shipping_order` varchar(191) DEFAULT NULL,
  `container_loading_date` date NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `drums`
--

CREATE TABLE `drums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_index` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `heated_date` date DEFAULT NULL,
  `heated_start` time DEFAULT NULL,
  `heated_end` time DEFAULT NULL,
  `temp` int(11) DEFAULT NULL,
  `temp2` int(11) DEFAULT NULL,
  `state` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `baled` bigint(20) UNSIGNED DEFAULT NULL,
  `bale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rolling_code` bigint(20) UNSIGNED DEFAULT NULL,
  `curing_house_id` int(11) DEFAULT NULL,
  `link` int(11) NOT NULL,
  `supervisor` text DEFAULT NULL,
  `heating_supervisor` text DEFAULT NULL,
  `impurity_removing` text DEFAULT NULL,
  `thickness` text DEFAULT NULL,
  `trang_thai_com` text DEFAULT NULL,
  `oven` int(11) DEFAULT NULL,
  `validation` text DEFAULT NULL,
  `time_to_dry` int(11) DEFAULT NULL,
  `remaining_bales` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `drums`
--

INSERT INTO `drums` (`id`, `status`, `code`, `name`, `last_index`, `date`, `time`, `heated_date`, `heated_start`, `heated_end`, `temp`, `temp2`, `state`, `created_at`, `updated_at`, `baled`, `bale_id`, `batch_id`, `rolling_code`, `curing_house_id`, `link`, `supervisor`, `heating_supervisor`, `impurity_removing`, `thickness`, `trang_thai_com`, `oven`, `validation`, `time_to_dry`, `remaining_bales`) VALUES
(896, 1, '1726655365_31', '1', 1, '2024-09-18', '17:38:00', '2024-09-18', '17:39:00', '22:39:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:30:54', 1, 416, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(897, 1, '1726655365_32', '2', 2, '2024-09-18', '17:48:00', '2024-09-18', '17:49:00', '22:49:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:30:54', 1, 417, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(898, 1, '1726655365_33', '3', 3, '2024-09-18', '17:58:00', '2024-09-18', '17:59:00', '22:59:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:30:54', 1, 418, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(899, 1, '1726655365_34', '4', 4, '2024-09-18', '18:08:00', '2024-09-18', '18:09:00', '23:09:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:30:54', 1, 419, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(900, 1, '1726655365_35', '5', 5, '2024-09-18', '18:18:00', '2024-09-18', '18:19:00', '23:19:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:30:54', 1, 420, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(901, 1, '1726655365_36', '6', 6, '2024-09-18', '18:28:00', '2024-09-18', '18:29:00', '23:29:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:01', 1, 421, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(902, 1, '1726655365_37', '7', 7, '2024-09-18', '18:38:00', '2024-09-18', '18:39:00', '23:39:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:08', 1, 422, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(903, 1, '1726655365_38', '8', 8, '2024-09-18', '18:48:00', '2024-09-18', '18:49:00', '23:49:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:08', 1, 423, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(904, 1, '1726655365_39', '9', 9, '2024-09-18', '18:58:00', '2024-09-18', '18:59:00', '23:59:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:08', 1, 424, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(905, 1, '1726655365_310', '10', 10, '2024-09-18', '19:08:00', '2024-09-18', '19:09:00', '00:09:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:13', 1, 425, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(906, 1, '1726655365_311', '11', 11, '2024-09-18', '19:18:00', '2024-09-18', '19:19:00', '00:19:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 426, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(907, 1, '1726655365_312', '12', 12, '2024-09-18', '19:28:00', '2024-09-18', '19:29:00', '00:29:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 427, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(908, 1, '1726655365_313', '13', 13, '2024-09-18', '19:38:00', '2024-09-18', '19:39:00', '00:39:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 428, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(909, 1, '1726655365_314', '14', 14, '2024-09-18', '19:48:00', '2024-09-18', '19:49:00', '00:49:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 429, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(910, 1, '1726655365_315', '15', 15, '2024-09-18', '19:58:00', '2024-09-18', '19:59:00', '00:59:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 430, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(911, 1, '1726655365_316', '16', 16, '2024-09-18', '20:08:00', '2024-09-18', '20:09:00', '01:09:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 431, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(912, 1, '1726655365_317', '17', 17, '2024-09-18', '20:18:00', '2024-09-18', '20:19:00', '01:19:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 11:17:29', 1, 432, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 25),
(913, 1, '1726655365_318', '18', 18, '2024-09-18', '20:28:00', '2024-09-18', '20:29:00', '01:29:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 433, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(914, 1, '1726655365_319', '19', 19, '2024-09-18', '20:38:00', '2024-09-18', '20:39:00', '01:39:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 434, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(915, 1, '1726655365_320', '20', 20, '2024-09-18', '20:48:00', '2024-09-18', '20:49:00', '01:49:00', 127, 126, 'Tốt', '2024-09-18 10:29:25', '2024-09-18 10:31:17', 1, 435, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(916, 1, '1726657985_321', '21', 21, '2024-09-18', '18:22:00', '2024-09-18', '18:23:00', '23:23:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:14:53', 1, 436, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(917, 1, '1726657985_322', '22', 22, '2024-09-18', '18:32:00', '2024-09-18', '18:33:00', '23:33:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:14:53', 1, 437, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(918, 1, '1726657985_323', '23', 23, '2024-09-18', '18:42:00', '2024-09-18', '18:43:00', '23:43:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:14:53', 1, 438, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(919, 1, '1726657985_324', '24', 24, '2024-09-18', '18:52:00', '2024-09-18', '18:53:00', '23:53:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:14:53', 1, 439, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(920, 1, '1726657985_325', '25', 25, '2024-09-18', '19:02:00', '2024-09-18', '19:03:00', '00:03:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:05', 1, 440, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(921, 1, '1726657985_326', '26', 26, '2024-09-18', '19:12:00', '2024-09-18', '19:13:00', '00:13:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:14', 1, 441, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(922, 1, '1726657985_327', '27', 27, '2024-09-18', '19:22:00', '2024-09-18', '19:23:00', '00:23:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:14', 1, 442, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(923, 1, '1726657985_328', '28', 28, '2024-09-18', '19:32:00', '2024-09-18', '19:33:00', '00:33:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:14', 1, 443, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(924, 1, '1726657985_329', '29', 29, '2024-09-18', '19:42:00', '2024-09-18', '19:43:00', '00:43:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:14', 1, 444, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(925, 1, '1726657985_330', '30', 30, '2024-09-18', '19:52:00', '2024-09-18', '19:53:00', '00:53:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:14', 1, 445, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(926, 1, '1726657985_331', '31', 31, '2024-09-18', '20:02:00', '2024-09-18', '20:03:00', '01:03:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:23', 1, 446, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(927, 1, '1726657985_332', '32', 32, '2024-09-18', '20:12:00', '2024-09-18', '20:13:00', '01:13:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:23', 1, 447, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(928, 1, '1726657985_333', '33', 33, '2024-09-18', '20:22:00', '2024-09-18', '20:23:00', '01:23:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:23', 1, 448, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(929, 1, '1726657985_334', '34', 34, '2024-09-18', '20:32:00', '2024-09-18', '20:33:00', '01:33:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 449, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(930, 1, '1726657985_335', '35', 35, '2024-09-18', '20:42:00', '2024-09-18', '20:43:00', '01:43:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 450, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(931, 1, '1726657985_336', '36', 36, '2024-09-18', '20:52:00', '2024-09-18', '20:53:00', '01:53:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 451, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(932, 1, '1726657985_337', '37', 37, '2024-09-18', '21:02:00', '2024-09-18', '21:03:00', '02:03:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 452, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(933, 1, '1726657985_338', '38', 38, '2024-09-18', '21:12:00', '2024-09-18', '21:13:00', '02:13:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 453, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(934, 1, '1726657985_339', '39', 39, '2024-09-18', '21:22:00', '2024-09-18', '21:23:00', '02:23:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 454, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(935, 1, '1726657985_340', '40', 40, '2024-09-18', '21:32:00', '2024-09-18', '21:33:00', '02:33:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 455, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(936, 1, '1726657985_341', '41', 41, '2024-09-18', '21:42:00', '2024-09-18', '21:43:00', '02:43:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 456, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(937, 1, '1726657985_342', '42', 42, '2024-09-18', '21:52:00', '2024-09-18', '21:53:00', '02:53:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 457, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(938, 1, '1726657985_343', '43', 43, '2024-09-18', '22:02:00', '2024-09-18', '22:03:00', '03:03:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 458, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(939, 1, '1726657985_344', '44', 44, '2024-09-18', '22:12:00', '2024-09-18', '22:13:00', '03:13:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 459, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(940, 1, '1726657985_345', '45', 45, '2024-09-18', '22:22:00', '2024-09-18', '22:23:00', '03:23:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 460, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(941, 1, '1726657985_346', '46', 46, '2024-09-18', '22:32:00', '2024-09-18', '22:33:00', '03:33:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 461, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(942, 1, '1726657985_347', '47', 47, '2024-09-18', '22:42:00', '2024-09-18', '22:43:00', '03:43:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 462, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(943, 1, '1726657985_348', '48', 48, '2024-09-18', '22:52:00', '2024-09-18', '22:53:00', '03:53:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 463, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(944, 1, '1726657985_349', '49', 49, '2024-09-18', '23:02:00', '2024-09-18', '23:03:00', '04:03:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 464, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0),
(945, 1, '1726657985_350', '50', 50, '2024-09-18', '23:12:00', '2024-09-18', '23:13:00', '04:13:00', 127, 126, 'Tốt', '2024-09-18 11:13:05', '2024-09-18 11:15:29', 1, 465, NULL, NULL, 3, 3, 'Admin', 'Admin', 'Cát, lá cây, dăm cạo', '0.8', 'đồng đều', 1, 'Nhiệt ổn định', 10, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `drums_per_day`
--

CREATE TABLE `drums_per_day` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `number` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farms`
--

CREATE TABLE `farms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `farms`
--

INSERT INTO `farms` (`id`, `code`, `name`, `created_at`, `updated_at`, `company_id`) VALUES
(1, 'NT1', 'Nông trường 1', '2024-08-30 03:25:18', '2024-09-10 07:35:10', 2),
(2, 'NT2', 'Nông trường 2', '2024-08-30 03:25:25', '2024-09-10 07:28:58', 2),
(3, 'NT3', 'Nông trường 3', '2024-09-04 08:36:35', '2024-09-10 07:29:04', 2),
(4, 'NT4', 'Nông trường 4', '2024-09-04 08:37:15', '2024-09-07 04:07:58', 1),
(5, 'NT5', 'Nông trường 5', '2024-09-04 08:39:13', '2024-09-10 07:29:41', 1),
(6, 'NT6', 'Nông trường 6', '2024-09-04 08:39:28', '2024-09-07 04:10:27', 2),
(7, 'NT7', 'Nông trường 7', '2024-09-04 08:39:38', '2024-09-10 07:29:54', 1),
(8, 'NT8', 'Nông trường 8', '2024-09-04 08:39:51', '2024-09-10 07:30:01', 1),
(9, 'TM', 'Thu mua', '2024-09-05 07:08:23', '2024-09-07 04:32:26', 4),
(10, 'TNSR', 'Tây Nguyên', '2024-09-05 07:08:42', '2024-09-09 03:09:12', 3),
(14, 'MD', 'Mũ dây', '2024-09-07 04:33:34', '2024-09-09 03:10:08', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_10_091749_create_farms_table', 1),
(5, '2024_08_11_133627_create_trucks_table', 1),
(6, '2024_08_12_014147_create_curing_areas_table', 1),
(7, '2024_08_12_014712_create_curing_houses_table', 1),
(8, '2024_08_12_024918_create_rubber_table', 1),
(9, '2024_08_14_141446_create_rubber_warehouses_table', 1),
(10, '2024_08_15_142941_a', 1),
(11, '2024_08_15_155906_create_machinings_table', 2),
(12, '2024_08_16_090326_avc', 2),
(13, '2024_08_19_092313_create_bales_table', 2),
(14, '2024_08_19_104200_add_bale_id_to_drums_table', 2),
(15, '2024_08_20_093529_add_constrain_to_bales_table', 2),
(16, '2024_08_20_161719_abc', 3),
(17, '2024_08_21_141846_rename_batch_table_to_batches_table', 4),
(18, '2024_08_30_110157_create_warehosues_table', 5),
(19, '2024_08_30_110612_rename', 6),
(20, '2024_08_30_111237_set_fk', 7),
(21, '2024_08_30_112003_delete', 8),
(22, '2024_08_30_112052_xxya', 9),
(23, '2024_09_04_134318_afk', 10),
(24, '2024_09_04_140352_ba', 11),
(25, '2024_09_04_141546_c', 12),
(26, '2024_09_04_142649_m', 13),
(27, '2024_09_05_154412_gh', 14),
(28, '2024_09_06_124730_add_foreign_key_to_contracts_table', 15),
(29, '2024_09_06_132859_add_foreign_keyy_to_contracts_table', 16),
(30, '2024_09_06_140808_q', 17),
(31, '2024_09_06_215945_create_roles_table', 18),
(32, '2024_09_07_085041_create_companies_table', 19),
(33, '2024_09_07_091356_add_company_id_to_farms_table', 20),
(34, '2024_09_07_140757_update_negative_values_in_your_table', 21),
(35, '2024_09_10_140010_create_box_roll_pivot_table', 21),
(36, '2024_09_13_083916_create_personal_access_tokens_table', 22),
(37, '2024_09_17_124821_t', 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 'App\\Models\\User', 1, 'Login', 'd1eb22db75b6b9b0f18c886d1ed333d6fe2e3bc24fe939ddd148a1f4bf9123a8', '[\"*\"]', '2024-09-17 03:12:07', NULL, '2024-09-14 17:27:36', '2024-09-17 03:12:07'),
(13, 'App\\Models\\User', 1, 'Login', 'd3a83aacf550eff7d34470e3e2193f33909644141bcc1b6a56f20e1d821b2d6f', '[\"*\"]', NULL, NULL, '2024-09-14 17:32:27', '2024-09-14 17:32:27'),
(14, 'App\\Models\\User', 1, 'Login', '49935791a6465d8dcdc7410086d218183d9dd3ad04e761171670c24013dbb075', '[\"*\"]', NULL, NULL, '2024-09-15 03:27:40', '2024-09-15 03:27:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reset_time`
--

CREATE TABLE `reset_time` (
  `id` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reset_time`
--

INSERT INTO `reset_time` (`id`, `time`, `created_at`, `updated_at`) VALUES
(1, '06:00:00', '2024-09-11 07:38:14', '2024-09-18 08:11:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Nguyên liệu', NULL, NULL),
(3, 'Cán vắt', NULL, NULL),
(4, 'Gia công hạt', NULL, NULL),
(5, 'Gia công nhiệt', NULL, NULL),
(6, 'Ép kiện', NULL, NULL),
(7, 'Đóng gói', NULL, NULL),
(8, 'Kho', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-09-06 16:04:23', '2024-09-06 16:04:23'),
(11, 5, 3, '2024-09-16 02:39:19', '2024-09-16 02:39:19'),
(12, 5, 1, '2024-09-16 04:19:49', '2024-09-16 04:19:49');

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
  `supervisor` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rubber`
--

INSERT INTO `rubber` (`id`, `status`, `date`, `time`, `truck_id`, `farm_id`, `receiving_place_id`, `latex_type`, `material_age`, `fresh_weight`, `drc_percentage`, `dry_weight`, `material_condition`, `impurity_type`, `grade`, `supervisor`, `created_at`, `updated_at`, `name`) VALUES
(211, 68, '2024-09-18', '17:04:00', 22, 3, 3, 'Mủ đông chén', 'Bốc chồng nhiều nhất', 20000, 51.24, 6.19, 4, 'lá cây, cát', 'CSR10', NULL, '2024-09-18 10:05:35', '2024-09-18 10:05:52', NULL);

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
(68, '1726653952', 2, 20000, 200, NULL, NULL, '2024-09-18', '2024-09-18', '17:05:00', '2024-09-18 10:05:52', '2024-09-18 11:13:05', 3, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ikxf4KRbebMZzjAycriHCY9cFtnaMIIHMd63MmTY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTXd5cEYzQWttRnpJSXdWSGN1Y3NsTkczVDlJYWVDWDRKTExkTEJZOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb250cmFjdENSQ0syLzEzNi9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1726659043);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipments`
--

CREATE TABLE `shipments` (
  `id` int(10) UNSIGNED NOT NULL,
  `ma_xuat` varchar(255) NOT NULL,
  `loai_hang` varchar(255) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `ngay_xuat` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contract_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shipments`
--

INSERT INTO `shipments` (`id`, `ma_xuat`, `loai_hang`, `so_luong`, `ngay_xuat`, `created_at`, `updated_at`, `contract_id`, `status`) VALUES
(35, 'PX1_1726656023', 'CSR10', 210, NULL, '2024-09-18 10:40:23', '2024-09-18 10:44:46', 136, 1),
(36, 'PX1_1726658736', 'CSR10', 123, NULL, '2024-09-18 11:25:36', '2024-09-18 11:27:59', 137, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trucks`
--

CREATE TABLE `trucks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `farm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trucks`
--

INSERT INTO `trucks` (`id`, `code`, `name`, `farm_id`, `created_at`, `updated_at`) VALUES
(22, '3A-1256', 'CRCK-07', NULL, NULL, NULL),
(23, '3A-3712', 'CRCK-08', NULL, NULL, NULL),
(24, '3A-5891', 'CRCK-03', NULL, NULL, NULL),
(25, '3A-6608', 'CRCK-04', NULL, NULL, NULL),
(26, '3A-7413', 'CRCK-01', NULL, NULL, NULL),
(27, '3A-3404', 'CRCK-06', NULL, NULL, NULL),
(28, '3A-2352', 'CRCK-02', NULL, NULL, NULL),
(29, '3A-4673', 'CRCK-05', NULL, NULL, NULL),
(30, '3A-2330', 'BHCK 01', NULL, NULL, NULL),
(31, '3A-1373', 'BHCK 02', NULL, NULL, NULL),
(32, '3A-1817', 'BHCK 03', NULL, NULL, NULL),
(33, '3A-1314', 'BHCK 04', NULL, NULL, NULL),
(34, '3A-1335', 'BHCK 05', NULL, NULL, NULL),
(35, '3A-1012', 'BHCK 06', NULL, NULL, NULL),
(36, '3A-2023', 'BHCK 07', NULL, NULL, NULL),
(37, '3B-1085', 'BHCK 08', NULL, NULL, NULL),
(38, '3A-1073', 'BHCK 09', NULL, NULL, NULL),
(39, '3B-1474', 'BHCK 10', NULL, NULL, NULL),
(40, '3A-1004', 'BHCK 11', NULL, NULL, NULL),
(41, '3B-5787', 'BHCK 12', NULL, NULL, NULL),
(42, '3A-1440', 'BHCK 13', NULL, NULL, NULL),
(43, '3A-1844', 'BHCK 14', NULL, NULL, NULL),
(44, '3A-2020', 'BHCK 15', NULL, NULL, NULL),
(45, '3A-1020', 'BHCK 16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$X3Lt7Rd9iu.U6wAHdYGKAey/prfmJGsXz0gvwOsRa/YsH2m.XarGa', NULL, '2024-09-06 14:38:46', '2024-09-06 14:38:46'),
(5, '123', '1234@gmail.com', NULL, '$2y$12$qCReUMEgBlS9ToDh/qyCoeFlvHAxOXooKS5eSjjlZ8v/0QJH6tDku', NULL, '2024-09-16 02:39:19', '2024-09-16 02:39:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `stack` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `code`, `stack`, `created_at`, `updated_at`, `batch_id`) VALUES
(1441, 'A1', 'A1-11', NULL, '2024-09-17 03:46:11', '2024-09-18 11:27:59', NULL),
(1442, 'A1', 'A1-12', NULL, '2024-09-17 03:46:11', '2024-09-18 10:54:55', NULL),
(1443, 'A1', 'A1-13', NULL, '2024-09-17 03:46:11', '2024-09-18 11:27:59', NULL),
(1444, 'A1', 'A1-14', NULL, '2024-09-17 03:46:11', '2024-09-18 07:14:50', NULL),
(1445, 'A1', 'A1-15', NULL, '2024-09-17 03:46:11', '2024-09-18 11:21:14', 96),
(1446, 'A1', 'A1-16', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1447, 'A1', 'A1-21', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1448, 'A1', 'A1-22', NULL, '2024-09-17 03:46:11', '2024-09-18 11:21:33', 98),
(1449, 'A1', 'A1-23', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1450, 'A1', 'A1-24', NULL, '2024-09-17 03:46:11', '2024-09-18 07:20:54', NULL),
(1451, 'A1', 'A1-25', NULL, '2024-09-17 03:46:11', '2024-09-18 11:27:59', NULL),
(1452, 'A1', 'A1-26', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1453, 'A1', 'A1-31', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1454, 'A1', 'A1-32', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1455, 'A1', 'A1-33', NULL, '2024-09-17 03:46:11', '2024-09-18 10:44:46', NULL),
(1456, 'A1', 'A1-34', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1457, 'A1', 'A1-35', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1458, 'A1', 'A1-36', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1459, 'A1', 'A1-41', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1460, 'A1', 'A1-42', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1461, 'A1', 'A1-43', NULL, '2024-09-17 03:46:11', '2024-09-18 11:22:26', NULL),
(1462, 'A1', 'A1-44', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1463, 'A1', 'A1-45', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1464, 'A1', 'A1-46', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1465, 'A1', 'A1-51', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1466, 'A1', 'A1-52', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1467, 'A1', 'A1-53', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1468, 'A1', 'A1-54', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1469, 'A1', 'A1-55', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1470, 'A1', 'A1-56', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1471, 'A1', 'A1-61', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1472, 'A1', 'A1-62', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1473, 'A1', 'A1-63', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1474, 'A1', 'A1-64', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1475, 'A1', 'A1-65', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1476, 'A1', 'A1-66', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1477, 'A1', 'A1-71', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1478, 'A1', 'A1-72', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1479, 'A1', 'A1-73', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1480, 'A1', 'A1-74', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1481, 'A1', 'A1-75', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1482, 'A1', 'A1-76', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1483, 'A1', 'A1-81', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1484, 'A1', 'A1-82', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1485, 'A1', 'A1-83', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1486, 'A1', 'A1-84', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1487, 'A1', 'A1-85', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1488, 'A1', 'A1-86', NULL, '2024-09-17 03:46:11', '2024-09-17 03:46:11', NULL),
(1489, 'A2', 'A2-11', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1490, 'A2', 'A2-12', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1491, 'A2', 'A2-13', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1492, 'A2', 'A2-14', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1493, 'A2', 'A2-15', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1494, 'A2', 'A2-16', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1495, 'A2', 'A2-21', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1496, 'A2', 'A2-22', NULL, '2024-09-17 03:46:53', '2024-09-17 03:46:53', NULL),
(1497, 'A2', 'A2-23', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1498, 'A2', 'A2-24', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1499, 'A2', 'A2-25', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1500, 'A2', 'A2-26', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1501, 'A2', 'A2-31', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1502, 'A2', 'A2-32', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1503, 'A2', 'A2-33', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1504, 'A2', 'A2-34', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1505, 'A2', 'A2-35', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1506, 'A2', 'A2-36', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1507, 'A2', 'A2-41', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1508, 'A2', 'A2-42', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1509, 'A2', 'A2-43', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1510, 'A2', 'A2-44', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1511, 'A2', 'A2-45', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1512, 'A2', 'A2-46', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1513, 'A2', 'A2-51', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1514, 'A2', 'A2-52', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1515, 'A2', 'A2-53', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1516, 'A2', 'A2-54', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1517, 'A2', 'A2-55', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1518, 'A2', 'A2-56', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1519, 'A2', 'A2-61', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1520, 'A2', 'A2-62', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1521, 'A2', 'A2-63', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1522, 'A2', 'A2-64', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1523, 'A2', 'A2-65', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1524, 'A2', 'A2-66', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1525, 'A2', 'A2-71', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1526, 'A2', 'A2-72', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1527, 'A2', 'A2-73', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1528, 'A2', 'A2-74', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1529, 'A2', 'A2-75', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1530, 'A2', 'A2-76', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1531, 'A2', 'A2-81', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1532, 'A2', 'A2-82', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1533, 'A2', 'A2-83', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1534, 'A2', 'A2-84', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1535, 'A2', 'A2-85', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1536, 'A2', 'A2-86', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1537, 'A2', 'A2-91', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1538, 'A2', 'A2-92', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1539, 'A2', 'A2-93', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1540, 'A2', 'A2-94', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1541, 'A2', 'A2-95', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1542, 'A2', 'A2-96', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1543, 'A2', 'A2-101', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1544, 'A2', 'A2-102', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1545, 'A2', 'A2-103', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1546, 'A2', 'A2-104', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1547, 'A2', 'A2-105', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1548, 'A2', 'A2-106', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1549, 'A2', 'A2-111', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1550, 'A2', 'A2-112', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1551, 'A2', 'A2-113', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1552, 'A2', 'A2-114', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1553, 'A2', 'A2-115', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1554, 'A2', 'A2-116', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1555, 'A2', 'A2-121', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1556, 'A2', 'A2-122', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1557, 'A2', 'A2-123', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1558, 'A2', 'A2-124', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1559, 'A2', 'A2-125', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1560, 'A2', 'A2-126', NULL, '2024-09-17 03:46:54', '2024-09-17 03:46:54', NULL),
(1561, 'A3', 'A3-11', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1562, 'A3', 'A3-12', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1563, 'A3', 'A3-13', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1564, 'A3', 'A3-14', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1565, 'A3', 'A3-15', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1566, 'A3', 'A3-16', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1567, 'A3', 'A3-21', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1568, 'A3', 'A3-22', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1569, 'A3', 'A3-23', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1570, 'A3', 'A3-24', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1571, 'A3', 'A3-25', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1572, 'A3', 'A3-26', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1573, 'A3', 'A3-31', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1574, 'A3', 'A3-32', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1575, 'A3', 'A3-33', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1576, 'A3', 'A3-34', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1577, 'A3', 'A3-35', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1578, 'A3', 'A3-36', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1579, 'A3', 'A3-41', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1580, 'A3', 'A3-42', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1581, 'A3', 'A3-43', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1582, 'A3', 'A3-44', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1583, 'A3', 'A3-45', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1584, 'A3', 'A3-46', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1585, 'A3', 'A3-51', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1586, 'A3', 'A3-52', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1587, 'A3', 'A3-53', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1588, 'A3', 'A3-54', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1589, 'A3', 'A3-55', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1590, 'A3', 'A3-56', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1591, 'A3', 'A3-61', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1592, 'A3', 'A3-62', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1593, 'A3', 'A3-63', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1594, 'A3', 'A3-64', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1595, 'A3', 'A3-65', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1596, 'A3', 'A3-66', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1597, 'A3', 'A3-71', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1598, 'A3', 'A3-72', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1599, 'A3', 'A3-73', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1600, 'A3', 'A3-74', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1601, 'A3', 'A3-75', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1602, 'A3', 'A3-76', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1603, 'A3', 'A3-81', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1604, 'A3', 'A3-82', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1605, 'A3', 'A3-83', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1606, 'A3', 'A3-84', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1607, 'A3', 'A3-85', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1608, 'A3', 'A3-86', NULL, '2024-09-17 03:47:59', '2024-09-17 03:47:59', NULL),
(1609, 'B1', 'B1-11', NULL, '2024-09-17 03:48:18', '2024-09-18 09:10:53', NULL),
(1610, 'B1', 'B1-12', NULL, '2024-09-17 03:48:18', '2024-09-18 09:02:28', NULL),
(1611, 'B1', 'B1-13', NULL, '2024-09-17 03:48:18', '2024-09-18 09:06:37', NULL),
(1612, 'B1', 'B1-14', NULL, '2024-09-17 03:48:18', '2024-09-18 09:06:49', NULL),
(1613, 'B1', 'B1-15', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1614, 'B1', 'B1-16', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1615, 'B1', 'B1-21', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1616, 'B1', 'B1-22', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1617, 'B1', 'B1-23', NULL, '2024-09-17 03:48:18', '2024-09-18 08:46:06', NULL),
(1618, 'B1', 'B1-24', NULL, '2024-09-17 03:48:18', '2024-09-18 08:51:11', NULL),
(1619, 'B1', 'B1-25', NULL, '2024-09-17 03:48:18', '2024-09-18 08:51:24', NULL),
(1620, 'B1', 'B1-26', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1621, 'B1', 'B1-31', NULL, '2024-09-17 03:48:18', '2024-09-18 09:06:37', NULL),
(1622, 'B1', 'B1-32', NULL, '2024-09-17 03:48:18', '2024-09-18 08:53:14', NULL),
(1623, 'B1', 'B1-33', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1624, 'B1', 'B1-34', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1625, 'B1', 'B1-35', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1626, 'B1', 'B1-36', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1627, 'B1', 'B1-41', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1628, 'B1', 'B1-42', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1629, 'B1', 'B1-43', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1630, 'B1', 'B1-44', NULL, '2024-09-17 03:48:18', '2024-09-18 09:07:24', NULL),
(1631, 'B1', 'B1-45', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1632, 'B1', 'B1-46', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1633, 'B1', 'B1-51', NULL, '2024-09-17 03:48:18', '2024-09-18 09:07:11', NULL),
(1634, 'B1', 'B1-52', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1635, 'B1', 'B1-53', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1636, 'B1', 'B1-54', NULL, '2024-09-17 03:48:18', '2024-09-18 09:07:24', NULL),
(1637, 'B1', 'B1-55', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1638, 'B1', 'B1-56', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1639, 'B1', 'B1-61', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1640, 'B1', 'B1-62', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1641, 'B1', 'B1-63', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1642, 'B1', 'B1-64', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1643, 'B1', 'B1-65', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1644, 'B1', 'B1-66', NULL, '2024-09-17 03:48:18', '2024-09-17 03:48:18', NULL),
(1645, 'B1', 'B1-71', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1646, 'B1', 'B1-72', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1647, 'B1', 'B1-73', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1648, 'B1', 'B1-74', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1649, 'B1', 'B1-75', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1650, 'B1', 'B1-76', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1651, 'B1', 'B1-81', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1652, 'B1', 'B1-82', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1653, 'B1', 'B1-83', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1654, 'B1', 'B1-84', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1655, 'B1', 'B1-85', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1656, 'B1', 'B1-86', NULL, '2024-09-17 03:48:19', '2024-09-17 03:48:19', NULL),
(1657, 'B2', 'B2-11', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1658, 'B2', 'B2-12', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1659, 'B2', 'B2-13', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1660, 'B2', 'B2-14', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1661, 'B2', 'B2-15', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1662, 'B2', 'B2-16', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1663, 'B2', 'B2-21', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1664, 'B2', 'B2-22', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1665, 'B2', 'B2-23', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1666, 'B2', 'B2-24', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1667, 'B2', 'B2-25', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1668, 'B2', 'B2-26', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1669, 'B2', 'B2-31', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1670, 'B2', 'B2-32', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1671, 'B2', 'B2-33', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1672, 'B2', 'B2-34', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1673, 'B2', 'B2-35', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1674, 'B2', 'B2-36', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1675, 'B2', 'B2-41', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1676, 'B2', 'B2-42', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1677, 'B2', 'B2-43', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1678, 'B2', 'B2-44', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1679, 'B2', 'B2-45', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1680, 'B2', 'B2-46', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1681, 'B2', 'B2-51', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1682, 'B2', 'B2-52', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1683, 'B2', 'B2-53', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1684, 'B2', 'B2-54', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1685, 'B2', 'B2-55', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1686, 'B2', 'B2-56', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1687, 'B2', 'B2-61', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1688, 'B2', 'B2-62', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1689, 'B2', 'B2-63', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1690, 'B2', 'B2-64', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1691, 'B2', 'B2-65', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1692, 'B2', 'B2-66', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1693, 'B2', 'B2-71', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1694, 'B2', 'B2-72', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1695, 'B2', 'B2-73', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1696, 'B2', 'B2-74', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1697, 'B2', 'B2-75', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1698, 'B2', 'B2-76', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1699, 'B2', 'B2-81', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1700, 'B2', 'B2-82', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1701, 'B2', 'B2-83', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1702, 'B2', 'B2-84', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1703, 'B2', 'B2-85', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1704, 'B2', 'B2-86', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1705, 'B2', 'B2-91', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1706, 'B2', 'B2-92', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1707, 'B2', 'B2-93', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1708, 'B2', 'B2-94', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1709, 'B2', 'B2-95', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1710, 'B2', 'B2-96', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1711, 'B2', 'B2-101', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1712, 'B2', 'B2-102', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1713, 'B2', 'B2-103', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1714, 'B2', 'B2-104', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1715, 'B2', 'B2-105', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1716, 'B2', 'B2-106', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1717, 'B2', 'B2-111', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1718, 'B2', 'B2-112', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1719, 'B2', 'B2-113', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1720, 'B2', 'B2-114', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1721, 'B2', 'B2-115', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1722, 'B2', 'B2-116', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1723, 'B2', 'B2-121', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1724, 'B2', 'B2-122', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1725, 'B2', 'B2-123', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1726, 'B2', 'B2-124', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1727, 'B2', 'B2-125', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1728, 'B2', 'B2-126', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1729, 'B2', 'B2-131', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1730, 'B2', 'B2-132', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1731, 'B2', 'B2-133', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1732, 'B2', 'B2-134', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1733, 'B2', 'B2-135', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1734, 'B2', 'B2-136', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1735, 'B2', 'B2-141', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1736, 'B2', 'B2-142', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1737, 'B2', 'B2-143', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1738, 'B2', 'B2-144', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1739, 'B2', 'B2-145', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1740, 'B2', 'B2-146', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1741, 'B2', 'B2-151', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1742, 'B2', 'B2-152', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1743, 'B2', 'B2-153', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1744, 'B2', 'B2-154', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1745, 'B2', 'B2-155', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1746, 'B2', 'B2-156', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1747, 'B2', 'B2-161', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1748, 'B2', 'B2-162', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1749, 'B2', 'B2-163', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1750, 'B2', 'B2-164', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1751, 'B2', 'B2-165', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1752, 'B2', 'B2-166', NULL, '2024-09-17 03:48:28', '2024-09-17 03:48:28', NULL),
(1753, 'B3', 'B3-11', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1754, 'B3', 'B3-12', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1755, 'B3', 'B3-13', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1756, 'B3', 'B3-14', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1757, 'B3', 'B3-15', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1758, 'B3', 'B3-16', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1759, 'B3', 'B3-21', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1760, 'B3', 'B3-22', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1761, 'B3', 'B3-23', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1762, 'B3', 'B3-24', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1763, 'B3', 'B3-25', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1764, 'B3', 'B3-26', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1765, 'B3', 'B3-31', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1766, 'B3', 'B3-32', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1767, 'B3', 'B3-33', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1768, 'B3', 'B3-34', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1769, 'B3', 'B3-35', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1770, 'B3', 'B3-36', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1771, 'B3', 'B3-41', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1772, 'B3', 'B3-42', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1773, 'B3', 'B3-43', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1774, 'B3', 'B3-44', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1775, 'B3', 'B3-45', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1776, 'B3', 'B3-46', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1777, 'B3', 'B3-51', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1778, 'B3', 'B3-52', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1779, 'B3', 'B3-53', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1780, 'B3', 'B3-54', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1781, 'B3', 'B3-55', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1782, 'B3', 'B3-56', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1783, 'B3', 'B3-61', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1784, 'B3', 'B3-62', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1785, 'B3', 'B3-63', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1786, 'B3', 'B3-64', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1787, 'B3', 'B3-65', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1788, 'B3', 'B3-66', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1789, 'B3', 'B3-71', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1790, 'B3', 'B3-72', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1791, 'B3', 'B3-73', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1792, 'B3', 'B3-74', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1793, 'B3', 'B3-75', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1794, 'B3', 'B3-76', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1795, 'B3', 'B3-81', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1796, 'B3', 'B3-82', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1797, 'B3', 'B3-83', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1798, 'B3', 'B3-84', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1799, 'B3', 'B3-85', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL),
(1800, 'B3', 'B3-86', NULL, '2024-09-17 03:48:37', '2024-09-17 03:48:37', NULL);

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
-- Chỉ mục cho bảng `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `batch_drum`
--
ALTER TABLE `batch_drum`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batch_drum_drum_id_batch_id_unique` (`drum_id`,`batch_id`),
  ADD KEY `batch_drum_batch_id_foreign` (`batch_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_contract_type_id_foreign` (`contract_type_id`),
  ADD KEY `contract_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `contract_type`
--
ALTER TABLE `contract_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `curing_areas`
--
ALTER TABLE `curing_areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curing_areas_code_unique` (`code`);

--
-- Chỉ mục cho bảng `curing_houses`
--
ALTER TABLE `curing_houses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curing_houses_code_unique` (`code`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `delivery_dates`
--
ALTER TABLE `delivery_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_dates_contract_id_foreign` (`contract_id`);

--
-- Chỉ mục cho bảng `drums`
--
ALTER TABLE `drums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drums_bale_id_foreign` (`bale_id`),
  ADD KEY `drums_batch_id_foreign` (`batch_id`),
  ADD KEY `drums_rolling_code_foreign` (`rolling_code`);

--
-- Chỉ mục cho bảng `drums_per_day`
--
ALTER TABLE `drums_per_day`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `farms_code_unique` (`code`),
  ADD KEY `farms_company_id_foreign` (`company_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `reset_time`
--
ALTER TABLE `reset_time`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Chỉ mục cho bảng `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `rubber`
--
ALTER TABLE `rubber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubber_truck_id_foreign` (`truck_id`),
  ADD KEY `rubber_farm_id_foreign` (`farm_id`),
  ADD KEY `rubber_receiving_place_id_foreign` (`receiving_place_id`);

--
-- Chỉ mục cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubber_warehouses_curing_house_id_foreign` (`curing_house_id`),
  ADD KEY `rubber_warehouses_curing_area_id_foreign` (`curing_area_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipments_contract_id_foreign` (`contract_id`);

--
-- Chỉ mục cho bảng `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trucks_code_unique` (`code`),
  ADD KEY `trucks_farm_id_foreign` (`farm_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouses_batch_id_foreign` (`batch_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bales`
--
ALTER TABLE `bales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT cho bảng `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `batch_drum`
--
ALTER TABLE `batch_drum`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=492;

--
-- AUTO_INCREMENT cho bảng `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT cho bảng `contract_type`
--
ALTER TABLE `contract_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `curing_areas`
--
ALTER TABLE `curing_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `curing_houses`
--
ALTER TABLE `curing_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `delivery_dates`
--
ALTER TABLE `delivery_dates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT cho bảng `drums`
--
ALTER TABLE `drums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=946;

--
-- AUTO_INCREMENT cho bảng `drums_per_day`
--
ALTER TABLE `drums_per_day`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `farms`
--
ALTER TABLE `farms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `reset_time`
--
ALTER TABLE `reset_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `rubber`
--
ALTER TABLE `rubber`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT cho bảng `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1801;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bales`
--
ALTER TABLE `bales`
  ADD CONSTRAINT `bales_drum_id_foreign` FOREIGN KEY (`drum_id`) REFERENCES `drums` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `batch_drum`
--
ALTER TABLE `batch_drum`
  ADD CONSTRAINT `batch_drum_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batch_drum_drum_id_foreign` FOREIGN KEY (`drum_id`) REFERENCES `drums` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_contract_type_id_foreign` FOREIGN KEY (`contract_type_id`) REFERENCES `contract_type` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contract_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `delivery_dates`
--
ALTER TABLE `delivery_dates`
  ADD CONSTRAINT `delivery_dates_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contract` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `drums`
--
ALTER TABLE `drums`
  ADD CONSTRAINT `drums_bale_id_foreign` FOREIGN KEY (`bale_id`) REFERENCES `bales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `drums_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `drums_rolling_code_foreign` FOREIGN KEY (`rolling_code`) REFERENCES `rubber_warehouses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `farms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rubber`
--
ALTER TABLE `rubber`
  ADD CONSTRAINT `rubber_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rubber_receiving_place_id_foreign` FOREIGN KEY (`receiving_place_id`) REFERENCES `curing_areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rubber_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  ADD CONSTRAINT `rubber_warehouses_curing_area_id_foreign` FOREIGN KEY (`curing_area_id`) REFERENCES `curing_areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rubber_warehouses_curing_house_id_foreign` FOREIGN KEY (`curing_house_id`) REFERENCES `curing_houses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contract` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `trucks`
--
ALTER TABLE `trucks`
  ADD CONSTRAINT `trucks_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
