<?php
class HomeController extends AuthController
{
    public $ongoing;

    public function __construct()
    {
        $db = Connection::$connection;
        $model = new MovieModel();
        $model->db = $db;
        $this->ongoing = $model->ongoing();
        $this->ongoing = json_decode($this->ongoing)->data;
    }
    public function indexAction()
    {
        $ongoing = $this->ongoing;
        $path = "HomePage";
        require_once('views/Client/index.php');
    }

    public function movieDetail()
    {
        $ongoing = $this->ongoing;
        $movie_id = $_GET['id'];
        $path = "MovieDetail";
        require_once('views/Client/index.php');
    }

    public function showtime()
    {
        $db = Connection::$connection;
        $model = new ScheduleModel();
        $model->db = $db;
        $showtimes = $model->getScheduleToday();
        $ongoing = $this->ongoing;
        $path = "Showtime";
        require_once('views/Client/index.php');
    }
}
