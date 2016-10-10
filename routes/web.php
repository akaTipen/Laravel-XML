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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'DataController@index');

Route::get('/add', 'DataController@create');
Route::post('/store', 'DataController@store');
Route::get('/delete/{id}', 'DataController@destroy');
Route::get('/edit/{id}', 'DataController@edit');
Route::put('/update/{id}', 'DataController@update');