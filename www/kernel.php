<?php
session_start();

require_once(__DIR__ . '/config.php');
// load connection
require_once(__DIR__ . '/connections/db.php');

// load controllers and models class
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/controllers/' . $class . '.php')) {
        require __DIR__ . '/controllers/' . $class . '.php';
    }

    if (file_exists(__DIR__ . '/models/' . $class . '.php')) {
        require __DIR__ . '/models/' . $class . '.php';
    }
});


include_once(__DIR__ . '/routes/web.php');
//  It checks if the $route variable is not empty, and if it is not, it splits it into two parts: the controller and the action, separated by the "@" symbol.
// $route = HomeController@indexAction => controller = HomeController, model = HomeModel, action = indexAction 
if (!empty($route)) {
    $routes = explode('@', $route);
    $controller = ucfirst($routes[0]);
    $model = ucfirst(str_replace("Controller", '', $routes[0])) . 'Model';
    $action = lcfirst($routes[1]);
} else {
    $controller = 'HomeController';
    $model = 'HomeModel';
    $action = 'indexAction';
}
// get connection
$db = Connection::connect();
// create a new instance of dynamic controller
$controllerInstance = new $controller();
// create a new instance of dynamic controller
$modelInstance = new $model();
// set model for controller and db for model
$controllerInstance->setModel($modelInstance);
$modelInstance->setDB($db);
// run action cmd
$action_load = $controllerInstance->$action();
