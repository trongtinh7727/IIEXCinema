<?php


include_once(__DIR__ . '/Route.php');

// ADMIN
Route::add("/?admin", "AdminController@indexAction");
Route::add("/?admin/home", "AdminController@indexAction");
Route::add("/?admin/logout", "AdminController@logout");

// Client
Route::add("/?updateprofile", "ClientController@updateProfile");

// Home
Route::add("/?", "HomeController@indexAction");
Route::add("/?profile", "HomeController@profile");
Route::add("/?bookinghistory", "HomeController@bookingHistory");
Route::add("/?movie", "HomeController@movie");
Route::add("/?moviedetail", "HomeController@movieDetail");
Route::add("/?showtime", "HomeController@showtime");
Route::add("/?ticketbooking", "HomeController@ticketBooking");
Route::add("/?seatbooking", "HomeController@seatBooking");
Route::add("/?combobooking", "HomeController@comboBooking");
Route::add("/?confirmbooking", "HomeController@confirmBooking");
Route::add("/?successbooking", "HomeController@successBooking");
Route::add("/?promotion", "HomeController@promotion");

// Auth
Route::add("/?admin/login", "AuthController@login");
Route::add("/?login", "AuthController@login");
Route::add("/?logout", "AuthController@logout");
Route::add("/?register", "AuthController@register");
Route::add("/?changepassword", "AuthController@changePassword");

// manager
Route::add("/?admin/staff", "AdminController@staffAction");
Route::add("/?admin/movie", "AdminController@movieAction");
Route::add("/?admin/schedule", "AdminController@scheduleAction");
Route::add("/?admin/theater", "AdminController@theaterAction");
Route::add("/?admin/product", "AdminController@productAction");
Route::add("/?admin/client", "AdminController@clientAction");
Route::add("/?admin/transaction", "AdminController@transactionAction");
Route::add("/?admin/foodcombo", "AdminController@comboAction");
Route::add("/?admin/revenue", "AdminController@revenueAction");


// API
// Staff
Route::add("/?api/staff/getbyid", "StaffController@getByID");
Route::add("/?api/staff/getall", "StaffController@getAll");
Route::add("/?api/staff/add", "StaffController@add");
Route::add("/?api/staff/update", "StaffController@update");
Route::add("/?api/staff/delete", "StaffController@delete");

// Client
Route::add("/?api/client/getbyid", "ClientController@getByID");
Route::add("/?api/client/getall", "ClientController@getAll");
Route::add("/?api/client/add", "ClientController@add");
Route::add("/?api/client/update", "ClientController@update");
Route::add("/?api/client/delete", "ClientController@delete");

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
Route::add("/?api/foodcombo/getdrinks", "FoodComboController@getDrinks");
Route::add("/?api/foodcombo/getfoods", "FoodComboController@getFoods");
Route::add("/?api/foodcombo/getall", "FoodComboController@getAll");
Route::add("/?api/foodcombo/add", "FoodComboController@add");
Route::add("/?api/foodcombo/update", "FoodComboController@update");
Route::add("/?api/foodcombo/delete", "FoodComboController@delete");

// Seat
Route::add("/?api/seat/getByTheater", "SeatController@getByTheater");

// Transaction
Route::add("/?api/transaction/getall", "TransactionController@getAll");
Route::add("/?api/transaction/getrevenue", "TransactionController@getRevenue");

// Ticket
Route::add("/?api/ticket/add", "TicketController@add");
Route::add("/?api/ticket/addticketseatschedule", "TicketController@addTicketSeatSchedule");

// Theater
Route::add("/?api/theater/getall", "TheaterController@getAll");
Route::add("/?api/theater/add", "TheaterController@add");
Route::add("/?api/theater/update", "TheaterController@update");
Route::add("/?api/theater/delete", "TheaterController@delete");

// Schedule
Route::add("/?api/schedule/getbookedseat", "ScheduleController@getBookedSeat");
Route::add("/?api/schedule/getByTheater", "ScheduleController@getByTheater");
Route::add("/?api/schedule/getByMovie", "ScheduleController@getByMovie");
Route::add("/?api/schedule/getbyid", "ScheduleController@getByID");
Route::add("/?api/schedule/add", "ScheduleController@add");
Route::add("/?api/schedule/update", "ScheduleController@update");
Route::add("/?api/schedule/delete", "ScheduleController@delete");

// Product
Route::add("/?api/product/getbyid", "ProductController@getByID");
Route::add("/?api/product/getall", "ProductController@getAll");
Route::add("/?api/product/add", "ProductController@add");
Route::add("/?api/product/update", "ProductController@update");
Route::add("/?api/product/delete", "ProductController@delete");

$route = Route::run();
