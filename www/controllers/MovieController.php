<?php
class MovieController extends AdminController
{
    public $model;
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {

        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();
        $params = array(
            'TITLE', 'DIRECTOR',
            'ACTORS', 'GENRE', 'STORY', 'DURATION',
            'OPENING_DAY', 'CLOSING_DAY', 'TRAILER'
        );
        $data = $this->validateParams($params);
        $poster = (new UploadHelper())->uploadFile("movie", $_FILES['POSTER']);

        echo $this->model->add(
            $data['TITLE'],
            $data['DIRECTOR'],
            $data['ACTORS'],
            $data['GENRE'],
            $data['STORY'],
            $data['DURATION'],
            $data['OPENING_DAY'],
            $data['CLOSING_DAY'],
            $poster,
            $data['TRAILER']
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
            'ID', 'TITLE', 'DIRECTOR',
            'ACTORS', 'GENRE', 'STORY', 'DURATION',
            'OPENING_DAY', 'CLOSING_DAY', 'TRAILER'
        );
        $data = $this->validateParams($params);
        $poster = '0';
        $trailer = '0';
        if (isset($_FILES['POSTER'])) {
            $poster = (new UploadHelper())->uploadFile("movie", $_FILES['POSTER']);
        }
        echo $this->model->update(
            $data['TITLE'],
            $data['DIRECTOR'],
            $data['ACTORS'],
            $data['GENRE'],
            $data['STORY'],
            $data['DURATION'],
            $data['OPENING_DAY'],
            $data['CLOSING_DAY'],
            $poster,
            $data['TRAILER'],
            $data['ID']
        );
    }
    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }

    public function ongoing()
    {
        echo $this->model->ongoing();
    }
    public function upcoming()
    {
        echo $this->model->upcoming();
    }
    public function gettrailer()
    {
        echo $this->model->gettrailer();
    }
}
