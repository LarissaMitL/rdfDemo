<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::get('/home', 'HomeController@showStart');
Route::get('/adminbit', 'AdminController@showStart');
Route::post('/tidbit/create', 'HomeController@goToDatabase');
Route::post('/adminbit/create', 'AdminController@goToDatabase');
Route::post('/adminbit/delete', 'AdminController@delData');
Route::post('/adminbit/update', 'AdminController@updateData');
Route::post('/tidbit/login', 'HomeController@login');

Route::get('/logout', 'HomeController@logout');