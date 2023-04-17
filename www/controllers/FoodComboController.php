<?php
class FoodComboController extends AdminController
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
        if (
            !isset($_POST['NAME'])
            ||  !isset($_POST['PRICE']) || !isset($_POST['TYPE']) || !isset($_POST['QUANTITY'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $NAME = $_POST['NAME'];
        $PRICE = $_POST['PRICE'];
        $TYPE = $_POST['TYPE'];
        $QUANTITY = $_POST['QUANTITY'];
        echo $this->model->add($NAME, $PRICE, $TYPE, $QUANTITY);
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
        if (
            !isset($_POST['NAME'])
            || !isset($_POST['PRICE']) || !isset($_POST['TYPE']) || !isset($_POST['QUANTITY'])
            || !isset($_POST['ID'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $ID = $_POST['ID'];
        $NAME = $_POST['NAME'];
        $PRICE = $_POST['PRICE'];
        $TYPE = $_POST['TYPE'];
        $QUANTITY = $_POST['QUANTITY'];
        echo $this->model->update($NAME, $PRICE, $TYPE, $QUANTITY, $ID);
    }
}
