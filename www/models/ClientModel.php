<?php

class ClientModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = 'SELECT ID, USERNAME, FIRSTNAME , LASTNAME, SEX, BIRTHDAY, PHONE, ADDRESS FROM client';
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
    public function add($USERNAME, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS)
    {
        $PASSWORD = 'Demo@123';
        if ($this->isExists($USERNAME)) {
            return (json_encode(array('status' => false, 'data' => "username đã tồn tại")));
        }
        $sql = 'INSERT INTO client(USERNAME, PASSWORD, FIRSTNAME,LASTNAME, SEX,BIRTHDAY,PHONE, ADDRESS) VALUES(?,?,?,?,?,?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($USERNAME, $PASSWORD, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS));

            return json_encode(array('status' => true, 'data' => 'Thêm khách hàng thành công'));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    private function isExists($USERNAME)
    {
        $sql = 'SELECT * FROM client where username = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($USERNAME));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM client where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa sinh viên thành công'));
            } else {
                return (json_encode(array('status' => false, 'data' => 'Mã sinh viên không hợp lệ')));
            }
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS, $ID)
    {


        $sql = 'UPDATE `client` SET  `FIRSTNAME` = ?, `LASTNAME` = ?,`SEX` = ?,`BIRTHDAY` = ?, `PHONE` = ?, `ADDRESS` = ? WHERE `client`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => "true", 'data' => 'Cập nhật nhân viên thành công'));
            } else {
                return (json_encode(array('status' => "false", 'data' => 'Không có nhân viên nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            return (json_encode(array('status' => "false", 'data' => $ex->getMessage())));
        }
    }

    public function getByID($ID)
    {
        $sql = "SELECT * FROM client where ID = '$ID'";
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
