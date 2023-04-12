<?php

class StaffModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM staff';
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

    public function add($USERNAME, $PASSWORD, $FIRSTNAME,$LASTNAME, $SEX,$BIRTHDAY,$PHONE, $ADDRESS, $SALARY,$ROLE)
    {
        $sql = 'INSERT INTO staff(USERNAME, PASSWORD, FIRSTNAME,LASTNAME, SEX,BIRTHDAY,PHONE, ADDRESS, SALARY,ROLE) VALUES(?,?,?,?,?,?,?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($USERNAME, $PASSWORD, $FIRSTNAME,$LASTNAME, $SEX,$BIRTHDAY,$PHONE, $ADDRESS, $SALARY,$ROLE));

            return json_encode(array('status' => true, 'data' => 'Thêm nhân viên thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM staff where id = ?';

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

    public function update($USERNAME, $FIRSTNAME,$LASTNAME, $SEX,$BIRTHDAY,$PHONE, $ADDRESS, $SALARY,$ROLE,$ID)
    {


        $sql = 'UPDATE `staff` SET `USERNAME` = ?, `FIRSTNAME` = ?, `LASTNAME` = ?,`SEX` = ?,`BIRTHDAY` = ?, `PHONE` = ?, `ADDRESS` = ?, `SALARY` = ?, `ROLE` = ? WHERE `staff`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($USERNAME,$FIRSTNAME,$LASTNAME,$SEX,$BIRTHDAY,$PHONE, $ADDRESS,$SALARY,$ROLE,$ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật nhân viên thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có nhân viên nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function getByID($ID)
    {
        $sql = "SELECT * FROM staff where ID = '$ID'";
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
}
