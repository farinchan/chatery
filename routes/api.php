<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::prefix('sessions')->name('session.')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\whatsappSessionController::class, 'index'])->name('index');
        Route::get('/{session_name}', [App\Http\Controllers\Api\whatsappSessionController::class, 'show'])->name('show');

        Route::get('/{session_name}/information', [App\Http\Controllers\Api\whatsappSessionController::class, 'information'])->name('information');
        Route::get('/{session_name}/start', [App\Http\Controllers\Api\whatsappSessionController::class, 'start'])->name('start');
        Route::get('/{session_name}/stop', [App\Http\Controllers\Api\whatsappSessionController::class, 'stop'])->name('stop');
        Route::get('/{session_name}/logout', [App\Http\Controllers\Api\whatsappSessionController::class, 'logout'])->name('logout');
        Route::get('/{session_name}/restart', [App\Http\Controllers\Api\whatsappSessionController::class, 'restart'])->name('restart');
        Route::get('/{session_name}/auth-qr', [App\Http\Controllers\Api\whatsappSessionController::class, 'AuthQrCode'])->name('authQrCode');
    });

    Route::prefix('observability')->name('observability.')->group(function () {
        Route::get('/ping', [App\Http\Controllers\Api\ObservabilityController::class, 'ping'])->name('ping');
        Route::get('/health', [App\Http\Controllers\Api\ObservabilityController::class, 'healthCheck'])->name('health');
        Route::get('/server-status', [App\Http\Controllers\Api\ObservabilityController::class, 'serverStatus'])->name('serverStatus');
    });
});
