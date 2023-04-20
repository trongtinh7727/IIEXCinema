-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 08:29 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iiex_cinema`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_schedule` (IN `p_theaterID` INT, IN `p_movieID` INT, IN `p_startTime` DATETIME, IN `p_endTime` DATETIME, IN `p_price` DOUBLE)   BEGIN	
Select THEATER.SEATCOUNT Into @seatCount from THEATER where ID =  p_theaterID;
	INSERT INTO `SCHEDULE`
           (`THEA_ID`
           ,`MOV_ID`
           ,`STARTTIME`
           ,`ENDTIME`)
     VALUES
           (p_theaterID
           ,p_movieID
           ,p_startTime
           ,p_endTime);

    SELECT MIN(SEAT.ID) INTO @counter from SEAT JOIN THEATER ON THEATER.ID = SEAT.THE_ID 
    WHERE THEATER.ID = p_theaterID
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_theater` (IN `theater_num` INT)   BEGIN
  -- Tạo rạp chiếu phim mới
  INSERT INTO `theater` (`THEATERNUM`, `SEATCOUNT`, `ISSHOWING`)
  VALUES (theater_num, 90, 0);

  -- Lấy ID của rạp chiếu phim mới
  SET @theater_id = LAST_INSERT_ID();

  -- Tạo các ghế Standard trong rạp chiếu phim    
	SET @letters = 'ABCDEFGH';
	SET @number = 1;
    WHILE @number <= 10 DO
        SET @letter_index = 1;
        WHILE @letter_index <= LENGTH(@letters) DO
            SET @letter = SUBSTRING(@letters, @letter_index, 1);
            INSERT INTO `seat` (`THE_ID`, `SEATNUMBER`, `SEATTYPE`)
            VALUES (@theater_id, CONCAT(@letter, @number), 'Standard');
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
            VALUES (@theater_id, CONCAT(@letter, @number), 'Couple');
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
    `iiex_cinema`.`foodcombo`.`ID` AS `ID`,
    `iiex_cinema`.`foodcombo`.`NAME` AS `NAME`,
    MAX(
        CASE WHEN `iiex_cinema`.`product`.`TYPE` = 'Đồ ăn' THEN `iiex_cinema`.`product`.`NAME` ELSE NULL
    END
) AS `TenDoAn`,
GROUP_CONCAT(
    CASE WHEN `iiex_cinema`.`product`.`TYPE` = 'Đồ ăn' THEN `iiex_cinema`.`product_fcb`.`QUANTITY` ELSE NULL
END SEPARATOR ','
) AS `QuantityDoAn`,
MAX(
    CASE WHEN `iiex_cinema`.`product`.`TYPE` = 'Đồ uống' THEN `iiex_cinema`.`product`.`NAME` ELSE NULL
END
) AS `TenDoUong`,
GROUP_CONCAT(
    CASE WHEN `iiex_cinema`.`product`.`TYPE` = 'Đồ uống' THEN `iiex_cinema`.`product_fcb`.`QUANTITY` ELSE NULL
END SEPARATOR ','
) AS `QuantityDoUong`,
`iiex_cinema`.`foodcombo`.`PRICE` AS `PRICE`,
foodcombo.Image
FROM
    (
        (
            `iiex_cinema`.`foodcombo`
        JOIN `iiex_cinema`.`product_fcb` ON
            (
                `iiex_cinema`.`foodcombo`.`ID` = `iiex_cinema`.`product_fcb`.`FCB_ID`
            )
        )
    JOIN `iiex_cinema`.`product` ON
        (
            `iiex_cinema`.`product`.`ID` = `iiex_cinema`.`product_fcb`.`PRODUCT_ID`
        )
    )
GROUP BY
    `iiex_cinema`.`foodcombo`.`NAME`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_revenue_of_month` (IN `month_value` DATE)   SELECT
    DATE(booking.CREATED_AT) AS order_date,
    SUM(booking.FOOD_PRICE+booking.TICKET_PRICE) AS total_price
FROM
    booking
