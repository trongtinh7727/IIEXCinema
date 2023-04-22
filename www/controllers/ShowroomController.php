<?php
class ShowroomController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
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
        $params = array(
            'SHOWROOMNUM', 'CINEMA_ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['SHOWROOMNUM'],
            $data['CINEMA_ID']

        );
    }
    public function update()
    {
        $this->isAuthenticated();
        $params = array(
            'SHOWROOMNUM', 'SHOWROOM_ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['SHOWROOMNUM'],
            $data['SHOWROOM_ID']
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
}
