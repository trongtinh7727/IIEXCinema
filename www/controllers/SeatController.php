<?php
class SeatController extends AdminController
{
    public $model;

    function __construct()
    {
    }

    public function getByTheater()
    {
        if (isset($_GET['theater_id'])) {
            echo $this->model->getByTheater($_GET['theater_id']);
        }
    }
}
