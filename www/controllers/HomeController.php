<?php
class HomeController extends AuthController
{
    public $ongoing;
    public $db;

    public function __construct()
    {
        $this->db = Connection::$connection;
        $model = new MovieModel();
        $model->db = $this->db;
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
    public function ticketBooking()
    {
        $this->isAuthenticated();
        $ongoing = $this->ongoing;
        if (isset($_GET['schedule'])) {
            $schedule_id = $_GET['schedule'];
            $model = new ScheduleModel();
            $model->db = $this->db;
            $schedule = $model->getByID($schedule_id);
            $_SESSION['booking']['schedule'] = json_decode($schedule)->data;
        }
        if (
            isset($_POST['total_regular']) && isset($_POST['total_couple']) &&
            isset($_POST['quantity_regular']) && isset($_POST['quantity_couple'])
        ) {
            $_SESSION['booking']['total_regular'] = $_POST['total_regular'];
            $_SESSION['booking']['total_couple'] = $_POST['total_couple'];
            $_SESSION['booking']['quantity_regular'] = $_POST['quantity_regular'];
            $_SESSION['booking']['quantity_couple'] = $_POST['quantity_couple'];
            exit;
        }
        $path = "TicketBooking";
        require_once('views/Client/index.php');
    }

    public function seatBooking()
    {
        $this->isAuthenticated();
        $ongoing = $this->ongoing;

        if (isset($_POST['seats'])) {
            $_SESSION['booking']['seats'] = $_POST['seats'];
        }

        $path = "SeatBooking";
        require_once('views/Client/index.php');
    }
    public function comboBooking()
    {
        $this->isAuthenticated();
        $ongoing = $this->ongoing;
        $model = new FoodComboModel();
        $model->db = $this->db;
        $foods = $model->getAll();
        $foods = json_decode($foods)->data;;
        $path = "ComboBooking";
        require_once('views/Client/index.php');
    }

    public function showtime()
    {
       
        $model = new ScheduleModel();
        $model->db = $this->db;
        $showtimes = $model->getScheduleToday();
        $ongoing = $this->ongoing;
        $path = "Showtime";
        require_once('views/Client/index.php');
    }
}
