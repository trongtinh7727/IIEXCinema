-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: mysql-server
-- Thời gian đã tạo: Th3 02, 2023 lúc 04:48 PM
-- Phiên bản máy phục vụ: 8.0.27
-- Phiên bản PHP: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `UserTable`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `CHOOSE`
--

CREATE TABLE `CHOOSE` (
  `CLIENTID` char(10) NOT NULL,
  `COMBOID` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `INCOME`
--

CREATE TABLE `INCOME` (
  `INCOMEID` char(10) NOT NULL,
  `TOTAL` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `MANAGE`
--

CREATE TABLE `MANAGE` (
  `ADMINID` char(10) NOT NULL,
  `CLIENTID` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `MOVIE`
--

CREATE TABLE `MOVIE` (
  `MOVIEID` char(10) NOT NULL,
  `NAME` char(255) DEFAULT NULL,
  `INFO` char(255) DEFAULT NULL,
  `DATE` date DEFAULT NULL,
  `START` time DEFAULT NULL,
  `END` time DEFAULT NULL,
  `CATEGORY` char(20) DEFAULT NULL,
  `RATING` int DEFAULT NULL,
  `IMAGE` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `MOVIE`
--

INSERT INTO `MOVIE` (`MOVIEID`, `NAME`, `INFO`, `DATE`, `START`, `END`, `CATEGORY`, `RATING`, `IMAGE`) VALUES
('MV_01', 'Nhà bà Gấm', 'Nơi rửa tiền hợp pháp', '2023-03-02', '12:41:22', '14:41:22', 'Family', 5, 0x68747470733a2f2f696d67732e7365617263682e62726176652e636f6d2f6a69566251417644726161555755664c696a644e70466a4775715a6a5064562d53455a33304f52504232302f72733a6669743a3734383a3232353a312f673a63652f6148523063484d364c793930633255302f4c6d31744c6d4a70626d6375626d56302f4c33526f50326c6b5055394a554335582f4f47467756457442556c5278566d68742f5448704e51326c7a546d3142534746462f63795a776157513951584270);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `POSITION`
--

CREATE TABLE `POSITION` (
  `POSITIONID` char(10) NOT NULL,
  `ROOMID` char(10) NOT NULL,
  `ROOM` char(10) DEFAULT NULL,
  `STATUS` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `SHOWN`
--

CREATE TABLE `SHOWN` (
  `MOVIEID` char(10) NOT NULL,
  `ROOMID` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `CHOOSE`
--
ALTER TABLE `CHOOSE`
  ADD PRIMARY KEY (`CLIENTID`,`COMBOID`),
  ADD KEY `CHOOSE_FK` (`CLIENTID`),
  ADD KEY `CHOOSE2_FK` (`COMBOID`);

--
-- Chỉ mục cho bảng `INCOME`
--
ALTER TABLE `INCOME`
  ADD PRIMARY KEY (`INCOMEID`);

--
-- Chỉ mục cho bảng `MANAGE`
--
ALTER TABLE `MANAGE`
  ADD PRIMARY KEY (`ADMINID`,`CLIENTID`),
  ADD KEY `MANAGE_FK` (`ADMINID`),
  ADD KEY `MANAGE2_FK` (`CLIENTID`);

--
-- Chỉ mục cho bảng `MOVIE`
--
ALTER TABLE `MOVIE`
  ADD PRIMARY KEY (`MOVIEID`);

--
-- Chỉ mục cho bảng `POSITION`
--
ALTER TABLE `POSITION`
  ADD PRIMARY KEY (`POSITIONID`),
  ADD KEY `IN_FK` (`ROOMID`);

--
-- Chỉ mục cho bảng `SHOWN`
--
ALTER TABLE `SHOWN`
  ADD PRIMARY KEY (`MOVIEID`,`ROOMID`),
  ADD KEY `SHOWN_FK` (`MOVIEID`),
  ADD KEY `SHOWN2_FK` (`ROOMID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
