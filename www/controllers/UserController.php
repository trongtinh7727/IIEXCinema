<?php
class UserController
{
    public $model;
    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            require_once('views/Auths/login.php');
            exit;
        }
    }

    function Login()
    {
        if (isset($_POST['LoginSubmit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $check =  $this->model->CheckUserLogin($username, $password);
            if ($check == 1) {
                $_SESSION['userLogin'] = 1;
                require_once('views/dashboard.php');
            }
        }
        if (isset($_SESSION['userLogin'])) {
            require_once('views/dashboard.php');
        } else {
            require_once('views/Auths/login.php');
        }
    }
    function logout()
    {
        unset($_SESSION['userLogin']);
        require_once('views/Auths/login.php');
    }
}
