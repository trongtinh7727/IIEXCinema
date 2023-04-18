-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 11:04 AM
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

	WHILE @counter < @seatCount
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_theater` (IN `theater_num` INT, IN `seat_count` INT)   BEGIN
  -- Tạo rạp chiếu phim mới
  INSERT INTO `theater` (`THEATERNUM`, `SEATCOUNT`, `ISSHOWING`)
  VALUES (theater_num, seat_count, 0);

  -- Lấy ID của rạp chiếu phim mới
  SET @theater_id = LAST_INSERT_ID();

  -- Tạo các ghế Standard trong rạp chiếu phim
  SET @Standard_count = FLOOR(seat_count / 3);
  SET @Standard_count = @Standard_count + @Standard_count;
  SET @seat_num = 1;
  WHILE @seat_num <= @Standard_count DO
    INSERT INTO `seat` (`THE_ID`, `SEATNUMBER`, `SEATTYPE`)
    VALUES (@theater_id, @seat_num, 'Standard');
    SET @seat_num = @seat_num + 1;
  END WHILE;

  -- Tạo các ghế Couple trong rạp chiếu phim
  SET @couple_count = FLOOR(seat_count / 3);
  SET @couple_seat_num = seat_count - @couple_count + 1;
  WHILE @couple_seat_num <= seat_count DO
    INSERT INTO `seat` (`THE_ID`, `SEATNUMBER`, `SEATTYPE`)
    VALUES (@theater_id, @couple_seat_num, 'Couple');
    SET @couple_seat_num = @couple_seat_num + 1;
  END WHILE;
END$$

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
`iiex_cinema`.`foodcombo`.`PRICE` AS `PRICE`
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_schedule_by_id` (IN `schedule_id` INT)   SELECT movie.TITLE,movie.POSTER,movie.TRAILER, schedule.STARTTIME, theater.THEATERNUM, ticket.price
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_transactions` ()   SELECT client.USERNAME, client.FIRSTNAME, client.LASTNAME, client.PHONE, client.ADDRESS,movie.TITLE,schedule.STARTTIME, schedule.ENDTIME, GROUP_CONCAT(seat.SEATNUMBER) as Seats, SUM(ticket.price) AS ticketPrice, foodcombo.NAME as Food, foodcombo.PRICE, SUM(ticket.price) + foodcombo.PRICE as Total FROM `booking`, client, ticket, ticket_seat_schedule, schedule, seat, movie, food_booking, foodcombo 
WHERE client.ID = booking.CLIENT_ID 
AND ticket.BOO_ID = booking.ID 
AND ticket_seat_schedule.TICKET_ID = ticket.ID 
AND schedule.ID = ticket_seat_schedule.SCHEDULE_ID 
AND seat.ID = ticket_seat_schedule.SEAT_ID 
AND movie.ID = schedule.MOV_ID 
AND food_booking.FOOD_ID = foodcombo.ID 
AND booking.ID = food_booking.BOOKING_ID
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
  `STAFF_ID` int(11) DEFAULT NULL,
  `CLIENT_ID` int(11) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`ID`, `STAFF_ID`, `CLIENT_ID`, `CREATED_AT`) VALUES
(2, 1, 1, '2023-04-17 16:37:42');

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
-- Stand-in structure for view `fcb_detail`
-- (See below for the actual view)
--
CREATE TABLE `fcb_detail` (
`ID` int(11)
,`NAME` varchar(50)
,`TenDoAn` varchar(50)
,`QuantityDoAn` mediumtext
,`TenDoUong` varchar(50)
,`QuantityDoUong` mediumtext
,`PRICE` float
);

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
(6, '2 Bắp 2 Nước', 145000, 'https://www.cgv.vn/media/concession/web/63aaa2d81b6bf_1672127192.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_booking`
--

CREATE TABLE `food_booking` (
  `FOOD_ID` int(11) NOT NULL,
  `BOOKING_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_booking`
--

INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`) VALUES
(6, 2);

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
(63, 'NGƯỜI GIỮ THỜI GIAN : TRI ÂM ', 'MỸ TÂM', 'Ca sĩ Mỹ Tâm', 'Musical', 106, NULL, 'Mỹ Tâm sẽ phác họa chân thực toàn bộ những diễn biến tâm lý và cảm xúc thăng trầm cùng những thăng hoa trong suốt quá trình thực hiện Liveshow \"Tri Âm\" lịch sử bằng những thước phim quý giá được quay lại trong 2 năm...', 'http://booking.bhdstar.vn/CDN/media/entity/get/FilmPosterGraphic/HO00002663?referenceScheme=HeadOffice&allowPlaceHolder=true&height=500', 'https://www.youtube.com/embed/8BdO_M8bUZo', '2023-04-08', '2023-06-20');

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
(6, 6, 2),
(8, 6, 2);

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
(1, 43, '2023-04-15 17:03:00', '2023-04-15 19:02:00', 1),
(2, 47, '2023-04-15 16:00:00', '2023-04-15 18:07:00', 2),
(3, 47, '2023-04-15 08:00:00', '2023-04-15 10:07:00', 2),
(4, 43, '2023-04-14 10:30:00', '2023-04-14 12:29:00', 2),
(5, 39, '2023-04-14 13:30:00', '2023-04-14 15:34:00', 2),
(6, 39, '2023-04-14 13:30:00', '2023-04-14 15:34:00', 1),
(8, 46, '2023-04-14 20:30:00', '2023-04-14 22:18:00', 3),
(10, 47, '2023-04-14 17:01:00', '2023-04-14 19:08:00', 2),
(11, 60, '2023-04-14 16:02:00', '2023-04-14 18:00:00', 1),
(12, 43, '2023-04-16 15:45:00', '2023-04-16 17:44:00', 1),
(13, 47, '2023-04-17 21:00:00', '2023-04-17 23:07:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `ID` int(11) NOT NULL,
  `THE_ID` int(11) NOT NULL,
  `SEATNUMBER` int(11) DEFAULT NULL,
  `SEATTYPE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`ID`, `THE_ID`, `SEATNUMBER`, `SEATTYPE`) VALUES
