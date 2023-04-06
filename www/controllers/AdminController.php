<?php
class AdminController
{
    public $model;

    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            header("Location: /?admin/login");
            // require_once('views/Auths/login.php');
            exit;
        }
    }

    function Login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $check =  $this->model->CheckUserLogin($username, $password);

            if ($check == 1) {
                $_SESSION['userLogin'] = 1;
                $this->indexAction();
            }
        }
        if (isset($_SESSION['userLogin'])) {
            header("Location: /?admin/");
            // $this->indexAction();
        } else {
            require_once('views/Auths/login.php');
        }
    }
    function logout()
    {
        unset($_SESSION['userLogin']);
        require_once('views/Auths/login.php');
    }

    public function indexAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Staff';
        require_once('views/Admin/dashboard.php');
    }

    public function staffAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Staff';
        require_once('views/Admin/dashboard.php');
    }
    public function cinemaAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Cinema';
        require_once('views/Admin/dashboard.php');
    }
    public function movieAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Movie';
        require_once('views/Admin/dashboard.php');
    }
    public function suppliesAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Supplies';
        require_once('views/Admin/dashboard.php');
    }
}
