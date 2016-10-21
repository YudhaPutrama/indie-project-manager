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


Route::group(['middleware'=>['auth']], function (){


    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/profile', 'UserController@showProfile')->name('profile');
    //Route::get('/profile/edit', 'UserController@showProfileEdit')->name('profile-edit');
    Route::post('/profile', 'UserController@updateProfile');
    Route::get('/projects', 'ProjectController@showProject')->name('project');
    Route::post('/projects', 'ProjectController@newProject')->name('project-add');
    Route::get('/projects/{project}', 'ProjectController@showProjectDetail')->name('project-detail');
    Route::post('/projects/{project}', 'ProjectController@updateProject');

    Route::post('/projects/{project}/event', 'ScheduleController@postSchedule')->name('postEvent');
    Route::post('/projects/{project}/event/{event}/approve', 'ScheduleController@accept');
    Route::post('/projects/{project}/event/{event}/done', 'ScheduleController@done');
    Route::post('/projects/{project}/event/{event}/edit', 'ScheduleController@edit');
    Route::post('/projects/{project}/event/{event}/remove', 'ScheduleController@remove');
    Route::get('/projects/{project}/calendar','ScheduleController@projectSchedule')->name('projectCalendar');
    Route::get('/projects/{project}/calendar/data','ScheduleController@dataSchedule');

    Route::get('/projects/{project}/upload', 'ProjectController@showUpload')->name('project-upload');
    Route::post('/projects/{project}/upload', 'ProjectController@uploadPhotos');

    //Route::post('/projects/{project}/schedule','ScheduleController@postSchedule');
    Route::get('/projects/{project}/members','ProjectController@listMember');
    Route::post('/projects/{project}/members','ProjectController@addMember');
    Route::get('/projects/{project}/members/{user}/remove','ProjectController@removeMember');


    Route::get('/projects/{project}/{photo}', 'PhotoController@showPhoto')->name('photo');
    Route::post('/projects/{project}/{photo}', 'PhotoController@updatePhoto');
    Route::get('/projects/{project}/{photo}/comments', 'PhotoController@listComments');
    Route::post('/projects/{project}/{photo}/comments', 'PhotoController@postComment');

    //for admin or staff
    Route::get('/schedule', 'ScheduleController@listSchedule');
    Route::get('/users', 'UserController@listUsers');
    Route::post('/users','UserController@newUser');
    Route::get('/users/{user}/','UserController@viewUser')->name('view-user');
    Route::post('/users/{user}/remove','UserController@removeUser');
    Route::post('/users/{user}/resetPassword','UserController@resetPassword');
    Route::post('/users/check', 'UserController@checkUsername')->name('checkUsername');
    //for client
});
