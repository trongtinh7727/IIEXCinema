<?php


include_once(__DIR__ . '/Route.php');

Route::add("/", "HomeController@indexAction");
Route::add("/?home", "HomeController@indexAction");
Route::add("/?login", "UserController@login");
Route::add("/?logout", "UserController@logout");
$route = Route::run();
