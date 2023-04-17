<?php

class FoodComboModel
{
    public $db;
    public function setDB($db)
    {
        $this->db = $db;
    }
    public function getAll()
    {
        $sql = 'SELECT * FROM foodcombo';
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

    public function add($NAME, $PRICE, $TYPE, $QUANTITY)
    {
        $sql = 'INSERT INTO foodcombo(NAME, PRICE, TYPE, QUANTITY) VALUES(?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $PRICE, $TYPE, $QUANTITY));

            return json_encode(array('status' => true, 'data' => 'Thêm foodcombo thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM foodcombo where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa foodcombo thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã foodcombo không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($NAME, $PRICE, $TYPE, $QUANTITY, $ID)
    {


        $sql = 'UPDATE `foodcombo` SET  `NAME` = ?,
                `PRICE` = ?, `TYPE` = ?, `QUANTITY` = ? WHERE `foodcombo`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $PRICE, $TYPE, $QUANTITY, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật foodcombo thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có foodcombo nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
