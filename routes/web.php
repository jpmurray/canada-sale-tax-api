<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RateController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('rates', RateController::class)->except(['show', 'destroy']);
});

// old route did not have the /api prefix
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

// old route did not have the /api prefix
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
