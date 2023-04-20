<?php
class FoodComboController extends AdminController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getDrinks()
    {
        echo $this->model->getDrinks();
    }
    public function getFoods()
    {
        echo $this->model->getFoods();
    }
    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();

        $params = array(
            'NAME', 'FOOD', 'FOOD_QUANTITY', 'DRINK', 'DRINK_QUANTITY', 'PRICE'
        );
        $data = $this->validateParams($params);
        $image_path = (new UploadHelper())->uploadFile("foodcombo", $_FILES['Image']);
        echo $this->model->add(
            $data['NAME'],
            $data['FOOD'],
            $data['FOOD_QUANTITY'],
            $data['DRINK'],
            $data['DRINK_QUANTITY'],
            $data['PRICE'],
            $image_path
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
            'NAME', 'FOOD', 'FOOD_QUANTITY', 'DRINK', 'DRINK_QUANTITY', 'PRICE', 'ID'
        );
        $data = $this->validateParams($params);

        echo $this->model->update(
            $data['NAME'],
            $data['FOOD'],
            $data['FOOD_QUANTITY'],
            $data['DRINK'],
            $data['DRINK_QUANTITY'],
            $data['PRICE'],
            $data['ID']
        );
    }
}
