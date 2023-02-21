<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/connections/db.php');

spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/controllers/' . $class . '.php')) {
        require __DIR__ . '/controllers/' . $class . '.php';
    }

    if (file_exists(__DIR__ . '/models/' . $class . '.php')) {
        require __DIR__ . '/models/' . $class . '.php';
    }
});

$db = Connection::connect();

$load_Home = new HomeController();
$model = new HomeModel();
$load_Home->model = $model;
$model->db = $db;
$index = $load_Home->indexAction();
