<?php
class MovieController extends AdminController
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
        if (
            !isset($_POST['NAME']) || !isset($_POST['INFO']) || !isset($_POST['DATE'])
            || !isset($_POST['START']) || !isset($_POST['END']) || !isset($_POST['CATEGORY'])
            || !isset($_POST['RATING']) || !isset($_POST['IMAGE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $NAME = $_POST['NAME'];
        $INFO = $_POST['INFO'];
        $DATE = $_POST['DATE'];
        $START = $_POST['START'];
        $END = $_POST['END'];
        $CATEGORY = $_POST['CATEGORY'];
        $RATING = $_POST['RATING'];
        $IMAGE = $_POST['IMAGE'];
        echo $this->model->add($NAME, $INFO, $DATE, $START, $END, $CATEGORY, $RATING, $IMAGE);
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
            !isset($_POST['NAME']) || !isset($_POST['INFO']) || !isset($_POST['DATE'])
            || !isset($_POST['START']) || !isset($_POST['END']) || !isset($_POST['CATEGORY'])
            || !isset($_POST['RATING']) || !isset($_POST['IMAGE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $NAME = $_POST['NAME'];
        $INFO = $_POST['INFO'];
        $DATE = $_POST['DATE'];
        $START = $_POST['START'];
        $END = $_POST['END'];
        $CATEGORY = $_POST['CATEGORY'];
        $RATING = $_POST['RATING'];
        $IMAGE = $_POST['IMAGE'];
        echo $this->model->add($NAME, $INFO, $DATE, $START, $END, $CATEGORY, $RATING, $IMAGE);
    }
}