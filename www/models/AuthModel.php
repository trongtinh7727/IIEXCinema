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
        $count = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count += 1;
        }
        return $count;
    }
}
