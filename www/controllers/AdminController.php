<?php
class AdminController extends AuthController
{
    public $model;

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
    public function suppliesAction()
    {
        $this->isAuthenticated();
        $_SESSION['path'] = 'Supplies';
        require_once('views/Admin/dashboard.php');
    }
}
