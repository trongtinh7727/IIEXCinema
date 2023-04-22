<?php
class TransactionController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function getRevenue(){
        $params = array(
            'Month'
        );
        $data = $this->validateParams($params);
        echo $this->model->getRevenue(
            $data['Month'],
        );
    }

    public function getByID(){
        if (isset($_GET['booking_id'])) {
            echo $this->model->getByID(
                $_GET['booking_id']
            );
        }
    }
}
