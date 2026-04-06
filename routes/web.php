<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    VulnAssesController,
    ApplicationController,
    AuthController,
    DashboardController,
    EvidenceController,
    IncidentController,
    NotificationController,
    PentestController,
    ProfileController,
    UserController,

};

Route::middleware('guest')->group(function(){
    Route::get('/login',        [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',       [AuthController::class, 'login']);
    Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',    [AuthController::class, 'register']);

});

Route::middleware('auth')->group(function () {
    Route::post('/logout',                               [AuthController::class, 'logout'])->name('logout');
    Route::get('/',                                      [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('verified')->group(function() {
        Route::resource('applications',                 ApplicationController::class);
        Route::resource('users',                        UserController::class)->except(['show']);
        Route::resource('pentests',                     PentestController::class);
        Route::get('/incidents/masyarakat',                    [IncidentController::class, 'masyarakat'])->name('incidents.masyarakat');
        Route::get('/incidents/masyarakat/{id}',             [IncidentController::class, 'masyarakatShow'])   ->name('incidents.masyarakat.show');
        Route::post('/incidents/masyarakat/{id}/save',       [IncidentController::class, 'masyarakatSave'])   ->name('incidents.masyarakat.save');
        Route::resource('incidents',                    IncidentController::class);
        Route::resource('vas',                          VulnAssesController::class);
        Route::patch('incidents/{incident}/update-status',  [IncidentController::class, 'updateStatus'])
            ->name('incidents.updateStatus');

    });
    // incident
    Route::patch('/incidents/{incident}/match-application',             [IncidentController::class, 'matchApplication'])
    ->name('incidents.matchApplication');
    Route::post('incidents/{incident}/evidences',                       [IncidentController::class, 'storeEvidence'])->name('incidents.evidences.store');
    Route::patch('incidents/{incident}/evidences/{evidence}/approve',   [IncidentController::class, 'approveEvidence'])->name('incidents.evidences.approve');
    Route::patch('incidents/{incident}/evidences/{evidence}/reject',    [IncidentController::class, 'rejectEvidence'])->name('incidents.evidences.reject');
    // pentest
    Route::post('pentests/{pentest}/evidences',                         [PentestController::class, 'storeEvidence'])->name('pentests.evidences.store');
    Route::patch('pentests/{pentest}/evidences/{evidence}/approve',     [PentestController::class, 'approveEvidence'])->name('pentests.evidences.approve');
    Route::patch('pentests/{pentest}/evidences/{evidence}/reject',      [PentestController::class, 'rejectEvidence'])->name('pentests.evidences.reject');
    //  vas
    Route::post('vas/{va}/evidence',                    [VulnAssesController::class, 'storeEvidence'])->name('vas.evidences.store');
    Route::patch('vas/{va}/evidence/{evidence}/approve',[VulnAssesController::class, 'approveEvidence'])->name('vas.evidences.approve');
    Route::patch('vas/{va}/evidence/{evidence}/reject', [VulnAssesController::class, 'rejectEvidence'])->name('vas.evidences.reject');
    // profile
    Route::get('/profile',              [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/name',       [ProfileController::class, 'updateName'])->name('profile.update.name');
    Route::patch('/profile/password',   [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    //  log
    Route::get('activity-logs',         [ActivityLogController::class, 'index'])->name('activity-logs.index');
    // evidence
    Route::post('evidences',                          [EvidenceController::class, 'store'])->name('evidences.store');
    Route::patch('evidences/{evidence}/approve',      [EvidenceController::class, 'approve'])->name('evidences.approve');
    Route::patch('evidences/{evidence}/reject',       [EvidenceController::class, 'reject'])->name('evidences.reject');
    // notification
    Route::middleware(['auth', 'throttle:30,1'])->group(function () {
    Route::get('notifications/poll',                   [NotificationController::class, 'poll'])->name('notifications.poll');
    Route::patch('notifications/read-all',             [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::patch('notifications/{id}/read',            [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('notifications',                        [NotificationController::class, 'index'])->name('notifications.index');
    });
});
