<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'WelcomeController@index');

Auth::routes();
//Route::get('/login', 'LoginController@index');

Route::get('/home', 'HomeController@index');

Route::get('/projects', 'ProjectController@index');
Route::post('/projects', 'ProjectController@create');

Route::get('/projects/{id}', 'ProjectController@show');
Route::get('/projects/{id}/gallery', 'ProjectController@showGallery');
Route::post('/projects/{id}/gallery', 'ProjectController@newGallery');
Route::get('/projects/{id}/members', 'ProjectController@showMembers');
Route::post('/projects/{id}/members', 'ProjectController@addMember');

Route::get('/albums/{id}', 'AlbumController@show');
Route::get('/photos/{id}', 'PhotoController@show');

Route::get('/profile', 'ProfileController@index');
Route::get('/user', 'UserController@index');
Route::get('/user/{id}', 'UserController@show');

Route::get('/view/dashboard', function(){
    return view('dashboard');
});
