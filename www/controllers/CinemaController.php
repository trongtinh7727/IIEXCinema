<?php
class CinemaController extends AdminController
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
        if ( !isset($_POST['NAME'])
          ||  !isset($_POST['PHONE']) || !isset($_POST['ADDRESS'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $NAME = $_POST['NAME'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        echo $this->model->add($NAME, $ADDRESS, $PHONE);
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
            !isset($_POST['NAME']) 
          ||  !isset($_POST['PHONE']) || !isset($_POST['ADDRESS']) || !isset($_POST['ID']) 
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $NAME = $_POST['NAME'];
        $PHONE = $_POST['PHONE'];
        $ADDRESS = $_POST['ADDRESS'];
        echo $this->model->update($NAME, $ADDRESS, $PHONE, $ID);
    }

    public function getByID()
    {
        if(isset($_POST['ID'])){
            echo $this->model->getByID($_POST['ID']);
        }
    }
}