<?php
class AdminController extends AuthController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    // validate if the params is null
    function validateParams($params)
    {
        foreach ($params as $param) {
            if (!isset($_POST[$param]) || strlen($_POST[$param]) < 1) {
                die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
            }
        }
        return array_map('trim', $_POST);
    }

    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            header("Location: /?admin/login");
            exit;
        } else if ($_SESSION['userLogin'] == 2) {
            header("Location: /?");
            exit;
        }
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
    public function scheduleAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Schedule';
        require_once('views/Admin/dashboard.php');
    }
    public function theaterAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'theater';
        require_once('views/Admin/dashboard.php');
    }
    public function productAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Product';
        require_once('views/Admin/dashboard.php');
    }
}
