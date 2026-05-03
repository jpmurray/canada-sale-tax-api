<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\HitController;
use App\Http\Controllers\PendingRateUpdateController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UsageController;
use Illuminate\Support\Facades\Route;

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
    Route::resource('alerts', AlertController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    // Pending Rate Updates - User submissions
    Route::get('/pending-rate-updates/create', [PendingRateUpdateController::class, 'create'])->name('pending-rate-updates.create');
    Route::post('/pending-rate-updates', [PendingRateUpdateController::class, 'store'])->name('pending-rate-updates.store');

    // Pending Rate Updates - Admin management
    Route::get('/pending-rate-updates', [PendingRateUpdateController::class, 'index'])->name('pending-rate-updates.index');
    Route::get('/pending-rate-updates/{pendingRateUpdate}', [PendingRateUpdateController::class, 'show'])->name('pending-rate-updates.show');
    Route::post('/pending-rate-updates/{pendingRateUpdate}/approve', [PendingRateUpdateController::class, 'approve'])->name('pending-rate-updates.approve');
    Route::post('/pending-rate-updates/{pendingRateUpdate}/reject', [PendingRateUpdateController::class, 'reject'])->name('pending-rate-updates.reject');
});
