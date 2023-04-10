<?php
class HomeController extends AuthController
{
    public function indexAction()
    {
        $this->isAuthenticated();
        require_once('views/Client/index.php');
    }
}
