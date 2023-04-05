<?php

class ScheduleModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM schedule';
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

    public function add($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME)
    {
        $sql = 'INSERT INTO schedule(CIN_ID, MOV_ID, STARTTIME, ENDTIME) VALUES(?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME));

            return json_encode(array('status' => true, 'data' => 'Thêm schedule thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
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
                echo json_encode(array('status' => true, 'data' => 'Xóa sinh viên thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã sinh viên không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID)
    {


        $sql = 'UPDATE `schedule` SET  `CIN_ID` = ?,
                `MOV_ID` = ?, `STARTTIME` = ?, `ENDTIME` = ? WHERE `schedule`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật schedule thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có schedule nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
