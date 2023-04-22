-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 22, 2023 lúc 03:07 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `manager`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_schedule` (IN `p_SHOWROOMID` INT, IN `p_movieID` INT, IN `p_startTime` DATETIME, IN `p_endTime` DATETIME, IN `p_price` DOUBLE)   BEGIN	
Select SHOWROOM.SEATCOUNT Into @seatCount from SHOWROOM where ID =  p_SHOWROOMID;
	INSERT INTO `SCHEDULE`
           (`SHOWROOM_ID`
           ,`MOV_ID`
           ,`STARTTIME`
           ,`ENDTIME`)
     VALUES
           (p_SHOWROOMID
           ,p_movieID
           ,p_startTime
           ,p_endTime);

    SELECT MIN(SEAT.ID) INTO @counter from SEAT JOIN SHOWROOM ON SHOWROOM.ID = SEAT.THE_ID 
    WHERE SHOWROOM.ID = p_SHOWROOMID
    LIMIT 1;


	SET @schedule_id = LAST_INSERT_ID();

   SET @seatCount = @seatCount+@counter;

	WHILE @counter < @seatCount - 10
	DO
		-- SQLINES LICENSE FOR EVALUATION USE ONLY
		INSERT INTO `TICKET`
           (`BOO_ID`
           ,`PRICE`)
		VALUES
           (null
           ,p_price);
		SET @ticket_id  = LAST_INSERT_ID();

		-- SQLINES LICENSE FOR EVALUATION USE ONLY
		INSERT INTO `TICKET_SEAT_SCHEDULE`
				(`SEAT_ID`
				,`SCHEDULE_ID`
				,`TICKET_ID`
				,`BOOKED`)
		VALUES
				 (@counter
				 , @schedule_id
				 ,@ticket_id
				 ,0);
		SET @counter = @counter + 1;
	END WHILE;
    
    -- ticket for douple seat
    WHILE @counter < @seatCount
	DO
		-- SQLINES LICENSE FOR EVALUATION USE ONLY
		INSERT INTO `TICKET`
           (`BOO_ID`
           ,`PRICE`)
		VALUES
           (null
           ,p_price+30000);
		SET @ticket_id  = LAST_INSERT_ID();

		-- SQLINES LICENSE FOR EVALUATION USE ONLY
		INSERT INTO `TICKET_SEAT_SCHEDULE`
				(`SEAT_ID`
				,`SCHEDULE_ID`
				,`TICKET_ID`
				,`BOOKED`)
		VALUES
				 (@counter
				 , @schedule_id
				 ,@ticket_id
				 ,0);
		SET @counter = @counter + 1;
	END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_showroom` (IN `SHOWROOM_num` INT, IN `CINEMA_ID` INT)   BEGIN
  -- Tạo rạp chiếu phim mới
  INSERT INTO `SHOWROOM` (`SHOWROOMNUM`, `SEATCOUNT`, `CINEMA_ID`)
  VALUES (SHOWROOM_num, 90, CINEMA_ID);

  -- Lấy ID của rạp chiếu phim mới
  SET @SHOWROOM_id = LAST_INSERT_ID();

  -- Tạo các ghế Standard trong rạp chiếu phim    
	SET @letters = 'ABCDEFGH';
	SET @number = 1;
    WHILE @number <= 10 DO
        SET @letter_index = 1;
        WHILE @letter_index <= LENGTH(@letters) DO
            SET @letter = SUBSTRING(@letters, @letter_index, 1);
            INSERT INTO `seat` (`THE_ID`, `SEATNUMBER`, `SEATTYPE`)
            VALUES (@SHOWROOM_id, CONCAT(@letter, @number), 'Standard');
            SET @letter_index = @letter_index + 1;
        END WHILE;
        SET @number = @number + 1;
    END WHILE;

  -- Tạo các ghế Couple trong rạp chiếu phim
    SET @letters = 'IJ';
	SET @number = 1;
    WHILE @number <= 5 DO
        SET @letter_index = 1;
        WHILE @letter_index <= LENGTH(@letters) DO
            SET @letter = SUBSTRING(@letters, @letter_index, 1);
            INSERT INTO `seat` (`THE_ID`, `SEATNUMBER`, `SEATTYPE`)
            VALUES (@SHOWROOM_id, CONCAT(@letter, @number), 'Couple');
            SET @letter_index = @letter_index + 1;
        END WHILE;
        SET @number = @number + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_booked_seats` (IN `schedule_id` INT)   SELECT seat.ID, seat.SEATNUMBER
FROM seat, schedule, ticket_seat_schedule
WHERE
seat.ID = ticket_seat_schedule.SEAT_ID
AND schedule.ID = ticket_seat_schedule.SCHEDULE_ID
AND ticket_seat_schedule.BOOKED = 1
AND schedule.ID = schedule_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_foodcombo` ()   SELECT
    `foodcombo`.`ID` AS `ID`,
    `foodcombo`.`NAME` AS `NAME`,
    MAX(
        CASE WHEN `product`.`TYPE` = 'Đồ ăn' THEN `product`.`NAME` ELSE NULL
    END
) AS `TenDoAn`,
GROUP_CONCAT(
    CASE WHEN `product`.`TYPE` = 'Đồ ăn' THEN `product_fcb`.`QUANTITY` ELSE NULL
END SEPARATOR ','
) AS `QuantityDoAn`,
MAX(
    CASE WHEN `product`.`TYPE` = 'Đồ uống' THEN `product`.`NAME` ELSE NULL
END
) AS `TenDoUong`,
GROUP_CONCAT(
    CASE WHEN `product`.`TYPE` = 'Đồ uống' THEN `product_fcb`.`QUANTITY` ELSE NULL
END SEPARATOR ','
) AS `QuantityDoUong`,
`foodcombo`.`PRICE` AS `PRICE`,
foodcombo.Image
FROM
    (
        (
            `foodcombo`
        JOIN `product_fcb` ON
            (
                `foodcombo`.`ID` = `product_fcb`.`FCB_ID`
            )
        )
    JOIN `product` ON
        (
            `product`.`ID` = `product_fcb`.`PRODUCT_ID`
        )
    )
