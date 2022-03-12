<?php

use Illuminate\Support\Facades\Route;



Route::get('/','HomeController@HomeIndex')->middleware('loginCheck');

Route::get('/visitor','VisitorController@VisitorIndex')->middleware('loginCheck');

//Admin panel service management
Route::get('/service','ServiceController@ServiceIndex')->middleware('loginCheck');
Route::get('/getServicesData','ServiceController@getServicesData')->middleware('loginCheck');
Route::post('/ServiceDelete','ServiceController@ServiceDelete')->middleware('loginCheck');
Route::post('/ServiceDetails','ServiceController@getServicesDetails')->middleware('loginCheck');
Route::post('/ServiceUpdate','ServiceController@ServiceUpdate')->middleware('loginCheck');
Route::post('/ServiceAdd','ServiceController@ServiceAdd')->middleware('loginCheck');


//Admin Panel Courses Management
Route::get('/courses','CoursesController@CoursesIndex')->middleware('loginCheck');
Route::get('/getCoursesData','CoursesController@getCoursesData')->middleware('loginCheck');
Route::post('/CoursesDelete','CoursesController@CoursesDelete')->middleware('loginCheck');
Route::post('/CoursesDetails','CoursesController@getCoursesDetails')->middleware('loginCheck');
Route::post('/CoursesUpdate','CoursesController@CoursesUpdate')->middleware('loginCheck');
Route::post('/CoursesAdd','CoursesController@CoursesAdd')->middleware('loginCheck');

//Admin Panel Projects Management
Route::get('/projects','ProjectsController@ProjectsIndex')->middleware('loginCheck');
Route::get('/getProjectsData','ProjectsController@getProjectsData')->middleware('loginCheck');
Route::post('/ProjectsDelete','ProjectsController@ProjectsDelete')->middleware('loginCheck');
Route::post('/ProjectsDetails','ProjectsController@getProjectsDetails')->middleware('loginCheck');
Route::post('/ProjectsUpdate','ProjectsController@ProjectsUpdate')->middleware('loginCheck');
Route::post('/ProjectsAdd','ProjectsController@ProjectsAdd')->middleware('loginCheck');

//Admin Panel Contact Management
Route::get('/contacts','ContactsController@ContactsIndex')->middleware('loginCheck');
Route::get('/getContactsData','ContactsController@getContactsData')->middleware('loginCheck');
Route::post('/ContactsDelete','ContactsController@ContactsDelete')->middleware('loginCheck');

//Admin Panel Review Management
Route::get('/reviews','ReviewsController@ReviewsIndex')->middleware('loginCheck');
Route::get('/getReviewsData','ReviewsController@getReviewsData')->middleware('loginCheck');
Route::post('/ReviewsAdd','ReviewsController@ReviewsAdd')->middleware('loginCheck');
Route::post('/ReviewsDelete','ReviewsController@ReviewsDelete')->middleware('loginCheck');
Route::post('/ReviewsDetails','ReviewsController@getReviewsDetails')->middleware('loginCheck');
Route::post('/ReviewsUpdate','ReviewsController@ReviewsUpdate')->middleware('loginCheck');

//Admin Panel Login Management
Route::get('/Login','LoginController@LoginIndex');
Route::post('/onLogin','LoginController@onLogin');
Route::get('/Logout','LoginController@onLogout');

//Admin Panel Photo Management
Route::get('/Photo','PhotoController@PhotoIndex')->middleware('loginCheck');
Route::post('/PhotoUpload','PhotoController@PhotoUpload')->middleware('loginCheck');
Route::get('/PhotoJSON','PhotoController@PhotoJSON')->middleware('loginCheck');
