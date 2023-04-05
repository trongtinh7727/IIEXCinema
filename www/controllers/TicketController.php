<?php
class TicketController extends AdminController
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
        if ( !isset($_POST['SCH_ID'])
          ||  !isset($_POST['BOO_ID']) || !isset($_POST['SEAT_ID']) || !isset($_POST['PRICE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $SCH_ID = $_POST['SCH_ID'];
        $BOO_ID = $_POST['BOO_ID'];
        $SEAT_ID = $_POST['SEAT_ID'];
        $Price = $_POST['PRICE'];
        echo $this->model->add($SCH_ID, $BOO_ID, $SEAT_ID,$Price);
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
        if( !isset($_POST['SCH_ID'])
        ||  !isset($_POST['BOO_ID']) || !isset($_POST['SEAT_ID']) || !isset($_POST['PRICE']) || !isset($_POST['ID']))
        {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $ID = $_POST['ID'];
        $SCH_ID = $_POST['SCH_ID'];
        $BOO_ID = $_POST['BOO_ID'];
        $SEAT_ID = $_POST['SEAT_ID'];
        $Price = $_POST['PRICE'];
        echo $this->model->update($ID,$SCH_ID, $BOO_ID, $SEAT_ID,$Price);
    }

    public function getByID()
    {
        if(isset($_POST['ID'])){
            echo $this->model->getByID($_POST['ID']);
        }
    }
}