GROUP BY
    `foodcombo`.`NAME`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_movie_schedule` (IN `PMOV_ID` INT)   SELECT schedule.ID, date(schedule.STARTTIME) as DAY, time(schedule.STARTTIME) as TIME,showroom.ID AS showroom_ID, showroom.SHOWROOMNUM, cinema.ID as cinema_ID, cinema.NAME, cinema.ADDRESS
FROM schedule , showroom, cinema
where 
MOV_ID = PMOV_ID
AND cinema.ID = showroom.CINEMA_ID
AND SHOWROOM.ID = schedule.SHOWROOM_ID
AND NOW() < schedule.STARTTIME 
order by STARTTIME$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_revenue_of_month` (IN `month_value` DATE)   SELECT
    DATE(booking.CREATED_AT) AS order_date,
    SUM(booking.FOOD_PRICE+booking.TICKET_PRICE) AS total_price
FROM
    booking
WHERE
    MONTH(booking.CREATED_AT) = MONTH(month_value)  AND YEAR(booking.CREATED_AT) = YEAR(month_value)
GROUP BY
    date(booking.CREATED_AT)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_by_id` (IN `schedule_id` INT(1))   SELECT
    movie.TITLE,
    movie.POSTER,
    movie.TRAILER,
    SCHEDULE.STARTTIME,
    SHOWROOM.SHOWROOMNUM,
    ticket.price,
    cinema.NAME,
    cinema.ADDRESS
FROM
    movie,
    SCHEDULE,
    SHOWROOM,
    ticket,
    ticket_seat_schedule,
    cinema
WHERE
    movie.ID = SCHEDULE.MOV_ID 
    AND SCHEDULE.SHOWROOM_ID = SHOWROOM.ID 
    AND ticket.ID = ticket_seat_schedule.TICKET_ID 
    AND SCHEDULE.ID = ticket_seat_schedule.SCHEDULE_ID 
    AND cinema.ID = showroom.CINEMA_ID
    AND SCHEDULE.ID = schedule_id
GROUP BY SCHEDULE.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_by_showroom` (IN `SHOWROOM_id` INT)   SELECT movie.TITLE, movie.DURATION,schedule.* ,  SHOWROOM.SEATCOUNT, COUNT(ticket_seat_schedule.TICKET_ID) AS EMPTYSEAT
FROM schedule, SHOWROOM, ticket_seat_schedule, movie
WHERE schedule.SHOWROOM_ID = SHOWROOM.ID
AND schedule.ID = ticket_seat_schedule.SCHEDULE_ID
AND movie.ID = schedule.MOV_ID
AND ticket_seat_schedule.BOOKED  = 0
AND SHOWROOM.ID = SHOWROOM_id
GROUP BY schedule.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_today` ()   SELECT schedule.ID,movie.ID as MID, movie.TITLE, movie.POSTER, movie.STORY, GROUP_CONCAT(DISTINCT  TIME(schedule.STARTTIME)) AS TIME, DATE(schedule.STARTTIME) as DAY FROM schedule JOIN movie ON movie.ID = schedule.MOV_ID WHERE now()< schedule.STARTTIME AND DATE(now()) = DATE(schedule.STARTTIME) GROUP BY MID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_trailers` ()   SELECT id, trailer FROM movie WHERE LENGTH(trailer) > 1 LIMIT 10$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transactions` ()   SELECT 
	booking.ID,
    cinema.NAME AS CINEMA,
	CLIENT
    .USERNAME,
    CLIENT.FIRSTNAME,
    CLIENT.LASTNAME,
    CLIENT.PHONE,
    CLIENT.ADDRESS,
    movie.TITLE,
    SCHEDULE.STARTTIME,
    booking.CREATED_AT,
    GROUP_CONCAT(seat.SEATNUMBER) AS Seats,
    booking.TICKET_PRICE,
    booking.FOOD_PRICE,
    booking.FOOD_PRICE+booking.TICKET_PRICE AS Total
FROM
    `booking`,
    CLIENT,
    ticket_seat_schedule,
    schedule,
    seat,
    movie,
    ticket,
    cinema,
    showroom
    
WHERE 
CLIENT.ID = booking.CLIENT_ID 
AND SCHEDULE.ID = ticket_seat_schedule.SCHEDULE_ID 
AND seat.ID = ticket_seat_schedule.SEAT_ID 
AND movie.ID = SCHEDULE.MOV_ID 
AND ticket.BOO_ID = booking.ID
AND ticket.ID = ticket_seat_schedule.TICKET_ID
AND schedule.SHOWROOM_ID = showroom.ID
AND cinema.ID = showroom.CINEMA_ID
GROUP BY booking.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transactions_by_user` (IN `client_id` INT)   SELECT 
	booking.ID,
    CLIENT
    .USERNAME,
    CLIENT.FIRSTNAME,
    CLIENT.LASTNAME,
    CLIENT.PHONE,
    CLIENT.ADDRESS,
    movie.TITLE,
    SCHEDULE.STARTTIME,
    booking.CREATED_AT,
    GROUP_CONCAT(seat.SEATNUMBER) AS Seats,
    booking.TICKET_PRICE,
    booking.FOOD_PRICE,
    booking.FOOD_PRICE+booking.TICKET_PRICE AS Total
