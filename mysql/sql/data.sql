-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2023 at 06:38 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ID` int NOT NULL,
  `STAFF_ID` int DEFAULT NULL,
  `CLIENT_ID` int DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`ID`, `STAFF_ID`, `CLIENT_ID`, `CREATED_AT`) VALUES
(1, 1, 1, '2023-04-04 15:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

CREATE TABLE `cinema` (
  `ID` int NOT NULL,
  `NAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ADDRESS` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PHONE` char(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`ID`, `NAME`, `ADDRESS`, `PHONE`) VALUES
(1, 'Lotte Cinema Q7', 'Q7, Thành phố Hồ Chí minh', '0843206397');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ID` int NOT NULL,
  `USERNAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PASSWORD` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PHONE` char(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ADDRESS` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ID`, `USERNAME`, `PASSWORD`, `NAME`, `PHONE`, `ADDRESS`) VALUES
(1, 'user', '123456', 'Lê Hoàng', '0843201578', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `foodcombo`
--

CREATE TABLE `foodcombo` (
  `ID` int NOT NULL,
  `NAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PRICE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foodcombo`
--

INSERT INTO `foodcombo` (`ID`, `NAME`, `PRICE`) VALUES
(1, '1 Bắp + 2 nước', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `food_booking`
--

CREATE TABLE `food_booking` (
  `FOOD_ID` int NOT NULL,
  `BOOKING_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_booking`
--

INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `ID` int NOT NULL,
  `TITLE` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `GENRE` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DURATION` int DEFAULT NULL,
  `RATING` float DEFAULT NULL,
  `STORY` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `POSTER` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OPENING_DAY` date DEFAULT NULL,
  `CLOSING_DAY` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`ID`, `TITLE`, `GENRE`, `DURATION`, `RATING`, `STORY`, `POSTER`, `OPENING_DAY`, `CLOSING_DAY`) VALUES
(1, 'Con mèo ngu ngốc', 'Drama', 90, 5, 'Một câu chuyện về những chú mèo', 'https://phimtuoitho.tv/uploads/video_thumb/1747.jp', NULL, NULL),
(2, 'Con mèo ngu ngốc', 'Drama', 90, 5, 'Câu chuyện về chó và mèo', 'https://phimtuoitho.tv/uploads/video_thumb/1747.jp', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `TYPE` varchar(20) DEFAULT NULL,
  `PRICE` float DEFAULT NULL,
  `QUANTITY` int DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_fcb`
--

CREATE TABLE `product_fcb` (
  `PRODUCT_ID` int NOT NULL,
  `FCB_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int NOT NULL,
  `CIN_ID` int NOT NULL,
  `MOV_ID` int NOT NULL,
  `STARTTIME` datetime DEFAULT NULL,
  `ENDTIME` datetime DEFAULT NULL,
  `THEA_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `CIN_ID`, `MOV_ID`, `STARTTIME`, `ENDTIME`, `THEA_ID`) VALUES
(1, 1, 2, '2023-03-12 19:00:00', '2023-03-12 21:30:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `ID` int NOT NULL,
  `THE_ID` int NOT NULL,
  `SEATNUMBER` int DEFAULT NULL,
  `SEATTYPE` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`ID`, `THE_ID`, `SEATNUMBER`, `SEATTYPE`) VALUES
(1, 1, 1, 'singer'),
(2, 1, 2, 'singer'),
(3, 1, 3, 'singer'),
(4, 1, 4, 'singer'),
(5, 1, 5, 'singer'),
(6, 1, 6, 'singer'),
(7, 1, 7, 'singer'),
(8, 1, 8, 'singer'),
(9, 1, 9, 'singer'),
(10, 1, 10, 'singer');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `ID` int NOT NULL,
  `USERNAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PASSWORD` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `FIRSTNAME` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LASTNAME` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SEX` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `PHONE` char(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ADDRESS` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SALARY` float DEFAULT NULL,
  `ROLE` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `SALARY`, `ROLE`) VALUES
(1, 'admin', 'admin', 'Lê Hoàng', 'Phú', 'nam', '2003-02-02', '0123456789', 'Quận 7', 50000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `ID` int NOT NULL,
  `CIN_ID` int NOT NULL,
  `THEATERNUM` int DEFAULT NULL,
  `SEATCOUNT` int DEFAULT NULL,
  `ISSHOWING` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`ID`, `CIN_ID`, `THEATERNUM`, `SEATCOUNT`, `ISSHOWING`) VALUES
(1, 1, 1, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ID` int NOT NULL,
  `BOO_ID` int NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ID`, `BOO_ID`, `price`) VALUES
(2, 1, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_seat_schedule`
--

CREATE TABLE `ticket_seat_schedule` (
  `SEAT_ID` int NOT NULL,
  `SCHEDULE_ID` int NOT NULL,
  `TICKET_ID` int NOT NULL,
  `ISSHOWING` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ticket_seat_schedule`
--

INSERT INTO `ticket_seat_schedule` (`SEAT_ID`, `SCHEDULE_ID`, `TICKET_ID`, `ISSHOWING`) VALUES
(1, 1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_BOOKING_CLIENT` (`CLIENT_ID`),
  ADD KEY `FK_BOOKING_STAFF` (`STAFF_ID`);

--
-- Indexes for table `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `foodcombo`
--
ALTER TABLE `foodcombo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `food_booking`
--
ALTER TABLE `food_booking`
  ADD PRIMARY KEY (`FOOD_ID`,`BOOKING_ID`),
  ADD KEY `FK_FCB_BOOKING` (`BOOKING_ID`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product_fcb`
--
ALTER TABLE `product_fcb`
  ADD PRIMARY KEY (`PRODUCT_ID`,`FCB_ID`),
  ADD KEY `FK_FCB_PRODUCT` (`FCB_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_SCHEDULE_MOVIE` (`MOV_ID`),
  ADD KEY `FK_SCHEDULE_THEATER` (`THEA_ID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_SEAT_THEATER` (`THE_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_TICKET_BOOKING` (`BOO_ID`);

--
-- Indexes for table `ticket_seat_schedule`
--
ALTER TABLE `ticket_seat_schedule`
  ADD PRIMARY KEY (`SEAT_ID`,`SCHEDULE_ID`,`TICKET_ID`),
  ADD KEY `Seat_Schedule` (`SCHEDULE_ID`),
  ADD KEY `FK_SEAT_SCHEDULE_TICKET` (`TICKET_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cinema`
--
ALTER TABLE `cinema`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foodcombo`
--
ALTER TABLE `foodcombo`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_BOOKING_CLIENT` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BOOKING_STAFF` FOREIGN KEY (`STAFF_ID`) REFERENCES `staff` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_booking`
--
ALTER TABLE `food_booking`
  ADD CONSTRAINT `FK_Booking_FCB` FOREIGN KEY (`FOOD_ID`) REFERENCES `foodcombo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FCB_BOOKING` FOREIGN KEY (`BOOKING_ID`) REFERENCES `booking` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_fcb`
--
ALTER TABLE `product_fcb`
  ADD CONSTRAINT `FK_FCB_PRODUCT` FOREIGN KEY (`FCB_ID`) REFERENCES `foodcombo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRODUCT_FCB` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `FK_SCHEDULE_MOVIE` FOREIGN KEY (`MOV_ID`) REFERENCES `movie` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SCHEDULE_THEATER` FOREIGN KEY (`THEA_ID`) REFERENCES `theater` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `FK_SEAT_THEATER` FOREIGN KEY (`THE_ID`) REFERENCES `theater` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_TICKET_BOOKING` FOREIGN KEY (`BOO_ID`) REFERENCES `booking` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_seat_schedule`
--
ALTER TABLE `ticket_seat_schedule`
  ADD CONSTRAINT `FK_SCHEDULE_SEAT` FOREIGN KEY (`SEAT_ID`) REFERENCES `seat` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SEAT_SCHEDULE_TICKET` FOREIGN KEY (`TICKET_ID`) REFERENCES `ticket` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Seat_Schedule` FOREIGN KEY (`SCHEDULE_ID`) REFERENCES `schedule` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
