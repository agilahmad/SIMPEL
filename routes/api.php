<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\SklnController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::patch('/profile', [UserController::class, 'updateProfile']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
    });

    Route::prefix('tickets')->group(function () {
        Route::get('/', [TicketController::class, 'index']);
        Route::post('/', [TicketController::class, 'store']);
        Route::get('/{id}', [TicketController::class, 'show']);
        Route::post('/{id}/messages', [TicketController::class, 'sendMessage']);
    });

    Route::prefix('admin/tickets')->middleware('admin')->group(function () {
        Route::get('/', [AdminTicketController::class, 'index']);
        Route::get('/{id}', [AdminTicketController::class, 'show']);
        Route::post('/{id}/messages', [AdminTicketController::class, 'sendMessage']);
        Route::patch('/{id}/status', [AdminTicketController::class, 'updateStatus']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('skln')->group(function () {
        Route::post('/permohonan/skln/store-pokok', [SklnController::class, 'store']);
        Route::post('/permohonan/skln/submit', [SklnController::class, 'submit']);
        Route::post('/permohonan/skln/sementara', [SklnController::class, 'sementara']);
        Route::post('/permohonan/skln/{id}/destroy', [SklnController::class, 'destroy']);
    });
});
