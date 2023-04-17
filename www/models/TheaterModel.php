<?php

class TheaterModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getByCinema($cinema_id)
    {
        $sql = "SELECT * FROM theater where cin_id = ? order by theaternum asc";
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
        $sql = 'SELECT * FROM theater';
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

    public function add($THEATERNUM, $SEATCOUNT)
    {
        $sql = ' CALL `create_theater`(?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($THEATERNUM, $SEATCOUNT));
            return json_encode(array('status' => true, 'data' => 'Thêm phòng chiếu thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($THEATERNUM, $THEATER_ID)
    {
        $sql = "UPDATE `theater` SET `THEATERNUM` = ? WHERE `theater`.`ID` = ? ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($THEATERNUM, $THEATER_ID));
            return json_encode(array('status' => true, 'data' => 'Sửa phòng chiếu thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM theater where id = ?';

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
