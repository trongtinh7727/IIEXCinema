<?php
class AuthModel
{
    public $db;
    public function setDB($db)
    {
        $this->db = $db;
    }
    public function CheckUserLogin($username, $password, $tb)
    {
        $sql = 'SELECT * FROM ' . $tb . ' where username = ? 
        and password = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $password));

        $data = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
            return $data;
        }
        return $data;
    }
    public function changePassword($username, $password, $newPassword, $tb)
    {
        $sql = "UPDATE
                    " . $tb . "
                SET
                    `PASSWORD` = ?
                WHERE
                    `username` = ? and password = ?;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($newPassword,$username, $password));

        $data = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
            return $data;
        }
        return $data;
    }

    public function add($USERNAME, $PASSWORD, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS)
    {
        if ($this->isExists($USERNAME)) {
            return  "username đã tồn tại";
        }
        $sql = 'INSERT INTO client(USERNAME, PASSWORD, FIRSTNAME,LASTNAME, SEX,BIRTHDAY,PHONE, ADDRESS) VALUES(?,?,?,?,?,?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($USERNAME, $PASSWORD, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS));

            return true;
        } catch (PDOException $ex) {
            return (array('status' => false, 'data' => $ex->getMessage()));
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
}
