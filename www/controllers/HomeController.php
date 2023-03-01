<?php
class HomeController extends UserController
{
    public $model;

    public function indexAction()
    {
        $this->isAuthenticated();
        require_once('views/dashboard.php');
    }
}
