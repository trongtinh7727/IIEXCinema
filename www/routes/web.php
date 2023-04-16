<?php


include_once(__DIR__ . '/Route.php');

// ADMIN
Route::add("/?admin", "AdminController@indexAction");
Route::add("/?admin/home", "AdminController@indexAction");

Route::add("/?admin/logout", "AdminController@logout");

// Client
Route::add("/?", "HomeController@indexAction");
Route::add("/?moviedetail", "HomeController@movieDetail");
Route::add("/?showtime", "HomeController@showtime");

// Auth
Route::add("/?admin/login", "AuthController@login");
Route::add("/?login", "AuthController@login");
Route::add("/?logout", "AuthController@logout");

// manager
Route::add("/?admin/staff", "AdminController@staffAction");
Route::add("/?admin/cinema", "AdminController@cinemaAction");
Route::add("/?admin/movie", "AdminController@movieAction");
Route::add("/?admin/schedule", "AdminController@scheduleAction");
Route::add("/?admin/theater", "AdminController@theaterAction");
Route::add("/?admin/supplies", "AdminController@suppliesAction");


// API
// Staff
Route::add("/?api/staff/getbyid", "StaffController@getByID");
Route::add("/?api/staff/getall", "StaffController@getAll");
Route::add("/?api/staff/add", "StaffController@add");
Route::add("/?api/staff/update", "StaffController@update");
Route::add("/?api/staff/delete", "StaffController@delete");

// Movie
Route::add("/?api/movie/getbyid", "MovieController@getByID");
Route::add("/?api/movie/getall", "MovieController@getAll");
Route::add("/?api/movie/add", "MovieController@add");
Route::add("/?api/movie/update", "MovieController@update");
Route::add("/?api/movie/delete", "MovieController@delete");
Route::add("/?api/movie/ongoing", "MovieController@ongoing");
Route::add("/?api/movie/upcoming", "MovieController@upcoming");
Route::add("/?api/movie/gettrailer", "MovieController@gettrailer");

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

// Seat
Route::add("/?api/seat/getByTheater", "SeatController@getByTheater");

// Ticket
Route::add("/?api/ticket/add", "TicketController@add");
Route::add("/?api/ticket/addticketseatschedule", "TicketController@addTicketSeatSchedule");

// Theater
Route::add("/?api/theater/getByCinema", "TheaterController@getByCinema");
Route::add("/?api/theater/getall", "TheaterController@getAll");
Route::add("/?api/theater/add", "TheaterController@add");
Route::add("/?api/theater/update", "TheaterController@update");
Route::add("/?api/theater/delete", "TheaterController@delete");

// Schedule
Route::add("/?api/schedule/getByTheater", "ScheduleController@getByTheater");
Route::add("/?api/schedule/getByMovie", "ScheduleController@getByMovie");
Route::add("/?api/schedule/getbyid", "ScheduleController@getByID");
Route::add("/?api/schedule/add", "ScheduleController@add");
Route::add("/?api/schedule/update", "ScheduleController@update");
Route::add("/?api/schedule/delete", "ScheduleController@delete");


$route = Route::run();
