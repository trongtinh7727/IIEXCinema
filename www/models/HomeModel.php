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
                    WHERE `ID` = (
                    SELECT
                        ticket.ID
                    FROM
                        `seat`,
                        ticket,
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
                             `ticket_seat_schedule`.`TICKET_ID` = (
                    SELECT
                        ticket.ID
                    FROM
                        `seat`,
                        ticket,
                        ticket_seat_schedule
                    WHERE
                        ticket_seat_schedule.SEAT_ID = seat.ID 
                        AND ticket_seat_schedule.TICKET_ID = ticket.ID 
                        AND ticket_seat_schedule.SCHEDULE_ID = ?
                        AND `SEATNUMBER` = ?
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
