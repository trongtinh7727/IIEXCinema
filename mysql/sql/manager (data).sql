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

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`ID`, `CLIENT_ID`, `CREATED_AT`, `FOOD_PRICE`, `TICKET_PRICE`) VALUES
(1, 1, '2023-04-19 17:20:13', 0, 300000),
(2, 1, '2023-04-19 17:21:39', 260000, 270000),
(3, 1, '2023-04-19 18:27:03', 130000, 180000),
(4, 1, '2023-04-19 18:37:30', 130000, 90000),
(5, 1, '2023-04-20 01:24:23', 100000, 90000),
(6, 1, '2023-04-21 01:15:33', 300000, 390000),
(7, 1, '2023-04-21 06:22:55', 330000, 90000),
(8, 1, '2023-04-22 05:55:14', 330000, 210000),
(9, 1, '2023-04-22 06:48:28', 130000, 420000),
(10, 1, '2023-04-22 07:29:49', 260000, 90900),
(11, 1, '2023-04-22 07:31:09', 260000, 90900);

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

--
-- Đang đổ dữ liệu cho bảng `cinema`
--

INSERT INTO `cinema` (`ID`, `NAME`, `PHONE`, `ADDRESS`) VALUES
(1, 'Lotte Q7', '0843206397', 'Quận 7, TP Hồ Chí Minh'),
(2, 'Lotte Quận 8', '084123456', 'Quận 8, TP Hồ Chí Minh'),
(3, 'Movie City', '0843206399', 'Quận 10, TP Hồ Chí Minh');

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

--
-- Đang đổ dữ liệu cho bảng `client`
--

INSERT INTO `client` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `ROLE`) VALUES
(1, 'user', '123456', 'Võ', 'Trọng Tình', 'Nam', '2004-04-09', '0843206399', 'Q7, Thành phố Hồ Chí minh', 2),
(3, 'mod', 'Demo@123', 'Lê Hoàng', 'Phúc', 'nam', '2003-08-20', '084113554', 'Quẩn 7, TP Hồ Chí Minh', 2),
(4, 'pucpeo115', '12345678', 'Lê', 'Phúc', NULL, NULL, '0843206345', NULL, 2);

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

--
-- Đang đổ dữ liệu cho bảng `foodcombo`
--

