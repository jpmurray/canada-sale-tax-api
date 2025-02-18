<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\RateController as V1RateController;
use App\Http\Controllers\API\v2\RateController as V2RateController;

Route::prefix('/v3')->group(function () {
    Route::get('/token-test', function (Request $request) {
        return $request->user();
    });
})->middleware('auth:sanctum');

Route::prefix('/v2')->group(function () {
    Route::group(['prefix' => '/federal'], function () {
        Route::get('/gst/historical', [V2RateController::class, 'getHistoricalGst']);
        Route::get('/gst/future', [V2RateController::class, 'getFutureGst']);
        Route::get('/gst', [V2RateController::class, 'getCurrentGst']);
    });

    Route::group(['prefix' => '/province'], function () {
        Route::get('/all', [V2RateController::class, 'getAllPst']);
        Route::get('/{province}/historical', [V2RateController::class, 'getHistoricalPst']);
        Route::get('/{province}/future', [V2RateController::class, 'getFuturePst']);
        Route::get('/{province}', [V2RateController::class, 'getCurrentPst']);
    });
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/federal')->group(function () {
        Route::get('/gst', [V1RateController::class, 'getGst']);
        Route::get('/hst/{prov}', [V1RateController::class, 'getHst']);
        Route::get('/hst/all', [V1RateController::class, 'getHst']);
    });

    Route::group(['prefix' => '/provincial'], function () {
        Route::get('/pst/{prov}', [V1RateController::class, 'getPst']);
        Route::get('/pst/all', [V1RateController::class, 'getPst']);
    });

    Route::get('/total/{province}', [V1RateController::class, 'getTotal']);
    Route::get('/total/all', [V1RateController::class, 'getTotal']);
});
