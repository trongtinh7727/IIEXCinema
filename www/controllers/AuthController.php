<?php
class AuthController
{
    public $model;

    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            header("Location: /?login");
            exit;
        }
    }

    function Login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $tb = $_POST['tb'];
            $check =  $this->model->CheckUserLogin($username, $password, $tb);
            if ($check == 1) {
                $_SESSION['userLogin']['username'] = $username;
                if ($tb == 'staff') {
                    $_SESSION['userLogin']['role'] = 1;
                    header("Location: /?admin/");
                } else {
                    $_SESSION['userLogin']['role'] = 2;
                    header("Location: /?");
                }
            }
        }
        if (isset($_SESSION['userLogin'])) {
            if ($_SESSION['userLogin']['role'] == 1) {
                header("Location: /?admin/");
            } else {
                header("Location: /?");
            }
        } else {
            if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
                require_once('views/Admin/Auths/login.php');
            } else {
                require_once('views/Client/Auths/login.php');
            }
        }
    }
    function logout()
    {
        unset($_SESSION['userLogin']);
        if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
            require_once('views/Admin/Auths/login.php');
        } else {
            require_once('views/Client/Auths/login.php');
        }
    }
}