WHERE
    MONTH(booking.CREATED_AT) = MONTH(month_value)  AND YEAR(booking.CREATED_AT) = YEAR(month_value)
GROUP BY
    date(booking.CREATED_AT)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_by_id` (IN `schedule_id` INT(1))   SELECT movie.TITLE,movie.POSTER,movie.TRAILER, schedule.STARTTIME, theater.THEATERNUM, ticket.price
FROM movie, schedule, theater, ticket, ticket_seat_schedule
WHERE movie.ID = schedule.MOV_ID
AND schedule.THEA_ID = theater.ID
AND ticket.ID = ticket_seat_schedule.TICKET_ID
AND schedule.ID = ticket_seat_schedule.SCHEDULE_ID
AND schedule.ID = schedule_id
GROUP BY schedule.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_by_theater` (IN `theater_id` INT)   SELECT movie.TITLE, movie.DURATION,schedule.* ,  theater.SEATCOUNT, COUNT(ticket_seat_schedule.TICKET_ID) AS EMPTYSEAT
FROM schedule, theater, ticket_seat_schedule, movie
WHERE schedule.THEA_ID = theater.ID
AND schedule.ID = ticket_seat_schedule.SCHEDULE_ID
AND movie.ID = schedule.MOV_ID
AND ticket_seat_schedule.BOOKED  = 0
AND theater.ID = theater_id
GROUP BY schedule.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_today` ()   SELECT schedule.ID,movie.ID as MID, movie.TITLE, movie.POSTER, movie.STORY, GROUP_CONCAT(TIME(schedule.STARTTIME)) AS TIME, DATE(schedule.STARTTIME) as DAY FROM schedule JOIN movie ON movie.ID = schedule.MOV_ID WHERE now()< schedule.STARTTIME AND DATE(now()) = DATE(schedule.STARTTIME) GROUP BY MID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_trailers` ()   SELECT id, trailer FROM movie WHERE LENGTH(trailer) > 1 LIMIT 10$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transactions` ()   SELECT 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `isValidSchedule` (IN `stime` DATETIME, IN `theater_num` INT)   SELECT * FROM `schedule` 
WHERE stime BETWEEN STARTTIME AND ENDTIME 
AND THEA_ID = theater_num$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ongoing_movies` ()   SELECT * FROM movie
WHERE CURDATE() BETWEEN OPENING_DAY AND CLOSING_DAY
ORDER by OPENING_DAY ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upcoming_movies` ()   SELECT * FROM movie WHERE opening_day > CURDATE() ORDER BY opening_day ASC LIMIT 10$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `FOOD_PRICE` float NOT NULL DEFAULT 0,
  `TICKET_PRICE` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`ID`, `CLIENT_ID`, `CREATED_AT`, `FOOD_PRICE`, `TICKET_PRICE`) VALUES
(1, 1, '2023-04-19 17:20:13', 0, 300000),
(2, 1, '2023-04-19 17:21:39', 260000, 270000),
(3, 1, '2023-04-19 18:27:03', 130000, 180000),
(4, 1, '2023-04-19 18:37:30', 130000, 90000),
(5, 1, '2023-04-20 01:24:23', 100000, 90000),
(6, 1, '2023-04-21 01:15:33', 300000, 390000);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(20) DEFAULT NULL,
  `SEX` varchar(5) DEFAULT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `PHONE` char(15) DEFAULT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `ROLE` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `ROLE`) VALUES
(1, 'user', '123456', 'Võ', 'Trọng Tình', 'nam', '2004-04-09', '0843206397', 'Q7, Thành phố Hồ Chí minh', 2);

-- --------------------------------------------------------

--
-- Table structure for table `foodcombo`
--

CREATE TABLE `foodcombo` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `PRICE` float DEFAULT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foodcombo`
--

