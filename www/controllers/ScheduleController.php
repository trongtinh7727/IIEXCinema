<?php
class ScheduleController extends AdminController
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
            !isset($_POST['CIN_ID']) ||
            !isset($_POST['MOV_ID']) || !isset($_POST['STARTTIME']) || !isset($_POST['ENDTIME'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $CIN_ID = $_POST['CIN_ID'];
        $MOV_ID = $_POST['MOV_ID'];
        $STARTTIME = $_POST['STARTTIME'];
        $ENDTIME = $_POST['ENDTIME'];
        echo $this->model->add($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME);
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
            !isset($_POST['CIN_ID']) ||
            !isset($_POST['MOV_ID']) || !isset($_POST['STARTTIME']) || !isset($_POST['ENDTIME'])
            || !isset($_POST['ID'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $CIN_ID = $_POST['CIN_ID'];
        $MOV_ID = $_POST['MOV_ID'];
        $STARTTIME = $_POST['STARTTIME'];
        $ENDTIME = $_POST['ENDTIME'];
        echo $this->model->update($CIN_ID, $MOV_ID, $STARTTIME, $ENDTIME, $ID);
    }
}
