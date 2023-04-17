<?php
class AdminModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }


    public function CheckUserLogin($username, $password)
    {
        $sql = 'SELECT * FROM staff where username = ? 
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
