<?php

class SeatModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM seat';
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

    public function add($THE_ID, $SEATNUMBER, $SEATTYPE)
    {
        $sql = 'INSERT INTO seat(THE_ID, SEATNUMBER, SEATTYPE) VALUES(?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($THE_ID, $SEATNUMBER, $SEATTYPE));

            return json_encode(array('status' => true, 'data' => 'Thêm seat thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM seat where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa sinh viên thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã sinh viên không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($THE_ID, $SEATNUMBER, $SEATTYPE, $ID)
    {


        $sql = 'UPDATE `seat` SET  `THE_ID` = ?,
                `SEATNUMBER` = ?, `SEATTYPE` = ? WHERE `seat`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($THE_ID, $SEATNUMBER, $SEATTYPE, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật seat thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có seat nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
