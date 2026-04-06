<?php

use App\Http\Controllers\ApplicationApiController;
use App\Http\Controllers\IncidentApiController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiKeyMiddleware::class)->group(function(){
    Route::get('/applications', [ApplicationApiController::class, 'index']);

    Route::post('/incidents', [IncidentApiController::class, 'store']);
});
