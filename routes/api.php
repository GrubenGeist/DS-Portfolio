<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\AnalyticsEventController;


// Authentifizierte API-Beispiele …
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'indexApi'])->name('api.users.index');
    Route::get('/user', fn (Request $r) => $r->user());
});

// Tracking-Endpoints (öffentlich, aber gedrosselt)
Route::post('/analytics-events', [AnalyticsEventController::class, 'store'])
    ->name('api.analytics-events.store')
    ->middleware('throttle:track-events');

// Optionaler Alias, falls du später ohne tracking-url am Button arbeiten willst
Route::post('/track-event', [AnalyticsEventController::class, 'store'])
    ->name('api.track-event')
    ->middleware('throttle:track-events');
