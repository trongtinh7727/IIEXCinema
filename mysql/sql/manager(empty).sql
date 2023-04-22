-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 22, 2023 lúc 03:53 AM
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

--
-- Đang đổ dữ liệu cho bảng `movie`
--

INSERT INTO `movie` (`ID`, `TITLE`, `DIRECTOR`, `ACTORS`, `GENRE`, `DURATION`, `RATING`, `STORY`, `POSTER`, `TRAILER`, `OPENING_DAY`, `CLOSING_DAY`) VALUES
(1, 'MARRY MY DEAD ', 'Wei Hao Cheng', 'Greg Han Hsu, Gingle Wang', 'Drama', 130, 5, 'Ming-Han, một sĩ quan cảnh sát nhiệt huyết, trong quá trình truy bắt tội phạm đã tìm thấy một phong bì cưới màu đỏ và chủ nhân của nó là hồn ma Mao-Mao với nguyện vọng phải được kết hôn với một sĩ quan cảnh sát trước khi tái sinh...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002654?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-07', '2023-06-20'),
(2, 'ASSASSIN CLUB', 'Camille Delamarre', 'Henry Golding, Noomi Repace', 'Action', 109, 5, 'Bảy tên sát thủ vô tình bị thiết lập trong một trò chơi sống còn. Morgan Gaines- một sát thủ chuyên nghiệp có nhiệm vụ phải giết bảy người,Morgan phát hiện ra bảy \"mục tiêu\" cũng là bảy sát thủ nặng ký. Lối thoát duy nhất cho Morgan là tìm ra kẻ chủ mưu..', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002661?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/usYcScx3yMk', '2023-04-07', '2023-06-20'),
(3, 'THE SUPER MARIO BROS. MOVIE', 'Aaron Horvath', 'Chris Pratt, Anya Taylor-Joy', 'Animation', 93, 5, 'Theo chân anh chàng thợ sửa ống nước tên Mario cùng công chúa Peach của Vương quốc Nấm trong cuộc phiêu lưu giải cứu anh trai Luigi đang bị bắt cóc và ngăn chặn tên độc tài Bowser, kẻ đang âm mưu thôn tính thế giới', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002631?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/wODah30-agA', '2023-04-07', '2023-06-20'),
(4, 'YOU & ME & ME ', 'Waew Waewwan Hongvivatana', 'Baipor Thitiya Jirapornsilp, Tony Anthony Buisseret', 'Drama', 121, 5, 'Hai chị em sinh đôi \"You\" và \"Me\"có ngoại hình và sở thích giống hệt nhau,thân thiết đến mức họ có thể chia sẻ mọi khía cạnh trong cuộc sống,cho đến khi một cậu bé - \"mối tình đầu\" của họ xuất hiện và đặt ra những thử thách khó khăn cho mối quan hệ của họ', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002669?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-07', '2023-06-20'),
(5, 'PULAU ', 'Eu  Ho', 'Amelia Henderson, Alif Satar', 'Horror', 112, 5, 'Kỳ nghỉ của nhóm bạn trẻ biến thành cơn ác mộng kinh hoàng sau khi họ thua một cuộc cá cược,họ buộc phải qua đêm tại một đảo hoang, khi tình cờ đến một ngôi làng bị bỏ hoang bí ẩn ở đó, họ đã phá vỡ câu thần chú cũ được đặt để kiềm chế một linh hồn tàn ác', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002673?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-31', '2023-06-20'),
(6, 'BIỆT ĐỘI RẤT ỔN', 'Tạ Nguyên Hiệp', 'Võ Tấn Phát, Hoàng  Oanh', 'Comedy', 104, 5, 'Xoay quanh bộ đôi Khuê và Phong. Sau lần chạm trán tình cờ, bộ đôi lôi kéo gia đình Bảy Cục tham gia vào phi vụ đặc biệt: Đánh tráo chiếc vòng đính hôn bằng kim cương quí giá và lật tẩy bộ mặt thật của Tuấn-chồng cũ của Khuê...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002633?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/6qZbBiL65cI', '2023-03-31', '2023-06-20'),
(7, 'THE ONE', 'Dmitriy Suvorov', 'Nadezhda Kaleganova, Viktor Dobronravov', 'Drama', 96, 5, 'Cặp vợ chồng mới cưới Larisa và Vladimir trở về nhà từ tuần trăng mật ở Blagoveshchensk và bị va chạm máy bay, Larisa phải vật lộn với cái đói cái lạnh và động vật hoang dã săn mồi. Liệu Larisa có tìm được vị hôn phu và cùng sống sót trở về ?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002580?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-31', '2023-06-20'),
(8, 'SOULMATE', 'Young-Keun Min', 'Kim Da-Mi, Woo-Seok Byeon', 'Drama', 124, 5, 'Mi So và Ha Eun trong một mối quan hệ chồng chéo chất chứa những hạnh phúc, rung động và biệt ly. Từ giây phút gặp nhau , hai cô gái đã hình thành sợi dây liên kết đặc biệt nhưng mối quan hệ của họ rạn nứt khi một chàng trai xuất hiện...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002611?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/pGAFcV97dpw', '2023-03-24', '2023-06-20'),
(9, 'NHỮNG ĐỨA TRẺ TRONG SƯƠNG', 'Hà Lệ Diễm', 'Má Thị Di', 'Documentary', 93, 5, 'Di, một cô gái trẻ nhiệt huyết đến từ cộng đồng người Mông bị mắc kẹt giữa truyền thống \"kéo vợ\" và mong muốn được tiếp tục sống thời thơ ấu và đến trường đi học , liệu với trái tim trong sáng ấy , Di sẽ đối diện với xã hội ấy như thế nào...?\r\n', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002676?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-03-17', '2023-06-20'),
(10, 'SIÊU LỪA GẶP SIÊU LẦY', 'Võ Thanh Hòa', 'Mạc Văn Khoa, Anh Tú', 'Comedy', 112, 5, 'Khoa, một tên lừa đảo tới Phú Quốc với mục tiêu đổi đời. Không ngờ đây là sân nhà của Tú, một tên lừa đảo chuyên nghiệp, cả hai bắt tay cùng thực hiện một phi vụ siêu lớn và mục tiêu là các quý bà giàu có và đam mê sự nổi tiếng', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002593?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/xy8RznX_uyM', '2023-03-03', '2023-06-20'),
(11, 'AIR', 'Ben  Affleck', 'Viola Davis', 'Drama', 112, 5, 'Bí mật trong mối quan hệ hợp tác lịch sử giữa Nike và một vận động viên bóng rổ vĩ đại.Cả hai đã cho ra mắt thương hiệu Air Jordan đình đám và theo chân Sonny Vaccaro- saleman của Nike trong hành trình tiếp cận và đánh cược cả sự nghiệp vào Michael Jordan', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002670?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(12, 'CHUYỆN XÓM TUI : CON NHÓT MÓT CHỒNG', 'Vũ  Ngọc Đãng', 'Thái Hòa, Thu  Trang', '', 100, 5, 'Là câu chuyện của Nhót - Người phụ nữ \"chưa kịp già\" đã sắp bị mãn kinh, vội vàng đi tìm chồng. Nhưng sâu thẳm trong cô là khao khát muốn có một đứa con và luôn muốn hàn gắn với người cha suốt ngày say xỉn của mình', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002650?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/qehxOMR-rFQ', '2023-04-28', '2023-06-20'),
(13, 'DUNGEONS & DRAGONS: HONOR AMONG THIEVES ', 'John Francis Daley', 'Chris Pine, Michelle Rodriguez', 'Adventure', 134, 5, 'Theo chân một tên trộm quyến rũ và một nhóm những kẻ bịp bợm nghiệp dư thực hiện vụ trộm sử thi nhằm lấy lại một di vật đã mất, nhưng mọi thứ trở nên nguy hiểm khó lường hơn bao giờ hết khi họ đã chạm trám nhầm người...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002629?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/iTZJ-uwIZxg', '2023-04-21', '2023-06-20'),
(14, 'ELEMENTAL', 'Peter Sohn', 'Leah Lewis, Mamoudou Athie', 'Animation', 93, 5, 'Ember, một cô nàng cá tính, thông minh, mạnh mẽ và đầy sức hút. Tuy nhiên mối quan hệ của cô với Wade- một anh chàng hài hước, luôn thuận thế đẩy dòng - khiến Ember cảm thấy ngờ vực với thế giới này...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002677?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/K19bf6ButD4', '2023-06-16', '2023-06-20'),
(15, 'GUARDIANS OF THE GALAXY 3', 'James  Gunn', 'Chris  Pratt, Zoe Saldana', 'Adventure', 119, 5, 'Cho dù vũ trụ này có bao la đến đâu, các Vệ Binh của chúng ta cũng không thể trốn chạy mãi mãi...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002647?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=Pp6reH8bpZ8', '2023-05-03', '2023-06-20'),
(16, 'LẬT MẶT 6', 'Lý  Hải', 'Duy Khánh, Quốc Cường', 'Action', 132, 5, 'Nhóm bạn thân lâu năm bất ngờ nhận được cơ hội đổi đời khi biết tấm vé của cả nhóm trúng giải độc đắc 136.8 tỷ. Đột nhiên An,người giữ tấm vé bất ngờ qua đời, liệu trong hành trình tìm kiếm và chia chác món tiền trong mơ béo bở này sẽ đưa cả nhóm đến đâu?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002653?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=tpjjd7usfnA', '2023-04-28', '2023-06-20'),
(17, 'MY BEAUTIFUL MAN MOVIE: SPECIAL EDITION', '', 'Riku Hagiwara, Yusei Yagi', 'Drama', 98, 5, 'Hira, 17 tuổi, cố gắng ẩn mình ở trường, không bao giờ muốn phơi bày tật nói lắp của mình với các bạn cùng lớp. Anh ấy nhìn thế giới qua ống kính máy ảnh của mình, cho đến một ngày Kiyoi Sou bước qua cửa lớp...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002651?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(18, 'RENFIELD', 'Chris McKay', 'Nicolas  Cage, Nicholas Hoult', 'Horror', 95, 5, 'Renfield bị buộc phải bắt con mồi về cho chủ nhân và thực hiện mọi mệnh lệnh, kể cả những việc nhục nhã. Nhưng giờ đây, sau nhiều thế kỷ làm nô lệ, Renfield đã sẵn sàng để khám phá cuộc sống bên ngoài cái bóng của Hoàng Tử Bóng Đêm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002656?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=_hO0vGwqClM', '2023-04-14', '2023-06-20'),
(19, 'SOUND OF SILENCE', 'Alessandro Antonaci', 'Daniel Lascar', 'Horror', 93, 5, 'Trở về nhà sau mất mát của cha mẹ, Emma vô tình giải phóng những linh hồn quá khứ mắc kẹt trong chiếc radio cổ. Vô số câu chuyện bí ẩn lần lượt được vạch trần, liệu Emma sẽ tỉnh táo đối mặt hay cô sẽ bị nhấn chìm bởi quỹ dữ ?', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002666?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-21', '2023-06-20'),
(20, 'THE FLASH ', 'Andy  Muschietti', 'Ben  Affleck, Michael Shannon', 'Action', 120, 5, 'Mùa hè này, đa thế giới sẽ va chạm khốc liệt với những bước chạy của FLASH', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002648?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=uXhf8LJq55Q', '2023-06-16', '2023-06-20'),
(21, 'THE GHOST WITHIN', 'Lawrence Fowler', 'Michaela Longden, Rebecca Phillipson', 'Horror', 103, 5, 'Bí ẩn về cái chết của em gái Evie 20 năm trước, vào lúc 09:09 hằng đêm, hàng loạt cuộc chạm trán kinh hoàng xảy ra. Liệu Margot có biết được sự thật ai là kẻ giết em gái mình?\r\n', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002674?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=p_Ppe-2_Vh8', '2023-04-14', '2023-06-20'),
(22, 'TRANSFORMERS: RISE OF THE BEASTS', 'Steven Caple Jr.', 'Michelle Yeoh, Dominique Fishback', 'Action', 112, 5, 'Bộ phim dựa trên sự kiện Beast Wars trong loạt phim hoạt hình \"Transformers\", nơi mà các robot có khả năng biến thành động vật khổng lồ cùng chiến đấu chống lại một mối đe dọa tiềm tàng', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002678?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/watch?v=gR2pkm9XVAY', '2023-06-09', '2023-06-20'),
(23, 'THE POPES EXORCIST', 'Julius Avery', 'Russell Crowe, Daniel Zovatto', 'Horror', 104, 5, 'Từ những hồ sơ có thật của Cha Gabriele Amorth, Trưởng Trừ Tà của Vatican, \"The Popes Exorcist\" theo chân Amorth trong cuộc điều tra về vụ quỷ ám kinh hoàng của một cậu bé và dần khám phá ra những bí mật hàng thế kỉ mà Vatican đã cố giấu kín...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002665?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/S2kymv60ndQ', '2023-04-14', '2023-06-20'),
(24, 'NGƯỜI GIỮ THỜI GIAN : TRI ÂM ', 'MỸ TÂM', 'Ca sĩ Mỹ Tâm', 'Musical', 106, NULL, 'Mỹ Tâm sẽ phác họa chân thực toàn bộ những diễn biến tâm lý và cảm xúc thăng trầm cùng những thăng hoa trong suốt quá trình thực hiện Liveshow \"Tri Âm\" lịch sử bằng những thước phim quý giá được quay lại trong 2 năm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002663?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/8BdO_M8bUZo', '2023-04-08', '2023-06-20');

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

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `SALARY`, `ROLE`) VALUES
(1, 'admin', '123456', 'Võ Trọng', 'Tình', 'nam', '2003-02-28', '0843221054', '476 Lê Văn Lương, Quận 7, TP Hồ Chí Minh', 50000, 0);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
