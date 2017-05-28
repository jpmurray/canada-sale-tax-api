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

    Route::group(['prefix' => '/federal'], function () {
        Route::get('/gst', 'RatesAPIV1Controller@getGst');
        Route::get('/hst/{prov}', 'RatesAPIV1Controller@getHst');
        Route::get('/hst/all', 'RatesAPIV1Controller@getHst');
    });

    Route::group(['prefix' => '/provincial'], function () {
        Route::get('/pst/{province}', 'RatesAPIV1Controller@getPst');
        Route::get('/pst/all', 'RatesAPIV1Controller@getPst');
    });

    Route::get('/total/{province}', 'RatesAPIV1Controller@getTotal');
    Route::get('/total/all', 'RatesAPIV1Controller@getTotal');
});