INSERT INTO `foodcombo` (`ID`, `NAME`, `PRICE`, `Image`) VALUES
(1, 'Không', 0, ''),
(2, '1 Bắp + 2 nước', 100000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg'),
(3, '2 Bắp + 2 nước', 130000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg'),
(4, '2 bắp + 1 nước', 100000, '../assets/uploads/foodcombofoodcombo644030eda59132.59667657.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `food_booking`
--

CREATE TABLE `food_booking` (
  `FOOD_ID` int(11) NOT NULL,
  `BOOKING_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_booking`
--

INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`, `QUANTITY`) VALUES
(1, 1, 0),
(2, 6, 1),
(3, 2, 2),
(3, 3, 1),
(3, 4, 1),
(4, 5, 1),
(4, 6, 2);

--
-- Triggers `food_booking`
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
CREATE TRIGGER `insert_food_booking` AFTER INSERT ON `food_booking` FOR EACH ROW UPDATE booking
SET booking.FOOD_PRICE = (SELECT SUM(foodcombo.PRICE*food_booking.QUANTITY) 
FROM foodcombo, food_booking
WHERE food_booking.FOOD_ID = foodcombo.ID
AND food_booking.BOOKING_ID =New.BOOKING_ID)
WHERE booking.ID = New.BOOKING_ID
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
-- Table structure for table `movie`
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
-- Dumping data for table `movie`
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
(63, 'NGƯỜI GIỮ THỜI GIAN : TRI ÂM ', 'MỸ TÂM', 'Ca sĩ Mỹ Tâm', 'Musical', 106, NULL, 'Mỹ Tâm sẽ phác họa chân thực toàn bộ những diễn biến tâm lý và cảm xúc thăng trầm cùng những thăng hoa trong suốt quá trình thực hiện Liveshow \"Tri Âm\" lịch sử bằng những thước phim quý giá được quay lại trong 2 năm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002663?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/8BdO_M8bUZo', '2023-04-08', '2023-06-20'),
(66, 'ádsada', 'sdasd', 'ádasd', 'ádasd', 0, NULL, 'ádad', '../assets/uploads/movie/movie64416ba636d2f7.72965157.jpg', '0', '2023-04-13', '2023-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `TYPE` varchar(20) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `NAME`, `TYPE`, `QUANTITY`, `Expiry_Date`) VALUES
(6, 'Bắp rang bơ L1', 'Đồ ăn', 1000, '2023-04-30'),
(8, 'Coca cola', 'Đồ uống', 1000, '2023-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `product_fcb`
--

CREATE TABLE `product_fcb` (
  `PRODUCT_ID` int(11) NOT NULL,
  `FCB_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_fcb`
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
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `MOV_ID` int(11) NOT NULL,
  `STARTTIME` datetime DEFAULT NULL,
  `ENDTIME` datetime DEFAULT NULL,
  `THEA_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `MOV_ID`, `STARTTIME`, `ENDTIME`, `THEA_ID`) VALUES
(6, 47, '2023-04-20 12:19:00', '2023-04-20 14:26:00', 5),
(7, 47, '2023-04-22 06:20:00', '2023-04-22 08:27:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `ID` int(11) NOT NULL,
  `THE_ID` int(11) NOT NULL,
  `SEATNUMBER` varchar(3) DEFAULT NULL,
  `SEATTYPE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
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
(90, 5, 'J5', 'Couple');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
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
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`ID`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `SEX`, `BIRTHDAY`, `PHONE`, `ADDRESS`, `SALARY`, `ROLE`) VALUES
(1, 'admin', 'admin', 'Lê Hoàng', 'Phú', 'nam', '2003-02-02', '0123456789', 'Quận 7', 50000, 0),
(5, 'staff1', 'Admin@123', 'Võ Trọng', 'Tình', 'nam', '2003-08-20', '084320639458', 'Quận 7, TP Hồ Chí Minh', 5000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `ID` int(11) NOT NULL,
  `THEATERNUM` int(11) UNSIGNED DEFAULT NULL,
  `SEATCOUNT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`ID`, `THEATERNUM`, `SEATCOUNT`) VALUES
(5, 1, 90);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ID` int(11) NOT NULL,
  `BOO_ID` int(11) DEFAULT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
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
(491, NULL, 90000),
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
(540, NULL, 120000);

--
-- Triggers `ticket`
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
-- Table structure for table `ticket_seat_schedule`
--

CREATE TABLE `ticket_seat_schedule` (
  `SEAT_ID` int(11) NOT NULL,
  `SCHEDULE_ID` int(11) NOT NULL,
  `TICKET_ID` int(11) NOT NULL,
  `BOOKED` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_seat_schedule`
--

INSERT INTO `ticket_seat_schedule` (`SEAT_ID`, `SCHEDULE_ID`, `TICKET_ID`, `BOOKED`) VALUES
(1, 6, 361, 0),
(1, 7, 451, 0),
(2, 6, 362, 0),
(2, 7, 452, 0),
(3, 6, 363, 0),
(3, 7, 453, 0),
(4, 6, 364, 0),
(4, 7, 454, 0),
(5, 6, 365, 0),
(5, 7, 455, 0),
(6, 6, 366, 0),
(6, 7, 456, 0),
(7, 6, 367, 0),
(7, 7, 457, 0),
(8, 6, 368, 0),
(8, 7, 458, 0),
(9, 6, 369, 0),
(9, 7, 459, 0),
(10, 6, 370, 0),
(10, 7, 460, 0),
(11, 6, 371, 0),
(11, 7, 461, 0),
(12, 6, 372, 0),
(12, 7, 462, 0),
(13, 6, 373, 0),
(13, 7, 463, 0),
(14, 6, 374, 0),
(14, 7, 464, 0),
(15, 6, 375, 0),
(15, 7, 465, 0),
(16, 6, 376, 0),
(16, 7, 466, 0),
(17, 6, 377, 0),
(17, 7, 467, 1),
(18, 6, 378, 0),
(18, 7, 468, 0),
(19, 6, 379, 0),
(19, 7, 469, 0),
(20, 6, 380, 0),
(20, 7, 470, 0),
(21, 6, 381, 0),
(21, 7, 471, 0),
(22, 6, 382, 0),
(22, 7, 472, 0),
(23, 6, 383, 0),
(23, 7, 473, 0),
(24, 6, 384, 0),
(24, 7, 474, 0),
(25, 6, 385, 1),
(25, 7, 475, 1),
(26, 6, 386, 0),
(26, 7, 476, 0),
(27, 6, 387, 0),
(27, 7, 477, 0),
(28, 6, 388, 0),
(28, 7, 478, 0),
(29, 6, 389, 0),
(29, 7, 479, 0),
(30, 6, 390, 0),
(30, 7, 480, 0),
(31, 6, 391, 0),
(31, 7, 481, 0),
(32, 6, 392, 0),
(32, 7, 482, 0),
(33, 6, 393, 0),
(33, 7, 483, 1),
(34, 6, 394, 0),
(34, 7, 484, 0),
(35, 6, 395, 0),
(35, 7, 485, 0),
(36, 6, 396, 0),
(36, 7, 486, 0),
(37, 6, 397, 0),
(37, 7, 487, 0),
(38, 6, 398, 0),
(38, 7, 488, 0),
(39, 6, 399, 0),
(39, 7, 489, 0),
(40, 6, 400, 0),
(40, 7, 490, 0),
(41, 6, 401, 0),
(41, 7, 491, 0),
(42, 6, 402, 0),
(42, 7, 492, 0),
(43, 6, 403, 0),
(43, 7, 493, 0),
(44, 6, 404, 0),
(44, 7, 494, 0),
(45, 6, 405, 0),
(45, 7, 495, 0),
(46, 6, 406, 0),
(46, 7, 496, 0),
(47, 6, 407, 0),
(47, 7, 497, 0),
(48, 6, 408, 0),
(48, 7, 498, 0),
(49, 6, 409, 0),
(49, 7, 499, 0),
(50, 6, 410, 0),
(50, 7, 500, 0),
(51, 6, 411, 0),
(51, 7, 501, 0),
(52, 6, 412, 0),
(52, 7, 502, 0),
(53, 6, 413, 0),
(53, 7, 503, 0),
(54, 6, 414, 0),
(54, 7, 504, 0),
(55, 6, 415, 0),
(55, 7, 505, 0),
(56, 6, 416, 0),
(56, 7, 506, 0),
(57, 6, 417, 0),
(57, 7, 507, 0),
(58, 6, 418, 0),
(58, 7, 508, 0),
(59, 6, 419, 0),
(59, 7, 509, 0),
(60, 6, 420, 0),
(60, 7, 510, 0),
(61, 6, 421, 0),
(61, 7, 511, 0),
(62, 6, 422, 0),
(62, 7, 512, 0),
(63, 6, 423, 0),
(63, 7, 513, 0),
(64, 6, 424, 0),
(64, 7, 514, 0),
(65, 6, 425, 0),
(65, 7, 515, 0),
(66, 6, 426, 0),
(66, 7, 516, 0),
(67, 6, 427, 0),
(67, 7, 517, 0),
(68, 6, 428, 0),
(68, 7, 518, 0),
(69, 6, 429, 0),
(69, 7, 519, 0),
(70, 6, 430, 0),
(70, 7, 520, 0),
(71, 6, 431, 0),
(71, 7, 521, 0),
(72, 6, 432, 0),
(72, 7, 522, 0),
(73, 6, 433, 0),
(73, 7, 523, 0),
(74, 6, 434, 0),
(74, 7, 524, 0),
(75, 6, 435, 0),
(75, 7, 525, 0),
(76, 6, 436, 0),
(76, 7, 526, 0),
(77, 6, 437, 0),
(77, 7, 527, 0),
(78, 6, 438, 0),
(78, 7, 528, 0),
(79, 6, 439, 0),
(79, 7, 529, 0),
(80, 6, 440, 0),
(80, 7, 530, 0),
(81, 6, 441, 0),
(81, 7, 531, 0),
(82, 6, 442, 0),
(82, 7, 532, 0),
(83, 6, 443, 0),
(83, 7, 533, 1),
(84, 6, 444, 0),
(84, 7, 534, 0),
(85, 6, 445, 0),
(85, 7, 535, 0),
(86, 6, 446, 0),
(86, 7, 536, 0),
(87, 6, 447, 0),
(87, 7, 537, 0),
(88, 6, 448, 0),
(88, 7, 538, 0),
(89, 6, 449, 0),
(89, 7, 539, 0),
(90, 6, 450, 0),
(90, 7, 540, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_BOOKING_CLIENT` (`CLIENT_ID`);

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
  ADD KEY `FK_BOOKING_FOOD` (`BOOKING_ID`);

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
  ADD KEY `FK_FCB_PRODUCT` (`FCB_ID`),
  ADD KEY `FK_PRODUCT_FCB` (`PRODUCT_ID`);

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
  ADD PRIMARY KEY (`SEAT_ID`,`SCHEDULE_ID`,`TICKET_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foodcombo`
--
ALTER TABLE `foodcombo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_BOOKING_CLIENT` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`);

--
-- Constraints for table `food_booking`
--
ALTER TABLE `food_booking`
  ADD CONSTRAINT `FK_BOOKING_FOOD` FOREIGN KEY (`BOOKING_ID`) REFERENCES `booking` (`ID`),
  ADD CONSTRAINT `FK_FOOD_BOOKING` FOREIGN KEY (`FOOD_ID`) REFERENCES `foodcombo` (`ID`);

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
  ADD CONSTRAINT `FK_SCHEDULE_MOVIE` FOREIGN KEY (`MOV_ID`) REFERENCES `movie` (`ID`),
  ADD CONSTRAINT `FK_SCHEDULE_THEATER` FOREIGN KEY (`THEA_ID`) REFERENCES `theater` (`ID`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `FK_SEAT_THEATER` FOREIGN KEY (`THE_ID`) REFERENCES `theater` (`ID`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_TICKET_BOOKING` FOREIGN KEY (`BOO_ID`) REFERENCES `booking` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
