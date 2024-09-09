-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 06, 2024 lúc 05:20 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tx_chusekptrubber_vn_custom`
--

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
(19, 'HIEP THANH RUBBER INDUSTRIES CORPORATION', 'ctyhiepthanhxnk@gmail.com', '0274 221 2821', 'KH Ngắn hạn', 'Land slot No. 409, Map sheet 41, Bau Bang Hamlet, Lai Uyen Town,  Bau Bang District, Binh Duong Province, Vietnam', '2024-04-04', '2024-04-04');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
