<?php
class CinemaController extends AdminController
{
    public $model;

    function __construct()
    {
        // $this->isAuthenticated();
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();

        $params = array(
            'NAME', 'PHONE', 'ADDRESS'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['NAME'],
            $data['ADDRESS'],
            $data['PHONE']
        );
    }


    public function delete()
    {
        $this->isAuthenticated();
        if (!isset($_POST['id'])) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $id = $_POST['id'];

        echo $this->model->delete($id);
    }


    public function update()
    {
        $this->isAuthenticated();
        $params = array(
            'NAME', 'PHONE', 'ADDRESS', 'ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['NAME'],
            $data['ADDRESS'],
            $data['PHONE'],
            $data['ID']
        );
    }

    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
