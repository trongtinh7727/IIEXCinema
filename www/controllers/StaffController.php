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
            !isset($_POST['USERNAME']) || !isset($_POST['FIRSTNAME'])
            || !isset($_POST['LASTNAME']) || !isset($_POST['SEX']) || !isset($_POST['BIRTHDAY'])
            || !isset($_POST['PHONE']) || !isset($_POST['ADDRESS'])
            || !isset($_POST['SALARY']) || !isset($_POST['ROLE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $USERNAME = $_POST['USERNAME'];
        $FIRSTNAME = $_POST['FIRSTNAME'];
        $LASTNAME = $_POST['LASTNAME'];
        $BIRTHDAY = $_POST['BIRTHDAY'];
        $SEX = $_POST['SEX'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        $SALARY = $_POST['SALARY'];
        $ROLE = $_POST['ROLE'];
        echo $this->model->add($USERNAME, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS, $SALARY, $ROLE);
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
            !isset($_POST['USERNAME'])  || !isset($_POST['FIRSTNAME'])
            || !isset($_POST['LASTNAME']) || !isset($_POST['SEX']) || !isset($_POST['BIRTHDAY'])
            || !isset($_POST['PHONE']) || !isset($_POST['ADDRESS'])
            || !isset($_POST['SALARY']) || !isset($_POST['ROLE']) || !isset($_POST['ID'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $USERNAME = $_POST['USERNAME'];
        $FIRSTNAME = $_POST['FIRSTNAME'];
        $LASTNAME = $_POST['LASTNAME'];
        $BIRTHDAY = $_POST['BIRTHDAY'];
        $SEX = $_POST['SEX'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        $SALARY = $_POST['SALARY'];
        $ROLE = $_POST['ROLE'];

        echo $this->model->update($USERNAME, $FIRSTNAME, $LASTNAME, $SEX, $BIRTHDAY, $PHONE, $ADDRESS, $SALARY, $ROLE, $ID);
    }
    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
