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
}
