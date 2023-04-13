<?php

class TheaterModel
{
    public $db;

    public function getByCinema($cinema_id){
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

    public function add($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING)
    {
        $sql = 'INSERT INTO theater(CIN_ID, THEATERNUM, SEATCOUNT, ISSHOWING) VALUES(?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING));

            return json_encode(array('status' => true, 'data' => 'Thêm seat thành công'));
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
                echo json_encode(array('status' => true, 'data' => 'Xóa sinh viên thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã sinh viên không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING, $ID)
    {


        $sql = 'UPDATE `theater` SET  `CIN_ID` = ?,
                `THEATERNUM` = ?, `SEATCOUNT, ISSHOWING` = ? WHERE `theater`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING, $ID));
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
