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
            !isset( $_POST['TITLE']) ||
            !isset( $_POST['DIRECTOR']) ||
            !isset( $_POST['ACTORS']) ||
            !isset( $_POST['GENRE']) ||
            !isset( $_POST['STORY']) ||
            !isset( $_POST['DURATION']) ||
            !isset( $_POST['OPENING_DAY']) ||
            !isset( $_POST['CLOSING_DAY']) ||
            !isset( $_POST['POSTER']) ||
            !isset( $_POST['TRAILER']) 
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }


        $TITLE =   $_POST['TITLE'];
        $DIRECTOR =   $_POST['DIRECTOR'];
        $ACTORS =   $_POST['ACTORS'];
        $GENRE =   $_POST['GENRE'];
        $STORY =   $_POST['STORY'];
        $DURATION =   $_POST['DURATION'];
        $OPENING_DAY =   $_POST['OPENING_DAY'];
        $CLOSING_DAY =   $_POST['CLOSING_DAY'];
        $POSTER =   $_POST['POSTER'];
        $TRAILER =   $_POST['TRAILER'];
        echo $this->model->add($TITLE,$DIRECTOR,$ACTORS,$GENRE,$STORY,$DURATION,$OPENING_DAY,$CLOSING_DAY,$POSTER,$TRAILER);
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

            !isset( $_POST['TITLE']) ||            
            !isset( $_POST['ID']) ||
            !isset( $_POST['DIRECTOR']) ||
            !isset( $_POST['ACTORS']) ||
            !isset( $_POST['GENRE']) ||
            !isset( $_POST['STORY']) ||
            !isset( $_POST['DURATION']) ||
            !isset( $_POST['OPENING_DAY']) ||
            !isset( $_POST['CLOSING_DAY']) ||
            !isset( $_POST['POSTER']) ||
            !isset( $_POST['TRAILER']) 
        ) {
            die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
        }
        $ID = $_POST['ID'];
     
        $TITLE =   $_POST['TITLE'];
        $DIRECTOR =   $_POST['DIRECTOR'];
        $ACTORS =   $_POST['ACTORS'];
        $GENRE =   $_POST['GENRE'];
        $STORY =   $_POST['STORY'];
        $DURATION =   $_POST['DURATION'];
        $OPENING_DAY =   $_POST['OPENING_DAY'];
        $CLOSING_DAY =   $_POST['CLOSING_DAY'];
        $POSTER =   $_POST['POSTER'];
        $TRAILER =   $_POST['TRAILER'];

        echo $this->model->update($TITLE,$DIRECTOR,$ACTORS,$GENRE,$STORY,$DURATION,$OPENING_DAY,$CLOSING_DAY,$POSTER,$TRAILER,$ID);
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
