<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => '/v1'], function () {

    Route::group(['prefix' => '/fed'], function () {
       Route::get('/gst', 'TaxesController@getGst');
       Route::get('/hst/{prov}', 'TaxesController@getHst');
       Route::get('/hst/all', 'TaxesController@getHst'); 
    });

    Route::group(['prefix' => '/prov'], function () {
       Route::get('/pst/{province}', 'TaxesController@getPst');
       Route::get('/pst/all', 'TaxesController@getPst'); 
    });

    Route::get('/total/{province}', 'TaxesController@getTotal');
    Route::get('/total/all', 'TaxesController@getTotal');
    
});