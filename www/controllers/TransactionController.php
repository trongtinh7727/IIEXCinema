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
}
