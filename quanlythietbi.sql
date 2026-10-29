-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 27, 2026 lúc 09:19 AM
-- Phiên bản máy phục vụ: 8.0.44
-- Phiên bản PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlythietbi`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `ma_dm` int NOT NULL AUTO_INCREMENT,
  `ten_dm` varchar(255) NOT NULL,
  PRIMARY KEY (`ma_dm`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`ma_dm`, `ten_dm`) VALUES
(1, 'Laptop'),
(2, 'Máy tính để bàn'),
(3, 'Màn hình'),
(4, 'Bàn phím');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tentaikhoan` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `hoten` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tentaikhoan` (`tentaikhoan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `tentaikhoan`, `matkhau`, `hoten`) VALUES
(1, 'admin', '123456', 'Quản Trị Viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

DROP TABLE IF EXISTS `nhacungcap`;
CREATE TABLE IF NOT EXISTS `nhacungcap` (
  `ma_ncc` int NOT NULL AUTO_INCREMENT,
  `ten_ncc` varchar(255) NOT NULL,
  `dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text,
  PRIMARY KEY (`ma_ncc`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`ma_ncc`, `ten_ncc`, `dien_thoai`, `dia_chi`) VALUES
(1, 'Dell Việt Nam', '0123456789', 'Hà Nội'),
(2, 'HP Việt Nam', '0987654321', 'TP.HCM'),
(3, 'LG Việt Nam', '0912345678', 'Đà Nẵng'),
(4, 'Logitech', '0933333333', 'Hà Nội');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `ma_sp` int NOT NULL AUTO_INCREMENT,
  `ten_sp` varchar(255) NOT NULL,
  `ma_dm` int NOT NULL,
  `ma_ncc` int NOT NULL,
  `gia` decimal(12,2) NOT NULL,
  `so_luong` int NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_sp`),
  KEY `ma_dm` (`ma_dm`),
  KEY `ma_ncc` (`ma_ncc`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`ma_dm`) REFERENCES `danhmuc` (`ma_dm`) ON DELETE CASCADE,
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`ma_ncc`) REFERENCES `nhacungcap` (`ma_ncc`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
