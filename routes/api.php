<?php

use App\Http\Controllers\CreatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('creators')->group(function () {
    Route::get('/test',[CreatorController::class,'test']);
    // Main search endpoint
    Route::get('/search', [CreatorController::class, 'search']);

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
