<?php
class StaffController extends AdminController
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
        if (
            !isset($_POST['USERNAME']) || !isset($_POST['PASSWORD']) || !isset($_POST['NAME'])
            || !isset($_POST['CODE']) || !isset($_POST['PHONE']) || !isset($_POST['ADDRESS'])
            || !isset($_POST['SALARY'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $USERNAME = $_POST['USERNAME'];
        $PASSWORD = $_POST['PASSWORD'];
        $NAME = $_POST['NAME'];
        $CODE = $_POST['CODE'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        $SALARY = $_POST['SALARY'];
        echo $this->model->add($USERNAME, $PASSWORD, $NAME, $CODE, $PHONE, $ADDRESS, $SALARY);
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
        if (
            !isset($_POST['USERNAME']) || !isset($_POST['PASSWORD']) || !isset($_POST['NAME'])
            || !isset($_POST['CODE']) || !isset($_POST['PHONE']) || !isset($_POST['ADDRESS'])
            || !isset($_POST['SALARY'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $ID = $_POST['ID'];
        $USERNAME = $_POST['USERNAME'];
        $PASSWORD = $_POST['PASSWORD'];
        $NAME = $_POST['NAME'];
        $CODE = $_POST['CODE'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        $SALARY = $_POST['SALARY'];
        echo $this->model->update($USERNAME, $PASSWORD, $NAME, $CODE, $PHONE, $ADDRESS, $SALARY, $ID);
    }
    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
