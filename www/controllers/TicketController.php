<?php
class TicketController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

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
        $params = array(
            'PRICE'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['PRICE'],
        );
    }
    public function addTicketSeatSchedule()
    {
        $this->isAuthenticated();
        $params = array(
            'SEAT_ID', 'SCHEDULE_ID', 'TICKET_ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['SEAT_ID'],
            $data['SCHEDULE_ID'],
            $data['TICKET_ID']
        );
    }

    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
