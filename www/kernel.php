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

include_once(__DIR__ . '/routes/web.php');

if (!empty($route)) {
    $routes = explode('@', $route);
    $controller = ucfirst($routes[0]);
    $model = ucfirst(str_replace("Controller", '', $routes[0])) . 'Model';
    $action = lcfirst($routes[1]);
} else {
    $controller = 'AdminController';
    $model = 'AdminModel';
    $action = 'indexAction';
}

$db = Connection::connect();

$load_Home = new $controller();
$model = new $model();
$load_Home->model = $model;
$model->db = $db;
$index = $load_Home->$action();
