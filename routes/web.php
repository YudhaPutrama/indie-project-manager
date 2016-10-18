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


Route::group(['middleware'=>'auth'], function (){
    Route::get('test', 'ProjectController@newProject');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/profile', 'UserController@showProfile')->name('profile');
    //Route::get('/profile/edit', 'UserController@showProfileEdit')->name('profile-edit');
    Route::post('/profile', 'UserController@updateProfile');
    Route::get('/projects', 'ProjectController@showProject')->name('project');
    Route::post('/projects', 'ProjectController@newProject')->name('project-add');
    Route::get('/projects/{project}', 'ProjectController@showProjectDetail')->name('project-detail');
    Route::get('/projects/{project}/upload', 'ProjectController@showUpload')->name('project-upload');
    Route::post('/projects/{project}/upload', 'ProjectController@uploadPhotos');
    Route::get('/projects/{project}/{photo}', 'PhotoController@showPhoto')->name('photo');
    Route::post('/projects/{project}/{photo}/comment', 'PhotoController@postComment');
    Route::get('/schedule', 'ScheduleController@listSchedule');
    Route::get('/schedule/{project}', 'ScheduleController@showSchedule');
    Route::get('/users', 'UserController@listUsers');
    Route::get('/users/{user}', 'UserController@showUsers');
});
//Route::get('/home', 'HomeController@index');
//
//Route::get('/projects', 'ProjectController@index');
//Route::post('/projects', 'ProjectController@create');
//
//Route::get('/projects/{id}', 'ProjectController@show')->name('project');
//Route::get('/projects/{id}/edit', 'ProjectController@show')->name('project-edit');
//Route::post('/projects/{id}/edit', 'ProjectController@show');
//Route::get('/projects/{id}/gallery', 'ProjectController@showGallery')->name('project-gallery');
//Route::post('/projects/{id}/gallery', 'ProjectController@newGallery');
//Route::get('/projects/{id}/members', 'ProjectController@showMembers');
//Route::post('/projects/{id}/members', 'ProjectController@addMember');
//
//Route::get('/gallery/{id}', 'AlbumController@show');
//Route::get('/gallery/{id}', 'AlbumController@show');
//
//Route::get('/profile', 'UserController@profile');
//Route::get('/user', 'UserController@index');
//Route::get('/user/{id}', 'UserController@show');
//
//// View Routes
//$user = [
//    'name'=>'Kurniawan Yudha P',
//    'title'=>'Telkom University',
//    'description'=>'',
//    'phone'=>'08845654877',
//    'twitter'=>'yudhaputrama',
//    'facebook'=>'yudhaputrama'
//];
//Route::get('/view/dashboard', function(){return view('dashboard');});
//Route::get('/view/profile', function(){
//    $comments =[
//        ['title'=>'Mountain', 'isRead'=>'1', 'time'=>'5 September 2016 15:40','body'=>'This is comments'],
//        ['title'=>'Class', 'isRead'=>'1', 'time'=>'5 September 2016 15:40','body'=>'This is comments'],
//        ['title'=>'Gate ', 'isRead'=>'1', 'time'=>'5 September 2016 15:40','body'=>'This is comments'],
//    ];
//    $data = [
//        'name'=>'Kurniawan Yudha P',
//        'title'=>'Telkom University',
//        'description'=>'This is desc',
//        'phone'=>'08845654877',
//        'twitter'=>'yudhaputrama',
//        'facebook'=>'yudhaputrama',
//        'comments'=>$comments
//    ];
//     return view('profile-view', $data);
//});
//

//Route::get('/view/projects', function(){return view('project-list');});
//Route::get('/view/projects/id', function(){return view('project-list');});
//Route::get('/view/gallery', function(){return view('gallery');});
//Route::get('/view/upload', function(){return view('upload');});
//Route::get('/view/schedule', function(){return view('schedule-view');});
//Route::get('/view/schedule/edit', function(){return view('schedule-edit');});
//Route::get('/view/user/add', function(){return view('user-add');});
//Route::get('/view/projects/user', function(){return view('project-user');});
//Route::get('/view/user/photos', function(){return view('gallery');});
//Route::get('/view/user/photos/id', function(){return view('photos');});
