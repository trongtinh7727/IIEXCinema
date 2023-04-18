<?php

class ScheduleModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getByTheater($theater_id)
    {
        $sql = "CALL `get_schedule_by_theater`(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($theater_id));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return json_encode(array('status' => true, 'data' => $data));
    }

    private function isValidSchedule($STARTTIME, $THEA_ID)
    {
        $sql = 'CALL `isValidSchedule`(?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($STARTTIME, $THEA_ID));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return (json_encode(array('status' => false, 'data' => "Trùng lịch chiếu!")));
        }
        return 1;
    }

    public function getScheduleToday()
    {
        $sql = "CALL `get_schedule_today`()";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tmp = array("ID" => $row['ID'], "TITLE" => $row['TITLE'], "MID" => $row['MID'], "POSTER" => $row['POSTER'], "STORY" => $row['STORY'], "TIME" =>   explode(',', $row['TIME']), "DAY" => $row['DAY']);
            $data[] = $tmp;
        }
        return $data;
    }

    public function getByMovie($ID)
    {
        $sql = "SELECT * FROM schedule where MOV_ID = '$ID' order by STARTTIME";
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

        return json_encode(array('status' => true, 'data' => $data));
    }
    public function getByID($ID)
    {
        $sql = "CALL `get_schedule_by_id`(?)";
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
        return json_encode(array('status' => true, 'data' => $data));
    }

    public function add($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $PRICE)
    {
        $isValid = $this->isValidSchedule($STARTTIME, $THEA_ID);
        if ($isValid == 1) {
            $sql = 'CALL `create_schedule`(?, ?, ?, ?, ?);';
            try {
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $PRICE));
                $schedule_id = $this->db->lastInsertId();
                return json_encode(array('status' => true, 'data' => array('schedule_id' => $schedule_id, 'message' => 'Thêm lịch chiếu thành công')));
            } catch (PDOException $ex) {
                return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
        } else {
            return  $isValid;
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM schedule where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa lịch chiếu thành công'));
            } else {
                return (json_encode(array('status' => false, 'data' => 'Mã lịch chiếu không hợp lệ')));
            }
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID)
    {
        $isValid = $this->isValidSchedule($STARTTIME, $THEA_ID);
        if ($isValid == 1) {
            $sql = 'UPDATE `schedule` SET  `THEA_ID` = ?,
                `MOV_ID` = ?, `STARTTIME` = ?, `ENDTIME` = ? WHERE `schedule`.`ID` = ?';

            try {
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID));
                $count = $stmt->rowCount();

                if ($count == 1) {
                    echo json_encode(array('status' => true, 'data' => 'Cập nhật lịch thành công'));
                } else {
                    return (json_encode(array('status' => false, 'data' => 'Không có lịch nào được cập nhật')));
                }
            } catch (PDOException $ex) {
                return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
        } else {
            return  $isValid;
        }
    }
}
