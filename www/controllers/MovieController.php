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
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Số dòng mỗi trang
        $columnIndex = $_POST['order'][0]['column']; // Cột đánh chỉ số
        $columnName = $_POST['columns'][$columnIndex]['data']; // Cột tên
        $columnSortOrder = $_POST['order'][0]['dir']; // Sắp xếp asc / desc
        $searchValue = $_POST['search']['value']; // Từ khóa tìm kiếm

        // print_r($row);
        echo $this->model->getAll();
    }




    public function add()
    {
        $this->isAuthenticated();
        $params = array(
            'TITLE', 'DIRECTOR',
            'ACTORS', 'GENRE', 'STORY', 'DURATION',
            'OPENING_DAY', 'CLOSING_DAY', 'POSTER', 'TRAILER'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['TITLE'],
            $data['DIRECTOR'],
            $data['ACTORS'],
            $data['GENRE'],
            $data['STORY'],
            $data['DURATION'],
            $data['OPENING_DAY'],
            $data['CLOSING_DAY'],
            $data['POSTER'],
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
        $this->isAuthenticated();
        $params = array(
            'ID', 'TITLE', 'DIRECTOR',
            'ACTORS', 'GENRE', 'STORY', 'DURATION',
            'OPENING_DAY', 'CLOSING_DAY', 'POSTER', 'TRAILER'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['TITLE'],
            $data['DIRECTOR'],
            $data['ACTORS'],
            $data['GENRE'],
            $data['STORY'],
            $data['DURATION'],
            $data['OPENING_DAY'],
            $data['CLOSING_DAY'],
            $data['POSTER'],
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
