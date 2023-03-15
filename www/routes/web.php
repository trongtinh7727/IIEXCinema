<?php


include_once(__DIR__ . '/Route.php');

Route::add("/", "AdminController@indexAction");
Route::add("/?home", "AdminController@indexAction");
Route::add("/?login", "AdminController@login");
Route::add("/?logout", "AdminController@logout");

// API
// Staff
Route::add("/?api/staff/getall", "StaffController@getAll");
Route::add("/?api/staff/add", "StaffController@add");
Route::add("/?api/staff/update", "StaffController@update");
Route::add("/?api/staff/delete", "StaffController@delete");

// Movie
Route::add("/?api/movie/getall", "MovieController@getAll");
Route::add("/?api/movie/add", "MovieController@add");
Route::add("/?api/movie/update", "MovieController@update");
Route::add("/?api/movie/delete", "MovieController@delete");
$route = Route::run();
