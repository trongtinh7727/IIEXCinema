<?php
class HomeModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getProfile($ID)
    {
        $sql = "SELECT * FROM client where ID = '$ID'";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getMovieSchedule($movie_id)
    {
        // get cinemas
        $sql = "CALL `get_movie_schedule`(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($movie_id));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $showtimes  = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $showtimes[] = $row;
        }

        $grouped = array();
        foreach ($showtimes as $showtime) {
            $cinemaId = $showtime['cinema_ID'];
            $showroomId = $showtime['showroom_ID'];
            $day = $showtime['DAY'];

            if (!isset($grouped[$cinemaId])) {
                $grouped[$cinemaId] = array(
                    "CINEMA_ID" => $showtime['cinema_ID'],
                    "NAME" => $showtime['NAME'],
                    "ADDRESS" => $showtime['ADDRESS'],
                    "Showrooms" => array()
                );
            }

            if (!isset($grouped[$cinemaId]["Showrooms"][$showroomId])) {
                $grouped[$cinemaId]["Showrooms"][$showroomId] = array(

                    "showroom_ID" => $showtime['showroom_ID'],
                    "SHOWROOMNUM" => $showtime['SHOWROOMNUM'],
                    "showtimes" => array()
                );
            }

            if (!isset($grouped[$cinemaId]["Showrooms"][$showroomId]['showtimes'][$day])) {
                $grouped[$cinemaId]["Showrooms"][$showroomId]['showtimes'][$day] = array(
                    "DAY" => $showtime['DAY'],
                    "times" => array()
                );
            }

            $grouped[$cinemaId]["Showrooms"][$showroomId]['showtimes'][$day]["times"][] = array(
                "ID" => $showtime['ID'],
                "TIME" =>  $showtime['TIME']
            );
        }
        return $grouped;
    }

    public function bookingHistory($ID)
    {
        $sql = " CALL `get_transactions_by_user`(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($ID));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function saveTransaction($Clinet_ID, $Schedule_id, $seats, $foods)
    {
        try {
            // Insert into booking
            $sql = "INSERT INTO `booking` (`ID`, `CLIENT_ID`, `CREATED_AT`, `FOOD_PRICE`, `TICKET_PRICE`) VALUES (NULL, ? , current_timestamp(), '0', '0');";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($Clinet_ID));
            $booking_id = $this->db->lastInsertId();

            // Update ticket booking
            foreach ($seats as $seat) {
                $sql = "UPDATE `ticket` 
                    SET `BOO_ID` = ? 
                    WHERE `ID` in (
                    SELECT
                        t.ID
                    FROM
                        `seat`,
                       (SELECT * FROM ticket) AS  t,
                        ticket_seat_schedule
                    WHERE
                        ticket_seat_schedule.SEAT_ID = seat.ID 
                        AND ticket_seat_schedule.TICKET_ID = ticket.ID 
                        AND ticket_seat_schedule.SCHEDULE_ID = ?
                        AND `SEATNUMBER` = ?
                    )";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($booking_id, $Schedule_id, $seat));

                $sql = "UPDATE
                            `ticket_seat_schedule`
                        SET
                            `BOOKED` = '1'
                        WHERE
                            `ticket_seat_schedule`.`TICKET_ID` IN(
                            SELECT
                                ticket.ID
                            FROM
                                (
                                SELECT
                                    *
                                FROM
                                    ticket_seat_schedule
                            ) AS t,
                            `seat`,
                            ticket
                        WHERE
                            ticket_seat_schedule.SEAT_ID = seat.ID AND ticket_seat_schedule.TICKET_ID = ticket.ID AND ticket_seat_schedule.SCHEDULE_ID = ? AND `SEATNUMBER` = ?
                        )";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($Schedule_id, $seat));
            }

            // Update foodcombo booking
            if (!$foods) {
                $sql = "INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`, `QUANTITY`) VALUES (?, ?, ?);";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                    1, $booking_id, 0
                ));
            } else {
                foreach ($foods as $food) {
                    $sql = "INSERT INTO `food_booking` (`FOOD_ID`, `BOOKING_ID`, `QUANTITY`) VALUES (?, ?, ?);";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute(array(
                        $food['id'], $booking_id, $food['quantity']
                    ));
                }
            }
        } catch (PDOException $ex) {
            echo (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
