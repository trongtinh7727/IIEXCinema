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

    public function showtime()
    {
        $db = Connection::$connection;
        $model = new ScheduleModel();
        $model->db = $db;
        $showtimes = $model->getScheduleToday();
        // foreach ($showtimes as $key) {
        //     print_r($key['ID']);
        //     print_r($key['TITLE']);
        //     print_r($key['MID']);
        //     print_r($key['POSTER']);
        // }
        // print_r($showtimes);
        $_SESSION['path'] = "Showtime";
        require_once('views/Client/index.php');
    }
}
