<?php
class HomeController extends AuthController
{
    public function indexAction()
    {
        // $this->isAuthenticated();
        $_SESSION['path'] = "HomePage";
        require_once('views/Client/index.php');
    }

    public function movieDetail()
    {
        $movie_id = $_GET['id'];
        $_SESSION['path'] = "MovieDetail";
        require_once('views/Client/index.php');
    }
}
