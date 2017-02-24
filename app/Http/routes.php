<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/**
 *
 * 限定中间件保证登录后的用户才能访问网站详细信息
 *
 */
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::controller('/sports', 'SportsController');
    Route::controller('/activity', 'ActivityController');
    Route::controller('/user', 'UserController');
    Route::controller('/society', 'SocietyController');
    Route::controller('/admin', 'AdminController');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::resource('/api/sports', 'SportsDataController',
        ['only' => ['show', 'update']]);
    Route::resource('/api/sports.date', 'SportsDataController',
        ['only' => ['show']]);
    Route::resource('/api/sleep', 'SleepDataController',
        ['only' => ['show', 'update', 'store']]);
    Route::resource('/api/sleep.date', 'SleepDataController',
        ['only' => ['show']]);
});
