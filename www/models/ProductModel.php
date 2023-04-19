<?php

class ProductModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM Product';
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
    public function add($NAME, $TYPE,  $QUANTITY, $Expiry_Date)
    {
        if ($TYPE == 1) {
            $TYPE = "Đồ ăn";
        }
        if ($TYPE == 2) {
            $TYPE = "Đồ uống";
        }

        $sql = 'INSERT INTO Product(NAME, TYPE, QUANTITY,Expiry_Date) VALUES(?,?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $TYPE,  $QUANTITY, $Expiry_Date));

            return json_encode(array('status' => true, 'data' => 'Thêm sản phẩm thành công'));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }


    public function delete($id)
    {

        $sql = 'DELETE FROM Product where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa sản phẩm thành công'));
            } else {
                return (json_encode(array('status' => false, 'data' => 'Mã sản phẩm không hợp lệ')));
            }
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($NAME, $TYPE,  $QUANTITY, $Expiry_Date, $ID)
    {
        if ($TYPE == 1) {
            $TYPE = "Đồ ăn";
        }
        if ($TYPE == 2) {
            $TYPE = "Đồ uống";
        }

        $sql = 'UPDATE `Product` SET `NAME` = ?, `TYPE` = ?, `QUANTITY` = ?,`Expiry_Date` = ? WHERE `Product`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $TYPE,  $QUANTITY, $Expiry_Date, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật sản phẩm thành công'));
            } else {
                return (json_encode(array('status' => false, 'data' => 'Không có sản phẩm nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function getByID($ID)
    {
        $sql = "SELECT * FROM Product where ID = '$ID'";
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
}
