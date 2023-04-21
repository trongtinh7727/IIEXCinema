<?php

class ShowroomModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getByCinema($cinema_id)
    {
        $sql = "SELECT * FROM showroom where cinema_id = ? order by showroom.SHOWROOMNUM asc";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($cinema_id));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return json_encode(array('status' => true, 'data' => $data));
    }


    public function getByID($ID)
    {
    }
    public function getAll()
    {
        $sql = 'SELECT * FROM SHOWROOM';
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

    public function add($SHOWROOMNUM, $CINEMA_ID)
    {
        $sql = ' CALL `create_SHOWROOM`(?, ?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($SHOWROOMNUM, $CINEMA_ID));
            return json_encode(array('status' => true, 'data' => 'Thêm phòng chiếu thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($SHOWROOMNUM, $SHOWROOM_ID)
    {
        $sql = "UPDATE `SHOWROOM` SET `SHOWROOMNUM` = ? WHERE `SHOWROOM`.`ID` = ? ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($SHOWROOMNUM, $SHOWROOM_ID));
            return json_encode(array('status' => true, 'data' => 'Sửa phòng chiếu thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM SHOWROOM where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa phòng chiếu thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã phòng chiếu không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