FROM
    `booking`,
    CLIENT,
    ticket_seat_schedule,
    schedule,
    seat,
    movie,
    ticket
    
WHERE 
CLIENT.ID = booking.CLIENT_ID 
AND SCHEDULE.ID = ticket_seat_schedule.SCHEDULE_ID 
AND seat.ID = ticket_seat_schedule.SEAT_ID 
AND movie.ID = SCHEDULE.MOV_ID 
AND ticket.BOO_ID = booking.ID
AND ticket.ID = ticket_seat_schedule.TICKET_ID
AND client.ID = client_id
GROUP BY booking.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transaction_by_id` (IN `booking_id` INT)   SELECT 
	booking.ID,
    cinema.NAME AS CINEMA,
    cinema.ADDRESS,
    showroom.SHOWROOMNUM,
    movie.TITLE,
    SCHEDULE.STARTTIME,
    booking.CREATED_AT,
    GROUP_CONCAT(seat.SEATNUMBER) AS Seats,
    booking.TICKET_PRICE,
    booking.FOOD_PRICE,
    booking.FOOD_PRICE+booking.TICKET_PRICE AS Total
FROM
    `booking`,
    CLIENT,
    ticket_seat_schedule,
    schedule,
    seat,
    movie,
    ticket,
    cinema,
    showroom
    
WHERE 
CLIENT.ID = booking.CLIENT_ID 
AND SCHEDULE.ID = ticket_seat_schedule.SCHEDULE_ID 
AND seat.ID = ticket_seat_schedule.SEAT_ID 
AND movie.ID = SCHEDULE.MOV_ID 
AND ticket.BOO_ID = booking.ID
AND ticket.ID = ticket_seat_schedule.TICKET_ID
AND schedule.SHOWROOM_ID = showroom.ID
AND cinema.ID = showroom.CINEMA_ID
AND booking.ID = booking_id
GROUP BY booking.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `isValidSchedule` (IN `stime` DATETIME, IN `SHOWROOM_num` INT)   SELECT * FROM `schedule` 
WHERE stime BETWEEN STARTTIME AND ENDTIME 
AND schedule.SHOWROOM_ID = SHOWROOM_num$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ongoing_movies` ()   SELECT * FROM movie
WHERE CURDATE() BETWEEN OPENING_DAY AND CLOSING_DAY
ORDER by OPENING_DAY ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upcoming_movies` ()   SELECT * FROM movie WHERE opening_day > CURDATE() ORDER BY opening_day ASC LIMIT 10$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `FOOD_PRICE` float NOT NULL DEFAULT 0,
  `TICKET_PRICE` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cinema`
