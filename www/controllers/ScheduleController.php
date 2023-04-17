<?php
class ScheduleController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
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
        $params = array(
            'THEA_ID', 'PRICE', 'MOV_ID', 'STARTTIME', 'ENDTIME'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['THEA_ID'],
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
            'THEA_ID', 'ID', 'MOV_ID', 'STARTTIME', 'ENDTIME'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['THEA_ID'],
            $data['MOV_ID'],
            $data['STARTTIME'],
            $data['ENDTIME'],
            $data['ID']
        );
    }
}
