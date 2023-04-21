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
        $stmt->execute(array($newPassword, $username, $password));
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function add($USERNAME, $PASSWORD, $FIRSTNAME, $LASTNAME, $PHONE)
    {
        if ($this->isExists($USERNAME)) {
            return  "username đã tồn tại";
        }
        $sql = 'INSERT INTO client(USERNAME, PASSWORD, FIRSTNAME,LASTNAME, PHONE) VALUES(?,?,?,?,?)';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($USERNAME, $PASSWORD, $FIRSTNAME, $LASTNAME, $PHONE));

            return true;
        } catch (PDOException $ex) {
            return ($ex->getMessage());
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
