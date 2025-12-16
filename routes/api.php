<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SklnController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\Backend\PilkadaTerkaitController;

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
        Route::get('/dashboard', [SklnController::class, 'index']);
        Route::post('/store-pokok', [SklnController::class, 'store']);
        Route::put('/{id}/update', [SklnController::class, 'update']);
        Route::post('/{id}/submit', [SklnController::class, 'submit']);
        Route::post('/{id}/sementara', [SklnController::class, 'sementara']);
        Route::post('/{id}/destroy', [SklnController::class, 'destroy']);

        Route::post('/{id}/store-pemohon', [SklnController::class, 'storePemohon']);
        Route::post('/{id}/store-kuasa', [SklnController::class, 'storeKuasa']);
        Route::post('/{id}/store-berkas', [SklnController::class, 'storeBerkas']);
        Route::post('/{id}/store-berkas-tambahan', [SklnController::class, 'storeBerkasTambahan']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('pilkada-pemohon')->group (function () {

    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('pilkada-terkait')->group (function () {
        Route::get('/{id}/perkara', [PilkadaTerkaitController::class, 'getPerkara']);
        Route::post('/store', [PilkadaTerkaitController::class, 'store']);
        Route::post('/{id}/kuasa', [PilkadaTerkaitController::class, 'storeKuasa']);
        Route::post('/{id}/berkas', [PilkadaTerkaitController::class, 'storeBerkas']);
        Route::put('/{id}/update', [PilkadaTerkaitController::class, 'update']);
        Route::delete('/{id}/destroy', [PilkadaTerkaitController::class, 'destroy']);
    });
});
