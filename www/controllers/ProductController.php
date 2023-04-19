<?php
class ProductController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

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
        $params = array(
            'NAME', 'TYPE',  'QUANTITY', 'Expiry_Date'
        );
        $data = $this->validateParams($params);
        echo $this->model->add(
            $data['NAME'],
            $data['TYPE'],
    
            $data['QUANTITY'],
            $data['Expiry_Date']
        );
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
        $params = array(
            'NAME', 'TYPE',  'QUANTITY', 'Expiry_Date', 'ID'
        );
        $data = $this->validateParams($params);
        echo $this->model->update(
            $data['NAME'],
            $data['TYPE'],
    
            $data['QUANTITY'],
            $data['Expiry_Date'],
            $data['ID']
        );
    }
    public function getByID()
    {
        if (isset($_POST['ID'])) {
            echo $this->model->getByID($_POST['ID']);
        }
    }
}
