<?php

class TicketModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM ticket';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return json_encode(array('status' => true, 'data' => $data));
    }

    public function add($price)
    {
        $sql = 'INSERT INTO ticket( price) VALUE(?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($price));
            $ticket_id = $this->db->lastInsertId();
            return json_encode(array('status' => true, 'data' => array('ticket_id' => $ticket_id)));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function addTicketSeatSchedule($SEAT_ID, $SCHEDULE_ID, $TICKET_ID)
    {
        $sql = 'INSERT INTO `ticket_seat_schedule` (`SEAT_ID`, `SCHEDULE_ID`, `TICKET_ID`, `BOOKED`) VALUES (?, ?, ?, ?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($SEAT_ID, $SCHEDULE_ID, $TICKET_ID, 0));
            $ticket_id = $this->db->lastInsertId();
            return json_encode(array('status' => true, 'data' => array('ticket_id' => $ticket_id)));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($ID, $SCH_ID, $BOO_ID, $SEAT_ID, $price)
    {
        $sql = 'UPDATE `ticket` SET `ID` = ?, `SCH_ID` = ?, `BOO_ID` = ?, `SEAT_ID` = ?, `price` = ? WHERE `ticket`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($ID, $SCH_ID, $BOO_ID, $SEAT_ID, $price));

            $count = $stmt->rowCount();
            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật ticket thành công'));
            } else {
                die(json_encode(array('status' => false, 'status' => 'Mã ticket không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
