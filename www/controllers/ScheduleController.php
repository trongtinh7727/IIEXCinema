<?php
class ScheduleController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }
    public function getByShowroom()
    {
        if (isset($_GET['showroom_id'])) {
            echo $this->model->getByShowroom($_GET['showroom_id']);
        }
    }

    public function getByMovie()
    {
        if (isset($_GET['movie_id'])) {
            echo $this->model->getByMovie($_GET['movie_id']);
        }
    }

    public function getBookedSeat()
    {
        if (isset($_POST['schedule_id'])) {
            echo $this->model->getBookedSeat($_POST['schedule_id']);
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
        $params = array(
            'SHOWROOM_ID', 'PRICE', 'MOV_ID', 'STARTTIME', 'ENDTIME'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['SHOWROOM_ID'],
            $data['MOV_ID'],
            $data['STARTTIME'],
            $data['ENDTIME'],
            $data['PRICE']
        );
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
        $params = array(
            'SHOWROOM_ID', 'ID', 'MOV_ID', 'STARTTIME', 'ENDTIME'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['SHOWROOM_ID'],
            $data['MOV_ID'],
            $data['STARTTIME'],
            $data['ENDTIME'],
            $data['ID']
        );
    }
}