--

CREATE TABLE `cinema` (
  `ID` int(11) NOT NULL,
  `NAME` text NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `ADDRESS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `client`
--

CREATE TABLE `client` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(20) DEFAULT NULL,
  `SEX` varchar(5) DEFAULT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `PHONE` char(15) DEFAULT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `ROLE` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `foodcombo`
--

CREATE TABLE `foodcombo` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `PRICE` float DEFAULT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `food_booking`
--

CREATE TABLE `food_booking` (
  `FOOD_ID` int(11) NOT NULL,
  `BOOKING_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `food_booking`
--
DELIMITER $$
CREATE TRIGGER `delete_food_booking` AFTER DELETE ON `food_booking` FOR EACH ROW UPDATE booking
SET booking.FOOD_PRICE = (SELECT SUM(foodcombo.PRICE*food_booking.QUANTITY) 
FROM foodcombo, food_booking
WHERE food_booking.FOOD_ID = foodcombo.ID
AND food_booking.BOOKING_ID =Old.BOOKING_ID)
WHERE booking.ID = Old.BOOKING_ID
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_food_booking` AFTER INSERT ON `food_booking` FOR EACH ROW BEGIN
UPDATE booking
SET booking.FOOD_PRICE = (SELECT SUM(foodcombo.PRICE*food_booking.QUANTITY) 
FROM foodcombo, food_booking
WHERE food_booking.FOOD_ID = foodcombo.ID
AND food_booking.BOOKING_ID =New.BOOKING_ID)
WHERE booking.ID = New.BOOKING_ID;

UPDATE product p INNER JOIN product_fcb pf ON p.ID = pf.PRODUCT_ID INNER JOIN food_booking fb ON pf.FCB_ID = fb.FOOD_ID SET p.QUANTITY = p.QUANTITY - (fb.QUANTITY * pf.QUANTITY) WHERE fb.BOOKING_ID = New.BOOKING_ID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_food_booking` AFTER UPDATE ON `food_booking` FOR EACH ROW UPDATE booking
SET booking.FOOD_PRICE = (SELECT SUM(foodcombo.PRICE*food_booking.QUANTITY) 
FROM foodcombo, food_booking
WHERE food_booking.FOOD_ID = foodcombo.ID
AND food_booking.BOOKING_ID =New.BOOKING_ID)
WHERE booking.ID = New.BOOKING_ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie`
--

CREATE TABLE `movie` (
  `ID` int(11) NOT NULL,
  `TITLE` text DEFAULT NULL,
  `DIRECTOR` text NOT NULL,
  `ACTORS` text NOT NULL,
  `GENRE` text DEFAULT NULL,
  `DURATION` int(11) DEFAULT NULL,
  `RATING` float DEFAULT NULL,
  `STORY` text DEFAULT NULL,
  `POSTER` text DEFAULT NULL,
  `TRAILER` longtext DEFAULT 'https://www.youtube.com/embed/S2kymv60ndQ',
  `OPENING_DAY` date DEFAULT NULL,
  `CLOSING_DAY` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `TYPE` varchar(20) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_fcb`
--

CREATE TABLE `product_fcb` (
  `PRODUCT_ID` int(11) NOT NULL,
  `FCB_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `MOV_ID` int(11) NOT NULL,
  `STARTTIME` datetime DEFAULT NULL,
  `ENDTIME` datetime DEFAULT NULL,
  `SHOWROOM_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seat`
--

CREATE TABLE `seat` (
  `ID` int(11) NOT NULL,
  `THE_ID` int(11) NOT NULL,
  `SEATNUMBER` varchar(3) DEFAULT NULL,
  `SEATTYPE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `showroom`
--

CREATE TABLE `showroom` (
  `ID` int(11) NOT NULL,
  `SHOWROOMNUM` int(11) UNSIGNED DEFAULT NULL,
  `SEATCOUNT` int(11) DEFAULT NULL,
  `CINEMA_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(20) DEFAULT NULL,
  `SEX` varchar(5) DEFAULT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `PHONE` char(15) DEFAULT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `SALARY` float DEFAULT NULL,
  `ROLE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `ID` int(11) NOT NULL,
  `BOO_ID` int(11) DEFAULT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `ticket`
--
DELIMITER $$
CREATE TRIGGER `update_ticket` AFTER UPDATE ON `ticket` FOR EACH ROW UPDATE booking
SET booking.TICKET_PRICE = (SELECT SUM(ticket.price) 
FROM ticket
WHERE ticket.BOO_ID =New.BOO_ID)
WHERE booking.ID = New.BOO_ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_seat_schedule`
--

CREATE TABLE `ticket_seat_schedule` (
  `SEAT_ID` int(11) NOT NULL,
  `SCHEDULE_ID` int(11) NOT NULL,
  `TICKET_ID` int(11) NOT NULL,
  `BOOKED` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_BOOKING_CLIENT` (`CLIENT_ID`);

--
-- Chỉ mục cho bảng `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `foodcombo`
--
ALTER TABLE `foodcombo`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `food_booking`
--
ALTER TABLE `food_booking`
  ADD PRIMARY KEY (`FOOD_ID`,`BOOKING_ID`),
  ADD KEY `FK_BOOKING_FOOD` (`BOOKING_ID`);

--
-- Chỉ mục cho bảng `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `product_fcb`
--
ALTER TABLE `product_fcb`
  ADD KEY `FK_FCB_PRODUCT` (`FCB_ID`),
  ADD KEY `FK_PRODUCT_FCB` (`PRODUCT_ID`);

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_SCHEDULE_MOVIE` (`MOV_ID`),
  ADD KEY `FK_SCHEDULE_SHOWROOM` (`SHOWROOM_ID`);

--
-- Chỉ mục cho bảng `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_SEAT_SHOWROOM` (`THE_ID`);

--
-- Chỉ mục cho bảng `showroom`
--
ALTER TABLE `showroom`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_CINEMA_SHOWROOM` (`CINEMA_ID`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_TICKET_BOOKING` (`BOO_ID`);

--
-- Chỉ mục cho bảng `ticket_seat_schedule`
--
ALTER TABLE `ticket_seat_schedule`
  ADD PRIMARY KEY (`SEAT_ID`,`SCHEDULE_ID`,`TICKET_ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cinema`
--
ALTER TABLE `cinema`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `foodcombo`
--
ALTER TABLE `foodcombo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `seat`
--
ALTER TABLE `seat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `showroom`
--
ALTER TABLE `showroom`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_BOOKING_CLIENT` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`);

--
-- Các ràng buộc cho bảng `food_booking`
--
ALTER TABLE `food_booking`
  ADD CONSTRAINT `FK_BOOKING_FOOD` FOREIGN KEY (`BOOKING_ID`) REFERENCES `booking` (`ID`),
  ADD CONSTRAINT `FK_FOOD_BOOKING` FOREIGN KEY (`FOOD_ID`) REFERENCES `foodcombo` (`ID`);

--
-- Các ràng buộc cho bảng `product_fcb`
--
ALTER TABLE `product_fcb`
  ADD CONSTRAINT `FK_FCB_PRODUCT` FOREIGN KEY (`FCB_ID`) REFERENCES `foodcombo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRODUCT_FCB` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `FK_SCHEDULE_MOVIE` FOREIGN KEY (`MOV_ID`) REFERENCES `movie` (`ID`),
  ADD CONSTRAINT `FK_SCHEDULE_SHOWROOM` FOREIGN KEY (`SHOWROOM_ID`) REFERENCES `showroom` (`ID`);

--
-- Các ràng buộc cho bảng `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `FK_SEAT_SHOWROOM` FOREIGN KEY (`THE_ID`) REFERENCES `showroom` (`ID`);

--
-- Các ràng buộc cho bảng `showroom`
--
ALTER TABLE `showroom`
  ADD CONSTRAINT `FK_CINEMA_SHOWROOM` FOREIGN KEY (`CINEMA_ID`) REFERENCES `cinema` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_TICKET_BOOKING` FOREIGN KEY (`BOO_ID`) REFERENCES `booking` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
