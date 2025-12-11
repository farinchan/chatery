<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Telegram Webhook (public, no auth required)
Route::post('/telegram/webhook/{botId}', [App\Http\Controllers\Api\TelegramWebhookController::class, 'handle'])
    ->name('api.telegram.webhook');

// Website Chat API (public, no auth required)
Route::prefix('webchat')->name('api.webchat.')->group(function () {
    Route::get('/widget/{widgetId}/script.js', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'getScript'])->name('script');
    Route::post('/init', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'initSession'])->name('init');
    Route::post('/send', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'sendMessage'])->name('send');
    Route::get('/messages', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'getMessages'])->name('messages');
    Route::post('/visitor-info', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'updateVisitorInfo'])->name('visitor-info');
    Route::post('/disconnect', [App\Http\Controllers\Api\WebsiteChatApiController::class, 'disconnect'])->name('disconnect');

    // Handle OPTIONS preflight requests
    Route::options('/{any}', function () {
        return response('', 200);
    })->where('any', '.*');
});

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {

        Route::prefix('sessions')->name('session.')->group(function () {
            Route::get('/', [App\Http\Controllers\Api\whatsappSessionController::class, 'index'])->name('index');

            Route::get('/information', [App\Http\Controllers\Api\whatsappSessionController::class, 'information'])->name('information');
            Route::post('/start', [App\Http\Controllers\Api\whatsappSessionController::class, 'start'])->name('start');
            Route::post('/stop', [App\Http\Controllers\Api\whatsappSessionController::class, 'stop'])->name('stop');
            Route::post('/logout', [App\Http\Controllers\Api\whatsappSessionController::class, 'logout'])->name('logout');
            Route::post('/restart', [App\Http\Controllers\Api\whatsappSessionController::class, 'restart'])->name('restart');
            Route::get('/auth-qr', [App\Http\Controllers\Api\whatsappSessionController::class, 'AuthQrCode'])->name('authQrCode');
        });

        Route::prefix('observability')->name('observability.')->group(function () {
            Route::get('/ping', [App\Http\Controllers\Api\ObservabilityController::class, 'ping'])->name('ping');
            Route::get('/health', [App\Http\Controllers\Api\ObservabilityController::class, 'healthCheck'])->name('health');
            Route::get('/server-status', [App\Http\Controllers\Api\ObservabilityController::class, 'serverStatus'])->name('serverStatus');
        });
    });
});
