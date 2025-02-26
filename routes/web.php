<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HitController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UsageController;

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
    Route::resource('usages', UsageController::class)->only(['index']);
    Route::resource('hits', HitController::class)->only(['index']);
});
