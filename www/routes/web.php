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

// FoodCombo
Route::add("/?api/foodcombo/getall", "FoodComboController@getAll");
Route::add("/?api/foodcombo/add", "FoodComboController@add");
Route::add("/?api/foodcombo/update", "FoodComboController@update");
Route::add("/?api/foodcombo/delete", "FoodComboController@delete");

// Cinema
Route::add("/?api/cinema/getbyid", "CinemaController@getByID");
Route::add("/?api/cinema/getall", "CinemaController@getAll");
Route::add("/?api/cinema/add", "CinemaController@add");
Route::add("/?api/cinema/update", "CinemaController@update");
Route::add("/?api/cinema/delete", "CinemaController@delete");

Route::add("/?api/ticket/getbyid", "TicketController@getByID");
Route::add("/?api/ticket/getall", "TicketController@getAll");
Route::add("/?api/ticket/add", "TicketController@add");
Route::add("/?api/ticket/update", "TicketController@update");
Route::add("/?api/ticket/delete", "TicketController@delete");

$route = Route::run();