INSERT INTO `foodcombo` (`ID`, `NAME`, `PRICE`, `Image`) VALUES
(1, 'Không', 0, ''),
(2, '1 Bắp + 2 nước', 100000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg'),
(3, '2 Bắp + 2 nước', 130000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg'),
(4, '2 bắp + 1 nước', 100000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg');

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
-- Đang đổ dữ liệu cho bảng `food_booking`
--

INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`, `QUANTITY`) VALUES
(1, 1, 0),
(2, 6, 1),
(2, 7, 1),
(2, 8, 1),
(3, 2, 2),
(3, 3, 1),
(3, 4, 1),
(3, 7, 1),
(3, 8, 1),
(3, 9, 1),
(3, 10, 2),
(3, 11, 2),
(4, 5, 1),
(4, 6, 2),
(4, 7, 1),
(4, 8, 1);

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

--
-- Đang đổ dữ liệu cho bảng `movie`
--

INSERT INTO `movie` (`ID`, `TITLE`, `DIRECTOR`, `ACTORS`, `GENRE`, `DURATION`, `RATING`, `STORY`, `POSTER`, `TRAILER`, `OPENING_DAY`, `CLOSING_DAY`) VALUES
(38, 'MARRY MY DEAD ', 'Wei Hao Cheng', 'Greg Han Hsu, Gingle Wang', 'Drama', 130, 5, 'Ming-Han, một sĩ quan cảnh sát nhiệt huyết, trong quá trình truy bắt tội phạm đã tìm thấy một phong bì cưới màu đỏ và chủ nhân của nó là hồn ma Mao-Mao với nguyện vọng phải được kết hôn với một sĩ quan cảnh sát trước khi tái sinh...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002654?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-07', '2023-06-20'),
(39, 'ASSASSIN CLUB', 'Camille Delamarre', 'Henry Golding, Noomi Repace', 'Action', 109, 5, 'Bảy tên sát thủ vô tình bị thiết lập trong một trò chơi sống còn. Morgan Gaines- một sát thủ chuyên nghiệp có nhiệm vụ phải giết bảy người,Morgan phát hiện ra bảy \"mục tiêu\" cũng là bảy sát thủ nặng ký. Lối thoát duy nhất cho Morgan là tìm ra kẻ chủ mưu..', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002661?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/usYcScx3yMk', '2023-04-07', '2023-06-20'),
(40, 'THE SUPER MARIO BROS. MOVIE', 'Aaron Horvath', 'Chris Pratt, Anya Taylor-Joy', 'Animation', 93, 5, 'Theo chân anh chàng thợ sửa ống nước tên Mario cùng công chúa Peach của Vương quốc Nấm trong cuộc phiêu lưu giải cứu anh trai Luigi đang bị bắt cóc và ngăn chặn tên độc tài Bowser, kẻ đang âm mưu thôn tính thế giới', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002631?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/wODah30-agA', '2023-04-07', '2023-06-20'),
(41, 'YOU & ME & ME ', 'Waew Waewwan Hongvivatana', 'Baipor Thitiya Jirapornsilp, Tony Anthony Buisseret', 'Drama', 121, 5, 'Hai chị em sinh đôi \"You\" và \"Me\"có ngoại hình và sở thích giống hệt nhau,thân thiết đến mức họ có thể chia sẻ mọi khía cạnh trong cuộc sống,cho đến khi một cậu bé - \"mối tình đầu\" của họ xuất hiện và đặt ra những thử thách khó khăn cho mối quan hệ của họ', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002669?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-07', '2023-06-20'),
(42, 'PULAU ', 'Eu  Ho', 'Amelia Henderson, Alif Satar', 'Horror', 112, 5, 'Kỳ nghỉ của nhóm bạn trẻ biến thành cơn ác mộng kinh hoàng sau khi họ thua một cuộc cá cược,họ buộc phải qua đêm tại một đảo hoang, khi tình cờ đến một ngôi làng bị bỏ hoang bí ẩn ở đó, họ đã phá vỡ câu thần chú cũ được đặt để kiềm chế một linh hồn tàn ác', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002673?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-31', '2023-06-20'),
(43, 'BIỆT ĐỘI RẤT ỔN', 'Tạ Nguyên Hiệp', 'Võ Tấn Phát, Hoàng  Oanh', 'Comedy', 104, 5, 'Xoay quanh bộ đôi Khuê và Phong. Sau lần chạm trán tình cờ, bộ đôi lôi kéo gia đình Bảy Cục tham gia vào phi vụ đặc biệt: Đánh tráo chiếc vòng đính hôn bằng kim cương quí giá và lật tẩy bộ mặt thật của Tuấn-chồng cũ của Khuê...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002633?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/6qZbBiL65cI', '2023-03-31', '2023-06-20'),
(44, 'THE ONE', 'Dmitriy Suvorov', 'Nadezhda Kaleganova, Viktor Dobronravov', 'Drama', 96, 5, 'Cặp vợ chồng mới cưới Larisa và Vladimir trở về nhà từ tuần trăng mật ở Blagoveshchensk và bị va chạm máy bay, Larisa phải vật lộn với cái đói cái lạnh và động vật hoang dã săn mồi. Liệu Larisa có tìm được vị hôn phu và cùng sống sót trở về ?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002580?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-31', '2023-06-20'),
(45, 'SOULMATE', 'Young-Keun Min', 'Kim Da-Mi, Woo-Seok Byeon', 'Drama', 124, 5, 'Mi So và Ha Eun trong một mối quan hệ chồng chéo chất chứa những hạnh phúc, rung động và biệt ly. Từ giây phút gặp nhau , hai cô gái đã hình thành sợi dây liên kết đặc biệt nhưng mối quan hệ của họ rạn nứt khi một chàng trai xuất hiện...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002611?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/pGAFcV97dpw', '2023-03-24', '2023-06-20'),
(46, 'NHỮNG ĐỨA TRẺ TRONG SƯƠNG', 'Hà Lệ Diễm', 'Má Thị Di', 'Documentary', 93, 5, 'Di, một cô gái trẻ nhiệt huyết đến từ cộng đồng người Mông bị mắc kẹt giữa truyền thống \"kéo vợ\" và mong muốn được tiếp tục sống thời thơ ấu và đến trường đi học , liệu với trái tim trong sáng ấy , Di sẽ đối diện với xã hội ấy như thế nào...?\r\n', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002676?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-17', '2023-06-20'),
(47, 'SIÊU LỪA GẶP SIÊU LẦY', 'Võ Thanh Hòa', 'Mạc Văn Khoa, Anh Tú', 'Comedy', 112, 5, 'Khoa, một tên lừa đảo tới Phú Quốc với mục tiêu đổi đời. Không ngờ đây là sân nhà của Tú, một tên lừa đảo chuyên nghiệp, cả hai bắt tay cùng thực hiện một phi vụ siêu lớn và mục tiêu là các quý bà giàu có và đam mê sự nổi tiếng', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002593?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/xy8RznX_uyM', '2023-03-03', '2023-06-20'),
(48, 'AIR', 'Ben  Affleck', 'Viola Davis', 'Drama', 112, 5, 'Bí mật trong mối quan hệ hợp tác lịch sử giữa Nike và một vận động viên bóng rổ vĩ đại.Cả hai đã cho ra mắt thương hiệu Air Jordan đình đám và theo chân Sonny Vaccaro- saleman của Nike trong hành trình tiếp cận và đánh cược cả sự nghiệp vào Michael Jordan', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002670?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(49, 'CHUYỆN XÓM TUI : CON NHÓT MÓT CHỒNG', 'Vũ  Ngọc Đãng', 'Thái Hòa, Thu  Trang', '', 100, 5, 'Là câu chuyện của Nhót - Người phụ nữ \"chưa kịp già\" đã sắp bị mãn kinh, vội vàng đi tìm chồng. Nhưng sâu thẳm trong cô là khao khát muốn có một đứa con và luôn muốn hàn gắn với người cha suốt ngày say xỉn của mình', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002650?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/qehxOMR-rFQ', '2023-04-28', '2023-06-20'),
(50, 'DUNGEONS & DRAGONS: HONOR AMONG THIEVES ', 'John Francis Daley', 'Chris Pine, Michelle Rodriguez', 'Adventure', 134, 5, 'Theo chân một tên trộm quyến rũ và một nhóm những kẻ bịp bợm nghiệp dư thực hiện vụ trộm sử thi nhằm lấy lại một di vật đã mất, nhưng mọi thứ trở nên nguy hiểm khó lường hơn bao giờ hết khi họ đã chạm trám nhầm người...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002629?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/iTZJ-uwIZxg', '2023-04-21', '2023-06-20'),
(51, 'ELEMENTAL', 'Peter Sohn', 'Leah Lewis, Mamoudou Athie', 'Animation', 93, 5, 'Ember, một cô nàng cá tính, thông minh, mạnh mẽ và đầy sức hút. Tuy nhiên mối quan hệ của cô với Wade- một anh chàng hài hước, luôn thuận thế đẩy dòng - khiến Ember cảm thấy ngờ vực với thế giới này...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002677?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/K19bf6ButD4', '2023-06-16', '2023-06-20'),
(53, 'GUARDIANS OF THE GALAXY 3', 'James  Gunn', 'Chris  Pratt, Zoe Saldana', 'Adventure', 119, 5, 'Cho dù vũ trụ này có bao la đến đâu, các Vệ Binh của chúng ta cũng không thể trốn chạy mãi mãi...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002647?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=Pp6reH8bpZ8', '2023-05-03', '2023-06-20'),
(54, 'LẬT MẶT 6', 'Lý  Hải', 'Duy Khánh, Quốc Cường', 'Action', 132, 5, 'Nhóm bạn thân lâu năm bất ngờ nhận được cơ hội đổi đời khi biết tấm vé của cả nhóm trúng giải độc đắc 136.8 tỷ. Đột nhiên An,người giữ tấm vé bất ngờ qua đời, liệu trong hành trình tìm kiếm và chia chác món tiền trong mơ béo bở này sẽ đưa cả nhóm đến đâu?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002653?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=tpjjd7usfnA', '2023-04-28', '2023-06-20'),
(55, 'MY BEAUTIFUL MAN MOVIE: SPECIAL EDITION', '', 'Riku Hagiwara, Yusei Yagi', 'Drama', 98, 5, 'Hira, 17 tuổi, cố gắng ẩn mình ở trường, không bao giờ muốn phơi bày tật nói lắp của mình với các bạn cùng lớp. Anh ấy nhìn thế giới qua ống kính máy ảnh của mình, cho đến một ngày Kiyoi Sou bước qua cửa lớp...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002651?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(56, 'RENFIELD', 'Chris McKay', 'Nicolas  Cage, Nicholas Hoult', 'Horror', 95, 5, 'Renfield bị buộc phải bắt con mồi về cho chủ nhân và thực hiện mọi mệnh lệnh, kể cả những việc nhục nhã. Nhưng giờ đây, sau nhiều thế kỷ làm nô lệ, Renfield đã sẵn sàng để khám phá cuộc sống bên ngoài cái bóng của Hoàng Tử Bóng Đêm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002656?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=_hO0vGwqClM', '2023-04-14', '2023-06-20'),
(57, 'SOUND OF SILENCE', 'Alessandro Antonaci', 'Daniel Lascar', 'Horror', 93, 5, 'Trở về nhà sau mất mát của cha mẹ, Emma vô tình giải phóng những linh hồn quá khứ mắc kẹt trong chiếc radio cổ. Vô số câu chuyện bí ẩn lần lượt được vạch trần, liệu Emma sẽ tỉnh táo đối mặt hay cô sẽ bị nhấn chìm bởi quỹ dữ ?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002666?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-21', '2023-06-20'),
(59, 'THE FLASH ', 'Andy  Muschietti', 'Ben  Affleck, Michael Shannon', 'Action', 120, 5, 'Mùa hè này, đa thế giới sẽ va chạm khốc liệt với những bước chạy của FLASH', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002648?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=uXhf8LJq55Q', '2023-06-16', '2023-06-20'),
(60, 'THE GHOST WITHIN', 'Lawrence Fowler', 'Michaela Longden, Rebecca Phillipson', 'Horror', 103, 5, 'Bí ẩn về cái chết của em gái Evie 20 năm trước, vào lúc 09:09 hằng đêm, hàng loạt cuộc chạm trán kinh hoàng xảy ra. Liệu Margot có biết được sự thật ai là kẻ giết em gái mình?\r\n', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002674?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=p_Ppe-2_Vh8', '2023-04-14', '2023-06-20'),
(61, 'TRANSFORMERS: RISE OF THE BEASTS', 'Steven Caple Jr.', 'Michelle Yeoh, Dominique Fishback', 'Action', 112, 5, 'Bộ phim dựa trên sự kiện Beast Wars trong loạt phim hoạt hình \"Transformers\", nơi mà các robot có khả năng biến thành động vật khổng lồ cùng chiến đấu chống lại một mối đe dọa tiềm tàng', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002678?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=gR2pkm9XVAY', '2023-06-09', '2023-06-20'),
(62, 'THE POPES EXORCIST', 'Julius Avery', 'Russell Crowe, Daniel Zovatto', 'Horror', 104, 5, 'Từ những hồ sơ có thật của Cha Gabriele Amorth, Trưởng Trừ Tà của Vatican, \"The Popes Exorcist\" theo chân Amorth trong cuộc điều tra về vụ quỷ ám kinh hoàng của một cậu bé và dần khám phá ra những bí mật hàng thế kỉ mà Vatican đã cố giấu kín...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002665?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(63, 'NGƯỜI GIỮ THỜI GIAN : TRI ÂM ', 'MỸ TÂM', 'Ca sĩ Mỹ Tâm', 'Musical', 106, NULL, 'Mỹ Tâm sẽ phác họa chân thực toàn bộ những diễn biến tâm lý và cảm xúc thăng trầm cùng những thăng hoa trong suốt quá trình thực hiện Liveshow \"Tri Âm\" lịch sử bằng những thước phim quý giá được quay lại trong 2 năm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002663?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/8BdO_M8bUZo', '2023-04-08', '2023-06-20');

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

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ID`, `NAME`, `TYPE`, `QUANTITY`, `Expiry_Date`) VALUES
(6, 'Bắp rang bơ L1', 'Đồ ăn', 990, '2023-04-30'),
(8, 'Coca cola', 'Đồ uống', 9990, '2023-04-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_fcb`
--

CREATE TABLE `product_fcb` (
  `PRODUCT_ID` int(11) NOT NULL,
  `FCB_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_fcb`
--

INSERT INTO `product_fcb` (`PRODUCT_ID`, `FCB_ID`, `QUANTITY`) VALUES
(6, 2, 1),
(8, 2, 2),
(6, 3, 2),
(8, 3, 2),
(8, 4, 1),
(6, 4, 2);

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

--
-- Đang đổ dữ liệu cho bảng `schedule`
--

INSERT INTO `schedule` (`ID`, `MOV_ID`, `STARTTIME`, `ENDTIME`, `SHOWROOM_ID`) VALUES
(6, 47, '2023-04-20 12:19:00', '2023-04-20 14:26:00', 5),
(7, 47, '2023-04-22 06:20:00', '2023-04-22 08:27:00', 5),
(9, 47, '2023-04-22 09:24:00', '2023-04-22 11:31:00', 5),
(10, 47, '2023-04-22 09:24:00', '2023-04-22 11:31:00', 6),
(11, 47, '2023-04-22 00:00:00', '2023-04-22 02:07:00', 7),
(13, 47, '2023-04-22 15:59:00', '2023-04-22 18:06:00', 8),
(14, 47, '2023-04-22 22:15:00', '2023-04-23 00:22:00', 5),
(15, 47, '2023-04-22 13:15:00', '2023-04-22 15:22:00', 5),
(16, 43, '2023-04-23 18:57:00', '2023-04-23 20:56:00', 9);

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

--
-- Đang đổ dữ liệu cho bảng `seat`
--

INSERT INTO `seat` (`ID`, `THE_ID`, `SEATNUMBER`, `SEATTYPE`) VALUES
(1, 5, 'A1', 'Standard'),
(2, 5, 'B1', 'Standard'),
(3, 5, 'C1', 'Standard'),
(4, 5, 'D1', 'Standard'),
(5, 5, 'E1', 'Standard'),
(6, 5, 'F1', 'Standard'),
(7, 5, 'G1', 'Standard'),
(8, 5, 'H1', 'Standard'),
(9, 5, 'A2', 'Standard'),
(10, 5, 'B2', 'Standard'),
(11, 5, 'C2', 'Standard'),
(12, 5, 'D2', 'Standard'),
(13, 5, 'E2', 'Standard'),
(14, 5, 'F2', 'Standard'),
(15, 5, 'G2', 'Standard'),
(16, 5, 'H2', 'Standard'),
(17, 5, 'A3', 'Standard'),
(18, 5, 'B3', 'Standard'),
(19, 5, 'C3', 'Standard'),
(20, 5, 'D3', 'Standard'),
(21, 5, 'E3', 'Standard'),
(22, 5, 'F3', 'Standard'),
(23, 5, 'G3', 'Standard'),
(24, 5, 'H3', 'Standard'),
(25, 5, 'A4', 'Standard'),
(26, 5, 'B4', 'Standard'),
(27, 5, 'C4', 'Standard'),
(28, 5, 'D4', 'Standard'),
(29, 5, 'E4', 'Standard'),
(30, 5, 'F4', 'Standard'),
(31, 5, 'G4', 'Standard'),
(32, 5, 'H4', 'Standard'),
(33, 5, 'A5', 'Standard'),
(34, 5, 'B5', 'Standard'),
(35, 5, 'C5', 'Standard'),
(36, 5, 'D5', 'Standard'),
(37, 5, 'E5', 'Standard'),
(38, 5, 'F5', 'Standard'),
(39, 5, 'G5', 'Standard'),
(40, 5, 'H5', 'Standard'),
(41, 5, 'A6', 'Standard'),
(42, 5, 'B6', 'Standard'),
(43, 5, 'C6', 'Standard'),
(44, 5, 'D6', 'Standard'),
(45, 5, 'E6', 'Standard'),
(46, 5, 'F6', 'Standard'),
(47, 5, 'G6', 'Standard'),
(48, 5, 'H6', 'Standard'),
(49, 5, 'A7', 'Standard'),
(50, 5, 'B7', 'Standard'),
(51, 5, 'C7', 'Standard'),
(52, 5, 'D7', 'Standard'),
(53, 5, 'E7', 'Standard'),
(54, 5, 'F7', 'Standard'),
(55, 5, 'G7', 'Standard'),
(56, 5, 'H7', 'Standard'),
(57, 5, 'A8', 'Standard'),
(58, 5, 'B8', 'Standard'),
(59, 5, 'C8', 'Standard'),
(60, 5, 'D8', 'Standard'),
(61, 5, 'E8', 'Standard'),
(62, 5, 'F8', 'Standard'),
(63, 5, 'G8', 'Standard'),
(64, 5, 'H8', 'Standard'),
(65, 5, 'A9', 'Standard'),
(66, 5, 'B9', 'Standard'),
(67, 5, 'C9', 'Standard'),
(68, 5, 'D9', 'Standard'),
(69, 5, 'E9', 'Standard'),
(70, 5, 'F9', 'Standard'),
(71, 5, 'G9', 'Standard'),
(72, 5, 'H9', 'Standard'),
(73, 5, 'A10', 'Standard'),
(74, 5, 'B10', 'Standard'),
(75, 5, 'C10', 'Standard'),
(76, 5, 'D10', 'Standard'),
(77, 5, 'E10', 'Standard'),
(78, 5, 'F10', 'Standard'),
(79, 5, 'G10', 'Standard'),
(80, 5, 'H10', 'Standard'),
(81, 5, 'I1', 'Couple'),
(82, 5, 'J1', 'Couple'),
(83, 5, 'I2', 'Couple'),
(84, 5, 'J2', 'Couple'),
(85, 5, 'I3', 'Couple'),
(86, 5, 'J3', 'Couple'),
(87, 5, 'I4', 'Couple'),
(88, 5, 'J4', 'Couple'),
(89, 5, 'I5', 'Couple'),
(90, 5, 'J5', 'Couple'),
(91, 6, 'A1', 'Standard'),
(92, 6, 'B1', 'Standard'),
(93, 6, 'C1', 'Standard'),
(94, 6, 'D1', 'Standard'),
(95, 6, 'E1', 'Standard'),
(96, 6, 'F1', 'Standard'),
(97, 6, 'G1', 'Standard'),
(98, 6, 'H1', 'Standard'),
(99, 6, 'A2', 'Standard'),
(100, 6, 'B2', 'Standard'),
(101, 6, 'C2', 'Standard'),
(102, 6, 'D2', 'Standard'),
(103, 6, 'E2', 'Standard'),
(104, 6, 'F2', 'Standard'),
(105, 6, 'G2', 'Standard'),
(106, 6, 'H2', 'Standard'),
(107, 6, 'A3', 'Standard'),
(108, 6, 'B3', 'Standard'),
(109, 6, 'C3', 'Standard'),
(110, 6, 'D3', 'Standard'),
(111, 6, 'E3', 'Standard'),
(112, 6, 'F3', 'Standard'),
(113, 6, 'G3', 'Standard'),
(114, 6, 'H3', 'Standard'),
(115, 6, 'A4', 'Standard'),
(116, 6, 'B4', 'Standard'),
(117, 6, 'C4', 'Standard'),
(118, 6, 'D4', 'Standard'),
(119, 6, 'E4', 'Standard'),
(120, 6, 'F4', 'Standard'),
(121, 6, 'G4', 'Standard'),
(122, 6, 'H4', 'Standard'),
(123, 6, 'A5', 'Standard'),
(124, 6, 'B5', 'Standard'),
(125, 6, 'C5', 'Standard'),
(126, 6, 'D5', 'Standard'),
(127, 6, 'E5', 'Standard'),
(128, 6, 'F5', 'Standard'),
(129, 6, 'G5', 'Standard'),
(130, 6, 'H5', 'Standard'),
(131, 6, 'A6', 'Standard'),
(132, 6, 'B6', 'Standard'),
(133, 6, 'C6', 'Standard'),
(134, 6, 'D6', 'Standard'),
(135, 6, 'E6', 'Standard'),
(136, 6, 'F6', 'Standard'),
(137, 6, 'G6', 'Standard'),
(138, 6, 'H6', 'Standard'),
(139, 6, 'A7', 'Standard'),
(140, 6, 'B7', 'Standard'),
(141, 6, 'C7', 'Standard'),
(142, 6, 'D7', 'Standard'),
(143, 6, 'E7', 'Standard'),
(144, 6, 'F7', 'Standard'),
(145, 6, 'G7', 'Standard'),
(146, 6, 'H7', 'Standard'),
(147, 6, 'A8', 'Standard'),
(148, 6, 'B8', 'Standard'),
(149, 6, 'C8', 'Standard'),
(150, 6, 'D8', 'Standard'),
(151, 6, 'E8', 'Standard'),
(152, 6, 'F8', 'Standard'),
(153, 6, 'G8', 'Standard'),
(154, 6, 'H8', 'Standard'),
(155, 6, 'A9', 'Standard'),
(156, 6, 'B9', 'Standard'),
(157, 6, 'C9', 'Standard'),
(158, 6, 'D9', 'Standard'),
(159, 6, 'E9', 'Standard'),
(160, 6, 'F9', 'Standard'),
(161, 6, 'G9', 'Standard'),
(162, 6, 'H9', 'Standard'),
(163, 6, 'A10', 'Standard'),
(164, 6, 'B10', 'Standard'),
(165, 6, 'C10', 'Standard'),
(166, 6, 'D10', 'Standard'),
(167, 6, 'E10', 'Standard'),
(168, 6, 'F10', 'Standard'),
(169, 6, 'G10', 'Standard'),
(170, 6, 'H10', 'Standard'),
(171, 6, 'I1', 'Couple'),
(172, 6, 'J1', 'Couple'),
(173, 6, 'I2', 'Couple'),
(174, 6, 'J2', 'Couple'),
(175, 6, 'I3', 'Couple'),
(176, 6, 'J3', 'Couple'),
(177, 6, 'I4', 'Couple'),
(178, 6, 'J4', 'Couple'),
(179, 6, 'I5', 'Couple'),
(180, 6, 'J5', 'Couple'),
(181, 7, 'A1', 'Standard'),
(182, 7, 'B1', 'Standard'),
(183, 7, 'C1', 'Standard'),
(184, 7, 'D1', 'Standard'),
(185, 7, 'E1', 'Standard'),
(186, 7, 'F1', 'Standard'),
(187, 7, 'G1', 'Standard'),
(188, 7, 'H1', 'Standard'),
(189, 7, 'A2', 'Standard'),
(190, 7, 'B2', 'Standard'),
(191, 7, 'C2', 'Standard'),
(192, 7, 'D2', 'Standard'),
(193, 7, 'E2', 'Standard'),
(194, 7, 'F2', 'Standard'),
(195, 7, 'G2', 'Standard'),
(196, 7, 'H2', 'Standard'),
(197, 7, 'A3', 'Standard'),
(198, 7, 'B3', 'Standard'),
(199, 7, 'C3', 'Standard'),
(200, 7, 'D3', 'Standard'),
(201, 7, 'E3', 'Standard'),
(202, 7, 'F3', 'Standard'),
(203, 7, 'G3', 'Standard'),
(204, 7, 'H3', 'Standard'),
(205, 7, 'A4', 'Standard'),
(206, 7, 'B4', 'Standard'),
(207, 7, 'C4', 'Standard'),
(208, 7, 'D4', 'Standard'),
(209, 7, 'E4', 'Standard'),
(210, 7, 'F4', 'Standard'),
(211, 7, 'G4', 'Standard'),
(212, 7, 'H4', 'Standard'),
(213, 7, 'A5', 'Standard'),
(214, 7, 'B5', 'Standard'),
(215, 7, 'C5', 'Standard'),
(216, 7, 'D5', 'Standard'),
(217, 7, 'E5', 'Standard'),
(218, 7, 'F5', 'Standard'),
(219, 7, 'G5', 'Standard'),
(220, 7, 'H5', 'Standard'),
(221, 7, 'A6', 'Standard'),
(222, 7, 'B6', 'Standard'),
(223, 7, 'C6', 'Standard'),
(224, 7, 'D6', 'Standard'),
(225, 7, 'E6', 'Standard'),
(226, 7, 'F6', 'Standard'),
(227, 7, 'G6', 'Standard'),
(228, 7, 'H6', 'Standard'),
(229, 7, 'A7', 'Standard'),
(230, 7, 'B7', 'Standard'),
(231, 7, 'C7', 'Standard'),
(232, 7, 'D7', 'Standard'),
(233, 7, 'E7', 'Standard'),
(234, 7, 'F7', 'Standard'),
(235, 7, 'G7', 'Standard'),
(236, 7, 'H7', 'Standard'),
(237, 7, 'A8', 'Standard'),
(238, 7, 'B8', 'Standard'),
(239, 7, 'C8', 'Standard'),
(240, 7, 'D8', 'Standard'),
(241, 7, 'E8', 'Standard'),
(242, 7, 'F8', 'Standard'),
(243, 7, 'G8', 'Standard'),
(244, 7, 'H8', 'Standard'),
(245, 7, 'A9', 'Standard'),
(246, 7, 'B9', 'Standard'),
(247, 7, 'C9', 'Standard'),
(248, 7, 'D9', 'Standard'),
(249, 7, 'E9', 'Standard'),
(250, 7, 'F9', 'Standard'),
(251, 7, 'G9', 'Standard'),
(252, 7, 'H9', 'Standard'),
(253, 7, 'A10', 'Standard'),
(254, 7, 'B10', 'Standard'),
(255, 7, 'C10', 'Standard'),
(256, 7, 'D10', 'Standard'),
(257, 7, 'E10', 'Standard'),
(258, 7, 'F10', 'Standard'),
(259, 7, 'G10', 'Standard'),
(260, 7, 'H10', 'Standard'),
(261, 7, 'I1', 'Couple'),
(262, 7, 'J1', 'Couple'),
(263, 7, 'I2', 'Couple'),
(264, 7, 'J2', 'Couple'),
(265, 7, 'I3', 'Couple'),
(266, 7, 'J3', 'Couple'),
(267, 7, 'I4', 'Couple'),
(268, 7, 'J4', 'Couple'),
(269, 7, 'I5', 'Couple'),
(270, 7, 'J5', 'Couple'),
(271, 8, 'A1', 'Standard'),
(272, 8, 'B1', 'Standard'),
(273, 8, 'C1', 'Standard'),
(274, 8, 'D1', 'Standard'),
(275, 8, 'E1', 'Standard'),
(276, 8, 'F1', 'Standard'),
(277, 8, 'G1', 'Standard'),
(278, 8, 'H1', 'Standard'),
(279, 8, 'A2', 'Standard'),
(280, 8, 'B2', 'Standard'),
(281, 8, 'C2', 'Standard'),
(282, 8, 'D2', 'Standard'),
(283, 8, 'E2', 'Standard'),
(284, 8, 'F2', 'Standard'),
(285, 8, 'G2', 'Standard'),
(286, 8, 'H2', 'Standard'),
(287, 8, 'A3', 'Standard'),
(288, 8, 'B3', 'Standard'),
(289, 8, 'C3', 'Standard'),
(290, 8, 'D3', 'Standard'),
(291, 8, 'E3', 'Standard'),
(292, 8, 'F3', 'Standard'),
(293, 8, 'G3', 'Standard'),
(294, 8, 'H3', 'Standard'),
(295, 8, 'A4', 'Standard'),
(296, 8, 'B4', 'Standard'),
(297, 8, 'C4', 'Standard'),
(298, 8, 'D4', 'Standard'),
(299, 8, 'E4', 'Standard'),
(300, 8, 'F4', 'Standard'),
(301, 8, 'G4', 'Standard'),
(302, 8, 'H4', 'Standard'),
(303, 8, 'A5', 'Standard'),
(304, 8, 'B5', 'Standard'),
(305, 8, 'C5', 'Standard'),
(306, 8, 'D5', 'Standard'),
(307, 8, 'E5', 'Standard'),
(308, 8, 'F5', 'Standard'),
(309, 8, 'G5', 'Standard'),
(310, 8, 'H5', 'Standard'),
(311, 8, 'A6', 'Standard'),
(312, 8, 'B6', 'Standard'),
(313, 8, 'C6', 'Standard'),
(314, 8, 'D6', 'Standard'),
(315, 8, 'E6', 'Standard'),
(316, 8, 'F6', 'Standard'),
(317, 8, 'G6', 'Standard'),
(318, 8, 'H6', 'Standard'),
(319, 8, 'A7', 'Standard'),
(320, 8, 'B7', 'Standard'),
(321, 8, 'C7', 'Standard'),
(322, 8, 'D7', 'Standard'),
(323, 8, 'E7', 'Standard'),
(324, 8, 'F7', 'Standard'),
(325, 8, 'G7', 'Standard'),
(326, 8, 'H7', 'Standard'),
(327, 8, 'A8', 'Standard'),
(328, 8, 'B8', 'Standard'),
(329, 8, 'C8', 'Standard'),
(330, 8, 'D8', 'Standard'),
(331, 8, 'E8', 'Standard'),
(332, 8, 'F8', 'Standard'),
(333, 8, 'G8', 'Standard'),
(334, 8, 'H8', 'Standard'),
(335, 8, 'A9', 'Standard'),
(336, 8, 'B9', 'Standard'),
(337, 8, 'C9', 'Standard'),
(338, 8, 'D9', 'Standard'),
(339, 8, 'E9', 'Standard'),
(340, 8, 'F9', 'Standard'),
(341, 8, 'G9', 'Standard'),
(342, 8, 'H9', 'Standard'),
(343, 8, 'A10', 'Standard'),
(344, 8, 'B10', 'Standard'),
(345, 8, 'C10', 'Standard'),
(346, 8, 'D10', 'Standard'),
(347, 8, 'E10', 'Standard'),
(348, 8, 'F10', 'Standard'),
(349, 8, 'G10', 'Standard'),
(350, 8, 'H10', 'Standard'),
(351, 8, 'I1', 'Couple'),
(352, 8, 'J1', 'Couple'),
(353, 8, 'I2', 'Couple'),
(354, 8, 'J2', 'Couple'),
(355, 8, 'I3', 'Couple'),
(356, 8, 'J3', 'Couple'),
(357, 8, 'I4', 'Couple'),
(358, 8, 'J4', 'Couple'),
(359, 8, 'I5', 'Couple'),
(360, 8, 'J5', 'Couple'),
(361, 9, 'A1', 'Standard'),
(362, 9, 'B1', 'Standard'),
(363, 9, 'C1', 'Standard'),
(364, 9, 'D1', 'Standard'),
(365, 9, 'E1', 'Standard'),
(366, 9, 'F1', 'Standard'),
(367, 9, 'G1', 'Standard'),
(368, 9, 'H1', 'Standard'),
(369, 9, 'A2', 'Standard'),
(370, 9, 'B2', 'Standard'),
(371, 9, 'C2', 'Standard'),
(372, 9, 'D2', 'Standard'),
(373, 9, 'E2', 'Standard'),
(374, 9, 'F2', 'Standard'),
(375, 9, 'G2', 'Standard'),
(376, 9, 'H2', 'Standard'),
(377, 9, 'A3', 'Standard'),
(378, 9, 'B3', 'Standard'),
(379, 9, 'C3', 'Standard'),
(380, 9, 'D3', 'Standard'),
(381, 9, 'E3', 'Standard'),
(382, 9, 'F3', 'Standard'),
(383, 9, 'G3', 'Standard'),
(384, 9, 'H3', 'Standard'),
(385, 9, 'A4', 'Standard'),
(386, 9, 'B4', 'Standard'),
(387, 9, 'C4', 'Standard'),
(388, 9, 'D4', 'Standard'),
(389, 9, 'E4', 'Standard'),
(390, 9, 'F4', 'Standard'),
(391, 9, 'G4', 'Standard'),
(392, 9, 'H4', 'Standard'),
(393, 9, 'A5', 'Standard'),
(394, 9, 'B5', 'Standard'),
(395, 9, 'C5', 'Standard'),
(396, 9, 'D5', 'Standard'),
(397, 9, 'E5', 'Standard'),
(398, 9, 'F5', 'Standard'),
(399, 9, 'G5', 'Standard'),
(400, 9, 'H5', 'Standard'),
(401, 9, 'A6', 'Standard'),
(402, 9, 'B6', 'Standard'),
(403, 9, 'C6', 'Standard'),
(404, 9, 'D6', 'Standard'),
(405, 9, 'E6', 'Standard'),
(406, 9, 'F6', 'Standard'),
(407, 9, 'G6', 'Standard'),
(408, 9, 'H6', 'Standard'),
(409, 9, 'A7', 'Standard'),
(410, 9, 'B7', 'Standard'),
(411, 9, 'C7', 'Standard'),
(412, 9, 'D7', 'Standard'),
(413, 9, 'E7', 'Standard'),
(414, 9, 'F7', 'Standard'),
(415, 9, 'G7', 'Standard'),
(416, 9, 'H7', 'Standard'),
(417, 9, 'A8', 'Standard'),
(418, 9, 'B8', 'Standard'),
(419, 9, 'C8', 'Standard'),
(420, 9, 'D8', 'Standard'),
(421, 9, 'E8', 'Standard'),
(422, 9, 'F8', 'Standard'),
(423, 9, 'G8', 'Standard'),
(424, 9, 'H8', 'Standard'),
(425, 9, 'A9', 'Standard'),
(426, 9, 'B9', 'Standard'),
(427, 9, 'C9', 'Standard'),
(428, 9, 'D9', 'Standard'),
(429, 9, 'E9', 'Standard'),
(430, 9, 'F9', 'Standard'),
(431, 9, 'G9', 'Standard'),
(432, 9, 'H9', 'Standard'),
(433, 9, 'A10', 'Standard'),
(434, 9, 'B10', 'Standard'),
(435, 9, 'C10', 'Standard'),
(436, 9, 'D10', 'Standard'),
(437, 9, 'E10', 'Standard'),
(438, 9, 'F10', 'Standard'),
(439, 9, 'G10', 'Standard'),
(440, 9, 'H10', 'Standard'),
(441, 9, 'I1', 'Couple'),
(442, 9, 'J1', 'Couple'),
(443, 9, 'I2', 'Couple'),
(444, 9, 'J2', 'Couple'),
(445, 9, 'I3', 'Couple'),
(446, 9, 'J3', 'Couple'),
(447, 9, 'I4', 'Couple'),
(448, 9, 'J4', 'Couple'),
(449, 9, 'I5', 'Couple'),
(450, 9, 'J5', 'Couple');

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

--
-- Đang đổ dữ liệu cho bảng `showroom`
--

INSERT INTO `showroom` (`ID`, `SHOWROOMNUM`, `SEATCOUNT`, `CINEMA_ID`) VALUES
(5, 1, 90, 1),
(6, 2, 90, 1),
(7, 1, 90, 2),
(8, 2, 90, 2),
(9, 1, 90, 3);

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

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `SALARY`, `ROLE`) VALUES
(1, 'admin', 'admin', 'Lê Hoàng', 'Phú', 'nam', '2003-02-02', '0123456789', 'Quận 7', 50000, 0),
(5, 'staff1', 'Admin@123', 'Võ Trọng', 'Tình', 'nam', '2003-08-20', '084320639458', 'Quận 7, TP Hồ Chí Minh', 5000, 1);

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
-- Đang đổ dữ liệu cho bảng `ticket`
--

INSERT INTO `ticket` (`ID`, `BOO_ID`, `price`) VALUES
(361, NULL, 90000),
(362, NULL, 90000),
(363, NULL, 90000),
(364, NULL, 90000),
(365, NULL, 90000),
(366, NULL, 90000),
(367, NULL, 90000),
(368, NULL, 90000),
(369, NULL, 90000),
(370, NULL, 90000),
(371, NULL, 90000),
(372, NULL, 90000),
(373, NULL, 90000),
(374, NULL, 90000),
(375, NULL, 90000),
(376, NULL, 90000),
(377, NULL, 90000),
(378, NULL, 90000),
(379, NULL, 90000),
(380, NULL, 90000),
(381, NULL, 90000),
(382, NULL, 90000),
(383, NULL, 90000),
(384, NULL, 90000),
(385, 5, 90000),
(386, NULL, 90000),
(387, NULL, 90000),
(388, NULL, 90000),
(389, NULL, 90000),
(390, NULL, 90000),
(391, NULL, 90000),
(392, NULL, 90000),
(393, NULL, 90000),
(394, NULL, 90000),
(395, NULL, 90000),
(396, NULL, 90000),
(397, NULL, 90000),
(398, NULL, 90000),
(399, NULL, 90000),
(400, NULL, 90000),
(401, NULL, 90000),
(402, NULL, 90000),
(403, NULL, 90000),
(404, NULL, 90000),
(405, NULL, 90000),
(406, NULL, 90000),
(407, NULL, 90000),
(408, NULL, 90000),
(409, NULL, 90000),
(410, NULL, 90000),
(411, NULL, 90000),
(412, NULL, 90000),
(413, NULL, 90000),
(414, NULL, 90000),
(415, NULL, 90000),
(416, NULL, 90000),
(417, NULL, 90000),
(418, NULL, 90000),
(419, NULL, 90000),
(420, NULL, 90000),
(421, NULL, 90000),
(422, NULL, 90000),
(423, NULL, 90000),
(424, NULL, 90000),
(425, NULL, 90000),
(426, NULL, 90000),
(427, NULL, 90000),
(428, NULL, 90000),
(429, NULL, 90000),
(430, NULL, 90000),
(431, NULL, 90000),
(432, NULL, 90000),
(433, NULL, 90000),
(434, NULL, 90000),
(435, NULL, 90000),
(436, NULL, 90000),
(437, NULL, 90000),
(438, NULL, 90000),
(439, NULL, 90000),
(440, NULL, 90000),
(441, NULL, 120000),
(442, NULL, 120000),
(443, NULL, 120000),
(444, NULL, 120000),
(445, NULL, 120000),
(446, NULL, 120000),
(447, NULL, 120000),
(448, NULL, 120000),
(449, NULL, 120000),
(450, NULL, 120000),
(451, NULL, 90000),
(452, NULL, 90000),
(453, NULL, 90000),
(454, NULL, 90000),
(455, NULL, 90000),
(456, NULL, 90000),
(457, NULL, 90000),
(458, NULL, 90000),
(459, NULL, 90000),
(460, NULL, 90000),
(461, NULL, 90000),
(462, NULL, 90000),
(463, NULL, 90000),
(464, NULL, 90000),
(465, NULL, 90000),
(466, NULL, 90000),
(467, 6, 90000),
(468, NULL, 90000),
(469, NULL, 90000),
(470, NULL, 90000),
(471, NULL, 90000),
(472, NULL, 90000),
(473, NULL, 90000),
(474, NULL, 90000),
(475, 6, 90000),
(476, NULL, 90000),
(477, NULL, 90000),
(478, NULL, 90000),
(479, NULL, 90000),
(480, NULL, 90000),
(481, NULL, 90000),
(482, NULL, 90000),
(483, 6, 90000),
(484, NULL, 90000),
(485, NULL, 90000),
(486, NULL, 90000),
(487, NULL, 90000),
(488, NULL, 90000),
(489, NULL, 90000),
(490, NULL, 90000),
(491, 7, 90000),
(492, NULL, 90000),
(493, NULL, 90000),
(494, NULL, 90000),
(495, NULL, 90000),
(496, NULL, 90000),
(497, NULL, 90000),
(498, NULL, 90000),
(499, NULL, 90000),
(500, NULL, 90000),
(501, NULL, 90000),
(502, NULL, 90000),
(503, NULL, 90000),
(504, NULL, 90000),
(505, NULL, 90000),
(506, NULL, 90000),
(507, NULL, 90000),
(508, NULL, 90000),
(509, NULL, 90000),
(510, NULL, 90000),
(511, NULL, 90000),
(512, NULL, 90000),
(513, NULL, 90000),
(514, NULL, 90000),
(515, NULL, 90000),
(516, NULL, 90000),
(517, NULL, 90000),
(518, NULL, 90000),
(519, NULL, 90000),
(520, NULL, 90000),
(521, NULL, 90000),
(522, NULL, 90000),
(523, NULL, 90000),
(524, NULL, 90000),
(525, NULL, 90000),
(526, NULL, 90000),
(527, NULL, 90000),
(528, NULL, 90000),
(529, NULL, 90000),
(530, NULL, 90000),
(531, NULL, 120000),
(532, NULL, 120000),
(533, 6, 120000),
(534, NULL, 120000),
(535, NULL, 120000),
(536, NULL, 120000),
(537, NULL, 120000),
(538, NULL, 120000),
(539, NULL, 120000),
(540, NULL, 120000),
(541, NULL, 90900),
(542, NULL, 90900),
(543, NULL, 90900),
(544, NULL, 90900),
(545, NULL, 90900),
(546, NULL, 90900),
(547, NULL, 90900),
(548, NULL, 90900),
(549, NULL, 90900),
(550, NULL, 90900),
(551, NULL, 90900),
(552, NULL, 90900),
(553, NULL, 90900),
(554, NULL, 90900),
(555, NULL, 90900),
(556, NULL, 90900),
(557, 10, 90900),
(558, NULL, 90900),
(559, NULL, 90900),
(560, NULL, 90900),
(561, NULL, 90900),
(562, NULL, 90900),
(563, NULL, 90900),
(564, NULL, 90900),
(565, NULL, 90900),
(566, NULL, 90900),
(567, NULL, 90900),
(568, NULL, 90900),
(569, NULL, 90900),
(570, NULL, 90900),
(571, 11, 90900),
(572, NULL, 90900),
(573, NULL, 90900),
(574, NULL, 90900),
(575, NULL, 90900),
(576, NULL, 90900),
(577, NULL, 90900),
(578, NULL, 90900),
(579, NULL, 90900),
(580, NULL, 90900),
(581, NULL, 90900),
(582, NULL, 90900),
(583, NULL, 90900),
(584, NULL, 90900),
(585, NULL, 90900),
(586, NULL, 90900),
(587, NULL, 90900),
(588, NULL, 90900),
(589, NULL, 90900),
(590, NULL, 90900),
(591, NULL, 90900),
(592, NULL, 90900),
(593, NULL, 90900),
(594, NULL, 90900),
(595, NULL, 90900),
(596, NULL, 90900),
(597, NULL, 90900),
(598, NULL, 90900),
(599, NULL, 90900),
(600, NULL, 90900),
(601, NULL, 90900),
(602, NULL, 90900),
(603, NULL, 90900),
(604, NULL, 90900),
(605, NULL, 90900),
(606, NULL, 90900),
(607, NULL, 90900),
(608, NULL, 90900),
(609, NULL, 90900),
(610, NULL, 90900),
(611, NULL, 90900),
(612, NULL, 90900),
(613, NULL, 90900),
(614, NULL, 90900),
(615, NULL, 90900),
(616, NULL, 90900),
(617, NULL, 90900),
(618, NULL, 90900),
(619, NULL, 90900),
(620, NULL, 90900),
(621, NULL, 120900),
(622, NULL, 120900),
(623, NULL, 120900),
(624, NULL, 120900),
(625, NULL, 120900),
(626, NULL, 120900),
(627, NULL, 120900),
(628, NULL, 120900),
(629, NULL, 120900),
(630, NULL, 120900),
(631, NULL, 90900),
(632, NULL, 90900),
(633, NULL, 90900),
(634, NULL, 90900),
(635, NULL, 90900),
(636, NULL, 90900),
(637, NULL, 90900),
(638, NULL, 90900),
(639, NULL, 90900),
(640, NULL, 90900),
(641, NULL, 90900),
(642, NULL, 90900),
(643, NULL, 90900),
(644, NULL, 90900),
(645, NULL, 90900),
(646, NULL, 90900),
(647, NULL, 90900),
(648, NULL, 90900),
(649, NULL, 90900),
(650, NULL, 90900),
(651, NULL, 90900),
(652, NULL, 90900),
(653, NULL, 90900),
(654, NULL, 90900),
(655, NULL, 90900),
(656, NULL, 90900),
(657, NULL, 90900),
(658, NULL, 90900),
(659, NULL, 90900),
(660, NULL, 90900),
(661, NULL, 90900),
(662, NULL, 90900),
(663, NULL, 90900),
(664, NULL, 90900),
(665, NULL, 90900),
(666, NULL, 90900),
(667, NULL, 90900),
(668, NULL, 90900),
(669, NULL, 90900),
(670, NULL, 90900),
(671, NULL, 90900),
(672, NULL, 90900),
(673, NULL, 90900),
(674, NULL, 90900),
(675, NULL, 90900),
(676, NULL, 90900),
(677, NULL, 90900),
(678, NULL, 90900),
(679, NULL, 90900),
(680, NULL, 90900),
(681, NULL, 90900),
(682, NULL, 90900),
(683, NULL, 90900),
(684, NULL, 90900),
(685, NULL, 90900),
(686, NULL, 90900),
(687, NULL, 90900),
(688, NULL, 90900),
(689, NULL, 90900),
(690, NULL, 90900),
(691, NULL, 90900),
(692, NULL, 90900),
(693, NULL, 90900),
(694, NULL, 90900),
(695, NULL, 90900),
(696, NULL, 90900),
(697, NULL, 90900),
(698, NULL, 90900),
(699, NULL, 90900),
(700, NULL, 90900),
(701, NULL, 90900),
(702, NULL, 90900),
(703, NULL, 90900),
(704, NULL, 90900),
(705, NULL, 90900),
(706, NULL, 90900),
(707, NULL, 90900),
(708, NULL, 90900),
(709, NULL, 90900),
(710, NULL, 90900),
(711, NULL, 120900),
(712, NULL, 120900),
(713, NULL, 120900),
(714, NULL, 120900),
(715, NULL, 120900),
(716, NULL, 120900),
(717, NULL, 120900),
(718, NULL, 120900),
(719, NULL, 120900),
(720, NULL, 120900),
(721, NULL, 90000),
(722, NULL, 90000),
(723, NULL, 90000),
(724, NULL, 90000),
(725, NULL, 90000),
(726, NULL, 90000),
(727, NULL, 90000),
(728, NULL, 90000),
(729, NULL, 90000),
(730, NULL, 90000),
(731, NULL, 90000),
(732, NULL, 90000),
(733, NULL, 90000),
(734, NULL, 90000),
(735, NULL, 90000),
(736, NULL, 90000),
(737, NULL, 90000),
(738, NULL, 90000),
(739, NULL, 90000),
(740, NULL, 90000),
(741, NULL, 90000),
(742, NULL, 90000),
(743, NULL, 90000),
(744, NULL, 90000),
(745, NULL, 90000),
(746, NULL, 90000),
(747, NULL, 90000),
(748, NULL, 90000),
(749, NULL, 90000),
(750, NULL, 90000),
(751, NULL, 90000),
(752, NULL, 90000),
(753, NULL, 90000),
(754, NULL, 90000),
(755, NULL, 90000),
(756, NULL, 90000),
(757, NULL, 90000),
(758, NULL, 90000),
(759, NULL, 90000),
(760, NULL, 90000),
(761, NULL, 90000),
(762, NULL, 90000),
(763, NULL, 90000),
(764, NULL, 90000),
(765, NULL, 90000),
(766, NULL, 90000),
(767, NULL, 90000),
(768, NULL, 90000),
(769, NULL, 90000),
(770, NULL, 90000),
(771, NULL, 90000),
(772, NULL, 90000),
(773, NULL, 90000),
(774, NULL, 90000),
(775, NULL, 90000),
(776, NULL, 90000),
(777, NULL, 90000),
(778, NULL, 90000),
(779, NULL, 90000),
(780, NULL, 90000),
(781, NULL, 90000),
(782, NULL, 90000),
(783, NULL, 90000),
(784, NULL, 90000),
(785, NULL, 90000),
(786, NULL, 90000),
(787, NULL, 90000),
(788, NULL, 90000),
(789, NULL, 90000),
(790, NULL, 90000),
(791, NULL, 90000),
(792, NULL, 90000),
(793, NULL, 90000),
(794, NULL, 90000),
(795, NULL, 90000),
(796, NULL, 90000),
(797, NULL, 90000),
(798, NULL, 90000),
(799, NULL, 90000),
(800, NULL, 90000),
(801, NULL, 120000),
(802, NULL, 120000),
(803, NULL, 120000),
(804, NULL, 120000),
(805, NULL, 120000),
(806, NULL, 120000),
(807, NULL, 120000),
(808, NULL, 120000),
(809, NULL, 120000),
(810, NULL, 120000),
(811, NULL, 90000),
(812, NULL, 90000),
(813, NULL, 90000),
(814, NULL, 90000),
(815, NULL, 90000),
(816, NULL, 90000),
(817, NULL, 90000),
(818, NULL, 90000),
(819, NULL, 90000),
(820, NULL, 90000),
(821, NULL, 90000),
(822, NULL, 90000),
(823, NULL, 90000),
(824, NULL, 90000),
(825, NULL, 90000),
(826, NULL, 90000),
(827, NULL, 90000),
(828, NULL, 90000),
(829, NULL, 90000),
(830, NULL, 90000),
(831, NULL, 90000),
(832, NULL, 90000),
(833, NULL, 90000),
(834, NULL, 90000),
(835, NULL, 90000),
(836, NULL, 90000),
(837, NULL, 90000),
(838, NULL, 90000),
(839, NULL, 90000),
(840, NULL, 90000),
(841, NULL, 90000),
(842, NULL, 90000),
(843, NULL, 90000),
(844, NULL, 90000),
(845, NULL, 90000),
(846, NULL, 90000),
(847, NULL, 90000),
(848, NULL, 90000),
(849, NULL, 90000),
(850, NULL, 90000),
(851, NULL, 90000),
(852, NULL, 90000),
(853, NULL, 90000),
(854, NULL, 90000),
(855, NULL, 90000),
(856, NULL, 90000),
(857, NULL, 90000),
(858, NULL, 90000),
(859, NULL, 90000),
(860, NULL, 90000),
(861, NULL, 90000),
(862, NULL, 90000),
(863, NULL, 90000),
(864, NULL, 90000),
(865, NULL, 90000),
(866, NULL, 90000),
(867, NULL, 90000),
(868, NULL, 90000),
(869, NULL, 90000),
(870, NULL, 90000),
(871, NULL, 90000),
(872, NULL, 90000),
(873, NULL, 90000),
(874, NULL, 90000),
(875, NULL, 90000),
(876, NULL, 90000),
(877, NULL, 90000),
(878, NULL, 90000),
(879, NULL, 90000),
(880, NULL, 90000),
(881, NULL, 90000),
(882, NULL, 90000),
(883, NULL, 90000),
(884, NULL, 90000),
(885, NULL, 90000),
(886, NULL, 90000),
(887, NULL, 90000),
(888, NULL, 90000),
(889, NULL, 90000),
(890, NULL, 90000),
(891, NULL, 120000),
(892, NULL, 120000),
(893, NULL, 120000),
(894, NULL, 120000),
(895, NULL, 120000),
(896, NULL, 120000),
(897, NULL, 120000),
(898, NULL, 120000),
(899, NULL, 120000),
(900, NULL, 120000),
(901, NULL, 90000),
(902, NULL, 90000),
(903, NULL, 90000),
(904, NULL, 90000),
(905, NULL, 90000),
(906, NULL, 90000),
(907, NULL, 90000),
(908, NULL, 90000),
(909, NULL, 90000),
(910, NULL, 90000),
(911, NULL, 90000),
(912, NULL, 90000),
(913, NULL, 90000),
(914, NULL, 90000),
(915, NULL, 90000),
(916, NULL, 90000),
(917, 9, 90000),
(918, NULL, 90000),
(919, NULL, 90000),
(920, NULL, 90000),
(921, NULL, 90000),
(922, NULL, 90000),
(923, NULL, 90000),
(924, NULL, 90000),
(925, 9, 90000),
(926, NULL, 90000),
(927, NULL, 90000),
(928, NULL, 90000),
(929, NULL, 90000),
(930, NULL, 90000),
(931, NULL, 90000),
(932, NULL, 90000),
(933, NULL, 90000),
(934, NULL, 90000),
(935, NULL, 90000),
(936, NULL, 90000),
(937, NULL, 90000),
(938, NULL, 90000),
(939, NULL, 90000),
(940, NULL, 90000),
(941, NULL, 90000),
(942, NULL, 90000),
(943, NULL, 90000),
(944, NULL, 90000),
(945, NULL, 90000),
(946, NULL, 90000),
(947, NULL, 90000),
(948, NULL, 90000),
(949, NULL, 90000),
(950, NULL, 90000),
(951, NULL, 90000),
(952, NULL, 90000),
(953, NULL, 90000),
(954, NULL, 90000),
(955, NULL, 90000),
(956, NULL, 90000),
(957, NULL, 90000),
(958, NULL, 90000),
(959, NULL, 90000),
(960, NULL, 90000),
(961, NULL, 90000),
(962, NULL, 90000),
(963, NULL, 90000),
(964, NULL, 90000),
(965, NULL, 90000),
(966, NULL, 90000),
(967, NULL, 90000),
(968, NULL, 90000),
(969, NULL, 90000),
(970, NULL, 90000),
(971, NULL, 90000),
(972, NULL, 90000),
(973, NULL, 90000),
(974, NULL, 90000),
(975, NULL, 90000),
(976, NULL, 90000),
(977, NULL, 90000),
(978, NULL, 90000),
(979, NULL, 90000),
(980, NULL, 90000),
(981, NULL, 120000),
(982, NULL, 120000),
(983, 9, 120000),
(984, NULL, 120000),
(985, 9, 120000),
(986, NULL, 120000),
(987, NULL, 120000),
(988, NULL, 120000),
(989, NULL, 120000),
(990, NULL, 120000),
(991, NULL, 90000),
(992, NULL, 90000),
(993, NULL, 90000),
(994, NULL, 90000),
(995, NULL, 90000),
(996, NULL, 90000),
(997, NULL, 90000),
(998, NULL, 90000),
(999, NULL, 90000),
(1000, NULL, 90000),
(1001, NULL, 90000),
(1002, NULL, 90000),
(1003, NULL, 90000),
(1004, NULL, 90000),
(1005, NULL, 90000),
(1006, NULL, 90000),
(1007, 8, 90000),
(1008, NULL, 90000),
(1009, NULL, 90000),
(1010, NULL, 90000),
(1011, NULL, 90000),
(1012, NULL, 90000),
(1013, NULL, 90000),
(1014, NULL, 90000),
(1015, NULL, 90000),
(1016, NULL, 90000),
(1017, NULL, 90000),
(1018, NULL, 90000),
(1019, NULL, 90000),
(1020, NULL, 90000),
(1021, NULL, 90000),
(1022, NULL, 90000),
(1023, NULL, 90000),
(1024, NULL, 90000),
(1025, NULL, 90000),
(1026, NULL, 90000),
(1027, NULL, 90000),
(1028, NULL, 90000),
(1029, NULL, 90000),
(1030, NULL, 90000),
(1031, NULL, 90000),
(1032, NULL, 90000),
(1033, NULL, 90000),
(1034, NULL, 90000),
(1035, NULL, 90000),
(1036, NULL, 90000),
(1037, NULL, 90000),
(1038, NULL, 90000),
(1039, NULL, 90000),
(1040, NULL, 90000),
(1041, NULL, 90000),
(1042, NULL, 90000),
(1043, NULL, 90000),
(1044, NULL, 90000),
(1045, NULL, 90000),
(1046, NULL, 90000),
(1047, NULL, 90000),
(1048, NULL, 90000),
(1049, NULL, 90000),
(1050, NULL, 90000),
(1051, NULL, 90000),
(1052, NULL, 90000),
(1053, NULL, 90000),
(1054, NULL, 90000),
(1055, NULL, 90000),
(1056, NULL, 90000),
(1057, NULL, 90000),
(1058, NULL, 90000),
(1059, NULL, 90000),
(1060, NULL, 90000),
(1061, NULL, 90000),
(1062, NULL, 90000),
(1063, NULL, 90000),
(1064, NULL, 90000),
(1065, NULL, 90000),
(1066, NULL, 90000),
(1067, NULL, 90000),
(1068, NULL, 90000),
(1069, NULL, 90000),
(1070, NULL, 90000),
(1071, NULL, 120000),
(1072, NULL, 120000),
(1073, 8, 120000),
(1074, NULL, 120000),
(1075, NULL, 120000),
(1076, NULL, 120000),
(1077, NULL, 120000),
(1078, NULL, 120000),
(1079, NULL, 120000),
(1080, NULL, 120000),
(1081, NULL, 90000),
(1082, NULL, 90000),
(1083, NULL, 90000),
(1084, NULL, 90000),
(1085, NULL, 90000),
(1086, NULL, 90000),
(1087, NULL, 90000),
(1088, NULL, 90000),
(1089, NULL, 90000),
(1090, NULL, 90000),
(1091, NULL, 90000),
(1092, NULL, 90000),
(1093, NULL, 90000),
(1094, NULL, 90000),
(1095, NULL, 90000),
(1096, NULL, 90000),
(1097, NULL, 90000),
(1098, NULL, 90000),
(1099, NULL, 90000),
(1100, NULL, 90000),
(1101, NULL, 90000),
(1102, NULL, 90000),
(1103, NULL, 90000),
(1104, NULL, 90000),
(1105, NULL, 90000),
(1106, NULL, 90000),
(1107, NULL, 90000),
(1108, NULL, 90000),
(1109, NULL, 90000),
(1110, NULL, 90000),
(1111, NULL, 90000),
(1112, NULL, 90000),
(1113, NULL, 90000),
(1114, NULL, 90000),
(1115, NULL, 90000),
(1116, NULL, 90000),
(1117, NULL, 90000),
(1118, NULL, 90000),
(1119, NULL, 90000),
(1120, NULL, 90000),
(1121, NULL, 90000),
(1122, NULL, 90000),
(1123, NULL, 90000),
(1124, NULL, 90000),
(1125, NULL, 90000),
(1126, NULL, 90000),
(1127, NULL, 90000),
(1128, NULL, 90000),
(1129, NULL, 90000),
(1130, NULL, 90000),
(1131, NULL, 90000),
(1132, NULL, 90000),
(1133, NULL, 90000),
(1134, NULL, 90000),
(1135, NULL, 90000),
(1136, NULL, 90000),
(1137, NULL, 90000),
(1138, NULL, 90000),
(1139, NULL, 90000),
(1140, NULL, 90000),
(1141, NULL, 90000),
(1142, NULL, 90000),
(1143, NULL, 90000),
(1144, NULL, 90000),
(1145, NULL, 90000),
(1146, NULL, 90000),
(1147, NULL, 90000),
(1148, NULL, 90000),
(1149, NULL, 90000),
(1150, NULL, 90000),
(1151, NULL, 90000),
(1152, NULL, 90000),
(1153, NULL, 90000),
(1154, NULL, 90000),
(1155, NULL, 90000),
(1156, NULL, 90000),
(1157, NULL, 90000),
(1158, NULL, 90000),
(1159, NULL, 90000),
(1160, NULL, 90000),
(1161, NULL, 120000),
(1162, NULL, 120000),
(1163, NULL, 120000),
(1164, NULL, 120000),
(1165, NULL, 120000),
(1166, NULL, 120000),
(1167, NULL, 120000),
(1168, NULL, 120000),
(1169, NULL, 120000),
(1170, NULL, 120000),
(1171, NULL, 100000),
(1172, NULL, 100000),
(1173, NULL, 100000),
(1174, NULL, 100000),
(1175, NULL, 100000),
(1176, NULL, 100000),
(1177, NULL, 100000),
(1178, NULL, 100000),
(1179, NULL, 100000),
(1180, NULL, 100000),
(1181, NULL, 100000),
(1182, NULL, 100000),
(1183, NULL, 100000),
(1184, NULL, 100000),
(1185, NULL, 100000),
(1186, NULL, 100000),
(1187, NULL, 100000),
(1188, NULL, 100000),
(1189, NULL, 100000),
(1190, NULL, 100000),
(1191, NULL, 100000),
(1192, NULL, 100000),
(1193, NULL, 100000),
(1194, NULL, 100000),
(1195, NULL, 100000),
(1196, NULL, 100000),
(1197, NULL, 100000),
(1198, NULL, 100000),
(1199, NULL, 100000),
(1200, NULL, 100000),
(1201, NULL, 100000),
(1202, NULL, 100000),
(1203, NULL, 100000),
(1204, NULL, 100000),
(1205, NULL, 100000),
(1206, NULL, 100000),
(1207, NULL, 100000),
(1208, NULL, 100000),
(1209, NULL, 100000),
(1210, NULL, 100000),
(1211, NULL, 100000),
(1212, NULL, 100000),
(1213, NULL, 100000),
(1214, NULL, 100000),
(1215, NULL, 100000),
(1216, NULL, 100000),
(1217, NULL, 100000),
(1218, NULL, 100000),
(1219, NULL, 100000),
(1220, NULL, 100000),
(1221, NULL, 100000),
(1222, NULL, 100000),
(1223, NULL, 100000),
(1224, NULL, 100000),
(1225, NULL, 100000),
(1226, NULL, 100000),
(1227, NULL, 100000),
(1228, NULL, 100000),
(1229, NULL, 100000),
(1230, NULL, 100000),
(1231, NULL, 100000),
(1232, NULL, 100000),
(1233, NULL, 100000),
(1234, NULL, 100000),
(1235, NULL, 100000),
(1236, NULL, 100000),
(1237, NULL, 100000),
(1238, NULL, 100000),
(1239, NULL, 100000),
(1240, NULL, 100000),
(1241, NULL, 100000),
(1242, NULL, 100000),
(1243, NULL, 100000),
(1244, NULL, 100000),
(1245, NULL, 100000),
(1246, NULL, 100000),
(1247, NULL, 100000),
(1248, NULL, 100000),
(1249, NULL, 100000),
(1250, NULL, 100000),
(1251, NULL, 130000),
(1252, NULL, 130000),
(1253, NULL, 130000),
(1254, NULL, 130000),
(1255, NULL, 130000),
(1256, NULL, 130000),
(1257, NULL, 130000),
(1258, NULL, 130000),
(1259, NULL, 130000),
(1260, NULL, 130000);

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
-- Đang đổ dữ liệu cho bảng `ticket_seat_schedule`
--

INSERT INTO `ticket_seat_schedule` (`SEAT_ID`, `SCHEDULE_ID`, `TICKET_ID`, `BOOKED`) VALUES
(1, 6, 361, 0),
(1, 7, 451, 0),
(1, 9, 541, 0),
(1, 14, 991, 0),
(1, 15, 1081, 0),
(2, 6, 362, 0),
(2, 7, 452, 0),
(2, 9, 542, 0),
(2, 14, 992, 0),
(2, 15, 1082, 0),
(3, 6, 363, 0),
(3, 7, 453, 0),
(3, 9, 543, 0),
(3, 14, 993, 0),
(3, 15, 1083, 0),
(4, 6, 364, 0),
(4, 7, 454, 0),
(4, 9, 544, 0),
(4, 14, 994, 0),
(4, 15, 1084, 0),
(5, 6, 365, 0),
(5, 7, 455, 0),
(5, 9, 545, 0),
(5, 14, 995, 0),
(5, 15, 1085, 0),
(6, 6, 366, 0),
(6, 7, 456, 0),
(6, 9, 546, 0),
(6, 14, 996, 0),
(6, 15, 1086, 0),
(7, 6, 367, 0),
(7, 7, 457, 0),
(7, 9, 547, 0),
(7, 14, 997, 0),
(7, 15, 1087, 0),
(8, 6, 368, 0),
(8, 7, 458, 0),
(8, 9, 548, 0),
(8, 14, 998, 0),
(8, 15, 1088, 0),
(9, 6, 369, 0),
(9, 7, 459, 0),
(9, 9, 549, 0),
(9, 14, 999, 0),
(9, 15, 1089, 0),
(10, 6, 370, 0),
(10, 7, 460, 0),
(10, 9, 550, 0),
(10, 14, 1000, 0),
(10, 15, 1090, 0),
(11, 6, 371, 0),
(11, 7, 461, 0),
(11, 9, 551, 0),
(11, 14, 1001, 0),
(11, 15, 1091, 0),
(12, 6, 372, 0),
(12, 7, 462, 0),
(12, 9, 552, 0),
(12, 14, 1002, 0),
(12, 15, 1092, 0),
(13, 6, 373, 0),
(13, 7, 463, 0),
(13, 9, 553, 0),
(13, 14, 1003, 0),
(13, 15, 1093, 0),
(14, 6, 374, 0),
(14, 7, 464, 0),
(14, 9, 554, 0),
(14, 14, 1004, 0),
(14, 15, 1094, 0),
(15, 6, 375, 0),
(15, 7, 465, 0),
(15, 9, 555, 0),
(15, 14, 1005, 0),
(15, 15, 1095, 0),
(16, 6, 376, 0),
(16, 7, 466, 0),
(16, 9, 556, 0),
(16, 14, 1006, 0),
(16, 15, 1096, 0),
(17, 6, 377, 0),
(17, 7, 467, 1),
(17, 9, 557, 1),
(17, 14, 1007, 1),
(17, 15, 1097, 0),
(18, 6, 378, 0),
(18, 7, 468, 0),
(18, 9, 558, 0),
(18, 14, 1008, 0),
(18, 15, 1098, 0),
(19, 6, 379, 0),
(19, 7, 469, 0),
(19, 9, 559, 0),
(19, 14, 1009, 0),
(19, 15, 1099, 0),
(20, 6, 380, 0),
(20, 7, 470, 0),
(20, 9, 560, 0),
(20, 14, 1010, 0),
(20, 15, 1100, 0),
(21, 6, 381, 0),
(21, 7, 471, 0),
(21, 9, 561, 0),
(21, 14, 1011, 0),
(21, 15, 1101, 0),
(22, 6, 382, 0),
(22, 7, 472, 0),
(22, 9, 562, 0),
(22, 14, 1012, 0),
(22, 15, 1102, 0),
(23, 6, 383, 0),
(23, 7, 473, 0),
(23, 9, 563, 0),
(23, 14, 1013, 0),
(23, 15, 1103, 0),
(24, 6, 384, 0),
(24, 7, 474, 0),
(24, 9, 564, 0),
(24, 14, 1014, 0),
(24, 15, 1104, 0),
(25, 6, 385, 1),
(25, 7, 475, 1),
(25, 9, 565, 0),
(25, 14, 1015, 0),
(25, 15, 1105, 0),
(26, 6, 386, 0),
(26, 7, 476, 0),
(26, 9, 566, 0),
(26, 14, 1016, 0),
(26, 15, 1106, 0),
(27, 6, 387, 0),
(27, 7, 477, 0),
(27, 9, 567, 0),
(27, 14, 1017, 0),
(27, 15, 1107, 0),
(28, 6, 388, 0),
(28, 7, 478, 0),
(28, 9, 568, 0),
(28, 14, 1018, 0),
(28, 15, 1108, 0),
(29, 6, 389, 0),
(29, 7, 479, 0),
(29, 9, 569, 0),
(29, 14, 1019, 0),
(29, 15, 1109, 0),
(30, 6, 390, 0),
(30, 7, 480, 0),
(30, 9, 570, 0),
(30, 14, 1020, 0),
(30, 15, 1110, 0),
(31, 6, 391, 0),
(31, 7, 481, 0),
(31, 9, 571, 1),
(31, 14, 1021, 0),
(31, 15, 1111, 0),
(32, 6, 392, 0),
(32, 7, 482, 0),
(32, 9, 572, 0),
(32, 14, 1022, 0),
(32, 15, 1112, 0),
(33, 6, 393, 0),
(33, 7, 483, 1),
(33, 9, 573, 0),
(33, 14, 1023, 0),
(33, 15, 1113, 0),
(34, 6, 394, 0),
(34, 7, 484, 0),
(34, 9, 574, 0),
(34, 14, 1024, 0),
(34, 15, 1114, 0),
(35, 6, 395, 0),
(35, 7, 485, 0),
(35, 9, 575, 0),
(35, 14, 1025, 0),
(35, 15, 1115, 0),
(36, 6, 396, 0),
(36, 7, 486, 0),
(36, 9, 576, 0),
(36, 14, 1026, 0),
(36, 15, 1116, 0),
(37, 6, 397, 0),
(37, 7, 487, 0),
(37, 9, 577, 0),
(37, 14, 1027, 0),
(37, 15, 1117, 0),
(38, 6, 398, 0),
(38, 7, 488, 0),
(38, 9, 578, 0),
(38, 14, 1028, 0),
(38, 15, 1118, 0),
(39, 6, 399, 0),
(39, 7, 489, 0),
(39, 9, 579, 0),
(39, 14, 1029, 0),
(39, 15, 1119, 0),
(40, 6, 400, 0),
(40, 7, 490, 0),
(40, 9, 580, 0),
(40, 14, 1030, 0),
(40, 15, 1120, 0),
(41, 6, 401, 0),
(41, 7, 491, 1),
(41, 9, 581, 0),
(41, 14, 1031, 0),
(41, 15, 1121, 0),
(42, 6, 402, 0),
(42, 7, 492, 0),
(42, 9, 582, 0),
(42, 14, 1032, 0),
(42, 15, 1122, 0),
(43, 6, 403, 0),
(43, 7, 493, 0),
(43, 9, 583, 0),
(43, 14, 1033, 0),
(43, 15, 1123, 0),
(44, 6, 404, 0),
(44, 7, 494, 0),
(44, 9, 584, 0),
(44, 14, 1034, 0),
(44, 15, 1124, 0),
(45, 6, 405, 0),
(45, 7, 495, 0),
(45, 9, 585, 0),
(45, 14, 1035, 0),
(45, 15, 1125, 0),
(46, 6, 406, 0),
(46, 7, 496, 0),
(46, 9, 586, 0),
(46, 14, 1036, 0),
(46, 15, 1126, 0),
(47, 6, 407, 0),
(47, 7, 497, 0),
(47, 9, 587, 0),
(47, 14, 1037, 0),
(47, 15, 1127, 0),
(48, 6, 408, 0),
(48, 7, 498, 0),
(48, 9, 588, 0),
(48, 14, 1038, 0),
(48, 15, 1128, 0),
(49, 6, 409, 0),
(49, 7, 499, 0),
(49, 9, 589, 0),
(49, 14, 1039, 0),
(49, 15, 1129, 0),
(50, 6, 410, 0),
(50, 7, 500, 0),
(50, 9, 590, 0),
(50, 14, 1040, 0),
(50, 15, 1130, 0),
(51, 6, 411, 0),
(51, 7, 501, 0),
(51, 9, 591, 0),
(51, 14, 1041, 0),
(51, 15, 1131, 0),
(52, 6, 412, 0),
(52, 7, 502, 0),
(52, 9, 592, 0),
(52, 14, 1042, 0),
(52, 15, 1132, 0),
(53, 6, 413, 0),
(53, 7, 503, 0),
(53, 9, 593, 0),
(53, 14, 1043, 0),
(53, 15, 1133, 0),
(54, 6, 414, 0),
(54, 7, 504, 0),
(54, 9, 594, 0),
(54, 14, 1044, 0),
(54, 15, 1134, 0),
(55, 6, 415, 0),
(55, 7, 505, 0),
(55, 9, 595, 0),
(55, 14, 1045, 0),
(55, 15, 1135, 0),
(56, 6, 416, 0),
(56, 7, 506, 0),
(56, 9, 596, 0),
(56, 14, 1046, 0),
(56, 15, 1136, 0),
(57, 6, 417, 0),
(57, 7, 507, 0),
(57, 9, 597, 0),
(57, 14, 1047, 0),
(57, 15, 1137, 0),
(58, 6, 418, 0),
(58, 7, 508, 0),
(58, 9, 598, 0),
(58, 14, 1048, 0),
(58, 15, 1138, 0),
(59, 6, 419, 0),
(59, 7, 509, 0),
(59, 9, 599, 0),
(59, 14, 1049, 0),
(59, 15, 1139, 0),
(60, 6, 420, 0),
(60, 7, 510, 0),
(60, 9, 600, 0),
(60, 14, 1050, 0),
(60, 15, 1140, 0),
(61, 6, 421, 0),
(61, 7, 511, 0),
(61, 9, 601, 0),
(61, 14, 1051, 0),
(61, 15, 1141, 0),
(62, 6, 422, 0),
(62, 7, 512, 0),
(62, 9, 602, 0),
(62, 14, 1052, 0),
(62, 15, 1142, 0),
(63, 6, 423, 0),
(63, 7, 513, 0),
(63, 9, 603, 0),
(63, 14, 1053, 0),
(63, 15, 1143, 0),
(64, 6, 424, 0),
(64, 7, 514, 0),
(64, 9, 604, 0),
(64, 14, 1054, 0),
(64, 15, 1144, 0),
(65, 6, 425, 0),
(65, 7, 515, 0),
(65, 9, 605, 0),
(65, 14, 1055, 0),
(65, 15, 1145, 0),
(66, 6, 426, 0),
(66, 7, 516, 0),
(66, 9, 606, 0),
(66, 14, 1056, 0),
(66, 15, 1146, 0),
(67, 6, 427, 0),
(67, 7, 517, 0),
(67, 9, 607, 0),
(67, 14, 1057, 0),
(67, 15, 1147, 0),
(68, 6, 428, 0),
(68, 7, 518, 0),
(68, 9, 608, 0),
(68, 14, 1058, 0),
(68, 15, 1148, 0),
(69, 6, 429, 0),
(69, 7, 519, 0),
(69, 9, 609, 0),
(69, 14, 1059, 0),
(69, 15, 1149, 0),
(70, 6, 430, 0),
(70, 7, 520, 0),
(70, 9, 610, 0),
(70, 14, 1060, 0),
(70, 15, 1150, 0),
(71, 6, 431, 0),
(71, 7, 521, 0),
(71, 9, 611, 0),
(71, 14, 1061, 0),
(71, 15, 1151, 0),
(72, 6, 432, 0),
(72, 7, 522, 0),
(72, 9, 612, 0),
(72, 14, 1062, 0),
(72, 15, 1152, 0),
(73, 6, 433, 0),
(73, 7, 523, 0),
(73, 9, 613, 0),
(73, 14, 1063, 0),
(73, 15, 1153, 0),
(74, 6, 434, 0),
(74, 7, 524, 0),
(74, 9, 614, 0),
(74, 14, 1064, 0),
(74, 15, 1154, 0),
(75, 6, 435, 0),
(75, 7, 525, 0),
(75, 9, 615, 0),
(75, 14, 1065, 0),
(75, 15, 1155, 0),
(76, 6, 436, 0),
(76, 7, 526, 0),
(76, 9, 616, 0),
(76, 14, 1066, 0),
(76, 15, 1156, 0),
(77, 6, 437, 0),
(77, 7, 527, 0),
(77, 9, 617, 0),
(77, 14, 1067, 0),
(77, 15, 1157, 0),
(78, 6, 438, 0),
(78, 7, 528, 0),
(78, 9, 618, 0),
(78, 14, 1068, 0),
(78, 15, 1158, 0),
(79, 6, 439, 0),
(79, 7, 529, 0),
(79, 9, 619, 0),
(79, 14, 1069, 0),
(79, 15, 1159, 0),
(80, 6, 440, 0),
(80, 7, 530, 0),
(80, 9, 620, 0),
(80, 14, 1070, 0),
(80, 15, 1160, 0),
(81, 6, 441, 0),
(81, 7, 531, 0),
(81, 9, 621, 0),
(81, 14, 1071, 0),
(81, 15, 1161, 0),
(82, 6, 442, 0),
(82, 7, 532, 0),
(82, 9, 622, 0),
(82, 14, 1072, 0),
(82, 15, 1162, 0),
(83, 6, 443, 0),
(83, 7, 533, 1),
(83, 9, 623, 0),
(83, 14, 1073, 1),
(83, 15, 1163, 0),
(84, 6, 444, 0),
(84, 7, 534, 0),
(84, 9, 624, 0),
(84, 14, 1074, 0),
(84, 15, 1164, 0),
(85, 6, 445, 0),
(85, 7, 535, 0),
(85, 9, 625, 0),
(85, 14, 1075, 0),
(85, 15, 1165, 0),
(86, 6, 446, 0),
(86, 7, 536, 0),
(86, 9, 626, 0),
(86, 14, 1076, 0),
(86, 15, 1166, 0),
(87, 6, 447, 0),
(87, 7, 537, 0),
(87, 9, 627, 0),
(87, 14, 1077, 0),
(87, 15, 1167, 0),
(88, 6, 448, 0),
(88, 7, 538, 0),
(88, 9, 628, 0),
(88, 14, 1078, 0),
(88, 15, 1168, 0),
(89, 6, 449, 0),
(89, 7, 539, 0),
(89, 9, 629, 0),
(89, 14, 1079, 0),
(89, 15, 1169, 0),
(90, 6, 450, 0),
(90, 7, 540, 0),
(90, 9, 630, 0),
(90, 14, 1080, 0),
(90, 15, 1170, 0),
(91, 10, 631, 0),
(92, 10, 632, 0),
(93, 10, 633, 0),
(94, 10, 634, 0),
(95, 10, 635, 0),
(96, 10, 636, 0),
(97, 10, 637, 0),
(98, 10, 638, 0),
(99, 10, 639, 0),
(100, 10, 640, 0),
(101, 10, 641, 0),
(102, 10, 642, 0),
(103, 10, 643, 0),
(104, 10, 644, 0),
(105, 10, 645, 0),
(106, 10, 646, 0),
(107, 10, 647, 0),
(108, 10, 648, 0),
(109, 10, 649, 0),
(110, 10, 650, 0),
(111, 10, 651, 0),
(112, 10, 652, 0),
(113, 10, 653, 0),
(114, 10, 654, 0),
(115, 10, 655, 0),
(116, 10, 656, 0),
(117, 10, 657, 0),
(118, 10, 658, 0),
(119, 10, 659, 0),
(120, 10, 660, 0),
(121, 10, 661, 0),
(122, 10, 662, 0),
(123, 10, 663, 0),
(124, 10, 664, 0),
(125, 10, 665, 0),
(126, 10, 666, 0),
(127, 10, 667, 0),
(128, 10, 668, 0),
(129, 10, 669, 0),
(130, 10, 670, 0),
(131, 10, 671, 0),
(132, 10, 672, 0),
(133, 10, 673, 0),
(134, 10, 674, 0),
(135, 10, 675, 0),
(136, 10, 676, 0),
(137, 10, 677, 0),
(138, 10, 678, 0),
(139, 10, 679, 0),
(140, 10, 680, 0),
(141, 10, 681, 0),
(142, 10, 682, 0),
(143, 10, 683, 0),
(144, 10, 684, 0),
(145, 10, 685, 0),
(146, 10, 686, 0),
(147, 10, 687, 0),
(148, 10, 688, 0),
(149, 10, 689, 0),
(150, 10, 690, 0),
(151, 10, 691, 0),
(152, 10, 692, 0),
(153, 10, 693, 0),
(154, 10, 694, 0),
(155, 10, 695, 0),
(156, 10, 696, 0),
(157, 10, 697, 0),
(158, 10, 698, 0),
(159, 10, 699, 0),
(160, 10, 700, 0),
(161, 10, 701, 0),
(162, 10, 702, 0),
(163, 10, 703, 0),
(164, 10, 704, 0),
(165, 10, 705, 0),
(166, 10, 706, 0),
(167, 10, 707, 0),
(168, 10, 708, 0),
(169, 10, 709, 0),
(170, 10, 710, 0),
(171, 10, 711, 0),
(172, 10, 712, 0),
(173, 10, 713, 0),
(174, 10, 714, 0),
(175, 10, 715, 0),
(176, 10, 716, 0),
(177, 10, 717, 0),
(178, 10, 718, 0),
(179, 10, 719, 0),
(180, 10, 720, 0),
(181, 11, 721, 0),
(182, 11, 722, 0),
(183, 11, 723, 0),
(184, 11, 724, 0),
(185, 11, 725, 0),
(186, 11, 726, 0),
(187, 11, 727, 0),
(188, 11, 728, 0),
(189, 11, 729, 0),
(190, 11, 730, 0),
(191, 11, 731, 0),
(192, 11, 732, 0),
(193, 11, 733, 0),
(194, 11, 734, 0),
(195, 11, 735, 0),
(196, 11, 736, 0),
(197, 11, 737, 0),
(198, 11, 738, 0),
(199, 11, 739, 0),
(200, 11, 740, 0),
(201, 11, 741, 0),
(202, 11, 742, 0),
(203, 11, 743, 0),
(204, 11, 744, 0),
(205, 11, 745, 0),
(206, 11, 746, 0),
(207, 11, 747, 0),
(208, 11, 748, 0),
(209, 11, 749, 0),
(210, 11, 750, 0),
(211, 11, 751, 0),
(212, 11, 752, 0),
(213, 11, 753, 0),
(214, 11, 754, 0),
(215, 11, 755, 0),
(216, 11, 756, 0),
(217, 11, 757, 0),
(218, 11, 758, 0),
(219, 11, 759, 0),
(220, 11, 760, 0),
(221, 11, 761, 0),
(222, 11, 762, 0),
(223, 11, 763, 0),
(224, 11, 764, 0),
(225, 11, 765, 0),
(226, 11, 766, 0),
(227, 11, 767, 0),
(228, 11, 768, 0),
(229, 11, 769, 0),
(230, 11, 770, 0),
(231, 11, 771, 0),
(232, 11, 772, 0),
(233, 11, 773, 0),
(234, 11, 774, 0),
(235, 11, 775, 0),
(236, 11, 776, 0),
(237, 11, 777, 0),
(238, 11, 778, 0),
(239, 11, 779, 0),
(240, 11, 780, 0),
(241, 11, 781, 0),
(242, 11, 782, 0),
(243, 11, 783, 0),
(244, 11, 784, 0),
(245, 11, 785, 0),
(246, 11, 786, 0),
(247, 11, 787, 0),
(248, 11, 788, 0),
(249, 11, 789, 0),
(250, 11, 790, 0),
(251, 11, 791, 0),
(252, 11, 792, 0),
(253, 11, 793, 0),
(254, 11, 794, 0),
(255, 11, 795, 0),
(256, 11, 796, 0),
(257, 11, 797, 0),
(258, 11, 798, 0),
(259, 11, 799, 0),
(260, 11, 800, 0),
(261, 11, 801, 0),
(262, 11, 802, 0),
(263, 11, 803, 0),
(264, 11, 804, 0),
(265, 11, 805, 0),
(266, 11, 806, 0),
(267, 11, 807, 0),
(268, 11, 808, 0),
(269, 11, 809, 0),
(270, 11, 810, 0),
(271, 12, 811, 0),
(271, 13, 901, 0),
(272, 12, 812, 0),
(272, 13, 902, 0),
(273, 12, 813, 0),
(273, 13, 903, 0),
(274, 12, 814, 0),
(274, 13, 904, 0),
(275, 12, 815, 0),
(275, 13, 905, 0),
(276, 12, 816, 0),
(276, 13, 906, 0),
(277, 12, 817, 0),
(277, 13, 907, 0),
(278, 12, 818, 0),
(278, 13, 908, 0),
(279, 12, 819, 0),
(279, 13, 909, 0),
(280, 12, 820, 0),
(280, 13, 910, 0),
(281, 12, 821, 0),
(281, 13, 911, 0),
(282, 12, 822, 0),
(282, 13, 912, 0),
(283, 12, 823, 0),
(283, 13, 913, 0),
(284, 12, 824, 0),
(284, 13, 914, 0),
(285, 12, 825, 0),
(285, 13, 915, 0),
(286, 12, 826, 0),
(286, 13, 916, 0),
(287, 12, 827, 0),
(287, 13, 917, 1),
(288, 12, 828, 0),
(288, 13, 918, 0),
(289, 12, 829, 0),
(289, 13, 919, 0),
(290, 12, 830, 0),
(290, 13, 920, 0),
(291, 12, 831, 0),
(291, 13, 921, 0),
(292, 12, 832, 0),
(292, 13, 922, 0),
(293, 12, 833, 0),
(293, 13, 923, 0),
(294, 12, 834, 0),
(294, 13, 924, 0),
(295, 12, 835, 0),
(295, 13, 925, 1),
(296, 12, 836, 0),
(296, 13, 926, 0),
(297, 12, 837, 0),
(297, 13, 927, 0),
(298, 12, 838, 0),
(298, 13, 928, 0),
(299, 12, 839, 0),
(299, 13, 929, 0),
(300, 12, 840, 0),
(300, 13, 930, 0),
(301, 12, 841, 0),
(301, 13, 931, 0),
(302, 12, 842, 0),
(302, 13, 932, 0),
(303, 12, 843, 0),
(303, 13, 933, 0),
(304, 12, 844, 0),
(304, 13, 934, 0),
(305, 12, 845, 0),
(305, 13, 935, 0),
(306, 12, 846, 0),
(306, 13, 936, 0),
(307, 12, 847, 0),
(307, 13, 937, 0),
(308, 12, 848, 0),
(308, 13, 938, 0),
(309, 12, 849, 0),
(309, 13, 939, 0),
(310, 12, 850, 0),
(310, 13, 940, 0),
(311, 12, 851, 0),
(311, 13, 941, 0),
(312, 12, 852, 0),
(312, 13, 942, 0),
(313, 12, 853, 0),
(313, 13, 943, 0),
(314, 12, 854, 0),
(314, 13, 944, 0),
(315, 12, 855, 0),
(315, 13, 945, 0),
(316, 12, 856, 0),
(316, 13, 946, 0),
(317, 12, 857, 0),
(317, 13, 947, 0),
(318, 12, 858, 0),
(318, 13, 948, 0),
(319, 12, 859, 0),
(319, 13, 949, 0),
(320, 12, 860, 0),
(320, 13, 950, 0),
(321, 12, 861, 0),
(321, 13, 951, 0),
(322, 12, 862, 0),
(322, 13, 952, 0),
(323, 12, 863, 0),
(323, 13, 953, 0),
(324, 12, 864, 0),
(324, 13, 954, 0),
(325, 12, 865, 0),
(325, 13, 955, 0),
(326, 12, 866, 0),
(326, 13, 956, 0),
(327, 12, 867, 0),
(327, 13, 957, 0),
(328, 12, 868, 0),
(328, 13, 958, 0),
(329, 12, 869, 0),
(329, 13, 959, 0),
(330, 12, 870, 0),
(330, 13, 960, 0),
(331, 12, 871, 0),
(331, 13, 961, 0),
(332, 12, 872, 0),
(332, 13, 962, 0),
(333, 12, 873, 0),
(333, 13, 963, 0),
(334, 12, 874, 0),
(334, 13, 964, 0),
(335, 12, 875, 0),
(335, 13, 965, 0),
(336, 12, 876, 0),
(336, 13, 966, 0),
(337, 12, 877, 0),
(337, 13, 967, 0),
(338, 12, 878, 0),
(338, 13, 968, 0),
(339, 12, 879, 0),
(339, 13, 969, 0),
(340, 12, 880, 0),
(340, 13, 970, 0),
(341, 12, 881, 0),
(341, 13, 971, 0),
(342, 12, 882, 0),
(342, 13, 972, 0),
(343, 12, 883, 0),
(343, 13, 973, 0),
(344, 12, 884, 0),
(344, 13, 974, 0),
(345, 12, 885, 0),
(345, 13, 975, 0),
(346, 12, 886, 0),
(346, 13, 976, 0),
(347, 12, 887, 0),
(347, 13, 977, 0),
(348, 12, 888, 0),
(348, 13, 978, 0),
(349, 12, 889, 0),
(349, 13, 979, 0),
(350, 12, 890, 0),
(350, 13, 980, 0),
(351, 12, 891, 0),
(351, 13, 981, 0),
(352, 12, 892, 0),
(352, 13, 982, 0),
(353, 12, 893, 0),
(353, 13, 983, 1),
(354, 12, 894, 0),
(354, 13, 984, 0),
(355, 12, 895, 0),
(355, 13, 985, 1),
(356, 12, 896, 0),
(356, 13, 986, 0),
(357, 12, 897, 0),
(357, 13, 987, 0),
(358, 12, 898, 0),
(358, 13, 988, 0),
(359, 12, 899, 0),
(359, 13, 989, 0),
(360, 12, 900, 0),
(360, 13, 990, 0),
(361, 16, 1171, 0),
(362, 16, 1172, 0),
(363, 16, 1173, 0),
(364, 16, 1174, 0),
(365, 16, 1175, 0),
(366, 16, 1176, 0),
(367, 16, 1177, 0),
(368, 16, 1178, 0),
(369, 16, 1179, 0),
(370, 16, 1180, 0),
(371, 16, 1181, 0),
(372, 16, 1182, 0),
(373, 16, 1183, 0),
(374, 16, 1184, 0),
(375, 16, 1185, 0),
(376, 16, 1186, 0),
(377, 16, 1187, 0),
(378, 16, 1188, 0),
(379, 16, 1189, 0),
(380, 16, 1190, 0),
(381, 16, 1191, 0),
(382, 16, 1192, 0),
(383, 16, 1193, 0),
(384, 16, 1194, 0),
(385, 16, 1195, 0),
(386, 16, 1196, 0),
(387, 16, 1197, 0),
(388, 16, 1198, 0),
(389, 16, 1199, 0),
(390, 16, 1200, 0),
(391, 16, 1201, 0),
(392, 16, 1202, 0),
(393, 16, 1203, 0),
(394, 16, 1204, 0),
(395, 16, 1205, 0),
(396, 16, 1206, 0),
(397, 16, 1207, 0),
(398, 16, 1208, 0),
(399, 16, 1209, 0),
(400, 16, 1210, 0),
(401, 16, 1211, 0),
(402, 16, 1212, 0),
(403, 16, 1213, 0),
(404, 16, 1214, 0),
(405, 16, 1215, 0),
(406, 16, 1216, 0),
(407, 16, 1217, 0),
(408, 16, 1218, 0),
(409, 16, 1219, 0),
(410, 16, 1220, 0),
(411, 16, 1221, 0),
(412, 16, 1222, 0),
(413, 16, 1223, 0),
(414, 16, 1224, 0),
(415, 16, 1225, 0),
(416, 16, 1226, 0),
(417, 16, 1227, 0),
(418, 16, 1228, 0),
(419, 16, 1229, 0),
(420, 16, 1230, 0),
(421, 16, 1231, 0),
(422, 16, 1232, 0),
(423, 16, 1233, 0),
(424, 16, 1234, 0),
(425, 16, 1235, 0),
(426, 16, 1236, 0),
(427, 16, 1237, 0),
(428, 16, 1238, 0),
(429, 16, 1239, 0),
(430, 16, 1240, 0),
(431, 16, 1241, 0),
(432, 16, 1242, 0),
(433, 16, 1243, 0),
(434, 16, 1244, 0),
(435, 16, 1245, 0),
(436, 16, 1246, 0),
(437, 16, 1247, 0),
(438, 16, 1248, 0),
(439, 16, 1249, 0),
(440, 16, 1250, 0),
(441, 16, 1251, 0),
(442, 16, 1252, 0),
(443, 16, 1253, 0),
(444, 16, 1254, 0),
(445, 16, 1255, 0),
(446, 16, 1256, 0),
(447, 16, 1257, 0),
(448, 16, 1258, 0),
(449, 16, 1259, 0),
(450, 16, 1260, 0);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `cinema`
--
ALTER TABLE `cinema`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `foodcombo`
--
ALTER TABLE `foodcombo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `seat`
--
ALTER TABLE `seat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT cho bảng `showroom`
--
ALTER TABLE `showroom`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1261;

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
