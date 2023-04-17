<?php
class SeatController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getByTheater()
    {
        if (isset($_GET['theater_id'])) {
            echo $this->model->getByTheater($_GET['theater_id']);
        }
    }
}