(1, 1, 1, 'Standard'),
(2, 1, 2, 'Standard'),
(3, 1, 3, 'Standard'),
(4, 1, 4, 'Standard'),
(5, 1, 5, 'Standard'),
(6, 1, 6, 'Standard'),
(7, 1, 7, 'Standard'),
(8, 1, 8, 'Standard'),
(9, 1, 9, 'Standard'),
(10, 1, 10, 'Standard'),
(11, 1, 11, 'Standard'),
(12, 1, 12, 'Standard'),
(13, 1, 13, 'Standard'),
(14, 1, 14, 'Standard'),
(15, 1, 15, 'Standard'),
(16, 1, 16, 'Standard'),
(17, 1, 17, 'Standard'),
(18, 1, 18, 'Standard'),
(19, 1, 19, 'Standard'),
(20, 1, 20, 'Standard'),
(21, 1, 21, 'Standard'),
(22, 1, 22, 'Standard'),
(23, 1, 23, 'Standard'),
(24, 1, 24, 'Standard'),
(25, 1, 25, 'Standard'),
(26, 1, 26, 'Standard'),
(27, 1, 27, 'Standard'),
(28, 1, 28, 'Standard'),
(29, 1, 29, 'Standard'),
(30, 1, 30, 'Standard'),
(31, 1, 31, 'Standard'),
(32, 1, 32, 'Standard'),
(33, 1, 33, 'Standard'),
(34, 1, 34, 'Standard'),
(35, 1, 35, 'Standard'),
(36, 1, 36, 'Standard'),
(37, 1, 37, 'Standard'),
(38, 1, 38, 'Standard'),
(39, 1, 39, 'Standard'),
(40, 1, 40, 'Standard'),
(41, 1, 41, 'Standard'),
(42, 1, 42, 'Standard'),
(43, 1, 43, 'Standard'),
(44, 1, 44, 'Standard'),
(45, 1, 45, 'Standard'),
(46, 1, 46, 'Standard'),
(47, 1, 47, 'Standard'),
(48, 1, 48, 'Standard'),
(49, 1, 49, 'Standard'),
(50, 1, 50, 'Standard'),
(51, 1, 51, 'Standard'),
(52, 1, 52, 'Standard'),
(53, 1, 53, 'Standard'),
(54, 1, 54, 'Standard'),
(55, 1, 55, 'Standard'),
(56, 1, 56, 'Standard'),
(57, 1, 57, 'Standard'),
(58, 1, 58, 'Standard'),
(59, 1, 59, 'Standard'),
(60, 1, 60, 'Standard'),
(61, 1, 41, 'Couple'),
(62, 1, 42, 'Couple'),
(63, 1, 43, 'Couple'),
(64, 1, 44, 'Couple'),
(65, 1, 45, 'Couple'),
(66, 1, 46, 'Couple'),
(67, 1, 47, 'Couple'),
(68, 1, 48, 'Couple'),
(69, 1, 49, 'Couple'),
(70, 1, 50, 'Couple'),
(71, 1, 51, 'Couple'),
(72, 1, 52, 'Couple'),
(73, 1, 53, 'Couple'),
(74, 1, 54, 'Couple'),
(75, 1, 55, 'Couple'),
(76, 1, 56, 'Couple'),
(77, 1, 57, 'Couple'),
(78, 1, 58, 'Couple'),
(79, 1, 59, 'Couple'),
(80, 1, 60, 'Couple'),
(81, 2, 1, 'Standard'),
(82, 2, 2, 'Standard'),
(83, 2, 3, 'Standard'),
(84, 2, 4, 'Standard'),
(85, 2, 5, 'Standard'),
(86, 2, 6, 'Standard'),
(87, 2, 7, 'Standard'),
(88, 2, 8, 'Standard'),
(89, 2, 9, 'Standard'),
(90, 2, 10, 'Standard'),
(91, 2, 11, 'Standard'),
(92, 2, 12, 'Standard'),
(93, 2, 13, 'Standard'),
(94, 2, 14, 'Standard'),
(95, 2, 15, 'Standard'),
(96, 2, 16, 'Standard'),
(97, 2, 17, 'Standard'),
(98, 2, 18, 'Standard'),
(99, 2, 19, 'Standard'),
(100, 2, 20, 'Standard'),
(101, 2, 21, 'Standard'),
(102, 2, 22, 'Standard'),
(103, 2, 23, 'Standard'),
(104, 2, 24, 'Standard'),
(105, 2, 25, 'Standard'),
(106, 2, 26, 'Standard'),
(107, 2, 27, 'Standard'),
(108, 2, 28, 'Standard'),
(109, 2, 29, 'Standard'),
(110, 2, 30, 'Standard'),
(111, 2, 31, 'Standard'),
(112, 2, 32, 'Standard'),
(113, 2, 33, 'Standard'),
(114, 2, 34, 'Standard'),
(115, 2, 35, 'Standard'),
(116, 2, 36, 'Standard'),
(117, 2, 37, 'Standard'),
(118, 2, 38, 'Standard'),
(119, 2, 39, 'Standard'),
(120, 2, 40, 'Standard'),
(121, 2, 41, 'Standard'),
(122, 2, 42, 'Standard'),
(123, 2, 43, 'Standard'),
(124, 2, 44, 'Standard'),
(125, 2, 45, 'Standard'),
(126, 2, 46, 'Standard'),
(127, 2, 47, 'Standard'),
(128, 2, 48, 'Standard'),
(129, 2, 49, 'Standard'),
(130, 2, 50, 'Standard'),
(131, 2, 51, 'Standard'),
(132, 2, 52, 'Standard'),
(133, 2, 53, 'Standard'),
(134, 2, 54, 'Standard'),
(135, 2, 55, 'Standard'),
(136, 2, 56, 'Standard'),
(137, 2, 57, 'Standard'),
(138, 2, 58, 'Standard'),
(139, 2, 59, 'Standard'),
(140, 2, 60, 'Standard'),
(141, 2, 41, 'Couple'),
(142, 2, 42, 'Couple'),
(143, 2, 43, 'Couple'),
(144, 2, 44, 'Couple'),
(145, 2, 45, 'Couple'),
(146, 2, 46, 'Couple'),
(147, 2, 47, 'Couple'),
(148, 2, 48, 'Couple'),
(149, 2, 49, 'Couple'),
(150, 2, 50, 'Couple'),
(151, 2, 51, 'Couple'),
(152, 2, 52, 'Couple'),
(153, 2, 53, 'Couple'),
(154, 2, 54, 'Couple'),
(155, 2, 55, 'Couple'),
(156, 2, 56, 'Couple'),
(157, 2, 57, 'Couple'),
(158, 2, 58, 'Couple'),
(159, 2, 59, 'Couple'),
(160, 2, 60, 'Couple'),
(161, 3, 1, 'Standard'),
(162, 3, 2, 'Standard'),
(163, 3, 3, 'Standard'),
(164, 3, 4, 'Standard'),
(165, 3, 5, 'Standard'),
(166, 3, 6, 'Standard'),
(167, 3, 7, 'Standard'),
(168, 3, 8, 'Standard'),
(169, 3, 9, 'Standard'),
(170, 3, 10, 'Standard'),
(171, 3, 11, 'Standard'),
(172, 3, 12, 'Standard'),
(173, 3, 13, 'Standard'),
(174, 3, 14, 'Standard'),
(175, 3, 15, 'Standard'),
(176, 3, 16, 'Standard'),
(177, 3, 17, 'Standard'),
(178, 3, 18, 'Standard'),
(179, 3, 19, 'Standard'),
(180, 3, 20, 'Standard'),
(181, 3, 21, 'Standard'),
(182, 3, 22, 'Standard'),
(183, 3, 23, 'Standard'),
(184, 3, 24, 'Standard'),
(185, 3, 25, 'Standard'),
(186, 3, 26, 'Standard'),
(187, 3, 27, 'Standard'),
(188, 3, 28, 'Standard'),
(189, 3, 29, 'Standard'),
(190, 3, 30, 'Standard'),
(191, 3, 31, 'Standard'),
(192, 3, 32, 'Standard'),
(193, 3, 33, 'Standard'),
(194, 3, 34, 'Standard'),
(195, 3, 35, 'Standard'),
(196, 3, 36, 'Standard'),
(197, 3, 37, 'Standard'),
(198, 3, 38, 'Standard'),
(199, 3, 39, 'Standard'),
(200, 3, 40, 'Standard'),
(201, 3, 41, 'Standard'),
(202, 3, 42, 'Standard'),
(203, 3, 43, 'Standard'),
(204, 3, 44, 'Standard'),
(205, 3, 45, 'Standard'),
(206, 3, 46, 'Standard'),
(207, 3, 47, 'Standard'),
(208, 3, 48, 'Standard'),
(209, 3, 49, 'Standard'),
(210, 3, 50, 'Standard'),
(211, 3, 51, 'Standard'),
(212, 3, 52, 'Standard'),
(213, 3, 53, 'Standard'),
(214, 3, 54, 'Standard'),
(215, 3, 55, 'Standard'),
(216, 3, 56, 'Standard'),
(217, 3, 57, 'Standard'),
(218, 3, 58, 'Standard'),
(219, 3, 59, 'Standard'),
(220, 3, 60, 'Standard'),
(221, 3, 61, 'Standard'),
(222, 3, 62, 'Standard'),
(223, 3, 63, 'Standard'),
(224, 3, 64, 'Standard'),
(225, 3, 65, 'Standard'),
(226, 3, 66, 'Standard'),
(227, 3, 67, 'Standard'),
(228, 3, 68, 'Standard'),
(229, 3, 69, 'Standard'),
(230, 3, 70, 'Standard'),
(231, 3, 71, 'Standard'),
(232, 3, 72, 'Standard'),
(233, 3, 73, 'Standard'),
(234, 3, 74, 'Standard'),
(235, 3, 75, 'Standard'),
(236, 3, 76, 'Standard'),
(237, 3, 77, 'Standard'),
(238, 3, 78, 'Standard'),
(239, 3, 79, 'Standard'),
(240, 3, 80, 'Standard'),
(241, 3, 81, 'Standard'),
(242, 3, 82, 'Standard'),
(243, 3, 83, 'Standard'),
(244, 3, 84, 'Standard'),
(245, 3, 85, 'Standard'),
(246, 3, 86, 'Standard'),
(247, 3, 87, 'Standard'),
(248, 3, 88, 'Standard'),
(249, 3, 89, 'Standard'),
(250, 3, 90, 'Standard'),
(251, 3, 91, 'Standard'),
(252, 3, 92, 'Standard'),
(253, 3, 93, 'Standard'),
(254, 3, 94, 'Standard'),
(255, 3, 95, 'Standard'),
(256, 3, 65, 'Couple'),
(257, 3, 66, 'Couple'),
(258, 3, 67, 'Couple'),
(259, 3, 68, 'Couple'),
(260, 3, 69, 'Couple'),
(261, 3, 70, 'Couple'),
(262, 3, 71, 'Couple'),
(263, 3, 72, 'Couple'),
(264, 3, 73, 'Couple'),
(265, 3, 74, 'Couple'),
(266, 3, 75, 'Couple'),
(267, 3, 76, 'Couple'),
(268, 3, 77, 'Couple'),
(269, 3, 78, 'Couple'),
(270, 3, 79, 'Couple'),
(271, 3, 80, 'Couple'),
(272, 3, 81, 'Couple'),
(273, 3, 82, 'Couple'),
(274, 3, 83, 'Couple'),
(275, 3, 84, 'Couple'),
(276, 3, 85, 'Couple'),
(277, 3, 86, 'Couple'),
(278, 3, 87, 'Couple'),
(279, 3, 88, 'Couple'),
(280, 3, 89, 'Couple'),
(281, 3, 90, 'Couple'),
(282, 3, 91, 'Couple'),
(283, 3, 92, 'Couple'),
(284, 3, 93, 'Couple'),
(285, 3, 94, 'Couple'),
(286, 3, 95, 'Couple'),
(287, 4, 1, 'Standard'),
(288, 4, 2, 'Standard'),
(289, 4, 3, 'Standard'),
(290, 4, 4, 'Standard'),
(291, 4, 5, 'Standard'),
(292, 4, 6, 'Standard'),
(293, 4, 7, 'Standard'),
(294, 4, 8, 'Standard'),
(295, 4, 9, 'Standard'),
(296, 4, 10, 'Standard'),
(297, 4, 11, 'Standard'),
(298, 4, 12, 'Standard'),
(299, 4, 13, 'Standard'),
(300, 4, 14, 'Standard'),
(301, 4, 15, 'Standard'),
(302, 4, 16, 'Standard'),
(303, 4, 17, 'Standard'),
(304, 4, 18, 'Standard'),
(305, 4, 19, 'Standard'),
(306, 4, 20, 'Standard'),
(307, 4, 21, 'Standard'),
(308, 4, 22, 'Standard'),
(309, 4, 23, 'Standard'),
(310, 4, 24, 'Standard'),
(311, 4, 25, 'Standard'),
(312, 4, 26, 'Standard'),
(313, 4, 27, 'Standard'),
(314, 4, 28, 'Standard'),
(315, 4, 29, 'Standard'),
(316, 4, 30, 'Standard'),
(317, 4, 31, 'Standard'),
(318, 4, 32, 'Standard'),
(319, 4, 33, 'Standard'),
(320, 4, 34, 'Standard'),
(321, 4, 35, 'Standard'),
(322, 4, 36, 'Standard'),
(323, 4, 37, 'Standard'),
(324, 4, 38, 'Standard'),
(325, 4, 39, 'Standard'),
(326, 4, 40, 'Standard'),
(327, 4, 41, 'Standard'),
(328, 4, 42, 'Standard'),
(329, 4, 43, 'Standard'),
(330, 4, 44, 'Standard'),
(331, 4, 45, 'Standard'),
(332, 4, 46, 'Standard'),
(333, 4, 47, 'Standard'),
(334, 4, 48, 'Standard'),
(335, 4, 49, 'Standard'),
(336, 4, 50, 'Standard'),
(337, 4, 35, 'Couple'),
(338, 4, 36, 'Couple'),
(339, 4, 37, 'Couple'),
(340, 4, 38, 'Couple'),
(341, 4, 39, 'Couple'),
(342, 4, 40, 'Couple'),
(343, 4, 41, 'Couple'),
(344, 4, 42, 'Couple'),
(345, 4, 43, 'Couple'),
(346, 4, 44, 'Couple'),
(347, 4, 45, 'Couple'),
(348, 4, 46, 'Couple'),
(349, 4, 47, 'Couple'),
(350, 4, 48, 'Couple'),
(351, 4, 49, 'Couple'),
(352, 4, 50, 'Couple'),
(646, 7, 1, 'Standard'),
(647, 7, 2, 'Standard'),
(648, 7, 3, 'Standard'),
(649, 7, 4, 'Standard'),
(650, 7, 5, 'Standard'),
(651, 7, 6, 'Standard'),
(652, 7, 7, 'Standard'),
(653, 7, 8, 'Standard'),
(654, 7, 9, 'Standard'),
(655, 7, 10, 'Standard'),
(656, 7, 11, 'Standard'),
(657, 7, 12, 'Standard'),
(658, 7, 13, 'Standard'),
(659, 7, 14, 'Standard'),
(660, 7, 15, 'Standard'),
(661, 7, 16, 'Standard'),
(662, 7, 17, 'Standard'),
(663, 7, 18, 'Standard'),
(664, 7, 19, 'Standard'),
(665, 7, 20, 'Standard'),
(666, 7, 21, 'Standard'),
(667, 7, 22, 'Standard'),
(668, 7, 23, 'Standard'),
(669, 7, 24, 'Standard'),
(670, 7, 25, 'Standard'),
(671, 7, 26, 'Standard'),
(672, 7, 27, 'Standard'),
(673, 7, 28, 'Standard'),
(674, 7, 29, 'Standard'),
(675, 7, 30, 'Standard'),
(676, 7, 31, 'Standard'),
(677, 7, 32, 'Standard'),
(678, 7, 33, 'Standard'),
(679, 7, 34, 'Standard'),
(680, 7, 35, 'Standard'),
(681, 7, 36, 'Standard'),
(682, 7, 37, 'Standard'),
(683, 7, 38, 'Standard'),
(684, 7, 39, 'Standard'),
(685, 7, 40, 'Standard'),
(686, 7, 41, 'Standard'),
(687, 7, 42, 'Standard'),
(688, 7, 43, 'Standard'),
(689, 7, 44, 'Standard'),
(690, 7, 45, 'Standard'),
(691, 7, 46, 'Standard'),
(692, 7, 47, 'Standard'),
(693, 7, 48, 'Standard'),
(694, 7, 49, 'Standard'),
(695, 7, 50, 'Standard'),
(696, 7, 35, 'Couple'),
(697, 7, 36, 'Couple'),
(698, 7, 37, 'Couple'),
(699, 7, 38, 'Couple'),
(700, 7, 39, 'Couple'),
(701, 7, 40, 'Couple'),
(702, 7, 41, 'Couple'),
(703, 7, 42, 'Couple'),
(704, 7, 43, 'Couple'),
(705, 7, 44, 'Couple'),
(706, 7, 45, 'Couple'),
(707, 7, 46, 'Couple'),
(708, 7, 47, 'Couple'),
(709, 7, 48, 'Couple'),
(710, 7, 49, 'Couple'),
(711, 7, 50, 'Couple'),
(712, 8, 1, 'Standard'),
(713, 8, 2, 'Standard'),
(714, 8, 3, 'Standard'),
(715, 8, 4, 'Standard'),
(716, 8, 5, 'Standard'),
(717, 8, 6, 'Standard'),
(718, 8, 7, 'Standard'),
(719, 8, 8, 'Standard'),
(720, 8, 9, 'Standard'),
(721, 8, 10, 'Standard'),
(722, 8, 11, 'Standard'),
(723, 8, 12, 'Standard'),
(724, 8, 13, 'Standard'),
(725, 8, 14, 'Standard'),
(726, 8, 15, 'Standard'),
(727, 8, 16, 'Standard'),
(728, 8, 17, 'Standard'),
(729, 8, 18, 'Standard'),
(730, 8, 19, 'Standard'),
(731, 8, 14, 'Couple'),
(732, 8, 15, 'Couple'),
(733, 8, 16, 'Couple'),
(734, 8, 17, 'Couple'),
(735, 8, 18, 'Couple'),
(736, 8, 19, 'Couple');

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
  `SEATCOUNT` int(11) DEFAULT NULL,
  `ISSHOWING` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`ID`, `THEATERNUM`, `SEATCOUNT`, `ISSHOWING`) VALUES
