<?php
class ScheduleController extends AdminController
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
    public function getByMovie()
    {
        if (isset($_GET['movie_id'])) {
            echo $this->model->getByMovie($_GET['movie_id']);
        }
    }

    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }

    public function add()
    {
        $this->isAuthenticated();
        if (
            !isset($_POST['THEA_ID']) || !isset($_POST['PRICE']) ||
            !isset($_POST['MOV_ID']) || !isset($_POST['STARTTIME']) || !isset($_POST['ENDTIME'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $THEA_ID = $_POST['THEA_ID'];
        $MOV_ID = $_POST['MOV_ID'];
        $STARTTIME = $_POST['STARTTIME'];
        $ENDTIME = $_POST['ENDTIME'];
        $PRICE = $_POST['PRICE'];
        echo $this->model->add($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $PRICE);
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
        if (
            !isset($_POST['THEA_ID']) ||
            !isset($_POST['MOV_ID']) || !isset($_POST['STARTTIME']) || !isset($_POST['ENDTIME'])
            || !isset($_POST['ID'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $THEA_ID = $_POST['THEA_ID'];
        $MOV_ID = $_POST['MOV_ID'];
        $STARTTIME = $_POST['STARTTIME'];
        $ENDTIME = $_POST['ENDTIME'];
        echo $this->model->update($THEA_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID);
    }
}
