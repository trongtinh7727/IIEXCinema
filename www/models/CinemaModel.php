<?php

class CinemaModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM cinema';
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

    public function add($NAME, $ADDRESS, $PHONE)
    {
        $sql = 'INSERT INTO cinema(NAME,ADDRESS, PHONE) VALUES(?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $ADDRESS, $PHONE));

            return json_encode(array('status' => true, 'data' => 'Thêm rạp phim thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM cinema where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa rạp phim thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã rạp phim không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($NAME, $ADDRESS, $PHONE, $ID)
    {


        $sql = 'UPDATE `cinema` SET `NAME` = ?, `ADDRESS` = ?, `PHONE` = ? WHERE `cinema`.`ID` = ?';
                 

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $ADDRESS, $PHONE, $ID, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật rạp phim thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có rạp phim nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
