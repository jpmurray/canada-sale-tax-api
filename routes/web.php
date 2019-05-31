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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{province}', 'RatesController@index')->name('rates.index');
Route::get('/rates/create', 'RatesController@create')->name('rates.create');
Route::post('/rates', 'RatesController@store')->name('rates.store');
Route::get('/rates/{rate}', 'RatesController@edit')->name('rates.edit');
Route::put('/rates/{rate}', 'RatesController@update')->name('rates.update');
