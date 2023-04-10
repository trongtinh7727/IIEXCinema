<?php
class SeatController extends AdminController
{
    public $model;

    function __construct()
    {
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();
        if (
            !isset($_POST['THE_ID']) ||
            !isset($_POST['SEATNUMBER']) || !isset($_POST['SEATTYPE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $THE_ID = $_POST['THE_ID'];
        $SEATNUMBER = $_POST['SEATNUMBER'];
        $SEATTYPE = $_POST['SEATTYPE'];
        echo $this->model->add($THE_ID, $SEATNUMBER, $SEATTYPE);
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
            !isset($_POST['THE_ID']) ||
            !isset($_POST['SEATNUMBER']) || !isset($_POST['SEATTYPE'])
            || !isset($_POST['ID'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $THE_ID = $_POST['THE_ID'];
        $SEATNUMBER = $_POST['SEATNUMBER'];
        $SEATTYPE = $_POST['SEATTYPE'];
        echo $this->model->update($THE_ID, $SEATNUMBER, $SEATTYPE, $ID);
    }
}
