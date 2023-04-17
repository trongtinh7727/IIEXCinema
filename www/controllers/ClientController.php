<?php
class ClientController extends AdminController
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
        $params = array(
            'USERNAME', 'FIRSTNAME', 'LASTNAME', 'SEX', 'BIRTHDAY', 'PHONE', 'ADDRESS'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['USERNAME'],
            $data['FIRSTNAME'],
            $data['LASTNAME'],
            $data['SEX'],
            $data['BIRTHDAY'],
            $data['PHONE'],
            $data['ADDRESS']
        );
    }
    public function delete()
    {
        if (!isset($_POST['id'])) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $id = $_POST['id'];

        echo $this->model->delete($id);
    }
    public function update()
    {
        $params = array(
            'USERNAME', 'FIRSTNAME', 'LASTNAME', 'SEX', 'BIRTHDAY', 'PHONE', 'ADDRESS', 'ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['USERNAME'],
            $data['FIRSTNAME'],
            $data['LASTNAME'],
            $data['SEX'],
            $data['BIRTHDAY'],
            $data['PHONE'],
            $data['ADDRESS'],
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
