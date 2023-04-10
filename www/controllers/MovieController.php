<?php
class MovieController extends AdminController
{
    public $model;

    function __construct()
    {
    }

    public function getAll()
    {
        echo $this->model->getAll();
    }

    public function add()
    {
        $this->isAuthenticated();
        if (
            !isset($_POST['TITLE']) || !isset($_POST['GENRE']) || !isset($_POST['DURATION'])
            || !isset($_POST['RATING']) || !isset($_POST['STORY']) || !isset($_POST['POSTER'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }

        $TITLE = $_POST['TITLE'];
        $GENRE = $_POST['GENRE'];
        $DURATION = $_POST['DURATION'];
        $RATING = $_POST['RATING'];
        $STORY = $_POST['STORY'];
        $POSTER = $_POST['POSTER'];

        echo $this->model->add($TITLE, $GENRE, $DURATION, $RATING, $STORY, $POSTER, $RATING);
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
            !isset($_POST['TITLE']) || !isset($_POST['GENRE']) || !isset($_POST['DURATION'])
            || !isset($_POST['RATING']) || !isset($_POST['STORY']) || !isset($_POST['POSTER'])
            || !isset($_POST['RATING']) || !isset($_POST['IMAGE'])
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $ID = $_POST['ID'];
        $TITLE = $_POST['TITLE'];
        $GENRE = $_POST['GENRE'];
        $DURATION = $_POST['DURATION'];
        $RATING = $_POST['RATING'];
        $STORY = $_POST['STORY'];
        $POSTER = $_POST['POSTER'];

        echo $this->model->update($TITLE, $GENRE, $DURATION, $RATING, $STORY, $POSTER, $RATING, $ID);
    }

    public function ongoing()
    {
        echo $this->model->ongoing();
    }
}
