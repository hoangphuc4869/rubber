-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 07, 2024 lúc 02:04 PM
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expected_grade` varchar(255) DEFAULT NULL,
  `batch_number` int(11) NOT NULL,
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
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 'CÔNG TY PHÁT TRIỂN CAO SU C.R.C.K', 'CRCK', '2024-09-07 02:08:13', '2024-09-07 02:08:13'),
(3, 'CÔNG TY TÂY NINH SIÊM RIỆP PHÁT TRIỂN CAO SU', 'TNSR', '2024-09-07 02:09:39', '2024-09-07 02:09:39'),
(4, 'Thu mua', 'TM', '2024-09-07 02:09:53', '2024-09-07 03:35:58'),
(7, 'mủ dây', 'MD', '2024-09-07 04:34:22', '2024-09-07 04:34:22');

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
(43, 3, 'Annex : 08-23/CRCK2-SINTEX (23HCRK) - 01/08/2023', 'Annex : 08-23/CRCK2-SINTEX (23HCRK)', '840', '2023-08-01', 'LONG-TERM CONTRACT NO. 01-23/CRCK2-SINTEX', '08', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-08-04', '2023-08-30'),
(45, 5, 'PO: 8200049693 - 26/07/2023', 'PO: 8200049693', '420', '2023-07-26', 'CART-CRCK/2023-01', '08', 12, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-08-05', '2023-08-30'),
(46, 4, '050723/CRCK2-LA - 05/07/2023', '050723/CRCK2-LA', '420', '2023-07-05', 'Bán Chuyến', '07', 13, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-08-05', '2023-08-30'),
(47, 4, '200723/CRCK2-LA - 20/07/2023', '200723/CRCK2-LA', '420', '2023-07-20', 'Bán Chuyến', '2023.09', 13, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-08-05', '2023-10-10'),
(48, 4, '128/VRG-CRCK2 - 02/08/2023', '128/VRG-CRCK2', '210', '2023-08-02', 'Bán Chuyến', '2023.10', 11, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-08-07', '2023-09-26'),
(56, 3, 'ANNEX 07 - 01/07/2023', 'ANNEX 07', '630', '2023-07-01', 'HĐ DÀI HẠN 01/SINTEX-BH-LT', '7', 9, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-08-29', '2023-08-31'),
(57, 3, 'ANNEX 08 - 01/08/2023', 'ANNEX 08', '630', '2023-08-01', 'HĐ DÀI HẠN 01/SINTEX-BH-LT', '8', 9, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-08-31', '2023-08-31'),
(58, 4, '01/2023/BHCK-LA - 06/07/2023', '01/2023/BHCK-LA', '210', '2023-07-06', 'HĐ CHUYẾN', '9', 13, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-08-31', '2023-08-31'),
(59, 4, 'PO 8200049694 - 28/07/2023', 'PO 8200049694', '210', '2023-07-28', 'HĐ CHUYẾN 01/CART-BHCK', '8', 12, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'CAMPUCHIA', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-08-31', '2023-08-31'),
(60, 4, '101/VRG-BHCK - 26/06/2023', '101/VRG-BHCK', '210', '2023-06-26', 'HĐ CHUYẾN', '8', 11, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-08-31', '2023-08-31'),
(61, 3, 'Annex: 09-23/CRCK2-SINTEX (23ICRK) - 01/09/2023', 'Annex: 09-23/CRCK2-SINTEX (23ICRK)', '1050', '2023-09-01', 'LONG-TERM CONTRACT NO. 01-23/CRCK2-SINTEX', '2023.09', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-09-03', '2023-10-07'),
(62, 5, 'PO: 8300020337 - 30/08/2023', 'PO: 8300020337', '420', '2023-08-30', 'CRCK2-SAILUN/HDNT-2023', '2023.09', 14, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-09-14', '2023-10-07'),
(63, 4, '050923/CRCK2-HK - 05/09/2023', '050923/CRCK2-HK', '210', '2023-09-05', 'Bán Chuyến', '2023.09', 10, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-09-14', '2023-09-26'),
(64, 3, 'Annex: 10-23/CRCK2-SINTEX (23JCRK) - 01/10/2023', 'Annex: 10-23/CRCK2-SINTEX (23JCRK)', '1050', '2023-10-01', 'LONG-TERM CONTRACT NO. 01-23/CRCK2-SINTEX', '2023.10', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-09-26', '2023-09-26'),
(65, 4, '131023/CRCK2-HKVN - 13/10/2023', '131023/CRCK2-HKVN', '403.2', '2023-10-13', 'Bán Chuyến', '2023.10', 17, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-10-17', '2023-10-17'),
(66, 5, 'PO: 8200050771 - 19/10/2023', 'PO: 8200050771', '210', '2023-10-19', 'CART-CRCK/2023-01', '2023.10', 12, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-10-24', '2023-10-24'),
(67, 3, 'Annex: 11-23/CRCK2-SINTEX (23KCRK) - 01/11/2023 - 01/11/2023', 'Annex: 11-23/CRCK2-SINTEX (23KCRK) - 01/11/2023', '840', '2023-11-01', 'LONG-TERM CONTRACT NO. 01-23/CRCK2-SINTEX', '2023.11', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-11-03', '2023-11-03'),
(68, 4, '214/VRG-CRCK2 - 01/11/2023', '214/VRG-CRCK2', '1680', '2023-11-01', 'Bán Chuyến', '2023.11', 11, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-11-08', '2023-11-08'),
(69, 4, '222/VRG-CRCK2 - 06/11/2023', '222/VRG-CRCK2', '210', '2023-11-06', 'Bán Chuyến', '2023.11', 11, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-11-16', '2023-11-16'),
(70, 4, '238/VRG-CRCK2 - 07/11/2023', '238/VRG-CRCK2', '420', '2023-11-07', 'Bán Chuyến', '2023.11', 11, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-11-16', '2023-11-16'),
(71, 3, 'ANNEX 09 - 01/09/2023', 'ANNEX 09', '630', '2023-09-01', 'HĐ DÀI HẠN', '9', 9, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(72, 3, 'ANNEX 10 - 01/10/2023', 'ANNEX 10', '630', '2023-10-01', 'HĐ DÀI HẠN', '10', 9, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(73, 3, 'ANNEX 11 - 02/11/2023', 'ANNEX 11', '630', '2023-11-02', 'HĐ DÀI HẠN', '11', 9, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(74, 4, '02/2023/BHCK-LA - 20/07/2023', '02/2023/BHCK-LA', '210', '2023-07-20', 'HĐ CHUYẾN', '10', 13, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(75, 5, 'PO 8200050772 - 19/10/2023', 'PO 8200050772', '210', '2023-10-19', 'HĐ CHUYẾN 01/CART-BHCK', '10', 12, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'CAMPUCHIA', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(76, 4, '158/VRG-BHCK - 06/09/2023', '158/VRG-BHCK', '210', '2023-09-06', 'HĐ CHUYẾN', '10', 11, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(77, 4, '02/2023/BHCK-HK - 11/10/2023', '02/2023/BHCK-HK', '436.80', '2023-10-11', 'HĐ CHUYẾN', '11', 17, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2023-11-17', '2023-11-17'),
(78, 4, '081123/CRCK2-LA - 08/11/2023', '081123/CRCK2-LA', '420', '2023-11-08', 'Bán Chuyến', '2023.12', 13, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-11-19', '2024-01-03'),
(79, 3, 'Annex: 12-23/CRCK2-SINTEX (23LCRK) - 01/12/2023', 'Annex: 12-23/CRCK2-SINTEX (23LCRK)', '630', '2023-12-01', 'LONG-TERM CONTRACT NO. 01-23/CRCK2-SINTEX', '2023.12', 9, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2023-12-06', '2023-12-06'),
(80, 4, '151223/CRCK2-HKVN - 15/12/2023', '151223/CRCK2-HKVN', '210', '2023-12-15', 'Bán Chuyến', '2023.12', 17, NULL, 'CSR10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'Không', '2024-01-03', '2024-01-03'),
(81, 3, 'Annex No.01 - 02/01/2024', 'Annex No.01', '420', '2024-01-02', 'No.12/VRG-CRCK2-LT', '01/2024', 11, NULL, 'CSR 10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-01-30', '2024-02-29'),
(82, 3, 'Annex No.01-24/CRCK2-HUANGJIN - 02/01/2024', 'Annex No.01-24/CRCK2-HUANGJIN', '420', '2024-01-02', 'No LT-24/CRCK2-HUANGJIN', '01/2024', 18, NULL, 'CSR 10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Singapore', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-01-30', '2024-02-29'),
(83, 5, 'PO.8200051734 - 13/01/2024', 'PO.8200051734', '420', '2024-01-13', 'CART-CRCK/2024-01', '01/2024', 12, NULL, 'CSR 10', NULL, NULL, 'Hàng rời, không pallet', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-01-30', '2024-01-30'),
(84, 3, 'Annex No.02 - 01/02/2024', 'Annex No.02', '420', '2024-02-01', 'No.12/VRG-CRCK2-LT', '02/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-02-29', '2024-02-29'),
(85, 3, 'Annex No 02-24/CRCK2-HUANGJIN - 01/02/2024', 'Annex No 02-24/CRCK2-HUANGJIN', '420', '2024-02-01', 'LT-24/CRCK2-HUANGJIN', '02/2024', 18, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-02-29', '2024-02-29'),
(86, 4, 'Annex No 140224/CRCK2-HK - 14/02/2024', 'Annex No 140224/CRCK2-HK', '420', '2024-02-14', NULL, '02/2024', 10, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-02-29', '2024-02-29'),
(87, 4, 'Annex No 090224/CRCK2-HK - 09/02/2024', 'Annex No 090224/CRCK2-HK', '210', '2024-02-09', NULL, '03/2024', 10, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-03-08', '2024-03-08'),
(88, 3, 'ANNEX 01 - 02/01/2024', 'ANNEX 01', '420', '2024-01-02', 'HĐ DÀI HẠN 11/VRG-BH-LT', '1', 11, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(89, 3, 'ANNEX 01 - 02/01/2024', 'ANNEX 01', '420', '2024-01-02', 'HĐ DÀI HẠN 01/HUANGJIN-BH-LT', '1', 18, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(90, 3, 'ANNEX 02 - 01/02/2024', 'ANNEX 02', '420', '2024-02-01', 'HĐ DÀI HẠN 11/VRG-BH-LT', '2', 11, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(91, 4, '01/2024/BHCK-HJS - 10/01/2024', '01/2024/BHCK-HJS', '210', '2024-01-10', '01/2023/BHCK-HJS', '1', 18, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(92, 3, 'ANNEX 02 - 03/02/2024', 'ANNEX 02', '420', '2024-02-03', 'HĐ DÀI HẠN 01/HUANGJIN-BH-LT', '2', 18, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(93, 3, 'ANNEX 03 - 02/03/2024', 'ANNEX 03', '420', '2024-03-02', 'HĐ DÀI HẠN 01/HUANGJIN-BH-LT', '3', 18, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(94, 3, 'ANNEX 03 - 01/03/2024', 'ANNEX 03', '420', '2024-03-01', 'HĐ DÀI HẠN 11/VRG-BH-LT', '3', 11, NULL, 'CSR10', NULL, NULL, 'HÀNG RỜI KHÔNG PALLET', NULL, 'VIỆT NAM', 'BEAN HEACK INVESTMENT CO., LTD', 'BHCK', 'KHÔNG', '2024-03-12', '2024-03-12'),
(95, 3, 'Annex No.03 - 01/03/2024', 'Annex No.03', '420', '2024-03-01', 'No.24/CRCK2-HUANGJIN', '03/2024', 18, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-03-14', '2024-03-14'),
(96, 3, 'Annex No.03 - 01/03/2024', 'Annex No.03', '420', '2024-03-01', 'No.12/VRG-CRCK2-LT', '03/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-03-14', '2024-03-14'),
(97, 4, '130124/CRCK2-HKVN - 13/01/2024', '130124/CRCK2-HKVN', '294.35', '2024-01-13', NULL, '03/2024', 17, NULL, 'CSR 20', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-03-14', '2024-03-14'),
(98, 4, '170224/CRCK2-HT - 17/02/2024', '170224/CRCK2-HT', '630', '2024-02-17', NULL, '04/2024', 19, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-04', '2024-04-04'),
(99, 3, 'Annex No.04 - 01/04/2024', 'Annex No.04', '420', '2024-04-01', 'No.12/VRG-CRCK2-LT', '04/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-12', '2024-04-12'),
(100, 3, 'Annex No.04 - 01/04/2024', 'Annex No.04', '420', '2024-04-01', 'LT-24/CRCK2-HUANGJIN', '04/2024', 18, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-22', '2024-04-22'),
(101, 4, '86/VRG-CRCK2 - 15/04/2024', '86/VRG-CRCK2', '420', '2024-04-15', NULL, '04/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-25', '2024-04-25'),
(102, 4, '190424/CRCK2-HK - 19/04/2024', '190424/CRCK2-HK', '840', '2024-04-19', NULL, '04-05/2024', 10, NULL, 'CSR 20', NULL, NULL, 'không', NULL, 'Campuchia', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-25', '2024-04-25'),
(103, 4, '080424/CRCK2-HT - 08/04/2024', '080424/CRCK2-HT', '315', '2024-04-08', NULL, '04-05/2024', 19, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-04-25', '2024-04-25'),
(104, 3, 'Annex No.05 - 02/05/2024', 'Annex No.05', '420', '2024-05-02', 'No.12/VRG-CRCK2-LT', '05/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-05-08', '2024-05-08'),
(105, 3, 'Annex No.05 - 02/05/2024', 'Annex No.05', '420', '2024-05-02', 'LT-24/CRCK2-HUANGJIN', '05/2024', 18, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-05-13', '2024-05-13'),
(106, 3, 'Annex No.06 - 03/06/2024', 'Annex No.06', '420', '2024-06-03', 'LT-24/CRCK2-HUANGJIN', '06/2024', 18, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-06-15', '2024-06-15'),
(107, 3, 'Annex No.07 - 03/06/2024', 'Annex No.07', '420', '2024-06-03', 'No.12/VRG-CRCK2-LT', '06/2024', 11, NULL, 'CSR 10', NULL, NULL, 'không', NULL, 'Việt Nam', 'C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd', 'CRCK2', 'không', '2024-06-20', '2024-06-20');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `curing_areas`
--

INSERT INTO `curing_areas` (`id`, `name`, `code`, `containing`, `created_at`, `updated_at`) VALUES
(1, 'Nguyên liệu nông trường 1', 'NLNT1', 0, '2024-09-05 06:50:41', '2024-09-07 12:01:55'),
(2, 'Nguyên liệu nông trường 2', 'NLNT2', 0, '2024-09-05 06:51:08', '2024-09-07 12:01:55'),
(3, 'Nguyên liệu nông trường 3', 'NLNT3', 0, '2024-09-05 06:51:59', '2024-09-05 09:18:06'),
(4, 'Nguyên liệu nông trường 4', 'NLNT4', 0, '2024-09-05 06:52:21', '2024-09-05 09:11:23'),
(5, 'Nguyên liệu nông trường 5', 'NLNT5', 0, '2024-09-05 06:54:46', '2024-09-05 06:54:46'),
(6, 'Nguyên liệu nông trường 6', 'NLNT6', 0, '2024-09-05 06:55:06', '2024-09-05 06:55:06'),
(7, 'Nguyên liệu nông trường 7', 'NLNT7', 0, '2024-09-05 06:55:53', '2024-09-05 06:55:53'),
(8, 'Nguyên liệu nông trường 8', 'NLNT8', 0, '2024-09-05 06:56:05', '2024-09-05 07:43:02'),
(9, 'Nguyên liệu Tây Nguyên', 'NLTNSR', 0, '2024-09-05 06:56:43', '2024-09-05 06:56:55'),
(10, 'Nguyên liệu thu mua', 'NLTM', 0, '2024-09-05 06:57:39', '2024-09-05 06:57:39'),
(11, 'Nguyên liệu mủ dây', 'MDCR', 0, '2024-09-05 06:58:45', '2024-09-05 06:58:45');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `curing_houses`
--

INSERT INTO `curing_houses` (`id`, `name`, `code`, `containing`, `created_at`, `updated_at`) VALUES
(1, 'Nguyên liệu cán vắt nông trường 1', 'NLCVNT1', 0, '2024-09-05 07:00:33', '2024-09-07 12:01:43'),
(2, 'Nguyên liệu cán vắt nông trường 2', 'NLCVNT2', 0, '2024-09-05 07:01:00', '2024-09-07 12:01:43'),
(3, 'Nguyên liệu cán vắt nông trường 3', 'NLCVNT3', 0, '2024-09-05 07:01:22', '2024-09-05 07:01:22'),
(4, 'Nguyên liệu cán vắt nông trường 4', 'NLCVNT4', 0, '2024-09-05 07:01:39', '2024-09-05 07:01:39'),
(5, 'Nguyên liệu cán vắt nông trường 5', 'NLCVNT5', 0, '2024-09-05 07:01:58', '2024-09-05 07:01:58'),
(6, 'Nguyên liệu cán vắt nông trường 6', 'NLCVNT6', 0, '2024-09-05 07:02:21', '2024-09-05 07:02:21'),
(7, 'Nguyên liệu cán vắt nông trường 7', 'NLCVNT7', 0, '2024-09-05 07:02:58', '2024-09-05 07:02:58'),
(8, 'Nguyên liệu cán vắt nông trường 8', 'NLCVNT8', 0, '2024-09-05 07:03:27', '2024-09-05 07:03:27'),
(9, 'Nguyên liệu cán vắt Tây Nguyên', 'NLCVTNSR', 0, '2024-09-05 07:04:22', '2024-09-05 07:04:22'),
(10, 'Nguyên liệu cán vắt thu mua', 'NLCVTM', 0, '2024-09-05 07:05:12', '2024-09-05 07:05:12');

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

--
-- Đang đổ dữ liệu cho bảng `delivery_dates`
--

INSERT INTO `delivery_dates` (`id`, `contract_id`, `amount`, `shipping_order`, `container_loading_date`, `date`, `created_at`, `updated_at`) VALUES
(7, 43, '210', 'PX1-MCS47', '2023-08-06', '2023-08-08', '2023-08-04 00:30:04', '2023-08-30 05:03:30'),
(11, 45, '105', 'PX1-MCS51', '2023-08-24', '2023-08-25', '2023-08-04 17:34:31', '2023-08-30 05:41:26'),
(12, 46, '210', 'PX1-MCS45', '2023-08-25', '2023-07-26', '2023-08-04 18:59:06', '2023-08-30 05:35:29'),
(13, 46, '210', 'PX1-MCS54', '2023-08-28', '2023-08-29', '2023-08-04 18:59:06', '2023-08-30 05:39:55'),
(14, 47, '210', 'PX1-MCS57', '2023-09-06', '2023-09-07', '2023-08-04 19:00:49', '2023-09-08 18:59:24'),
(15, 48, '210', 'PX1-MCS70', '2023-10-17', '2023-10-18', '2023-08-07 01:54:08', '2023-10-17 01:00:27'),
(16, 47, '210', 'PX1-MCS58', '2023-09-10', '2023-09-11', '2023-08-07 01:54:58', '2023-09-08 19:56:07'),
(17, 45, '105', 'PX1-MCS52', '2023-08-26', '2023-08-27', '2023-08-07 01:55:25', '2023-08-30 05:41:26'),
(18, 43, '210', 'PX1-MCS48', '2023-08-12', '2023-08-14', '2023-08-07 01:57:17', '2023-08-11 19:03:34'),
(19, 43, '210', 'PX1-MCS49', '2023-08-17', '2023-08-19', '2023-08-07 01:57:17', '2023-09-21 00:22:00'),
(20, 43, '210', 'PX1-MCS50', '2023-08-23', '2023-08-25', '2023-08-07 01:57:18', '2023-08-23 17:46:49'),
(21, 45, '105', 'PX1-MCS53', '2023-08-28', '2023-08-29', '2023-08-14 02:42:33', '2023-08-29 19:17:01'),
(22, 45, '105', 'PX1-MCS55', '2023-08-29', '2023-08-30', '2023-08-14 02:42:33', '2023-08-29 19:17:01'),
(28, 56, '210', '35', '2023-07-06', '2023-07-08', '2023-08-29 01:48:48', '2023-08-30 18:50:20'),
(29, 56, '210', '37', '2023-07-18', '2023-07-20', '2023-08-30 18:50:20', '2023-08-30 18:50:20'),
(30, 56, '210', '38', '2023-07-24', '2023-07-26', '2023-08-30 18:50:20', '2023-08-30 18:50:20'),
(31, 57, '210', '40', '2023-08-03', '2023-08-05', '2023-08-30 19:15:20', '2023-08-30 19:15:20'),
(32, 57, '210', '41', '2023-08-14', '2023-08-16', '2023-08-30 19:15:20', '2023-08-30 19:15:20'),
(33, 57, '210', '42', '2023-08-21', '2023-08-23', '2023-08-30 19:15:20', '2023-08-30 19:15:20'),
(34, 58, '210', '44', '2023-09-04', '2023-09-05', '2023-08-30 19:21:42', '2023-08-30 19:21:42'),
(35, 59, '210', '43', '2023-08-22', '2023-08-23', '2023-08-30 19:30:43', '2023-08-30 19:30:43'),
(36, 60, '210', '39', '2023-08-02', '2023-08-03', '2023-08-31 01:42:41', '2023-08-31 01:42:41'),
(37, 61, '210', 'PX1-MCS56', '2023-09-05', '2023-09-07', '2023-09-03 01:59:48', '2023-09-08 19:01:49'),
(38, 61, '210', 'PX1-MCS59', '2023-09-11', '2023-09-13', '2023-09-03 02:01:23', '2023-09-21 00:18:07'),
(39, 61, '210', 'PX1-MCS61', '2023-09-13', '2023-09-15', '2023-09-03 02:01:23', '2023-09-21 00:18:07'),
(40, 61, '210', 'PX1-MCS63', '2023-09-18', '2023-09-20', '2023-09-03 02:01:23', '2023-09-21 00:18:07'),
(41, 61, '210', 'PX1-MCS65', '2023-09-23', '2023-09-25', '2023-09-03 02:01:23', '2023-09-25 19:21:49'),
(42, 62, '210', 'PX1-MCS64', '2023-09-22', '2023-09-24', '2023-09-14 06:22:01', '2023-09-21 00:11:20'),
(43, 62, '210', 'PX1-MCS66', '2023-09-27', '2023-09-29', '2023-09-14 06:22:01', '2023-09-25 19:18:13'),
(44, 63, '105', 'PX1-MCS60', '2023-09-12', '2023-09-13', '2023-09-14 06:26:06', '2023-09-18 18:36:38'),
(45, 63, '105', 'PX1-MCS62', '2023-09-17', '2023-09-18', '2023-09-14 06:26:06', '2023-09-18 18:36:38'),
(46, 64, '210', 'PX1-MCS67', '2023-10-05', '2023-10-07', '2023-09-25 19:48:12', '2023-10-06 21:20:29'),
(47, 64, '210', 'PX1-MCS68', '2023-10-07', '2023-10-09', '2023-09-25 19:48:12', '2023-10-06 21:20:29'),
(48, 64, '210', 'PX1-MCS69', '2023-10-16', '2023-10-18', '2023-09-25 19:48:12', '2023-10-17 01:01:40'),
(49, 64, '210', 'PX1-MCS72', '2023-10-21', '2023-10-23', '2023-09-25 19:48:12', '2023-10-23 01:57:24'),
(50, 64, '210', 'PX1-MCS75', '2023-10-25', '2023-10-27', '2023-09-25 19:48:12', '2023-10-23 19:35:21'),
(51, 65, '201.6', 'PX1-MCS71', '2023-10-19', '2023-10-20', '2023-10-17 01:10:25', '2023-10-23 01:53:38'),
(52, 65, '201.6', 'PX1-MCS74', '2023-10-23', '2023-10-24', '2023-10-17 01:10:25', '2023-10-23 01:53:55'),
(53, 66, '105', 'PX1-MCS73', '2023-10-22', '2023-10-23', '2023-10-23 19:16:57', '2023-10-23 19:16:57'),
(54, 66, '105', 'PX1-MCS76', '2023-10-25', '2023-10-26', '2023-10-23 19:16:57', '2023-10-23 19:35:33'),
(55, 67, '210', 'PX1-MCS77', '2023-11-06', '2023-11-08', '2023-11-03 00:28:17', '2023-11-09 17:30:02'),
(56, 67, '210', 'PX1-MCS78', '2023-11-09', '2023-11-11', '2023-11-03 00:28:17', '2023-11-16 00:55:50'),
(57, 67, '210', 'PX1-MCS79', '2023-11-15', '2023-11-17', '2023-11-03 00:28:17', '2023-11-16 00:55:50'),
(58, 67, '210', 'PX1-MCS83', '2023-11-20', '2023-11-22', '2023-11-03 00:28:17', '2023-12-06 07:36:39'),
(59, 68, '134.4', 'PX1-MCS80', '2023-11-18', '2023-11-19', '2023-11-08 06:12:03', '2023-11-19 06:15:18'),
(60, 69, '210', 'PX1-MCS82', '2023-11-19', '2023-11-21', '2023-11-16 00:59:23', '2023-11-19 06:19:44'),
(61, 70, '210', 'PX1-MCS88', '2023-11-25', '2023-11-27', '2023-11-16 01:00:44', '2023-12-06 07:13:29'),
(62, 70, '210', 'PX1-MCS89', '2023-11-26', '2023-11-28', '2023-11-16 01:00:44', '2023-12-06 07:13:29'),
(63, 68, '134.4', 'PX1-MCS81', '2023-11-19', '2023-11-20', '2023-11-16 01:02:09', '2023-11-19 06:15:18'),
(64, 68, '134.4', 'PX1-MCS84', '2023-11-20', '2023-11-21', '2023-11-16 01:02:09', '2023-12-06 07:38:05'),
(65, 68, '134.4', 'PX1-MCS85', '2023-11-21', '2023-11-22', '2023-11-16 01:02:09', '2023-12-06 07:38:05'),
(66, 68, '134.4', 'PX1-MCS86', '2023-11-22', '2023-11-23', '2023-11-16 01:02:09', '2023-12-06 07:38:31'),
(67, 68, '134.4', 'PX1-MCS87', '2023-11-23', '2023-11-24', '2023-11-16 01:02:09', '2023-12-06 07:38:31'),
(68, 68, '100.8', 'PX1-MCS90', '2023-11-27', '2023-11-28', '2023-11-16 01:02:09', '2023-12-06 07:39:21'),
(69, 68, '100.8', 'PX1-MCS91', '2023-11-28', '2023-11-29', '2023-11-16 01:02:09', '2023-12-06 07:39:21'),
(70, 71, '210', '45', '2023-09-06', '2023-09-08', '2023-11-17 01:08:17', '2023-11-17 01:08:17'),
(71, 71, '210', '46', '2023-09-14', '2023-09-16', '2023-11-17 01:09:25', '2023-11-17 01:09:25'),
(72, 71, '210', '48', '2023-09-19', '2023-09-21', '2023-11-17 01:09:25', '2023-11-17 01:09:25'),
(73, 72, '210', '54', '2023-10-04', '2023-10-06', '2023-11-17 01:12:42', '2023-11-17 01:12:42'),
(74, 72, '210', '55', '2023-10-08', '2023-10-10', '2023-11-17 01:12:42', '2023-11-17 01:12:42'),
(75, 72, '210', '56', '2023-10-16', '2023-10-18', '2023-11-17 01:12:42', '2023-11-17 01:12:42'),
(76, 73, '210', '63', '2023-11-12', '2023-11-14', '2023-11-17 01:14:01', '2023-11-17 01:14:01'),
(77, 73, '210', '64', '2023-11-16', '2023-11-18', '2023-11-17 01:14:01', '2023-11-17 01:14:01'),
(78, 73, '210', '65', '2023-11-18', '2023-11-20', '2023-11-17 01:14:01', '2023-11-17 01:14:01'),
(79, 74, '210', '57', '2023-10-17', '2023-10-18', '2023-11-17 01:16:31', '2023-11-17 01:16:31'),
(80, 75, '105', '59', '2023-10-25', '2023-10-26', '2023-11-17 01:20:50', '2023-11-17 01:23:27'),
(81, 75, '105', '61', '2023-10-27', '2023-10-28', '2023-11-17 01:23:27', '2023-11-17 01:23:27'),
(82, 76, '210', '60', '2023-10-27', '2023-10-28', '2023-11-17 01:26:34', '2023-11-17 01:26:34'),
(83, 77, '436.80', '62', '2023-11-01', '2023-11-03', '2023-11-17 01:30:02', '2023-11-17 01:30:02'),
(84, 78, '210', 'PX1-MCS96', '2023-12-06', '2023-12-07', '2023-11-19 06:29:55', '2023-12-06 07:29:34'),
(85, 78, '210', 'PX1-MCS101', '2023-12-20', '2023-12-21', '2023-11-19 06:29:55', '2024-01-03 07:50:50'),
(87, 79, '210', 'PX1-MCS97', '2023-12-07', '2023-12-09', '2023-12-06 07:18:23', '2023-12-06 07:41:17'),
(88, 79, '210', 'PX1-MCS99', '2023-12-16', '2023-12-18', '2023-12-06 07:18:23', '2024-01-03 07:42:22'),
(89, 79, '210', 'PX1-MCS100', '2023-12-19', '2023-12-21', '2023-12-06 07:18:23', '2024-01-03 07:42:22'),
(90, 68, '120.96', 'PX1-MCS92', '2023-12-03', '2023-12-04', '2023-12-06 07:21:08', '2023-12-06 07:40:19'),
(91, 68, '120.96', 'PX1-MCS93', '2023-12-04', '2023-12-05', '2023-12-06 07:21:08', '2023-12-06 07:40:56'),
(92, 68, '120.96', 'PX1-MCS94', '2023-12-05', '2023-12-06', '2023-12-06 07:21:08', '2023-12-06 07:40:56'),
(93, 68, '120.96', 'PX1-MCS95', '2023-12-06', '2023-12-07', '2023-12-06 07:21:08', '2023-12-06 07:40:56'),
(94, 68, '188.16', 'PX1-MCS98', '2023-12-13', '2023-12-14', '2023-12-06 07:21:08', '2024-01-03 07:46:43'),
(95, 80, '210', 'PX1-MCS102', '2023-12-22', '2023-12-24', '2024-01-03 07:56:38', '2024-01-03 07:56:38'),
(96, 81, '210', 'PX1-MCS03', '2024-01-13', '2024-01-15', '2024-01-29 20:24:53', '2024-01-29 20:59:39'),
(97, 81, '210', 'PX1-MCS04', '2024-01-15', '2024-01-17', '2024-01-29 20:24:53', '2024-01-29 20:59:39'),
(98, 82, '210', 'PX1-MCS01', '2024-01-09', '2024-01-11', '2024-01-29 21:25:42', '2024-01-29 21:25:42'),
(99, 82, '210', 'PX1-MCS02', '2024-01-11', '2024-01-13', '2024-01-29 21:25:42', '2024-01-29 21:25:42'),
(100, 83, '105', 'PX1-MCS05', '2024-01-18', '2024-01-19', '2024-01-29 21:32:02', '2024-01-29 21:32:02'),
(101, 83, '105', 'PX1-MCS06', '2024-01-19', '2024-01-20', '2024-01-29 21:32:02', '2024-01-29 21:32:02'),
(102, 83, '105', 'PX1-MCS07', '2024-01-23', '2024-01-24', '2024-01-29 21:32:02', '2024-01-29 21:32:02'),
(103, 83, '105', 'PX1-MCS08', '2024-01-25', '2024-01-26', '2024-01-29 21:32:02', '2024-01-29 21:32:02'),
(104, 84, '210', 'PX1-MCS11', '2024-02-24', '2024-02-26', '2024-02-29 02:14:15', '2024-03-13 17:49:36'),
(105, 84, '210', 'PX1-MCS12', '2024-02-26', '2024-02-28', '2024-02-29 02:14:15', '2024-03-13 17:49:36'),
(106, 85, '210', 'PX1-MCS09', '2024-02-20', '2024-02-22', '2024-02-29 02:21:44', '2024-03-13 17:50:09'),
(107, 85, '210', 'PX1-MCS10', '2024-02-22', '2024-02-24', '2024-02-29 02:21:44', '2024-03-13 17:50:09'),
(108, 86, '105', 'PX1-MCS13', '2024-02-26', '2024-02-27', '2024-02-29 02:25:02', '2024-03-13 17:50:57'),
(109, 86, '210', 'PX1-MCS14', '2024-02-27', '2024-02-28', '2024-02-29 02:25:02', '2024-03-13 17:50:57'),
(110, 86, '105', 'PX1-MCS15', '2024-02-28', '2024-02-29', '2024-02-29 02:25:02', '2024-03-13 17:50:57'),
(111, 87, '210', 'PX1-MCS17', '2024-03-07', '2024-03-08', '2024-03-07 21:25:22', '2024-03-14 00:29:54'),
(112, 88, '210', '03', '2024-01-16', '2024-01-18', '2024-03-12 01:23:10', '2024-03-12 01:23:58'),
(113, 88, '210', '04', '2024-01-17', '2024-01-19', '2024-03-12 01:23:10', '2024-03-12 01:23:58'),
(114, 89, '210', '01', '2024-01-10', '2024-01-12', '2024-03-12 01:26:35', '2024-03-12 01:26:35'),
(115, 89, '210', '02', '2024-01-14', '2024-01-16', '2024-03-12 01:26:35', '2024-03-12 01:26:35'),
(116, 90, '210', '06', '2024-02-19', '2024-02-21', '2024-03-12 01:29:52', '2024-03-12 01:29:52'),
(117, 90, '210', '07', '2024-02-20', '2024-02-22', '2024-03-12 01:29:52', '2024-03-12 01:29:52'),
(118, 91, '210', '05', '2024-01-20', '2024-01-21', '2024-03-12 01:31:35', '2024-03-12 01:31:35'),
(119, 92, '210', '08', '2024-02-21', '2024-02-23', '2024-03-12 01:34:23', '2024-03-12 01:34:23'),
(120, 92, '210', '09', '2024-02-26', '2024-02-28', '2024-03-12 01:34:23', '2024-03-12 01:34:23'),
(121, 93, '210', '11', '2024-03-14', '2024-03-16', '2024-03-12 01:38:50', '2024-03-12 01:38:50'),
(122, 93, '210', '13', '2024-03-18', '2024-03-20', '2024-03-12 01:38:50', '2024-03-12 01:38:50'),
(123, 94, '210', '10', '2024-03-16', '2024-03-16', '2024-03-12 01:41:47', '2024-03-12 01:41:47'),
(124, 94, '210', '12', '2024-03-16', '2024-03-18', '2024-03-12 01:41:47', '2024-03-12 01:41:47'),
(125, 95, '210', 'PX1-MCS20', '2024-03-13', '2024-03-15', '2024-03-13 18:28:01', '2024-03-13 23:34:23'),
(126, 95, '210', 'PX1-MCS21', '2024-03-19', '2024-03-21', '2024-03-13 18:28:01', '2024-03-13 23:34:23'),
(127, 96, '210', 'PX1-MCS18', '2024-03-11', '2024-03-13', '2024-03-13 18:30:27', '2024-03-13 23:29:25'),
(128, 96, '210', 'PX1-MCS19', '2024-03-13', '2024-03-15', '2024-03-13 18:30:27', '2024-03-13 23:29:25'),
(129, 97, '294.35', 'PX1-MCS16', '2024-03-05', '2024-03-06', '2024-03-14 00:20:28', '2024-03-14 00:20:28'),
(130, 98, '210', 'PX1-MCS22', '2024-03-31', '2024-04-01', '2024-04-03 18:25:10', '2024-04-03 18:25:10'),
(131, 98, '210', 'PX1-MCS23', '2024-04-03', '2024-04-04', '2024-04-03 18:25:10', '2024-04-03 18:25:10'),
(132, 99, '210', 'PX1-MCS24', '2024-04-09', '2024-04-11', '2024-04-11 21:22:01', '2024-04-11 21:22:01'),
(133, 99, '210', 'PX1-MCS25', '2024-04-11', '2024-04-13', '2024-04-11 21:22:01', '2024-04-11 21:22:01'),
(134, 100, '210', 'PX1-MCS26', '2024-04-18', '2024-04-20', '2024-04-21 23:47:26', '2024-04-21 23:48:00'),
(135, 100, '210', 'PX1-MCS27', '2024-04-20', '2024-04-22', '2024-04-21 23:47:26', '2024-04-21 23:48:00'),
(136, 101, '210', 'PX1-MCS28', '2024-04-21', '2024-04-22', '2024-04-24 23:30:53', '2024-04-24 23:37:09'),
(137, 101, '210', 'PX1-MCS29', '2024-04-22', '2024-04-23', '2024-04-24 23:30:53', '2024-04-24 23:37:09'),
(138, 102, '105', 'PX1-MCS30', '0224-04-24', '2024-04-24', '2024-04-25 01:54:58', '2024-04-25 18:01:27'),
(139, 102, '105', 'PX1-MCS31', '0224-04-25', '2024-04-25', '2024-04-25 01:54:58', '2024-04-25 18:01:27'),
(140, 102, '105', 'PX1-MCS32', '0224-04-28', '2024-04-28', '2024-04-25 01:54:58', '2024-04-25 18:01:27'),
(141, 103, '210', 'PX1-MCS36', '2024-05-02', '2024-05-03', '2024-04-25 01:56:31', '2024-05-16 00:21:47'),
(142, 102, '105', 'PX1-MCS33', '0224-04-29', '2024-04-29', '2024-05-02 23:50:53', '2024-05-07 23:26:53'),
(143, 102, '105', 'PX1-MCS34', '0224-04-30', '2024-04-30', '2024-05-02 23:50:53', '2024-05-07 23:26:53'),
(144, 102, '105', 'PX1-MCS35', '0224-05-02', '2024-05-02', '2024-05-02 23:50:53', '2024-05-07 23:26:53'),
(145, 102, '105', 'PX1-MCS37', '2024-05-03', '2024-05-03', '2024-05-02 23:51:36', '2024-05-16 00:20:03'),
(146, 102, '105', 'PX1-MCS38', '2024-05-04', '2024-05-04', '2024-05-07 23:26:53', '2024-05-16 00:20:03'),
(147, 104, '210', 'PX1-MCS39', '2024-05-07', '2024-05-09', '2024-05-07 23:28:35', '2024-05-16 00:21:02'),
(148, 104, '210', 'PX1-MCS40', '2024-05-09', '2024-05-11', '2024-05-07 23:28:35', '2024-05-16 00:21:02'),
(149, 105, '210', 'PX1-MCS42', '2024-05-12', '2024-05-14', '2024-05-12 17:26:21', '2024-05-16 00:22:07'),
(150, 105, '210', 'PX1-MCS43', '2024-05-14', '2024-05-16', '2024-05-12 17:26:21', '2024-05-16 00:22:07'),
(151, 98, '210', 'PX1-MCS41', '2024-05-09', '2024-05-10', '2024-05-14 23:31:28', '2024-05-16 00:21:13'),
(152, 103, '105', 'PX1-MCS44', '2024-05-29', '2024-05-30', '2024-05-29 17:18:53', '2024-05-29 17:18:53'),
(153, 107, '210', 'PX1-MCS46', '2024-06-19', '2024-06-21', '2024-06-19 18:27:01', '2024-06-19 18:31:37'),
(154, 107, '210', 'PX1-MCS47', '2024-06-22', '2024-06-24', '2024-06-19 18:27:01', '2024-06-19 18:31:37'),
(155, 106, '210', 'PX1-MCS44', '0004-06-08', '2024-06-10', '2024-06-19 18:27:51', '2024-06-19 18:28:38'),
(156, 106, '210', 'PX1-MCS45', '0004-06-19', '2024-06-21', '2024-06-19 18:27:51', '2024-06-19 18:28:38');

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
  `heated_time` time DEFAULT NULL,
  `temp` int(11) DEFAULT NULL,
  `state` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `baled` bigint(20) UNSIGNED DEFAULT NULL,
  `bale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rolling_code` bigint(20) UNSIGNED DEFAULT NULL,
  `curing_house_id` int(11) DEFAULT NULL,
  `link` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'NT1', 'Nông trường 1', '2024-08-30 03:25:18', '2024-09-07 04:03:34', 1),
(2, 'NT2', 'Nông trường 2', '2024-08-30 03:25:25', '2024-09-07 04:05:46', 1),
(3, 'NT3', 'Nông trường 3', '2024-09-04 08:36:35', '2024-09-07 04:06:21', 1),
(4, 'NT4', 'Nông trường 4', '2024-09-04 08:37:15', '2024-09-07 04:07:58', 1),
(5, 'NT5', 'Nông trường 5', '2024-09-04 08:39:13', '2024-09-07 04:08:25', 2),
(6, 'NT6', 'Nông trường 6', '2024-09-04 08:39:28', '2024-09-07 04:10:27', 2),
(7, 'NT7', 'Nông trường 7', '2024-09-04 08:39:38', '2024-09-07 04:11:31', 2),
(8, 'NT8', 'Nông trường 8', '2024-09-04 08:39:51', '2024-09-07 04:12:03', 2),
(9, 'TM', 'Thu mua', '2024-09-05 07:08:23', '2024-09-07 04:32:26', 4),
(10, 'TNSR', 'Tây Nguyên', '2024-09-05 07:08:42', '2024-09-07 04:32:12', 3),
(14, 'MD', 'mủ dây', '2024-09-07 04:33:34', '2024-09-07 04:38:11', 7);

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
(33, '2024_09_07_091356_add_company_id_to_farms_table', 20);

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
(7, 4, 1, '2024-09-07 10:51:39', '2024-09-07 10:51:39'),
(8, 4, 3, '2024-09-07 10:51:39', '2024-09-07 10:51:39');

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
('ZplLdkYKUogIVMB757tjruH1cvETfEGxHvwu3h60', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnJwWDdpVkxDVEViQWRXNDJtTzdacTNRekR3VVRDUUREMldMWmx3MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ydWJiZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1725710556);

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
(3, '3A-3712', NULL, 1, '2024-09-04 08:40:42', '2024-09-04 08:40:42'),
(4, '3A-3404', NULL, 1, '2024-09-04 08:41:31', '2024-09-04 08:41:31'),
(5, '3A-1256', NULL, 6, '2024-09-04 08:41:46', '2024-09-04 08:41:46'),
(6, '3A-6608', NULL, 6, '2024-09-04 08:41:59', '2024-09-04 08:41:59'),
(7, '3A-4673', NULL, 2, '2024-09-04 08:42:06', '2024-09-04 08:42:06'),
(8, '3B-1085', NULL, 8, '2024-09-04 08:43:30', '2024-09-04 08:43:30'),
(9, '3A-1817', NULL, 5, '2024-09-04 08:43:44', '2024-09-04 08:43:44'),
(10, '3A-2023', NULL, 8, '2024-09-04 08:44:02', '2024-09-04 08:44:02'),
(11, '3B-5787', NULL, 5, '2024-09-04 08:44:20', '2024-09-04 08:44:20'),
(12, '3A-1440', NULL, 5, '2024-09-04 08:44:29', '2024-09-04 08:44:29'),
(13, '3A-1012', NULL, 8, '2024-09-04 08:44:41', '2024-09-04 08:44:41'),
(14, '3A-1844', NULL, 5, '2024-09-04 08:45:29', '2024-09-04 08:45:29'),
(15, '3A-1020', NULL, 8, '2024-09-04 08:45:55', '2024-09-04 08:45:55'),
(16, '3A- 2020', NULL, 8, '2024-09-04 08:46:09', '2024-09-04 08:46:09'),
(17, '3B-1474', NULL, 4, '2024-09-04 08:46:19', '2024-09-04 08:46:19'),
(18, '3A-2330', NULL, 7, '2024-09-04 08:46:35', '2024-09-04 08:46:35'),
(19, '3A-1373', NULL, 8, '2024-09-04 08:47:08', '2024-09-04 08:47:08'),
(20, '3A-1335', NULL, 7, '2024-09-04 08:47:52', '2024-09-04 08:47:52');

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
(4, '123', '1234@gmail.com', NULL, '$2y$12$lyrlc5ftOD/2mWQuUjBxxu.69q1IWQOgDwCadWQtVKaFHlfEH9xtK', NULL, '2024-09-07 10:51:39', '2024-09-07 10:51:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `stack` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `code`, `stack`, `created_at`, `updated_at`, `batch_id`) VALUES
(1, 'A1', 'A1-11', '1', '2024-08-30 04:08:28', '2024-09-05 09:47:34', NULL),
(2, 'A1', 'A1-12', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(3, 'A1', 'A1-13', '1', '2024-08-30 04:08:28', '2024-08-30 04:14:58', NULL),
(4, 'A1', 'A1-14', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(5, 'A1', 'A1-15', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(6, 'A1', 'A1-16', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(7, 'A1', 'A1-21', '1', '2024-08-30 04:08:28', '2024-08-30 04:13:17', NULL),
(8, 'A1', 'A1-22', '1', '2024-08-30 04:08:28', '2024-08-30 04:13:35', NULL),
(9, 'A1', 'A1-23', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(10, 'A1', 'A1-24', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(11, 'A1', 'A1-25', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(12, 'A1', 'A1-26', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(13, 'A1', 'A1-31', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(14, 'A1', 'A1-32', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(15, 'A1', 'A1-33', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(16, 'A1', 'A1-34', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(17, 'A1', 'A1-35', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(18, 'A1', 'A1-36', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(19, 'A1', 'A1-41', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(20, 'A1', 'A1-42', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(21, 'A1', 'A1-43', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(22, 'A1', 'A1-44', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(23, 'A1', 'A1-45', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(24, 'A1', 'A1-46', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(25, 'A1', 'A1-51', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(26, 'A1', 'A1-52', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(27, 'A1', 'A1-53', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(28, 'A1', 'A1-54', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(29, 'A1', 'A1-55', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(30, 'A1', 'A1-56', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(31, 'A1', 'A1-61', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(32, 'A1', 'A1-62', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(33, 'A1', 'A1-63', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(34, 'A1', 'A1-64', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(35, 'A1', 'A1-65', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(36, 'A1', 'A1-66', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(37, 'A1', 'A1-71', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(38, 'A1', 'A1-72', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(39, 'A1', 'A1-73', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(40, 'A1', 'A1-74', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(41, 'A1', 'A1-75', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(42, 'A1', 'A1-76', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(43, 'A1', 'A1-81', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(44, 'A1', 'A1-82', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(45, 'A1', 'A1-83', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(46, 'A1', 'A1-84', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(47, 'A1', 'A1-85', '1', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(48, 'A1', 'A1-86', '1', '2024-08-30 04:08:28', '2024-09-04 04:42:23', NULL),
(49, 'A1', 'A1-11', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(50, 'A1', 'A1-12', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(51, 'A1', 'A1-13', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(52, 'A1', 'A1-14', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(53, 'A1', 'A1-15', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(54, 'A1', 'A1-16', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(55, 'A1', 'A1-21', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(56, 'A1', 'A1-22', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(57, 'A1', 'A1-23', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(58, 'A1', 'A1-24', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(59, 'A1', 'A1-25', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(60, 'A1', 'A1-26', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(61, 'A1', 'A1-31', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(62, 'A1', 'A1-32', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(63, 'A1', 'A1-33', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(64, 'A1', 'A1-34', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(65, 'A1', 'A1-35', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(66, 'A1', 'A1-36', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(67, 'A1', 'A1-41', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(68, 'A1', 'A1-42', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(69, 'A1', 'A1-43', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(70, 'A1', 'A1-44', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(71, 'A1', 'A1-45', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(72, 'A1', 'A1-46', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(73, 'A1', 'A1-51', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(74, 'A1', 'A1-52', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(75, 'A1', 'A1-53', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(76, 'A1', 'A1-54', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(77, 'A1', 'A1-55', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(78, 'A1', 'A1-56', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(79, 'A1', 'A1-61', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(80, 'A1', 'A1-62', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(81, 'A1', 'A1-63', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(82, 'A1', 'A1-64', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(83, 'A1', 'A1-65', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(84, 'A1', 'A1-66', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(85, 'A1', 'A1-71', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(86, 'A1', 'A1-72', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(87, 'A1', 'A1-73', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(88, 'A1', 'A1-74', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(89, 'A1', 'A1-75', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(90, 'A1', 'A1-76', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(91, 'A1', 'A1-81', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(92, 'A1', 'A1-82', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(93, 'A1', 'A1-83', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(94, 'A1', 'A1-84', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(95, 'A1', 'A1-85', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(96, 'A1', 'A1-86', '2', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(97, 'A1', 'A1-11', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(98, 'A1', 'A1-12', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(99, 'A1', 'A1-13', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(100, 'A1', 'A1-14', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(101, 'A1', 'A1-15', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(102, 'A1', 'A1-16', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(103, 'A1', 'A1-21', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(104, 'A1', 'A1-22', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(105, 'A1', 'A1-23', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(106, 'A1', 'A1-24', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(107, 'A1', 'A1-25', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(108, 'A1', 'A1-26', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(109, 'A1', 'A1-31', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(110, 'A1', 'A1-32', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(111, 'A1', 'A1-33', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(112, 'A1', 'A1-34', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(113, 'A1', 'A1-35', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(114, 'A1', 'A1-36', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(115, 'A1', 'A1-41', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(116, 'A1', 'A1-42', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(117, 'A1', 'A1-43', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(118, 'A1', 'A1-44', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(119, 'A1', 'A1-45', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(120, 'A1', 'A1-46', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(121, 'A1', 'A1-51', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(122, 'A1', 'A1-52', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(123, 'A1', 'A1-53', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(124, 'A1', 'A1-54', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(125, 'A1', 'A1-55', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(126, 'A1', 'A1-56', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(127, 'A1', 'A1-61', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(128, 'A1', 'A1-62', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(129, 'A1', 'A1-63', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(130, 'A1', 'A1-64', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(131, 'A1', 'A1-65', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(132, 'A1', 'A1-66', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(133, 'A1', 'A1-71', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(134, 'A1', 'A1-72', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(135, 'A1', 'A1-73', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(136, 'A1', 'A1-74', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(137, 'A1', 'A1-75', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(138, 'A1', 'A1-76', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(139, 'A1', 'A1-81', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(140, 'A1', 'A1-82', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(141, 'A1', 'A1-83', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(142, 'A1', 'A1-84', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(143, 'A1', 'A1-85', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(144, 'A1', 'A1-86', '3', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(145, 'A1', 'A1-11', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(146, 'A1', 'A1-12', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(147, 'A1', 'A1-13', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(148, 'A1', 'A1-14', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(149, 'A1', 'A1-15', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(150, 'A1', 'A1-16', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(151, 'A1', 'A1-21', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(152, 'A1', 'A1-22', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(153, 'A1', 'A1-23', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(154, 'A1', 'A1-24', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(155, 'A1', 'A1-25', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(156, 'A1', 'A1-26', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(157, 'A1', 'A1-31', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(158, 'A1', 'A1-32', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(159, 'A1', 'A1-33', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(160, 'A1', 'A1-34', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(161, 'A1', 'A1-35', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(162, 'A1', 'A1-36', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(163, 'A1', 'A1-41', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(164, 'A1', 'A1-42', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(165, 'A1', 'A1-43', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(166, 'A1', 'A1-44', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(167, 'A1', 'A1-45', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(168, 'A1', 'A1-46', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(169, 'A1', 'A1-51', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(170, 'A1', 'A1-52', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(171, 'A1', 'A1-53', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(172, 'A1', 'A1-54', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(173, 'A1', 'A1-55', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(174, 'A1', 'A1-56', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(175, 'A1', 'A1-61', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(176, 'A1', 'A1-62', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(177, 'A1', 'A1-63', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(178, 'A1', 'A1-64', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(179, 'A1', 'A1-65', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(180, 'A1', 'A1-66', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(181, 'A1', 'A1-71', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(182, 'A1', 'A1-72', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(183, 'A1', 'A1-73', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(184, 'A1', 'A1-74', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(185, 'A1', 'A1-75', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(186, 'A1', 'A1-76', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(187, 'A1', 'A1-81', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(188, 'A1', 'A1-82', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(189, 'A1', 'A1-83', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(190, 'A1', 'A1-84', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(191, 'A1', 'A1-85', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(192, 'A1', 'A1-86', '4', '2024-08-30 04:08:28', '2024-08-30 04:08:28', NULL),
(193, 'A2', 'A2-11', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(194, 'A2', 'A2-12', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(195, 'A2', 'A2-13', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(196, 'A2', 'A2-14', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(197, 'A2', 'A2-15', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(198, 'A2', 'A2-16', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(199, 'A2', 'A2-21', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(200, 'A2', 'A2-22', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(201, 'A2', 'A2-23', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(202, 'A2', 'A2-24', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(203, 'A2', 'A2-25', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(204, 'A2', 'A2-26', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(205, 'A2', 'A2-31', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(206, 'A2', 'A2-32', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(207, 'A2', 'A2-33', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(208, 'A2', 'A2-34', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(209, 'A2', 'A2-35', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(210, 'A2', 'A2-36', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(211, 'A2', 'A2-41', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(212, 'A2', 'A2-42', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(213, 'A2', 'A2-43', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(214, 'A2', 'A2-44', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(215, 'A2', 'A2-45', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(216, 'A2', 'A2-46', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(217, 'A2', 'A2-51', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(218, 'A2', 'A2-52', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(219, 'A2', 'A2-53', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(220, 'A2', 'A2-54', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(221, 'A2', 'A2-55', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(222, 'A2', 'A2-56', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(223, 'A2', 'A2-61', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(224, 'A2', 'A2-62', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(225, 'A2', 'A2-63', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(226, 'A2', 'A2-64', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(227, 'A2', 'A2-65', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(228, 'A2', 'A2-66', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(229, 'A2', 'A2-71', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(230, 'A2', 'A2-72', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(231, 'A2', 'A2-73', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(232, 'A2', 'A2-74', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(233, 'A2', 'A2-75', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(234, 'A2', 'A2-76', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(235, 'A2', 'A2-81', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(236, 'A2', 'A2-82', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(237, 'A2', 'A2-83', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(238, 'A2', 'A2-84', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(239, 'A2', 'A2-85', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(240, 'A2', 'A2-86', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(241, 'A2', 'A2-91', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(242, 'A2', 'A2-92', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(243, 'A2', 'A2-93', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(244, 'A2', 'A2-94', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(245, 'A2', 'A2-95', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(246, 'A2', 'A2-96', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(247, 'A2', 'A2-101', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(248, 'A2', 'A2-102', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(249, 'A2', 'A2-103', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(250, 'A2', 'A2-104', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(251, 'A2', 'A2-105', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(252, 'A2', 'A2-106', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(253, 'A2', 'A2-111', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(254, 'A2', 'A2-112', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(255, 'A2', 'A2-113', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(256, 'A2', 'A2-114', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(257, 'A2', 'A2-115', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(258, 'A2', 'A2-116', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(259, 'A2', 'A2-121', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(260, 'A2', 'A2-122', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(261, 'A2', 'A2-123', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(262, 'A2', 'A2-124', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(263, 'A2', 'A2-125', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(264, 'A2', 'A2-126', '1', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(265, 'A2', 'A2-11', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(266, 'A2', 'A2-12', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(267, 'A2', 'A2-13', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(268, 'A2', 'A2-14', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(269, 'A2', 'A2-15', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(270, 'A2', 'A2-16', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(271, 'A2', 'A2-21', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(272, 'A2', 'A2-22', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(273, 'A2', 'A2-23', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(274, 'A2', 'A2-24', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(275, 'A2', 'A2-25', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(276, 'A2', 'A2-26', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(277, 'A2', 'A2-31', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(278, 'A2', 'A2-32', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(279, 'A2', 'A2-33', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(280, 'A2', 'A2-34', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(281, 'A2', 'A2-35', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(282, 'A2', 'A2-36', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(283, 'A2', 'A2-41', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(284, 'A2', 'A2-42', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(285, 'A2', 'A2-43', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(286, 'A2', 'A2-44', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(287, 'A2', 'A2-45', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(288, 'A2', 'A2-46', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(289, 'A2', 'A2-51', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(290, 'A2', 'A2-52', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(291, 'A2', 'A2-53', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(292, 'A2', 'A2-54', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(293, 'A2', 'A2-55', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(294, 'A2', 'A2-56', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(295, 'A2', 'A2-61', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(296, 'A2', 'A2-62', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(297, 'A2', 'A2-63', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(298, 'A2', 'A2-64', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(299, 'A2', 'A2-65', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(300, 'A2', 'A2-66', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(301, 'A2', 'A2-71', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(302, 'A2', 'A2-72', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(303, 'A2', 'A2-73', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(304, 'A2', 'A2-74', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(305, 'A2', 'A2-75', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(306, 'A2', 'A2-76', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(307, 'A2', 'A2-81', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(308, 'A2', 'A2-82', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(309, 'A2', 'A2-83', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(310, 'A2', 'A2-84', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(311, 'A2', 'A2-85', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(312, 'A2', 'A2-86', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(313, 'A2', 'A2-91', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(314, 'A2', 'A2-92', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(315, 'A2', 'A2-93', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(316, 'A2', 'A2-94', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(317, 'A2', 'A2-95', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(318, 'A2', 'A2-96', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(319, 'A2', 'A2-101', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(320, 'A2', 'A2-102', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(321, 'A2', 'A2-103', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(322, 'A2', 'A2-104', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(323, 'A2', 'A2-105', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(324, 'A2', 'A2-106', '2', '2024-08-30 04:08:43', '2024-08-30 04:08:43', NULL),
(325, 'A2', 'A2-111', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(326, 'A2', 'A2-112', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(327, 'A2', 'A2-113', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(328, 'A2', 'A2-114', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(329, 'A2', 'A2-115', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(330, 'A2', 'A2-116', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(331, 'A2', 'A2-121', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(332, 'A2', 'A2-122', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(333, 'A2', 'A2-123', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(334, 'A2', 'A2-124', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(335, 'A2', 'A2-125', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(336, 'A2', 'A2-126', '2', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(337, 'A2', 'A2-11', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(338, 'A2', 'A2-12', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(339, 'A2', 'A2-13', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(340, 'A2', 'A2-14', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(341, 'A2', 'A2-15', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(342, 'A2', 'A2-16', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(343, 'A2', 'A2-21', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(344, 'A2', 'A2-22', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(345, 'A2', 'A2-23', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(346, 'A2', 'A2-24', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(347, 'A2', 'A2-25', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(348, 'A2', 'A2-26', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(349, 'A2', 'A2-31', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(350, 'A2', 'A2-32', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(351, 'A2', 'A2-33', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(352, 'A2', 'A2-34', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(353, 'A2', 'A2-35', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(354, 'A2', 'A2-36', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(355, 'A2', 'A2-41', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(356, 'A2', 'A2-42', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(357, 'A2', 'A2-43', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(358, 'A2', 'A2-44', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(359, 'A2', 'A2-45', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(360, 'A2', 'A2-46', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(361, 'A2', 'A2-51', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(362, 'A2', 'A2-52', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(363, 'A2', 'A2-53', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(364, 'A2', 'A2-54', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(365, 'A2', 'A2-55', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(366, 'A2', 'A2-56', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(367, 'A2', 'A2-61', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(368, 'A2', 'A2-62', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(369, 'A2', 'A2-63', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(370, 'A2', 'A2-64', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(371, 'A2', 'A2-65', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(372, 'A2', 'A2-66', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(373, 'A2', 'A2-71', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(374, 'A2', 'A2-72', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(375, 'A2', 'A2-73', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(376, 'A2', 'A2-74', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(377, 'A2', 'A2-75', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(378, 'A2', 'A2-76', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(379, 'A2', 'A2-81', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(380, 'A2', 'A2-82', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(381, 'A2', 'A2-83', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(382, 'A2', 'A2-84', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(383, 'A2', 'A2-85', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(384, 'A2', 'A2-86', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(385, 'A2', 'A2-91', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(386, 'A2', 'A2-92', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(387, 'A2', 'A2-93', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(388, 'A2', 'A2-94', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(389, 'A2', 'A2-95', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(390, 'A2', 'A2-96', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(391, 'A2', 'A2-101', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(392, 'A2', 'A2-102', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(393, 'A2', 'A2-103', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(394, 'A2', 'A2-104', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(395, 'A2', 'A2-105', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(396, 'A2', 'A2-106', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(397, 'A2', 'A2-111', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(398, 'A2', 'A2-112', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(399, 'A2', 'A2-113', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(400, 'A2', 'A2-114', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(401, 'A2', 'A2-115', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(402, 'A2', 'A2-116', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(403, 'A2', 'A2-121', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(404, 'A2', 'A2-122', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(405, 'A2', 'A2-123', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(406, 'A2', 'A2-124', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(407, 'A2', 'A2-125', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(408, 'A2', 'A2-126', '3', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(409, 'A2', 'A2-11', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(410, 'A2', 'A2-12', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(411, 'A2', 'A2-13', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(412, 'A2', 'A2-14', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(413, 'A2', 'A2-15', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(414, 'A2', 'A2-16', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(415, 'A2', 'A2-21', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(416, 'A2', 'A2-22', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(417, 'A2', 'A2-23', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(418, 'A2', 'A2-24', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(419, 'A2', 'A2-25', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(420, 'A2', 'A2-26', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(421, 'A2', 'A2-31', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(422, 'A2', 'A2-32', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(423, 'A2', 'A2-33', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(424, 'A2', 'A2-34', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(425, 'A2', 'A2-35', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(426, 'A2', 'A2-36', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(427, 'A2', 'A2-41', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(428, 'A2', 'A2-42', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(429, 'A2', 'A2-43', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(430, 'A2', 'A2-44', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(431, 'A2', 'A2-45', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(432, 'A2', 'A2-46', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(433, 'A2', 'A2-51', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(434, 'A2', 'A2-52', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(435, 'A2', 'A2-53', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(436, 'A2', 'A2-54', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(437, 'A2', 'A2-55', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(438, 'A2', 'A2-56', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(439, 'A2', 'A2-61', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(440, 'A2', 'A2-62', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(441, 'A2', 'A2-63', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(442, 'A2', 'A2-64', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(443, 'A2', 'A2-65', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(444, 'A2', 'A2-66', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(445, 'A2', 'A2-71', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(446, 'A2', 'A2-72', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(447, 'A2', 'A2-73', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(448, 'A2', 'A2-74', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(449, 'A2', 'A2-75', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(450, 'A2', 'A2-76', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(451, 'A2', 'A2-81', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(452, 'A2', 'A2-82', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(453, 'A2', 'A2-83', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(454, 'A2', 'A2-84', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(455, 'A2', 'A2-85', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(456, 'A2', 'A2-86', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(457, 'A2', 'A2-91', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(458, 'A2', 'A2-92', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(459, 'A2', 'A2-93', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(460, 'A2', 'A2-94', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(461, 'A2', 'A2-95', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(462, 'A2', 'A2-96', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(463, 'A2', 'A2-101', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(464, 'A2', 'A2-102', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(465, 'A2', 'A2-103', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(466, 'A2', 'A2-104', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(467, 'A2', 'A2-105', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(468, 'A2', 'A2-106', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(469, 'A2', 'A2-111', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(470, 'A2', 'A2-112', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(471, 'A2', 'A2-113', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(472, 'A2', 'A2-114', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(473, 'A2', 'A2-115', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(474, 'A2', 'A2-116', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(475, 'A2', 'A2-121', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(476, 'A2', 'A2-122', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(477, 'A2', 'A2-123', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(478, 'A2', 'A2-124', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(479, 'A2', 'A2-125', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(480, 'A2', 'A2-126', '4', '2024-08-30 04:08:44', '2024-08-30 04:08:44', NULL),
(481, 'A3', 'A3-11', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(482, 'A3', 'A3-12', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(483, 'A3', 'A3-13', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(484, 'A3', 'A3-14', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(485, 'A3', 'A3-15', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(486, 'A3', 'A3-16', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(487, 'A3', 'A3-21', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(488, 'A3', 'A3-22', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(489, 'A3', 'A3-23', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(490, 'A3', 'A3-24', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(491, 'A3', 'A3-25', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(492, 'A3', 'A3-26', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(493, 'A3', 'A3-31', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(494, 'A3', 'A3-32', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(495, 'A3', 'A3-33', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(496, 'A3', 'A3-34', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(497, 'A3', 'A3-35', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(498, 'A3', 'A3-36', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(499, 'A3', 'A3-41', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(500, 'A3', 'A3-42', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(501, 'A3', 'A3-43', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(502, 'A3', 'A3-44', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(503, 'A3', 'A3-45', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(504, 'A3', 'A3-46', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(505, 'A3', 'A3-51', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(506, 'A3', 'A3-52', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(507, 'A3', 'A3-53', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(508, 'A3', 'A3-54', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(509, 'A3', 'A3-55', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(510, 'A3', 'A3-56', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(511, 'A3', 'A3-61', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(512, 'A3', 'A3-62', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(513, 'A3', 'A3-63', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(514, 'A3', 'A3-64', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(515, 'A3', 'A3-65', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(516, 'A3', 'A3-66', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(517, 'A3', 'A3-71', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(518, 'A3', 'A3-72', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(519, 'A3', 'A3-73', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(520, 'A3', 'A3-74', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(521, 'A3', 'A3-75', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(522, 'A3', 'A3-76', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(523, 'A3', 'A3-81', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(524, 'A3', 'A3-82', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(525, 'A3', 'A3-83', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(526, 'A3', 'A3-84', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(527, 'A3', 'A3-85', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(528, 'A3', 'A3-86', '1', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(529, 'A3', 'A3-11', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(530, 'A3', 'A3-12', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(531, 'A3', 'A3-13', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(532, 'A3', 'A3-14', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(533, 'A3', 'A3-15', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(534, 'A3', 'A3-16', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(535, 'A3', 'A3-21', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(536, 'A3', 'A3-22', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(537, 'A3', 'A3-23', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(538, 'A3', 'A3-24', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(539, 'A3', 'A3-25', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(540, 'A3', 'A3-26', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(541, 'A3', 'A3-31', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(542, 'A3', 'A3-32', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(543, 'A3', 'A3-33', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(544, 'A3', 'A3-34', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(545, 'A3', 'A3-35', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(546, 'A3', 'A3-36', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(547, 'A3', 'A3-41', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(548, 'A3', 'A3-42', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(549, 'A3', 'A3-43', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(550, 'A3', 'A3-44', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(551, 'A3', 'A3-45', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(552, 'A3', 'A3-46', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(553, 'A3', 'A3-51', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(554, 'A3', 'A3-52', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(555, 'A3', 'A3-53', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(556, 'A3', 'A3-54', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(557, 'A3', 'A3-55', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(558, 'A3', 'A3-56', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(559, 'A3', 'A3-61', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(560, 'A3', 'A3-62', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(561, 'A3', 'A3-63', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(562, 'A3', 'A3-64', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(563, 'A3', 'A3-65', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(564, 'A3', 'A3-66', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(565, 'A3', 'A3-71', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(566, 'A3', 'A3-72', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(567, 'A3', 'A3-73', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(568, 'A3', 'A3-74', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(569, 'A3', 'A3-75', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(570, 'A3', 'A3-76', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(571, 'A3', 'A3-81', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(572, 'A3', 'A3-82', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(573, 'A3', 'A3-83', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(574, 'A3', 'A3-84', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(575, 'A3', 'A3-85', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(576, 'A3', 'A3-86', '2', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(577, 'A3', 'A3-11', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(578, 'A3', 'A3-12', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(579, 'A3', 'A3-13', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(580, 'A3', 'A3-14', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(581, 'A3', 'A3-15', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(582, 'A3', 'A3-16', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(583, 'A3', 'A3-21', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(584, 'A3', 'A3-22', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(585, 'A3', 'A3-23', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(586, 'A3', 'A3-24', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(587, 'A3', 'A3-25', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(588, 'A3', 'A3-26', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(589, 'A3', 'A3-31', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(590, 'A3', 'A3-32', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(591, 'A3', 'A3-33', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(592, 'A3', 'A3-34', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(593, 'A3', 'A3-35', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(594, 'A3', 'A3-36', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(595, 'A3', 'A3-41', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(596, 'A3', 'A3-42', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(597, 'A3', 'A3-43', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(598, 'A3', 'A3-44', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(599, 'A3', 'A3-45', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(600, 'A3', 'A3-46', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(601, 'A3', 'A3-51', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(602, 'A3', 'A3-52', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(603, 'A3', 'A3-53', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(604, 'A3', 'A3-54', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(605, 'A3', 'A3-55', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(606, 'A3', 'A3-56', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(607, 'A3', 'A3-61', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(608, 'A3', 'A3-62', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(609, 'A3', 'A3-63', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(610, 'A3', 'A3-64', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(611, 'A3', 'A3-65', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(612, 'A3', 'A3-66', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(613, 'A3', 'A3-71', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(614, 'A3', 'A3-72', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(615, 'A3', 'A3-73', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(616, 'A3', 'A3-74', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(617, 'A3', 'A3-75', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(618, 'A3', 'A3-76', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(619, 'A3', 'A3-81', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(620, 'A3', 'A3-82', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(621, 'A3', 'A3-83', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(622, 'A3', 'A3-84', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(623, 'A3', 'A3-85', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(624, 'A3', 'A3-86', '3', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(625, 'A3', 'A3-11', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(626, 'A3', 'A3-12', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(627, 'A3', 'A3-13', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(628, 'A3', 'A3-14', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(629, 'A3', 'A3-15', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(630, 'A3', 'A3-16', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(631, 'A3', 'A3-21', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(632, 'A3', 'A3-22', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(633, 'A3', 'A3-23', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(634, 'A3', 'A3-24', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(635, 'A3', 'A3-25', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(636, 'A3', 'A3-26', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(637, 'A3', 'A3-31', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(638, 'A3', 'A3-32', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(639, 'A3', 'A3-33', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(640, 'A3', 'A3-34', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(641, 'A3', 'A3-35', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(642, 'A3', 'A3-36', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(643, 'A3', 'A3-41', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(644, 'A3', 'A3-42', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(645, 'A3', 'A3-43', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(646, 'A3', 'A3-44', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(647, 'A3', 'A3-45', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(648, 'A3', 'A3-46', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL);
INSERT INTO `warehouses` (`id`, `name`, `code`, `stack`, `created_at`, `updated_at`, `batch_id`) VALUES
(649, 'A3', 'A3-51', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(650, 'A3', 'A3-52', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(651, 'A3', 'A3-53', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(652, 'A3', 'A3-54', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(653, 'A3', 'A3-55', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(654, 'A3', 'A3-56', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(655, 'A3', 'A3-61', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(656, 'A3', 'A3-62', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(657, 'A3', 'A3-63', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(658, 'A3', 'A3-64', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(659, 'A3', 'A3-65', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(660, 'A3', 'A3-66', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(661, 'A3', 'A3-71', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(662, 'A3', 'A3-72', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(663, 'A3', 'A3-73', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(664, 'A3', 'A3-74', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(665, 'A3', 'A3-75', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(666, 'A3', 'A3-76', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(667, 'A3', 'A3-81', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(668, 'A3', 'A3-82', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(669, 'A3', 'A3-83', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(670, 'A3', 'A3-84', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(671, 'A3', 'A3-85', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(672, 'A3', 'A3-86', '4', '2024-08-30 04:09:00', '2024-08-30 04:09:00', NULL),
(673, 'B1', 'B1-11', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(674, 'B1', 'B1-12', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(675, 'B1', 'B1-13', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(676, 'B1', 'B1-14', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(677, 'B1', 'B1-15', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(678, 'B1', 'B1-16', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(679, 'B1', 'B1-21', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(680, 'B1', 'B1-22', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(681, 'B1', 'B1-23', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(682, 'B1', 'B1-24', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(683, 'B1', 'B1-25', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(684, 'B1', 'B1-26', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(685, 'B1', 'B1-31', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(686, 'B1', 'B1-32', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(687, 'B1', 'B1-33', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(688, 'B1', 'B1-34', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(689, 'B1', 'B1-35', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(690, 'B1', 'B1-36', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(691, 'B1', 'B1-41', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(692, 'B1', 'B1-42', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(693, 'B1', 'B1-43', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(694, 'B1', 'B1-44', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(695, 'B1', 'B1-45', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(696, 'B1', 'B1-46', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(697, 'B1', 'B1-51', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(698, 'B1', 'B1-52', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(699, 'B1', 'B1-53', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(700, 'B1', 'B1-54', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(701, 'B1', 'B1-55', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(702, 'B1', 'B1-56', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(703, 'B1', 'B1-61', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(704, 'B1', 'B1-62', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(705, 'B1', 'B1-63', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(706, 'B1', 'B1-64', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(707, 'B1', 'B1-65', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(708, 'B1', 'B1-66', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(709, 'B1', 'B1-71', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(710, 'B1', 'B1-72', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(711, 'B1', 'B1-73', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(712, 'B1', 'B1-74', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(713, 'B1', 'B1-75', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(714, 'B1', 'B1-76', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(715, 'B1', 'B1-81', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(716, 'B1', 'B1-82', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(717, 'B1', 'B1-83', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(718, 'B1', 'B1-84', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(719, 'B1', 'B1-85', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(720, 'B1', 'B1-86', '1', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(721, 'B1', 'B1-11', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(722, 'B1', 'B1-12', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(723, 'B1', 'B1-13', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(724, 'B1', 'B1-14', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(725, 'B1', 'B1-15', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(726, 'B1', 'B1-16', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(727, 'B1', 'B1-21', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(728, 'B1', 'B1-22', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(729, 'B1', 'B1-23', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(730, 'B1', 'B1-24', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(731, 'B1', 'B1-25', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(732, 'B1', 'B1-26', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(733, 'B1', 'B1-31', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(734, 'B1', 'B1-32', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(735, 'B1', 'B1-33', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(736, 'B1', 'B1-34', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(737, 'B1', 'B1-35', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(738, 'B1', 'B1-36', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(739, 'B1', 'B1-41', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(740, 'B1', 'B1-42', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(741, 'B1', 'B1-43', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(742, 'B1', 'B1-44', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(743, 'B1', 'B1-45', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(744, 'B1', 'B1-46', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(745, 'B1', 'B1-51', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(746, 'B1', 'B1-52', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(747, 'B1', 'B1-53', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(748, 'B1', 'B1-54', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(749, 'B1', 'B1-55', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(750, 'B1', 'B1-56', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(751, 'B1', 'B1-61', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(752, 'B1', 'B1-62', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(753, 'B1', 'B1-63', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(754, 'B1', 'B1-64', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(755, 'B1', 'B1-65', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(756, 'B1', 'B1-66', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(757, 'B1', 'B1-71', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(758, 'B1', 'B1-72', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(759, 'B1', 'B1-73', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(760, 'B1', 'B1-74', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(761, 'B1', 'B1-75', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(762, 'B1', 'B1-76', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(763, 'B1', 'B1-81', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(764, 'B1', 'B1-82', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(765, 'B1', 'B1-83', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(766, 'B1', 'B1-84', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(767, 'B1', 'B1-85', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(768, 'B1', 'B1-86', '2', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(769, 'B1', 'B1-11', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(770, 'B1', 'B1-12', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(771, 'B1', 'B1-13', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(772, 'B1', 'B1-14', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(773, 'B1', 'B1-15', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(774, 'B1', 'B1-16', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(775, 'B1', 'B1-21', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(776, 'B1', 'B1-22', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(777, 'B1', 'B1-23', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(778, 'B1', 'B1-24', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(779, 'B1', 'B1-25', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(780, 'B1', 'B1-26', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(781, 'B1', 'B1-31', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(782, 'B1', 'B1-32', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(783, 'B1', 'B1-33', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(784, 'B1', 'B1-34', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(785, 'B1', 'B1-35', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(786, 'B1', 'B1-36', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(787, 'B1', 'B1-41', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(788, 'B1', 'B1-42', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(789, 'B1', 'B1-43', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(790, 'B1', 'B1-44', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(791, 'B1', 'B1-45', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(792, 'B1', 'B1-46', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(793, 'B1', 'B1-51', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(794, 'B1', 'B1-52', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(795, 'B1', 'B1-53', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(796, 'B1', 'B1-54', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(797, 'B1', 'B1-55', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(798, 'B1', 'B1-56', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(799, 'B1', 'B1-61', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(800, 'B1', 'B1-62', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(801, 'B1', 'B1-63', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(802, 'B1', 'B1-64', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(803, 'B1', 'B1-65', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(804, 'B1', 'B1-66', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(805, 'B1', 'B1-71', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(806, 'B1', 'B1-72', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(807, 'B1', 'B1-73', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(808, 'B1', 'B1-74', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(809, 'B1', 'B1-75', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(810, 'B1', 'B1-76', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(811, 'B1', 'B1-81', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(812, 'B1', 'B1-82', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(813, 'B1', 'B1-83', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(814, 'B1', 'B1-84', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(815, 'B1', 'B1-85', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(816, 'B1', 'B1-86', '3', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(817, 'B1', 'B1-11', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(818, 'B1', 'B1-12', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(819, 'B1', 'B1-13', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(820, 'B1', 'B1-14', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(821, 'B1', 'B1-15', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(822, 'B1', 'B1-16', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(823, 'B1', 'B1-21', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(824, 'B1', 'B1-22', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(825, 'B1', 'B1-23', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(826, 'B1', 'B1-24', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(827, 'B1', 'B1-25', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(828, 'B1', 'B1-26', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(829, 'B1', 'B1-31', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(830, 'B1', 'B1-32', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(831, 'B1', 'B1-33', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(832, 'B1', 'B1-34', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(833, 'B1', 'B1-35', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(834, 'B1', 'B1-36', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(835, 'B1', 'B1-41', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(836, 'B1', 'B1-42', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(837, 'B1', 'B1-43', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(838, 'B1', 'B1-44', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(839, 'B1', 'B1-45', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(840, 'B1', 'B1-46', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(841, 'B1', 'B1-51', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(842, 'B1', 'B1-52', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(843, 'B1', 'B1-53', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(844, 'B1', 'B1-54', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(845, 'B1', 'B1-55', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(846, 'B1', 'B1-56', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(847, 'B1', 'B1-61', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(848, 'B1', 'B1-62', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(849, 'B1', 'B1-63', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(850, 'B1', 'B1-64', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(851, 'B1', 'B1-65', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(852, 'B1', 'B1-66', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(853, 'B1', 'B1-71', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(854, 'B1', 'B1-72', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(855, 'B1', 'B1-73', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(856, 'B1', 'B1-74', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(857, 'B1', 'B1-75', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(858, 'B1', 'B1-76', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(859, 'B1', 'B1-81', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(860, 'B1', 'B1-82', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(861, 'B1', 'B1-83', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(862, 'B1', 'B1-84', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(863, 'B1', 'B1-85', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(864, 'B1', 'B1-86', '4', '2024-08-30 04:09:11', '2024-08-30 04:09:11', NULL),
(865, 'B2', 'B2-11', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(866, 'B2', 'B2-12', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(867, 'B2', 'B2-13', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(868, 'B2', 'B2-14', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(869, 'B2', 'B2-15', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(870, 'B2', 'B2-16', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(871, 'B2', 'B2-21', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(872, 'B2', 'B2-22', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(873, 'B2', 'B2-23', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(874, 'B2', 'B2-24', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(875, 'B2', 'B2-25', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(876, 'B2', 'B2-26', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(877, 'B2', 'B2-31', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(878, 'B2', 'B2-32', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(879, 'B2', 'B2-33', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(880, 'B2', 'B2-34', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(881, 'B2', 'B2-35', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(882, 'B2', 'B2-36', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(883, 'B2', 'B2-41', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(884, 'B2', 'B2-42', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(885, 'B2', 'B2-43', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(886, 'B2', 'B2-44', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(887, 'B2', 'B2-45', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(888, 'B2', 'B2-46', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(889, 'B2', 'B2-51', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(890, 'B2', 'B2-52', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(891, 'B2', 'B2-53', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(892, 'B2', 'B2-54', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(893, 'B2', 'B2-55', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(894, 'B2', 'B2-56', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(895, 'B2', 'B2-61', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(896, 'B2', 'B2-62', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(897, 'B2', 'B2-63', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(898, 'B2', 'B2-64', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(899, 'B2', 'B2-65', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(900, 'B2', 'B2-66', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(901, 'B2', 'B2-71', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(902, 'B2', 'B2-72', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(903, 'B2', 'B2-73', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(904, 'B2', 'B2-74', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(905, 'B2', 'B2-75', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(906, 'B2', 'B2-76', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(907, 'B2', 'B2-81', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(908, 'B2', 'B2-82', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(909, 'B2', 'B2-83', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(910, 'B2', 'B2-84', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(911, 'B2', 'B2-85', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(912, 'B2', 'B2-86', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(913, 'B2', 'B2-91', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(914, 'B2', 'B2-92', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(915, 'B2', 'B2-93', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(916, 'B2', 'B2-94', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(917, 'B2', 'B2-95', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(918, 'B2', 'B2-96', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(919, 'B2', 'B2-101', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(920, 'B2', 'B2-102', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(921, 'B2', 'B2-103', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(922, 'B2', 'B2-104', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(923, 'B2', 'B2-105', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(924, 'B2', 'B2-106', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(925, 'B2', 'B2-111', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(926, 'B2', 'B2-112', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(927, 'B2', 'B2-113', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(928, 'B2', 'B2-114', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(929, 'B2', 'B2-115', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(930, 'B2', 'B2-116', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(931, 'B2', 'B2-121', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(932, 'B2', 'B2-122', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(933, 'B2', 'B2-123', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(934, 'B2', 'B2-124', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(935, 'B2', 'B2-125', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(936, 'B2', 'B2-126', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(937, 'B2', 'B2-131', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(938, 'B2', 'B2-132', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(939, 'B2', 'B2-133', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(940, 'B2', 'B2-134', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(941, 'B2', 'B2-135', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(942, 'B2', 'B2-136', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(943, 'B2', 'B2-141', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(944, 'B2', 'B2-142', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(945, 'B2', 'B2-143', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(946, 'B2', 'B2-144', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(947, 'B2', 'B2-145', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(948, 'B2', 'B2-146', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(949, 'B2', 'B2-151', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(950, 'B2', 'B2-152', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(951, 'B2', 'B2-153', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(952, 'B2', 'B2-154', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(953, 'B2', 'B2-155', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(954, 'B2', 'B2-156', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(955, 'B2', 'B2-161', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(956, 'B2', 'B2-162', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(957, 'B2', 'B2-163', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(958, 'B2', 'B2-164', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(959, 'B2', 'B2-165', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(960, 'B2', 'B2-166', '1', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(961, 'B2', 'B2-11', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(962, 'B2', 'B2-12', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(963, 'B2', 'B2-13', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(964, 'B2', 'B2-14', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(965, 'B2', 'B2-15', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(966, 'B2', 'B2-16', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(967, 'B2', 'B2-21', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(968, 'B2', 'B2-22', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(969, 'B2', 'B2-23', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(970, 'B2', 'B2-24', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(971, 'B2', 'B2-25', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(972, 'B2', 'B2-26', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(973, 'B2', 'B2-31', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(974, 'B2', 'B2-32', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(975, 'B2', 'B2-33', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(976, 'B2', 'B2-34', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(977, 'B2', 'B2-35', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(978, 'B2', 'B2-36', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(979, 'B2', 'B2-41', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(980, 'B2', 'B2-42', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(981, 'B2', 'B2-43', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(982, 'B2', 'B2-44', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(983, 'B2', 'B2-45', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(984, 'B2', 'B2-46', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(985, 'B2', 'B2-51', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(986, 'B2', 'B2-52', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(987, 'B2', 'B2-53', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(988, 'B2', 'B2-54', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(989, 'B2', 'B2-55', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(990, 'B2', 'B2-56', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(991, 'B2', 'B2-61', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(992, 'B2', 'B2-62', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(993, 'B2', 'B2-63', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(994, 'B2', 'B2-64', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(995, 'B2', 'B2-65', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(996, 'B2', 'B2-66', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(997, 'B2', 'B2-71', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(998, 'B2', 'B2-72', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(999, 'B2', 'B2-73', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1000, 'B2', 'B2-74', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1001, 'B2', 'B2-75', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1002, 'B2', 'B2-76', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1003, 'B2', 'B2-81', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1004, 'B2', 'B2-82', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1005, 'B2', 'B2-83', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1006, 'B2', 'B2-84', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1007, 'B2', 'B2-85', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1008, 'B2', 'B2-86', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1009, 'B2', 'B2-91', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1010, 'B2', 'B2-92', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1011, 'B2', 'B2-93', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1012, 'B2', 'B2-94', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1013, 'B2', 'B2-95', '2', '2024-08-30 04:09:18', '2024-08-30 04:09:18', NULL),
(1014, 'B2', 'B2-96', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1015, 'B2', 'B2-101', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1016, 'B2', 'B2-102', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1017, 'B2', 'B2-103', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1018, 'B2', 'B2-104', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1019, 'B2', 'B2-105', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1020, 'B2', 'B2-106', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1021, 'B2', 'B2-111', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1022, 'B2', 'B2-112', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1023, 'B2', 'B2-113', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1024, 'B2', 'B2-114', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1025, 'B2', 'B2-115', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1026, 'B2', 'B2-116', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1027, 'B2', 'B2-121', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1028, 'B2', 'B2-122', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1029, 'B2', 'B2-123', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1030, 'B2', 'B2-124', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1031, 'B2', 'B2-125', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1032, 'B2', 'B2-126', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1033, 'B2', 'B2-131', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1034, 'B2', 'B2-132', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1035, 'B2', 'B2-133', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1036, 'B2', 'B2-134', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1037, 'B2', 'B2-135', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1038, 'B2', 'B2-136', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1039, 'B2', 'B2-141', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1040, 'B2', 'B2-142', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1041, 'B2', 'B2-143', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1042, 'B2', 'B2-144', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1043, 'B2', 'B2-145', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1044, 'B2', 'B2-146', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1045, 'B2', 'B2-151', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1046, 'B2', 'B2-152', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1047, 'B2', 'B2-153', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1048, 'B2', 'B2-154', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1049, 'B2', 'B2-155', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1050, 'B2', 'B2-156', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1051, 'B2', 'B2-161', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1052, 'B2', 'B2-162', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1053, 'B2', 'B2-163', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1054, 'B2', 'B2-164', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1055, 'B2', 'B2-165', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1056, 'B2', 'B2-166', '2', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1057, 'B2', 'B2-11', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1058, 'B2', 'B2-12', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1059, 'B2', 'B2-13', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1060, 'B2', 'B2-14', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1061, 'B2', 'B2-15', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1062, 'B2', 'B2-16', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1063, 'B2', 'B2-21', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1064, 'B2', 'B2-22', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1065, 'B2', 'B2-23', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1066, 'B2', 'B2-24', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1067, 'B2', 'B2-25', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1068, 'B2', 'B2-26', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1069, 'B2', 'B2-31', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1070, 'B2', 'B2-32', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1071, 'B2', 'B2-33', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1072, 'B2', 'B2-34', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1073, 'B2', 'B2-35', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1074, 'B2', 'B2-36', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1075, 'B2', 'B2-41', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1076, 'B2', 'B2-42', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1077, 'B2', 'B2-43', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1078, 'B2', 'B2-44', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1079, 'B2', 'B2-45', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1080, 'B2', 'B2-46', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1081, 'B2', 'B2-51', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1082, 'B2', 'B2-52', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1083, 'B2', 'B2-53', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1084, 'B2', 'B2-54', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1085, 'B2', 'B2-55', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1086, 'B2', 'B2-56', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1087, 'B2', 'B2-61', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1088, 'B2', 'B2-62', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1089, 'B2', 'B2-63', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1090, 'B2', 'B2-64', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1091, 'B2', 'B2-65', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1092, 'B2', 'B2-66', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1093, 'B2', 'B2-71', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1094, 'B2', 'B2-72', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1095, 'B2', 'B2-73', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1096, 'B2', 'B2-74', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1097, 'B2', 'B2-75', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1098, 'B2', 'B2-76', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1099, 'B2', 'B2-81', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1100, 'B2', 'B2-82', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1101, 'B2', 'B2-83', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1102, 'B2', 'B2-84', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1103, 'B2', 'B2-85', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1104, 'B2', 'B2-86', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1105, 'B2', 'B2-91', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1106, 'B2', 'B2-92', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1107, 'B2', 'B2-93', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1108, 'B2', 'B2-94', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1109, 'B2', 'B2-95', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1110, 'B2', 'B2-96', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1111, 'B2', 'B2-101', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1112, 'B2', 'B2-102', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1113, 'B2', 'B2-103', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1114, 'B2', 'B2-104', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1115, 'B2', 'B2-105', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1116, 'B2', 'B2-106', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1117, 'B2', 'B2-111', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1118, 'B2', 'B2-112', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1119, 'B2', 'B2-113', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1120, 'B2', 'B2-114', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1121, 'B2', 'B2-115', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1122, 'B2', 'B2-116', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1123, 'B2', 'B2-121', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1124, 'B2', 'B2-122', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1125, 'B2', 'B2-123', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1126, 'B2', 'B2-124', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1127, 'B2', 'B2-125', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1128, 'B2', 'B2-126', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1129, 'B2', 'B2-131', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1130, 'B2', 'B2-132', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1131, 'B2', 'B2-133', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1132, 'B2', 'B2-134', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1133, 'B2', 'B2-135', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1134, 'B2', 'B2-136', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1135, 'B2', 'B2-141', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1136, 'B2', 'B2-142', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1137, 'B2', 'B2-143', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1138, 'B2', 'B2-144', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1139, 'B2', 'B2-145', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1140, 'B2', 'B2-146', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1141, 'B2', 'B2-151', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1142, 'B2', 'B2-152', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1143, 'B2', 'B2-153', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1144, 'B2', 'B2-154', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1145, 'B2', 'B2-155', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1146, 'B2', 'B2-156', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1147, 'B2', 'B2-161', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1148, 'B2', 'B2-162', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1149, 'B2', 'B2-163', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1150, 'B2', 'B2-164', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1151, 'B2', 'B2-165', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1152, 'B2', 'B2-166', '3', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1153, 'B2', 'B2-11', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1154, 'B2', 'B2-12', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1155, 'B2', 'B2-13', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1156, 'B2', 'B2-14', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1157, 'B2', 'B2-15', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1158, 'B2', 'B2-16', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1159, 'B2', 'B2-21', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1160, 'B2', 'B2-22', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1161, 'B2', 'B2-23', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1162, 'B2', 'B2-24', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1163, 'B2', 'B2-25', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1164, 'B2', 'B2-26', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1165, 'B2', 'B2-31', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1166, 'B2', 'B2-32', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1167, 'B2', 'B2-33', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1168, 'B2', 'B2-34', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1169, 'B2', 'B2-35', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1170, 'B2', 'B2-36', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1171, 'B2', 'B2-41', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1172, 'B2', 'B2-42', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1173, 'B2', 'B2-43', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1174, 'B2', 'B2-44', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1175, 'B2', 'B2-45', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1176, 'B2', 'B2-46', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1177, 'B2', 'B2-51', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1178, 'B2', 'B2-52', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1179, 'B2', 'B2-53', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1180, 'B2', 'B2-54', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1181, 'B2', 'B2-55', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1182, 'B2', 'B2-56', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1183, 'B2', 'B2-61', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1184, 'B2', 'B2-62', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1185, 'B2', 'B2-63', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1186, 'B2', 'B2-64', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1187, 'B2', 'B2-65', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1188, 'B2', 'B2-66', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1189, 'B2', 'B2-71', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1190, 'B2', 'B2-72', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1191, 'B2', 'B2-73', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1192, 'B2', 'B2-74', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1193, 'B2', 'B2-75', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1194, 'B2', 'B2-76', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1195, 'B2', 'B2-81', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1196, 'B2', 'B2-82', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1197, 'B2', 'B2-83', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1198, 'B2', 'B2-84', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1199, 'B2', 'B2-85', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1200, 'B2', 'B2-86', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1201, 'B2', 'B2-91', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1202, 'B2', 'B2-92', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1203, 'B2', 'B2-93', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1204, 'B2', 'B2-94', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1205, 'B2', 'B2-95', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1206, 'B2', 'B2-96', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1207, 'B2', 'B2-101', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1208, 'B2', 'B2-102', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1209, 'B2', 'B2-103', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1210, 'B2', 'B2-104', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1211, 'B2', 'B2-105', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1212, 'B2', 'B2-106', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1213, 'B2', 'B2-111', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1214, 'B2', 'B2-112', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1215, 'B2', 'B2-113', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1216, 'B2', 'B2-114', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1217, 'B2', 'B2-115', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1218, 'B2', 'B2-116', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1219, 'B2', 'B2-121', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1220, 'B2', 'B2-122', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1221, 'B2', 'B2-123', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1222, 'B2', 'B2-124', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1223, 'B2', 'B2-125', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1224, 'B2', 'B2-126', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1225, 'B2', 'B2-131', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1226, 'B2', 'B2-132', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1227, 'B2', 'B2-133', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1228, 'B2', 'B2-134', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1229, 'B2', 'B2-135', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1230, 'B2', 'B2-136', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1231, 'B2', 'B2-141', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1232, 'B2', 'B2-142', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1233, 'B2', 'B2-143', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1234, 'B2', 'B2-144', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1235, 'B2', 'B2-145', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1236, 'B2', 'B2-146', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1237, 'B2', 'B2-151', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1238, 'B2', 'B2-152', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1239, 'B2', 'B2-153', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1240, 'B2', 'B2-154', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1241, 'B2', 'B2-155', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1242, 'B2', 'B2-156', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1243, 'B2', 'B2-161', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1244, 'B2', 'B2-162', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1245, 'B2', 'B2-163', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1246, 'B2', 'B2-164', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1247, 'B2', 'B2-165', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1248, 'B2', 'B2-166', '4', '2024-08-30 04:09:19', '2024-08-30 04:09:19', NULL),
(1249, 'B3', 'B3-11', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1250, 'B3', 'B3-12', '1', '2024-08-30 04:09:26', '2024-09-04 03:45:55', NULL),
(1251, 'B3', 'B3-13', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1252, 'B3', 'B3-14', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1253, 'B3', 'B3-15', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1254, 'B3', 'B3-16', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1255, 'B3', 'B3-21', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1256, 'B3', 'B3-22', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1257, 'B3', 'B3-23', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1258, 'B3', 'B3-24', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1259, 'B3', 'B3-25', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1260, 'B3', 'B3-26', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1261, 'B3', 'B3-31', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1262, 'B3', 'B3-32', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1263, 'B3', 'B3-33', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1264, 'B3', 'B3-34', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1265, 'B3', 'B3-35', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1266, 'B3', 'B3-36', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1267, 'B3', 'B3-41', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1268, 'B3', 'B3-42', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1269, 'B3', 'B3-43', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1270, 'B3', 'B3-44', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1271, 'B3', 'B3-45', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1272, 'B3', 'B3-46', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1273, 'B3', 'B3-51', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1274, 'B3', 'B3-52', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1275, 'B3', 'B3-53', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1276, 'B3', 'B3-54', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1277, 'B3', 'B3-55', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1278, 'B3', 'B3-56', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1279, 'B3', 'B3-61', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1280, 'B3', 'B3-62', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1281, 'B3', 'B3-63', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1282, 'B3', 'B3-64', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1283, 'B3', 'B3-65', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1284, 'B3', 'B3-66', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1285, 'B3', 'B3-71', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1286, 'B3', 'B3-72', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1287, 'B3', 'B3-73', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1288, 'B3', 'B3-74', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1289, 'B3', 'B3-75', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1290, 'B3', 'B3-76', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL);
INSERT INTO `warehouses` (`id`, `name`, `code`, `stack`, `created_at`, `updated_at`, `batch_id`) VALUES
(1291, 'B3', 'B3-81', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1292, 'B3', 'B3-82', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1293, 'B3', 'B3-83', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1294, 'B3', 'B3-84', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1295, 'B3', 'B3-85', '1', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1296, 'B3', 'B3-86', '1', '2024-08-30 04:09:26', '2024-08-30 04:47:49', NULL),
(1297, 'B3', 'B3-11', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1298, 'B3', 'B3-12', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1299, 'B3', 'B3-13', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1300, 'B3', 'B3-14', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1301, 'B3', 'B3-15', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1302, 'B3', 'B3-16', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1303, 'B3', 'B3-21', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1304, 'B3', 'B3-22', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1305, 'B3', 'B3-23', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1306, 'B3', 'B3-24', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1307, 'B3', 'B3-25', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1308, 'B3', 'B3-26', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1309, 'B3', 'B3-31', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1310, 'B3', 'B3-32', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1311, 'B3', 'B3-33', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1312, 'B3', 'B3-34', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1313, 'B3', 'B3-35', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1314, 'B3', 'B3-36', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1315, 'B3', 'B3-41', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1316, 'B3', 'B3-42', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1317, 'B3', 'B3-43', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1318, 'B3', 'B3-44', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1319, 'B3', 'B3-45', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1320, 'B3', 'B3-46', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1321, 'B3', 'B3-51', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1322, 'B3', 'B3-52', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1323, 'B3', 'B3-53', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1324, 'B3', 'B3-54', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1325, 'B3', 'B3-55', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1326, 'B3', 'B3-56', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1327, 'B3', 'B3-61', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1328, 'B3', 'B3-62', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1329, 'B3', 'B3-63', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1330, 'B3', 'B3-64', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1331, 'B3', 'B3-65', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1332, 'B3', 'B3-66', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1333, 'B3', 'B3-71', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1334, 'B3', 'B3-72', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1335, 'B3', 'B3-73', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1336, 'B3', 'B3-74', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1337, 'B3', 'B3-75', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1338, 'B3', 'B3-76', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1339, 'B3', 'B3-81', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1340, 'B3', 'B3-82', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1341, 'B3', 'B3-83', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1342, 'B3', 'B3-84', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1343, 'B3', 'B3-85', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1344, 'B3', 'B3-86', '2', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1345, 'B3', 'B3-11', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1346, 'B3', 'B3-12', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1347, 'B3', 'B3-13', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1348, 'B3', 'B3-14', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1349, 'B3', 'B3-15', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1350, 'B3', 'B3-16', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1351, 'B3', 'B3-21', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1352, 'B3', 'B3-22', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1353, 'B3', 'B3-23', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1354, 'B3', 'B3-24', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1355, 'B3', 'B3-25', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1356, 'B3', 'B3-26', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1357, 'B3', 'B3-31', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1358, 'B3', 'B3-32', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1359, 'B3', 'B3-33', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1360, 'B3', 'B3-34', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1361, 'B3', 'B3-35', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1362, 'B3', 'B3-36', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1363, 'B3', 'B3-41', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1364, 'B3', 'B3-42', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1365, 'B3', 'B3-43', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1366, 'B3', 'B3-44', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1367, 'B3', 'B3-45', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1368, 'B3', 'B3-46', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1369, 'B3', 'B3-51', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1370, 'B3', 'B3-52', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1371, 'B3', 'B3-53', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1372, 'B3', 'B3-54', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1373, 'B3', 'B3-55', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1374, 'B3', 'B3-56', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1375, 'B3', 'B3-61', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1376, 'B3', 'B3-62', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1377, 'B3', 'B3-63', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1378, 'B3', 'B3-64', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1379, 'B3', 'B3-65', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1380, 'B3', 'B3-66', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1381, 'B3', 'B3-71', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1382, 'B3', 'B3-72', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1383, 'B3', 'B3-73', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1384, 'B3', 'B3-74', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1385, 'B3', 'B3-75', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1386, 'B3', 'B3-76', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1387, 'B3', 'B3-81', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1388, 'B3', 'B3-82', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1389, 'B3', 'B3-83', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1390, 'B3', 'B3-84', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1391, 'B3', 'B3-85', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1392, 'B3', 'B3-86', '3', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1393, 'B3', 'B3-11', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1394, 'B3', 'B3-12', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1395, 'B3', 'B3-13', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1396, 'B3', 'B3-14', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1397, 'B3', 'B3-15', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1398, 'B3', 'B3-16', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1399, 'B3', 'B3-21', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1400, 'B3', 'B3-22', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1401, 'B3', 'B3-23', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1402, 'B3', 'B3-24', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1403, 'B3', 'B3-25', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1404, 'B3', 'B3-26', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1405, 'B3', 'B3-31', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1406, 'B3', 'B3-32', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1407, 'B3', 'B3-33', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1408, 'B3', 'B3-34', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1409, 'B3', 'B3-35', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1410, 'B3', 'B3-36', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1411, 'B3', 'B3-41', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1412, 'B3', 'B3-42', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1413, 'B3', 'B3-43', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1414, 'B3', 'B3-44', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1415, 'B3', 'B3-45', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1416, 'B3', 'B3-46', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1417, 'B3', 'B3-51', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1418, 'B3', 'B3-52', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1419, 'B3', 'B3-53', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1420, 'B3', 'B3-54', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1421, 'B3', 'B3-55', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1422, 'B3', 'B3-56', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1423, 'B3', 'B3-61', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1424, 'B3', 'B3-62', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1425, 'B3', 'B3-63', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1426, 'B3', 'B3-64', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1427, 'B3', 'B3-65', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1428, 'B3', 'B3-66', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1429, 'B3', 'B3-71', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1430, 'B3', 'B3-72', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1431, 'B3', 'B3-73', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1432, 'B3', 'B3-74', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1433, 'B3', 'B3-75', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1434, 'B3', 'B3-76', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1435, 'B3', 'B3-81', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1436, 'B3', 'B3-82', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1437, 'B3', 'B3-83', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1438, 'B3', 'B3-84', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1439, 'B3', 'B3-85', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL),
(1440, 'B3', 'B3-86', '4', '2024-08-30 04:09:26', '2024-08-30 04:09:26', NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT cho bảng `contract_type`
--
ALTER TABLE `contract_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `curing_areas`
--
ALTER TABLE `curing_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `curing_houses`
--
ALTER TABLE `curing_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `rubber`
--
ALTER TABLE `rubber`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT cho bảng `rubber_warehouses`
--
ALTER TABLE `rubber_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1441;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bales`
--
ALTER TABLE `bales`
  ADD CONSTRAINT `bales_drum_id_foreign` FOREIGN KEY (`drum_id`) REFERENCES `drums` (`id`) ON DELETE CASCADE;

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
