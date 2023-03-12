<?php

class UserModel
{
    public $db;
    public function CheckUserLogin($username, $password)
    {
        $sql = "Select * From usertable where username = '{$username}' 
        and password = '{$password}'";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
}
?>
