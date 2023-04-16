<?php
class TheaterController extends AdminController
{
    public $model;

    function __construct()
    {
    }

    public function getByCinema()
    {
        if (isset($_GET['cinema_id'])) {
            echo $this->model->getByCinema($_GET['cinema_id']);
        }
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();
        if (

            !isset($_POST['THEATERNUM'])
            || !isset($_POST['SEATCOUNT'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $THEATERNUM = $_POST['THEATERNUM'];
        $SEATCOUNT = $_POST['SEATCOUNT'];
        echo $this->model->add($THEATERNUM, $SEATCOUNT);
    }
    public function update()
    {
        $this->isAuthenticated();
        if (
            !isset($_POST['THEATER_ID']) ||
            !isset($_POST['THEATERNUM'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $THEATER_ID = $_POST['THEATER_ID'];
        $THEATERNUM = $_POST['THEATERNUM'];
        echo $this->model->update($THEATERNUM, $THEATER_ID);
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
}
