<?php
class TicketController extends AdminController
{
    public $model;

    function __construct()
    {
        $this->isAuthenticated();
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();
        if (!isset($_POST['PRICE'])) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $Price = $_POST['PRICE'];
        echo $this->model->add($Price);
    }
    public function addTicketSeatSchedule()
    {
        $this->isAuthenticated();
        if (!isset($_POST['SEAT_ID']) || !isset($_POST['SCHEDULE_ID']) || !isset($_POST['TICKET_ID'])) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $SEAT_ID = $_POST['SEAT_ID'];
        $SCHEDULE_ID = $_POST['SCHEDULE_ID'];
        $TICKET_ID = $_POST['TICKET_ID'];
        echo $this->model->add($SEAT_ID, $SCHEDULE_ID, $TICKET_ID);
    }

    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
