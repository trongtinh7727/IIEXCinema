<?php
class HomeController
{
    public $model;

    public function indexAction()
    {
        if (isset($_POST['LoginSubmit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $check =  $this->model->CheckUserLogin($username, $password);
            if ($check == 1) {
                $_SESSION['userLogin'] = 1;
            }
        }
        $this->routeManger();
    }
    public function routeManger()
    {
        if (isset($_SESSION['userLogin'])) {
            require_once('views/dashboard.php');
        } else {
            require_once('views/login.php');
        }
    }
}
