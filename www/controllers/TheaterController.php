<?php
class TheaterController extends AdminController
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
            !isset($_POST['CIN_ID']) ||
            !isset($_POST['THEATERNUM'])
            || !isset($_POST['SEATCOUNT'])
            || !isset($_POST['ISSHOWING'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $CIN_ID = $_POST['CIN_ID'];
        $THEATERNUM = $_POST['THEATERNUM'];
        $SEATCOUNT = $_POST['SEATCOUNT'];
        $ISSHOWING = $_POST['ISSHOWING'];
        echo $this->model->add($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING);
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
            !isset($_POST['CIN_ID']) ||
            !isset($_POST['THEATERNUM']) || !isset($_POST['SEATCOUNT'])
            || !isset($_POST['ID'])
            || !isset($_POST['ISSHOWING'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $CIN_ID = $_POST['CIN_ID'];
        $THEATERNUM = $_POST['THEATERNUM'];
        $ISSHOWING = $_POST['ISSHOWING'];
        $SEATCOUNT = $_POST['SEATCOUNT'];
        echo $this->model->update($CIN_ID, $THEATERNUM, $SEATCOUNT, $ISSHOWING, $ID);
    }
}
