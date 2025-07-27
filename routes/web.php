<?php

use App\Http\Controllers\CreatorController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('creators')->group(function () {
    // Main search endpoint
    Route::get('/search', [CreatorController::class, 'search']);// Main search endpoint

    // Filter-specific endpoints
    Route::get('/trending', [CreatorController::class, 'trending']);
    Route::get('/rising-stars', [CreatorController::class, 'risingStars']);
    Route::get('/most-viewed', [CreatorController::class, 'mostViewed']);
    Route::get('/under-price', [CreatorController::class, 'underPrice']);
    Route::get('/fast-turnaround', [CreatorController::class, 'fastTurnaround']);
    Route::get('/top-creators', [CreatorController::class, 'topCreators']);

    // Get available filter options
    Route::get('/filter-options', [CreatorController::class, 'getFilterOptions']);
});