(1, 1, 60, 0),
(2, 2, 60, 0),
(3, 3, 95, 0),
(4, 4, 50, 0),
(7, 5, 50, 0),
(8, 8, 19, 0);

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
(1, 2, 60000),
(2, 2, 60000),
(3, NULL, 60000),
(4, 2, 60000),
(5, NULL, 60000),
(6, NULL, 60000),
(7, NULL, 60000),
(8, NULL, 60000),
(9, NULL, 60000),
(10, NULL, 60000),
(11, NULL, 60000),
(12, NULL, 60000),
(13, NULL, 60000),
(14, NULL, 60000),
(15, NULL, 60000),
(16, NULL, 60000),
(17, NULL, 60000),
(18, NULL, 60000),
(19, NULL, 60000),
(20, NULL, 60000),
(21, NULL, 60000),
(22, NULL, 60000),
(23, NULL, 60000),
(24, NULL, 60000),
(25, NULL, 60000),
(26, NULL, 60000),
(27, NULL, 60000),
(28, NULL, 60000),
(29, NULL, 60000),
(30, NULL, 60000),
(31, NULL, 60000),
(32, NULL, 60000),
(33, NULL, 60000),
(34, NULL, 60000),
(35, NULL, 60000),
(36, NULL, 60000),
(37, NULL, 60000),
(38, NULL, 60000),
(39, NULL, 60000),
(40, NULL, 60000),
(41, NULL, 60000),
(42, NULL, 60000),
(43, NULL, 60000),
(44, NULL, 60000),
(45, NULL, 60000),
(46, NULL, 60000),
(47, NULL, 60000),
(48, NULL, 60000),
(49, NULL, 60000),
(50, NULL, 60000),
(51, NULL, 60000),
(52, NULL, 60000),
(53, NULL, 60000),
(54, NULL, 60000),
(55, NULL, 60000),
(56, NULL, 60000),
(57, NULL, 60000),
(58, NULL, 60000),
(59, NULL, 60000),
(60, NULL, 60000),
(61, NULL, 60000),
(62, NULL, 60000),
(63, NULL, 60000),
(64, NULL, 60000),
(65, NULL, 60000),
(66, NULL, 60000),
(67, NULL, 60000),
(68, NULL, 60000),
(69, NULL, 60000),
(70, NULL, 60000),
(71, NULL, 60000),
(72, NULL, 60000),
(73, NULL, 60000),
(74, NULL, 60000),
(75, NULL, 60000),
(76, NULL, 60000),
(77, NULL, 60000),
(78, NULL, 60000),
(79, NULL, 60000),
(80, NULL, 60000),
(81, NULL, 60000),
(82, NULL, 60000),
(83, NULL, 60000),
(84, NULL, 60000),
(85, NULL, 60000),
(86, NULL, 60000),
(87, NULL, 60000),
(88, NULL, 60000),
(89, NULL, 60000),
(90, NULL, 60000),
(91, NULL, 60000),
(92, NULL, 60000),
(93, NULL, 60000),
(94, NULL, 60000),
(95, NULL, 60000),
(96, NULL, 60000),
(97, NULL, 60000),
(98, NULL, 60000),
(99, NULL, 60000),
(100, NULL, 60000),
(101, NULL, 60000),
(102, NULL, 60000),
(103, NULL, 60000),
(104, NULL, 60000),
(105, NULL, 60000),
(106, NULL, 60000),
(107, NULL, 60000),
(108, NULL, 60000),
(109, NULL, 60000),
(110, NULL, 60000),
(111, NULL, 60000),
(112, NULL, 60000),
(113, NULL, 60000),
(114, NULL, 60000),
(115, NULL, 60000),
(116, NULL, 60000),
(117, NULL, 60000),
(118, NULL, 60000),
(119, NULL, 60000),
(120, NULL, 60000),
(121, NULL, 60000),
(122, NULL, 60000),
(123, NULL, 60000),
(124, NULL, 60000),
(125, NULL, 60000),
(126, NULL, 60000),
(127, NULL, 60000),
(128, NULL, 60000),
(129, NULL, 60000),
(130, NULL, 60000),
(131, NULL, 60000),
(132, NULL, 60000),
(133, NULL, 60000),
(134, NULL, 60000),
(135, NULL, 60000),
(136, NULL, 60000),
(137, NULL, 60000),
(138, NULL, 60000),
(139, NULL, 60000),
(140, NULL, 60000),
(141, NULL, 60000),
(142, NULL, 60000),
(143, NULL, 60000),
(144, NULL, 60000),
(145, NULL, 60000),
(146, NULL, 60000),
(147, NULL, 60000),
(148, NULL, 60000),
(149, NULL, 60000),
(150, NULL, 60000),
(151, NULL, 60000),
(152, NULL, 60000),
(153, NULL, 60000),
(154, NULL, 60000),
(155, NULL, 60000),
(156, NULL, 60000),
(157, NULL, 60000),
(158, NULL, 60000),
(159, NULL, 60000),
(160, NULL, 60000),
(161, NULL, 60000),
(162, NULL, 60000),
(163, NULL, 60000),
(164, NULL, 60000),
(165, NULL, 60000),
(166, NULL, 60000),
(167, NULL, 60000),
(168, NULL, 60000),
(169, NULL, 60000),
(170, NULL, 60000),
(171, NULL, 60000),
(172, NULL, 60000),
(173, NULL, 60000),
(174, NULL, 60000),
(175, NULL, 60000),
(176, NULL, 60000),
(177, NULL, 60000),
(178, NULL, 60000),
(179, NULL, 60000),
(180, NULL, 60000),
(181, NULL, 60000),
(182, NULL, 60000),
(183, NULL, 60000),
(184, NULL, 60000),
(185, NULL, 60000),
(186, NULL, 60000),
(187, NULL, 60000),
(188, NULL, 60000),
(189, NULL, 60000),
(190, NULL, 60000),
(191, NULL, 60000),
(192, NULL, 60000),
(193, NULL, 60000),
(194, NULL, 60000),
(195, NULL, 60000),
(196, NULL, 60000),
(197, NULL, 60000),
(198, NULL, 60000),
(199, NULL, 60000),
(200, NULL, 60000),
(201, NULL, 60000),
(202, NULL, 60000),
(203, NULL, 60000),
(204, NULL, 60000),
(205, NULL, 60000),
(206, NULL, 60000),
(207, NULL, 60000),
(208, NULL, 60000),
(209, NULL, 60000),
(210, NULL, 60000),
(211, NULL, 60000),
(212, NULL, 60000),
(213, NULL, 60000),
(214, NULL, 60000),
(215, NULL, 60000),
(216, NULL, 60000),
(217, NULL, 60000),
(218, NULL, 60000),
(219, NULL, 60000),
(220, NULL, 60000),
(221, NULL, 60000),
(222, NULL, 60000),
(223, NULL, 60000),
(224, NULL, 60000),
(225, NULL, 60000),
(226, NULL, 60000),
(227, NULL, 60000),
(228, NULL, 60000),
(229, NULL, 60000),
(230, NULL, 60000),
(231, NULL, 60000),
(232, NULL, 60000),
(233, NULL, 60000),
(234, NULL, 60000),
(235, NULL, 60000),
(236, NULL, 60000),
(237, NULL, 60000),
(238, NULL, 60000),
(239, NULL, 60000),
(240, NULL, 60000),
(241, NULL, 60000),
(242, NULL, 60000),
(243, NULL, 60000),
(244, NULL, 60000),
(245, NULL, 60000),
(246, NULL, 60000),
(247, NULL, 60000),
(248, NULL, 60000),
(249, NULL, 60000),
(250, NULL, 60000),
(251, NULL, 60000),
(252, NULL, 60000),
(253, NULL, 60000),
(254, NULL, 60000),
(255, NULL, 60000),
(256, NULL, 60000),
(257, NULL, 60000),
(258, NULL, 60000),
(259, NULL, 60000),
(260, NULL, 60000),
(261, NULL, 60000),
(262, NULL, 60000),
(263, NULL, 60000),
(264, NULL, 60000),
(265, NULL, 60000),
(266, NULL, 60000),
(267, NULL, 60000),
(268, NULL, 60000),
(269, NULL, 60000),
(270, NULL, 60000),
(271, NULL, 60000),
(272, NULL, 60000),
(273, NULL, 60000),
(274, NULL, 60000),
(275, NULL, 60000),
(276, NULL, 60000),
(277, NULL, 60000),
(278, NULL, 60000),
(279, NULL, 60000),
(280, NULL, 60000),
(281, NULL, 60000),
(282, NULL, 60000),
(283, NULL, 60000),
(284, NULL, 60000),
(285, NULL, 60000),
(286, NULL, 60000),
(287, NULL, 60000),
(288, NULL, 60000),
(289, NULL, 60000),
(290, NULL, 60000),
(291, NULL, 60000),
(292, NULL, 60000),
(293, NULL, 60000),
(294, NULL, 60000),
(295, NULL, 60000),
(296, NULL, 60000),
(297, NULL, 60000),
(298, NULL, 60000),
(299, NULL, 60000),
(300, NULL, 60000),
(301, NULL, 60000),
(302, NULL, 60000),
(303, NULL, 60000),
(304, NULL, 60000),
(305, NULL, 60000),
(306, NULL, 60000),
(307, NULL, 60000),
(308, NULL, 60000),
(309, NULL, 60000),
(310, NULL, 60000),
(311, NULL, 60000),
(312, NULL, 60000),
(313, NULL, 60000),
(314, NULL, 60000),
(315, NULL, 60000),
(316, NULL, 60000),
(317, NULL, 60000),
(318, NULL, 60000),
(319, NULL, 60000),
(320, NULL, 60000),
(321, NULL, 60000),
(322, NULL, 60000),
(323, NULL, 60000),
(324, NULL, 60000),
(325, NULL, 60000),
(326, NULL, 60000),
(327, NULL, 60000),
(328, NULL, 60000),
(329, NULL, 60000),
(330, NULL, 60000),
(331, NULL, 60000),
(332, NULL, 60000),
(333, NULL, 60000),
(334, NULL, 60000),
(335, NULL, 60000),
(336, NULL, 60000),
(337, NULL, 60000),
(338, NULL, 60000),
(339, NULL, 60000),
(340, NULL, 60000),
(341, NULL, 60000),
(342, NULL, 60000),
(343, NULL, 60000),
(344, NULL, 60000),
(345, NULL, 60000),
(346, NULL, 60000),
(347, NULL, 60000),
(348, NULL, 60000),
(349, NULL, 60000),
(350, NULL, 60000),
(351, NULL, 60000),
(352, NULL, 60000),
(353, NULL, 60000),
(354, NULL, 60000),
(355, NULL, 60000),
(356, NULL, 60000),
(357, NULL, 60000),
(358, NULL, 60000),
(359, NULL, 60000),
(360, NULL, 60000),
(361, NULL, 60000),
(362, NULL, 60000),
(363, NULL, 60000),
(364, NULL, 60000),
(365, NULL, 60000),
(366, NULL, 60000),
(367, NULL, 60000),
(368, NULL, 60000),
(369, NULL, 60000),
(370, NULL, 60000),
(371, NULL, 60000),
(372, NULL, 60000),
(373, NULL, 60000),
(374, NULL, 60000),
(375, NULL, 60000),
(376, NULL, 60000),
(377, NULL, 60000),
(378, NULL, 60000),
(379, NULL, 60000),
(380, NULL, 60000),
(381, NULL, 60000),
(382, NULL, 60000),
(383, NULL, 60000),
(384, NULL, 60000),
(385, NULL, 60000),
(386, NULL, 60000),
(387, NULL, 60000),
(388, NULL, 60000),
(389, NULL, 60000),
(390, NULL, 60000),
(391, NULL, 60000),
(392, NULL, 60000),
(393, NULL, 60000),
(394, NULL, 60000),
(395, NULL, 60000),
(396, NULL, 60000),
(397, NULL, 60000),
(398, NULL, 60000),
(399, NULL, 60000),
(400, NULL, 60000),
(401, NULL, 60000),
(402, NULL, 60000),
(403, NULL, 60000),
(404, NULL, 60000),
(405, NULL, 60000),
(406, NULL, 60000),
(407, NULL, 60000),
(408, NULL, 60000),
(409, NULL, 60000),
(410, NULL, 60000),
(411, NULL, 60000),
(412, NULL, 60000),
(413, NULL, 60000),
(414, NULL, 60000),
(415, NULL, 60000),
(416, NULL, 60000),
(417, NULL, 60000),
(418, NULL, 60000),
(419, NULL, 60000),
(420, NULL, 60000),
(421, NULL, 50000),
(422, NULL, 50000),
(423, NULL, 50000),
(424, NULL, 50000),
(425, NULL, 50000),
(426, NULL, 50000),
(427, NULL, 50000),
(428, NULL, 50000),
(429, NULL, 50000),
(430, NULL, 50000),
(431, NULL, 50000),
(432, NULL, 50000),
(433, NULL, 50000),
(434, NULL, 50000),
(435, NULL, 50000),
(436, NULL, 50000),
(437, NULL, 50000),
(438, NULL, 50000),
(439, NULL, 50000),
(440, NULL, 50000),
(441, NULL, 50000),
(442, NULL, 50000),
(443, NULL, 50000),
(444, NULL, 50000),
(445, NULL, 50000),
(446, NULL, 50000),
(447, NULL, 50000),
(448, NULL, 50000),
(449, NULL, 50000),
(450, NULL, 50000),
(451, NULL, 50000),
(452, NULL, 50000),
(453, NULL, 50000),
(454, NULL, 50000),
(455, NULL, 50000),
(456, NULL, 50000),
(457, NULL, 50000),
(458, NULL, 50000),
(459, NULL, 50000),
(460, NULL, 50000),
(461, NULL, 50000),
(462, NULL, 50000),
(463, NULL, 50000),
(464, NULL, 50000),
(465, NULL, 50000),
(466, NULL, 50000),
(467, NULL, 50000),
(468, NULL, 50000),
(469, NULL, 50000),
(470, NULL, 50000),
(471, NULL, 50000),
(472, NULL, 50000),
(473, NULL, 50000),
(474, NULL, 50000),
(475, NULL, 50000),
(476, NULL, 50000),
(477, NULL, 50000),
(478, NULL, 50000),
(479, NULL, 50000),
(480, NULL, 50000),
(481, NULL, 50000),
(482, NULL, 50000),
(483, NULL, 50000),
(484, NULL, 50000),
(485, NULL, 50000),
(486, NULL, 50000),
(487, NULL, 50000),
(488, NULL, 50000),
(489, NULL, 50000),
(490, NULL, 50000),
(491, NULL, 50000),
(492, NULL, 50000),
(493, NULL, 50000),
(494, NULL, 50000),
(495, NULL, 50000),
(496, NULL, 50000),
(497, NULL, 50000),
(498, NULL, 50000),
(499, NULL, 50000),
(500, NULL, 50000),
(501, NULL, 50000),
(502, NULL, 50000),
(503, NULL, 50000),
(504, NULL, 50000),
(505, NULL, 50000),
(506, NULL, 50000),
(507, NULL, 50000),
(508, NULL, 50000),
(509, NULL, 50000),
(510, NULL, 50000),
(511, NULL, 50000),
(512, NULL, 50000),
(513, NULL, 50000),
(514, NULL, 50000),
(515, NULL, 50000),
(516, NULL, 50000),
(517, NULL, 50000),
(518, NULL, 50000),
(519, NULL, 50000),
(520, NULL, 50000),
(521, NULL, 50000),
(522, NULL, 50000),
(523, NULL, 50000),
(524, NULL, 50000),
(525, NULL, 50000),
(526, NULL, 50000),
(527, NULL, 50000),
(528, NULL, 50000),
(529, NULL, 50000),
(530, NULL, 50000),
(531, NULL, 50000),
(532, NULL, 50000),
(533, NULL, 50000),
(534, NULL, 50000),
(535, NULL, 50000),
(536, NULL, 50000),
(537, NULL, 50000),
(538, NULL, 50000),
(539, NULL, 50000),
(540, NULL, 50000),
(541, NULL, 50000),
(542, NULL, 50000),
(543, NULL, 50000),
(544, NULL, 50000),
(545, NULL, 50000),
(546, NULL, 50000),
(547, NULL, 50000),
(548, NULL, 50000),
(549, NULL, 50000),
(550, NULL, 50000),
(551, NULL, 50000),
(552, NULL, 50000),
(553, NULL, 50000),
(554, NULL, 50000),
(555, NULL, 50000),
(556, NULL, 50000),
(557, NULL, 50000),
(558, NULL, 50000),
(559, NULL, 50000),
(560, NULL, 50000),
(561, NULL, 50000),
(562, NULL, 50000),
(563, NULL, 50000),
(564, NULL, 50000),
(565, NULL, 50000),
(566, NULL, 50000),
(567, NULL, 50000),
(568, NULL, 50000),
(569, NULL, 50000),
(570, NULL, 50000),
(571, NULL, 50000),
(572, NULL, 50000),
(573, NULL, 50000),
(574, NULL, 50000),
(575, NULL, 50000),
(576, NULL, 50000),
(577, NULL, 50000),
(578, NULL, 50000),
(579, NULL, 50000),
(580, NULL, 50000),
(581, NULL, 50000),
(582, NULL, 50000),
(583, NULL, 50000),
(584, NULL, 50000),
(585, NULL, 50000),
(586, NULL, 50000),
(587, NULL, 50000),
(588, NULL, 50000),
(589, NULL, 50000),
(590, NULL, 50000),
(591, NULL, 50000),
(592, NULL, 50000),
(593, NULL, 50000),
(594, NULL, 50000),
(595, NULL, 50000),
(596, NULL, 50000),
(597, NULL, 50000),
(598, NULL, 50000),
(599, NULL, 50000),
(600, NULL, 50000),
(601, NULL, 50000),
(602, NULL, 50000),
(603, NULL, 50000),
(604, NULL, 50000),
(605, NULL, 50000),
(606, NULL, 50000),
(607, NULL, 50000),
(608, NULL, 50000),
(609, NULL, 50000),
(610, NULL, 50000),
(611, NULL, 50000),
(612, NULL, 50000),
(613, NULL, 50000),
(614, NULL, 50000),
(615, NULL, 50000),
(616, NULL, 0),
(617, NULL, 0),
(618, NULL, 0),
(619, NULL, 0),
(620, NULL, 0),
(621, NULL, 0),
(622, NULL, 0),
(623, NULL, 0),
(624, NULL, 0),
(625, NULL, 0),
(626, NULL, 0),
(627, NULL, 0),
(628, NULL, 0),
(629, NULL, 0),
(630, NULL, 0),
(631, NULL, 0),
(632, NULL, 0),
(633, NULL, 0),
(634, NULL, 0),
(635, NULL, 0),
(636, NULL, 0),
(637, NULL, 0),
(638, NULL, 0),
(639, NULL, 0),
(640, NULL, 0),
(641, NULL, 0),
(642, NULL, 0),
(643, NULL, 0),
(644, NULL, 0),
(645, NULL, 0),
(646, NULL, 0),
(647, NULL, 0),
(648, NULL, 0),
(649, NULL, 0),
(650, NULL, 0),
(651, NULL, 0),
(652, NULL, 0),
(653, NULL, 0),
(654, NULL, 0),
(655, NULL, 0),
(656, NULL, 0),
(657, NULL, 0),
(658, NULL, 0),
(659, NULL, 0),
(660, NULL, 0),
(661, NULL, 0),
(662, NULL, 0),
(663, NULL, 0),
(664, NULL, 0),
(665, NULL, 0),
(666, NULL, 0),
(667, NULL, 0),
(668, NULL, 0),
(669, NULL, 0),
(670, NULL, 0),
(671, NULL, 0),
(672, NULL, 0),
(673, NULL, 0),
(674, NULL, 0),
(675, NULL, 0),
(676, NULL, 60000),
(677, NULL, 60000),
(678, NULL, 60000),
(679, NULL, 60000),
(680, NULL, 60000),
(681, NULL, 60000),
(682, NULL, 60000),
(683, NULL, 60000),
(684, NULL, 60000),
(685, NULL, 60000),
(686, NULL, 60000),
(687, NULL, 60000),
(688, NULL, 60000),
(689, NULL, 60000),
(690, NULL, 60000),
(691, NULL, 60000),
(692, NULL, 60000),
(693, NULL, 60000),
(694, NULL, 60000),
(695, NULL, 60000),
(696, NULL, 60000),
(697, NULL, 60000),
(698, NULL, 60000),
(699, NULL, 60000),
(700, NULL, 60000),
(701, NULL, 60000),
(702, NULL, 60000),
(703, NULL, 60000),
(704, NULL, 60000),
(705, NULL, 60000),
(706, NULL, 60000),
(707, NULL, 60000),
(708, NULL, 60000),
(709, NULL, 60000),
(710, NULL, 60000),
(711, NULL, 60000),
(712, NULL, 60000),
(713, NULL, 60000),
(714, NULL, 60000),
(715, NULL, 60000),
(716, NULL, 60000),
(717, NULL, 60000),
(718, NULL, 60000),
(719, NULL, 60000),
(720, NULL, 60000),
(721, NULL, 60000),
(722, NULL, 60000),
(723, NULL, 60000),
(724, NULL, 60000),
(725, NULL, 60000),
(726, NULL, 60000),
(727, NULL, 60000),
(728, NULL, 60000),
(729, NULL, 60000),
(730, NULL, 60000),
(731, NULL, 60000),
(732, NULL, 60000),
(733, NULL, 60000),
(734, NULL, 60000),
(735, NULL, 60000),
(736, NULL, 12),
(737, NULL, 12),
(738, NULL, 12),
(739, NULL, 12),
(740, NULL, 12),
(741, NULL, 12),
(742, NULL, 12),
(743, NULL, 12),
(744, NULL, 12),
(745, NULL, 12),
(746, NULL, 12),
(747, NULL, 12),
(748, NULL, 12),
(749, NULL, 12),
(750, NULL, 12),
(751, NULL, 12),
(752, NULL, 12),
(753, NULL, 12),
(754, NULL, 12),
(755, NULL, 12),
(756, NULL, 12),
(757, NULL, 12),
(758, NULL, 12),
(759, NULL, 12),
(760, NULL, 12),
(761, NULL, 12),
(762, NULL, 12),
(763, NULL, 12),
(764, NULL, 12),
(765, NULL, 12),
(766, NULL, 12),
(767, NULL, 12),
(768, NULL, 12),
(769, NULL, 12),
(770, NULL, 12),
(771, NULL, 12),
(772, NULL, 12),
(773, NULL, 12),
(774, NULL, 12),
(775, NULL, 12),
(776, NULL, 12),
(777, NULL, 12),
(778, NULL, 12),
(779, NULL, 12),
(780, NULL, 12),
(781, NULL, 12),
(782, NULL, 12),
(783, NULL, 12),
(784, NULL, 12),
(785, NULL, 12),
(786, NULL, 12),
(787, NULL, 12),
(788, NULL, 12),
(789, NULL, 12),
(790, NULL, 12),
(791, NULL, 12),
(792, NULL, 12),
(793, NULL, 12),
(794, NULL, 12),
(795, NULL, 12),
(796, NULL, 2),
(797, NULL, 2),
(798, NULL, 2),
(799, NULL, 2),
(800, NULL, 2),
(801, NULL, 2),
(802, NULL, 2),
(803, NULL, 2),
(804, NULL, 2),
(805, NULL, 2),
(806, NULL, 2),
(807, NULL, 2),
(808, NULL, 2),
(809, NULL, 2),
(810, NULL, 2),
(811, NULL, 2),
(812, NULL, 2),
(813, NULL, 2),
(814, NULL, 2),
(815, NULL, 2),
(816, NULL, 2),
(817, NULL, 2),
(818, NULL, 2),
(819, NULL, 2),
(820, NULL, 2),
(821, NULL, 2),
(822, NULL, 2),
(823, NULL, 2),
(824, NULL, 2),
(825, NULL, 2),
(826, NULL, 2),
(827, NULL, 2),
(828, NULL, 2),
(829, NULL, 2),
(830, NULL, 2),
(831, NULL, 2),
(832, NULL, 2),
(833, NULL, 2),
(834, NULL, 2),
(835, NULL, 2),
(836, NULL, 2),
(837, NULL, 2),
(838, NULL, 2),
(839, NULL, 2),
(840, NULL, 2),
(841, NULL, 2),
(842, NULL, 2),
(843, NULL, 2),
(844, NULL, 2),
(845, NULL, 2),
(846, NULL, 2),
(847, NULL, 2),
(848, NULL, 2),
(849, NULL, 2),
(850, NULL, 2),
(851, NULL, 2),
(852, NULL, 2),
(853, NULL, 2),
(854, NULL, 2),
(855, NULL, 2);

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
(1, 1, 1, 0),
(1, 6, 301, 0),
(1, 11, 676, 0),
(1, 12, 736, 0),
(2, 1, 2, 0),
(2, 6, 302, 0),
(2, 11, 677, 0),
(2, 12, 737, 0),
(3, 1, 3, 0),
(3, 6, 303, 0),
(3, 11, 678, 0),
(3, 12, 738, 0),
(4, 1, 4, 0),
(4, 6, 304, 0),
(4, 11, 679, 0),
(4, 12, 739, 0),
(5, 1, 5, 0),
(5, 6, 305, 0),
(5, 11, 680, 0),
(5, 12, 740, 0),
(6, 1, 6, 0),
(6, 6, 306, 0),
(6, 11, 681, 0),
(6, 12, 741, 0),
(7, 1, 7, 0),
(7, 6, 307, 0),
(7, 11, 682, 0),
(7, 12, 742, 0),
(8, 1, 8, 0),
(8, 6, 308, 0),
(8, 11, 683, 0),
(8, 12, 743, 0),
(9, 1, 9, 0),
(9, 6, 309, 0),
(9, 11, 684, 0),
(9, 12, 744, 0),
(10, 1, 10, 0),
(10, 6, 310, 0),
(10, 11, 685, 0),
(10, 12, 745, 0),
(11, 1, 11, 0),
(11, 6, 311, 0),
(11, 11, 686, 0),
(11, 12, 746, 0),
(12, 1, 12, 0),
(12, 6, 312, 0),
(12, 11, 687, 0),
(12, 12, 747, 0),
(13, 1, 13, 0),
(13, 6, 313, 0),
(13, 11, 688, 0),
(13, 12, 748, 0),
(14, 1, 14, 0),
(14, 6, 314, 0),
(14, 11, 689, 0),
(14, 12, 749, 0),
(15, 1, 15, 0),
(15, 6, 315, 0),
(15, 11, 690, 0),
(15, 12, 750, 0),
(16, 1, 16, 0),
(16, 6, 316, 0),
(16, 11, 691, 0),
(16, 12, 751, 0),
(17, 1, 17, 0),
(17, 6, 317, 0),
(17, 11, 692, 0),
(17, 12, 752, 0),
(18, 1, 18, 0),
(18, 6, 318, 0),
(18, 11, 693, 0),
(18, 12, 753, 0),
(19, 1, 19, 0),
(19, 6, 319, 0),
(19, 11, 694, 0),
(19, 12, 754, 0),
(20, 1, 20, 0),
(20, 6, 320, 0),
(20, 11, 695, 0),
(20, 12, 755, 0),
(21, 1, 21, 0),
(21, 6, 321, 0),
(21, 11, 696, 0),
(21, 12, 756, 0),
(22, 1, 22, 0),
(22, 6, 322, 0),
(22, 11, 697, 0),
(22, 12, 757, 0),
(23, 1, 23, 0),
(23, 6, 323, 0),
(23, 11, 698, 0),
(23, 12, 758, 0),
(24, 1, 24, 0),
(24, 6, 324, 0),
(24, 11, 699, 0),
(24, 12, 759, 0),
(25, 1, 25, 0),
(25, 6, 325, 0),
(25, 11, 700, 0),
(25, 12, 760, 0),
(26, 1, 26, 0),
(26, 6, 326, 0),
(26, 11, 701, 0),
(26, 12, 761, 0),
(27, 1, 27, 0),
(27, 6, 327, 0),
(27, 11, 702, 0),
(27, 12, 762, 0),
(28, 1, 28, 0),
(28, 6, 328, 0),
(28, 11, 703, 0),
(28, 12, 763, 0),
(29, 1, 29, 0),
(29, 6, 329, 0),
(29, 11, 704, 0),
(29, 12, 764, 0),
(30, 1, 30, 0),
(30, 6, 330, 0),
(30, 11, 705, 0),
(30, 12, 765, 0),
(31, 1, 31, 0),
(31, 6, 331, 0),
(31, 11, 706, 0),
(31, 12, 766, 0),
(32, 1, 32, 0),
(32, 6, 332, 0),
(32, 11, 707, 0),
(32, 12, 767, 0),
(33, 1, 33, 0),
(33, 6, 333, 0),
(33, 11, 708, 0),
(33, 12, 768, 0),
(34, 1, 34, 0),
(34, 6, 334, 0),
(34, 11, 709, 0),
(34, 12, 769, 0),
(35, 1, 35, 0),
(35, 6, 335, 0),
(35, 11, 710, 0),
(35, 12, 770, 0),
(36, 1, 36, 0),
(36, 6, 336, 0),
(36, 11, 711, 0),
(36, 12, 771, 0),
(37, 1, 37, 0),
(37, 6, 337, 0),
(37, 11, 712, 0),
(37, 12, 772, 0),
(38, 1, 38, 0),
(38, 6, 338, 0),
(38, 11, 713, 0),
(38, 12, 773, 0),
(39, 1, 39, 0),
(39, 6, 339, 0),
(39, 11, 714, 0),
(39, 12, 774, 0),
(40, 1, 40, 0),
(40, 6, 340, 0),
(40, 11, 715, 0),
(40, 12, 775, 0),
(41, 1, 41, 0),
(41, 6, 341, 0),
(41, 11, 716, 0),
(41, 12, 776, 0),
(42, 1, 42, 0),
(42, 6, 342, 0),
(42, 11, 717, 0),
(42, 12, 777, 0),
(43, 1, 43, 0),
(43, 6, 343, 0),
(43, 11, 718, 0),
(43, 12, 778, 0),
(44, 1, 44, 0),
(44, 6, 344, 0),
(44, 11, 719, 0),
(44, 12, 779, 0),
(45, 1, 45, 0),
(45, 6, 345, 0),
(45, 11, 720, 0),
(45, 12, 780, 0),
(46, 1, 46, 0),
(46, 6, 346, 0),
(46, 11, 721, 0),
(46, 12, 781, 0),
(47, 1, 47, 0),
(47, 6, 347, 0),
(47, 11, 722, 0),
(47, 12, 782, 0),
(48, 1, 48, 0),
(48, 6, 348, 0),
(48, 11, 723, 0),
(48, 12, 783, 0),
(49, 1, 49, 0),
(49, 6, 349, 0),
(49, 11, 724, 0),
(49, 12, 784, 0),
(50, 1, 50, 0),
(50, 6, 350, 0),
(50, 11, 725, 0),
(50, 12, 785, 0),
(51, 1, 51, 0),
(51, 6, 351, 0),
(51, 11, 726, 0),
(51, 12, 786, 0),
(52, 1, 52, 0),
(52, 6, 352, 0),
(52, 11, 727, 0),
(52, 12, 787, 0),
(53, 1, 53, 0),
(53, 6, 353, 0),
(53, 11, 728, 0),
(53, 12, 788, 0),
(54, 1, 54, 0),
(54, 6, 354, 0),
(54, 11, 729, 0),
(54, 12, 789, 0),
(55, 1, 55, 0),
(55, 6, 355, 0),
(55, 11, 730, 0),
(55, 12, 790, 0),
(56, 1, 56, 0),
(56, 6, 356, 0),
(56, 11, 731, 0),
(56, 12, 791, 0),
(57, 1, 57, 0),
(57, 6, 357, 0),
(57, 11, 732, 0),
(57, 12, 792, 0),
(58, 1, 58, 0),
(58, 6, 358, 0),
(58, 11, 733, 0),
(58, 12, 793, 0),
(59, 1, 59, 0),
(59, 6, 359, 0),
(59, 11, 734, 0),
(59, 12, 794, 0),
(60, 1, 60, 0),
(60, 6, 360, 0),
(60, 11, 735, 0),
(60, 12, 795, 0),
(81, 2, 61, 0),
(81, 3, 121, 0),
(81, 4, 181, 0),
(81, 5, 241, 0),
(81, 10, 616, 0),
(81, 13, 796, 0),
(82, 2, 62, 0),
(82, 3, 122, 0),
(82, 4, 182, 0),
(82, 5, 242, 0),
(82, 10, 617, 0),
(82, 13, 797, 0),
(83, 2, 63, 0),
(83, 3, 123, 0),
(83, 4, 183, 0),
(83, 5, 243, 0),
(83, 10, 618, 0),
(83, 13, 798, 0),
(84, 2, 64, 0),
(84, 3, 124, 0),
(84, 4, 184, 0),
(84, 5, 244, 0),
(84, 10, 619, 0),
(84, 13, 799, 0),
(85, 2, 65, 0),
(85, 3, 125, 0),
(85, 4, 185, 0),
(85, 5, 245, 0),
(85, 10, 620, 0),
(85, 13, 800, 0),
(86, 2, 66, 0),
(86, 3, 126, 0),
(86, 4, 186, 0),
(86, 5, 246, 0),
(86, 10, 621, 0),
(86, 13, 801, 0),
(87, 2, 67, 0),
(87, 3, 127, 0),
(87, 4, 187, 0),
(87, 5, 247, 0),
(87, 10, 622, 0),
(87, 13, 802, 0),
(88, 2, 68, 0),
(88, 3, 128, 0),
(88, 4, 188, 0),
(88, 5, 248, 0),
(88, 10, 623, 0),
(88, 13, 803, 0),
(89, 2, 69, 0),
(89, 3, 129, 0),
(89, 4, 189, 0),
(89, 5, 249, 0),
(89, 10, 624, 0),
(89, 13, 804, 0),
(90, 2, 70, 0),
(90, 3, 130, 0),
(90, 4, 190, 0),
(90, 5, 250, 0),
(90, 10, 625, 0),
(90, 13, 805, 0),
(91, 2, 71, 0),
(91, 3, 131, 0),
(91, 4, 191, 0),
(91, 5, 251, 0),
(91, 10, 626, 0),
(91, 13, 806, 0),
(92, 2, 72, 0),
(92, 3, 132, 0),
(92, 4, 192, 0),
(92, 5, 252, 0),
(92, 10, 627, 0),
(92, 13, 807, 0),
(93, 2, 73, 0),
(93, 3, 133, 0),
(93, 4, 193, 0),
(93, 5, 253, 0),
(93, 10, 628, 0),
(93, 13, 808, 0),
(94, 2, 74, 0),
(94, 3, 134, 0),
(94, 4, 194, 0),
(94, 5, 254, 0),
(94, 10, 629, 0),
(94, 13, 809, 0),
(95, 2, 75, 0),
(95, 3, 135, 0),
(95, 4, 195, 0),
(95, 5, 255, 0),
(95, 10, 630, 0),
(95, 13, 810, 0),
(96, 2, 76, 0),
(96, 3, 136, 0),
(96, 4, 196, 0),
(96, 5, 256, 0),
(96, 10, 631, 0),
(96, 13, 811, 0),
(97, 2, 77, 0),
(97, 3, 137, 0),
(97, 4, 197, 0),
(97, 5, 257, 0),
(97, 10, 632, 0),
(97, 13, 812, 0),
(98, 2, 78, 0),
(98, 3, 138, 0),
(98, 4, 198, 0),
(98, 5, 258, 0),
(98, 10, 633, 0),
(98, 13, 813, 0),
(99, 2, 79, 0),
(99, 3, 139, 0),
(99, 4, 199, 0),
(99, 5, 259, 0),
(99, 10, 634, 0),
(99, 13, 814, 0),
(100, 2, 80, 0),
(100, 3, 140, 0),
(100, 4, 200, 0),
(100, 5, 260, 0),
(100, 10, 635, 0),
(100, 13, 815, 0),
(101, 2, 81, 0),
(101, 3, 141, 0),
(101, 4, 201, 0),
(101, 5, 261, 0),
(101, 10, 636, 0),
(101, 13, 816, 0),
(102, 2, 82, 0),
(102, 3, 142, 0),
(102, 4, 202, 0),
(102, 5, 262, 0),
(102, 10, 637, 0),
(102, 13, 817, 0),
(103, 2, 83, 0),
(103, 3, 143, 0),
(103, 4, 203, 0),
(103, 5, 263, 0),
(103, 10, 638, 0),
(103, 13, 818, 0),
(104, 2, 84, 0),
(104, 3, 144, 0),
(104, 4, 204, 0),
(104, 5, 264, 0),
(104, 10, 639, 0),
(104, 13, 819, 0),
(105, 2, 85, 0),
(105, 3, 145, 0),
(105, 4, 205, 0),
(105, 5, 265, 0),
(105, 10, 640, 0),
(105, 13, 820, 0),
(106, 2, 86, 0),
(106, 3, 146, 0),
(106, 4, 206, 0),
(106, 5, 266, 0),
(106, 10, 641, 0),
(106, 13, 821, 0),
(107, 2, 87, 0),
(107, 3, 147, 0),
(107, 4, 207, 0),
(107, 5, 267, 0),
(107, 10, 642, 0),
(107, 13, 822, 0),
(108, 2, 88, 0),
(108, 3, 148, 0),
(108, 4, 208, 0),
(108, 5, 268, 0),
(108, 10, 643, 0),
(108, 13, 823, 0),
(109, 2, 89, 0),
(109, 3, 149, 0),
(109, 4, 209, 0),
(109, 5, 269, 0),
(109, 10, 644, 0),
(109, 13, 824, 0),
(110, 2, 90, 0),
(110, 3, 150, 0),
(110, 4, 210, 0),
(110, 5, 270, 0),
(110, 10, 645, 0),
(110, 13, 825, 0),
(111, 2, 91, 0),
(111, 3, 151, 0),
(111, 4, 211, 0),
(111, 5, 271, 0),
(111, 10, 646, 0),
(111, 13, 826, 0),
(112, 2, 92, 0),
(112, 3, 152, 0),
(112, 4, 212, 0),
(112, 5, 272, 0),
(112, 10, 647, 0),
(112, 13, 827, 0),
(113, 2, 93, 0),
(113, 3, 153, 0),
(113, 4, 213, 0),
(113, 5, 273, 0),
(113, 10, 648, 0),
(113, 13, 828, 0),
(114, 2, 94, 0),
(114, 3, 154, 0),
(114, 4, 214, 0),
(114, 5, 274, 0),
(114, 10, 649, 0),
(114, 13, 829, 0),
(115, 2, 95, 0),
(115, 3, 155, 0),
(115, 4, 215, 0),
(115, 5, 275, 0),
(115, 10, 650, 0),
(115, 13, 830, 0),
(116, 2, 96, 0),
(116, 3, 156, 0),
(116, 4, 216, 0),
(116, 5, 276, 0),
(116, 10, 651, 0),
(116, 13, 831, 0),
(117, 2, 97, 0),
(117, 3, 157, 0),
(117, 4, 217, 0),
(117, 5, 277, 0),
(117, 10, 652, 0),
(117, 13, 832, 0),
(118, 2, 98, 0),
(118, 3, 158, 0),
(118, 4, 218, 0),
(118, 5, 278, 0),
(118, 10, 653, 0),
(118, 13, 833, 0),
(119, 2, 99, 0),
(119, 3, 159, 0),
(119, 4, 219, 0),
(119, 5, 279, 0),
(119, 10, 654, 0),
(119, 13, 834, 0),
(120, 2, 100, 0),
(120, 3, 160, 0),
(120, 4, 220, 0),
(120, 5, 280, 0),
(120, 10, 655, 0),
(120, 13, 835, 0),
(121, 2, 101, 0),
(121, 3, 161, 0),
(121, 4, 221, 0),
(121, 5, 281, 0),
(121, 10, 656, 0),
(121, 13, 836, 0),
(122, 2, 102, 0),
(122, 3, 162, 0),
(122, 4, 222, 0),
(122, 5, 282, 0),
(122, 10, 657, 0),
(122, 13, 837, 0),
(123, 2, 103, 0),
(123, 3, 163, 0),
(123, 4, 223, 0),
(123, 5, 283, 0),
(123, 10, 658, 0),
(123, 13, 838, 0),
(124, 2, 104, 0),
(124, 3, 164, 0),
(124, 4, 224, 0),
(124, 5, 284, 0),
(124, 10, 659, 0),
(124, 13, 839, 0),
(125, 2, 105, 0),
(125, 3, 165, 0),
(125, 4, 225, 0),
(125, 5, 285, 0),
(125, 10, 660, 0),
(125, 13, 840, 0),
(126, 2, 106, 0),
(126, 3, 166, 0),
(126, 4, 226, 0),
(126, 5, 286, 0),
(126, 10, 661, 0),
(126, 13, 841, 0),
(127, 2, 107, 0),
(127, 3, 167, 0),
(127, 4, 227, 0),
(127, 5, 287, 0),
(127, 10, 662, 0),
(127, 13, 842, 0),
(128, 2, 108, 0),
(128, 3, 168, 0),
(128, 4, 228, 0),
(128, 5, 288, 0),
(128, 10, 663, 0),
(128, 13, 843, 0),
(129, 2, 109, 0),
(129, 3, 169, 0),
(129, 4, 229, 0),
(129, 5, 289, 0),
(129, 10, 664, 0),
(129, 13, 844, 0),
(130, 2, 110, 0),
(130, 3, 170, 0),
(130, 4, 230, 0),
(130, 5, 290, 0),
(130, 10, 665, 0),
(130, 13, 845, 0),
(131, 2, 111, 0),
(131, 3, 171, 0),
(131, 4, 231, 0),
(131, 5, 291, 0),
(131, 10, 666, 0),
(131, 13, 846, 0),
(132, 2, 112, 0),
(132, 3, 172, 0),
(132, 4, 232, 0),
(132, 5, 292, 0),
(132, 10, 667, 0),
(132, 13, 847, 0),
(133, 2, 113, 0),
(133, 3, 173, 0),
(133, 4, 233, 0),
(133, 5, 293, 0),
(133, 10, 668, 0),
(133, 13, 848, 0),
(134, 2, 114, 0),
(134, 3, 174, 0),
(134, 4, 234, 0),
(134, 5, 294, 0),
(134, 10, 669, 0),
(134, 13, 849, 0),
(135, 2, 115, 0),
(135, 3, 175, 0),
(135, 4, 235, 0),
(135, 5, 295, 0),
(135, 10, 670, 0),
(135, 13, 850, 0),
(136, 2, 116, 0),
(136, 3, 176, 0),
(136, 4, 236, 0),
(136, 5, 296, 0),
(136, 10, 671, 0),
(136, 13, 851, 0),
(137, 2, 117, 0),
(137, 3, 177, 0),
(137, 4, 237, 0),
(137, 5, 297, 0),
(137, 10, 672, 0),
(137, 13, 852, 0),
(138, 2, 118, 0),
(138, 3, 178, 0),
(138, 4, 238, 0),
(138, 5, 298, 0),
(138, 10, 673, 0),
(138, 13, 853, 0),
(139, 2, 119, 0),
(139, 3, 179, 0),
(139, 4, 239, 0),
(139, 5, 299, 0),
(139, 10, 674, 0),
(139, 13, 854, 0),
(140, 2, 120, 0),
(140, 3, 180, 0),
(140, 4, 240, 0),
(140, 5, 300, 0),
(140, 10, 675, 0),
(140, 13, 855, 0),
(161, 8, 421, 0),
(162, 8, 422, 0),
(163, 8, 423, 0),
(164, 8, 424, 0),
(165, 8, 425, 0),
(166, 8, 426, 0),
(167, 8, 427, 0),
(168, 8, 428, 0),
(169, 8, 429, 0),
(170, 8, 430, 0),
(171, 8, 431, 0),
(172, 8, 432, 0),
(173, 8, 433, 0),
(174, 8, 434, 0),
(175, 8, 435, 0),
(176, 8, 436, 0),
(177, 8, 437, 0),
(178, 8, 438, 0),
(179, 8, 439, 0),
(180, 8, 440, 0),
(181, 8, 441, 0),
(182, 8, 442, 0),
(183, 8, 443, 0),
(184, 8, 444, 0),
(185, 8, 445, 0),
(186, 8, 446, 0),
(187, 8, 447, 0),
(188, 8, 448, 0),
(189, 8, 449, 0),
(190, 8, 450, 0),
(191, 8, 451, 0),
(192, 8, 452, 0),
(193, 8, 453, 0),
(194, 8, 454, 0),
(195, 8, 455, 0),
(196, 8, 456, 0),
(197, 8, 457, 0),
(198, 8, 458, 0),
(199, 8, 459, 0),
(200, 8, 460, 0),
(201, 8, 461, 0),
(202, 8, 462, 0),
(203, 8, 463, 0),
(204, 8, 464, 0),
(205, 8, 465, 0),
(206, 8, 466, 0),
(207, 8, 467, 0),
(208, 8, 468, 0),
(209, 8, 469, 0),
(210, 8, 470, 0),
(211, 8, 471, 0),
(212, 8, 472, 0),
(213, 8, 473, 0),
(214, 8, 474, 0),
(215, 8, 475, 0),
(216, 8, 476, 0),
(217, 8, 477, 0),
(218, 8, 478, 0),
(219, 8, 479, 0),
(220, 8, 480, 0),
(221, 8, 481, 0),
(222, 8, 482, 0),
(223, 8, 483, 0),
(224, 8, 484, 0),
(225, 8, 485, 0),
(226, 8, 486, 0),
(227, 8, 487, 0),
(228, 8, 488, 0),
(229, 8, 489, 0),
(230, 8, 490, 0),
(231, 8, 491, 0),
(232, 8, 492, 0),
(233, 8, 493, 0),
(234, 8, 494, 0),
(235, 8, 495, 0),
(236, 8, 496, 0),
(237, 8, 497, 0),
(238, 8, 498, 0),
(239, 8, 499, 0),
(240, 8, 500, 0),
(241, 8, 501, 0),
(242, 8, 502, 0),
(243, 8, 503, 0),
(244, 8, 504, 0),
(245, 8, 505, 0),
(246, 8, 506, 0),
(247, 8, 507, 0),
(248, 8, 508, 0),
(249, 8, 509, 0),
(250, 8, 510, 0),
(251, 8, 511, 0),
(252, 8, 512, 0),
(253, 8, 513, 0),
(254, 8, 514, 0),
(255, 8, 515, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `transactions`
-- (See below for the actual view)
--
CREATE TABLE `transactions` (
);

-- --------------------------------------------------------

--
-- Structure for view `fcb_detail`
--
DROP TABLE IF EXISTS `fcb_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fcb_detail`  AS SELECT `foodcombo`.`ID` AS `ID`, `foodcombo`.`NAME` AS `NAME`, max(case when `product`.`TYPE` = 'Đồ ăn' then `product`.`NAME` else NULL end) AS `TenDoAn`, group_concat(case when `product`.`TYPE` = 'Đồ ăn' then `product_fcb`.`QUANTITY` else NULL end separator ',') AS `QuantityDoAn`, max(case when `product`.`TYPE` = 'Đồ uống' then `product`.`NAME` else NULL end) AS `TenDoUong`, group_concat(case when `product`.`TYPE` = 'Đồ uống' then `product_fcb`.`QUANTITY` else NULL end separator ',') AS `QuantityDoUong`, `foodcombo`.`PRICE` AS `PRICE` FROM ((`foodcombo` join `product_fcb` on(`foodcombo`.`ID` = `product_fcb`.`FCB_ID`)) join `product` on(`product`.`ID` = `product_fcb`.`PRODUCT_ID`)) GROUP BY `foodcombo`.`NAME``NAME`  ;

-- --------------------------------------------------------

--
-- Structure for view `transactions`
--
DROP TABLE IF EXISTS `transactions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transactions`  AS SELECT `booking`.`ID` AS `ID`, `client`.`NAME` AS `NAME`, `client`.`PHONE` AS `PHONE`, `client`.`ADDRESS` AS `ADDRESS`, `movie`.`TITLE` AS `TITLE`, `schedule`.`STARTTIME` AS `STARTTIME`, `schedule`.`ENDTIME` AS `ENDTIME`, group_concat(`seat`.`SEATNUMBER` separator ',') AS `Seats`, sum(`ticket`.`price`) AS `ticketPrice`, `foodcombo`.`NAME` AS `Food`, `foodcombo`.`PRICE` AS `PRICE`, sum(`ticket`.`price`) + `foodcombo`.`PRICE` AS `Total` FROM ((((((((`booking` join `client`) join `ticket`) join `ticket_seat_schedule`) join `schedule`) join `seat`) join `movie`) join `food_booking`) join `foodcombo`) WHERE `client`.`ID` = `booking`.`CLIENT_ID` AND `ticket`.`BOO_ID` = `booking`.`ID` AND `ticket_seat_schedule`.`TICKET_ID` = `ticket`.`ID` AND `schedule`.`ID` = `ticket_seat_schedule`.`SCHEDULE_ID` AND `seat`.`ID` = `ticket_seat_schedule`.`SEAT_ID` AND `movie`.`ID` = `schedule`.`MOV_ID` AND `food_booking`.`FOOD_ID` = `foodcombo`.`ID` AND `booking`.`ID` = `food_booking`.`BOOKING_ID` GROUP BY `booking`.`ID``ID`  ;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `foodcombo`
--
ALTER TABLE `foodcombo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=744;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=856;

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
