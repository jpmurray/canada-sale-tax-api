<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\RateController as V1RateController;
use App\Http\Controllers\API\v2\RateController as V2RateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
