<?php

class FoodComboModel
{
    public $db;
    public function setDB($db)
    {
        $this->db = $db;
    }
    public function getDrinks()
    {
        $sql = 'SELECT * FROM `product` where Type = "Đồ uống"';
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
    public function getFoods()
    {
        $sql = 'SELECT * FROM `product` where Type = "Đồ ăn"';
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
    public function getAll()
    {
        $sql = 'CALL `get_foodcombo`()';
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

    private function isExists($foodcombo_id)
    {
        $sql = 'SELECT * FROM food_booking where FOOD_ID = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($foodcombo_id));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }
        return false;
    }

    public function add($NAME, $FOOD, $FOOD_QUANTITY, $DRINK, $DRINK_QUANTITY, $PRICE, $Image)
    {

        // Insert into foodcombo

        $sql = 'INSERT INTO `foodcombo` (`ID`, `NAME`, `PRICE`, `Image`) VALUES (NULL, ?, ?, ?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $PRICE, $Image));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        // insert drink into product_fcb
        $foodcombo_id = $this->db->lastInsertId();
        $sql = 'INSERT INTO `product_fcb` (`PRODUCT_ID`, `FCB_ID`, `QUANTITY`) VALUES (?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($DRINK, $foodcombo_id, $DRINK_QUANTITY));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        // insert food into product_fcb
        $sql = 'INSERT INTO `product_fcb` (`PRODUCT_ID`, `FCB_ID`, `QUANTITY`) VALUES (?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($FOOD, $foodcombo_id, $FOOD_QUANTITY));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        return json_encode(array('status' => true, 'data' => 'Thêm foodcombo thành công'));
    }

    public function delete($id)
    {
        if ($this->isExists($id)) {
            return (json_encode(array('status' => false, 'data' => "Combo đã tồn tại trong lịch sử giao dịch")));
        }

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

    public function update($NAME, $FOOD, $FOOD_QUANTITY, $DRINK, $DRINK_QUANTITY, $PRICE, $ID)
    {


        $sql = 'UPDATE `foodcombo` SET `NAME` = ? , `PRICE` = ? WHERE `foodcombo`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $PRICE, $ID));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        // update Drink
        $sql = 'UPDATE `product_fcb` SET `QUANTITY` = ?, `product_fcb`.`PRODUCT_ID` = ? WHERE  `product_fcb`.`FCB_ID` = ?';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($DRINK_QUANTITY, $DRINK, $ID));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        // update FOOD
        $sql = 'UPDATE `product_fcb` SET `QUANTITY` = ?, `product_fcb`.`PRODUCT_ID` = ? WHERE  `product_fcb`.`FCB_ID` = ?';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($FOOD_QUANTITY, $FOOD, $ID));
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
