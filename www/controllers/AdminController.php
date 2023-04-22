<?php
class AdminController extends AuthController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    // validate if the params is null


    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            header("Location: /?admin/login");
            exit;
        } else if ($_SESSION['userLogin']['role'] == 2) {
            header("Location: /?");
            exit;
        }
    }

    public function indexAction()
    {
        $this->isAuthenticated();
        $path = 'Staff';
        require_once('views/Admin/dashboard.php');
    }
    public function changePasswordAction()
    {
        $this->isAuthenticated();
        require_once('views/Admin/Auths/changepass.php');
    }

    public function staffAction()
    {
        $this->isAuthenticated();
        $path = 'Staff';
        require_once('views/Admin/dashboard.php');
    }
    public function clientAction()
    {
        $this->isAuthenticated();
        $path = 'Client';
        require_once('views/Admin/dashboard.php');
    }
    public function cinemaAction()
    {
        $this->isAuthenticated();
        $path = 'Cinema';
        require_once('views/Admin/dashboard.php');
    }
    public function movieAction()
    {
        $this->isAuthenticated();
        $path = 'Movie';
        require_once('views/Admin/dashboard.php');
    }
    public function scheduleAction()
    {
        $this->isAuthenticated();
        $path = 'Schedule';
        require_once('views/Admin/dashboard.php');
    }
    public function showroomAction()
    {
        $this->isAuthenticated();
        $path = 'Showroom';
        require_once('views/Admin/dashboard.php');
    }
    public function productAction()
    {
        $this->isAuthenticated();
        $path = 'Product';
        require_once('views/Admin/dashboard.php');
    }

    public function transactionAction()
    {
        $this->isAuthenticated();
        $path = 'Transaction';
        require_once('views/Admin/dashboard.php');
    }
    public function comboAction()
    {
        $this->isAuthenticated();
        $path = 'Combo';
        require_once('views/Admin/dashboard.php');
    }
    public function revenueAction()
    {
        $this->isAuthenticated();
        $path = 'Revenue';
        require_once('views/Admin/dashboard.php');
    }
}
