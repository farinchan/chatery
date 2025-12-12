<?php

use App\Http\Controllers\Api\TelegramApiController;
use App\Http\Controllers\Api\whatsappApiController;
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

        // Website Chat API (public, no auth required)
        Route::prefix('observability')->name('observability.')->group(function () {
            Route::get('/ping', [App\Http\Controllers\Api\ObservabilityController::class, 'ping'])->name('ping');
            Route::get('/health', [App\Http\Controllers\Api\ObservabilityController::class, 'healthCheck'])->name('health');
            Route::get('/server-status', [App\Http\Controllers\Api\ObservabilityController::class, 'serverStatus'])->name('serverStatus');
        });

        Route::prefix('sessions')->name('session.')->group(function () {
            Route::get('/information', [whatsappApiController::class, 'SessionInformation'])->name('information');
            Route::post('/start', [whatsappApiController::class, 'SessionStart'])->name('start');
            Route::post('/stop', [whatsappApiController::class, 'SessionStop'])->name('stop');
            Route::post('/logout', [whatsappApiController::class, 'SessionLogout'])->name('logout');
            Route::post('/restart', [whatsappApiController::class, 'SessionRestart'])->name('restart');
            Route::get('/auth-qr', [whatsappApiController::class, 'SessionAuthQrCode'])->name('authQrCode');
        });

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::post('/send-text', [whatsappApiController::class, 'ChatSendText'])->name('sendText');
            Route::post('/send-image', [whatsappApiController::class, 'ChatSendImage'])->name('sendImage');
            Route::post('/send-document', [whatsappApiController::class, 'ChatSendDocument'])->name('sendDocument');
            Route::post('/send-voice', [whatsappApiController::class, 'ChatSendVoice'])->name('sendVoice');
            Route::post('/send-bulk-text', [whatsappApiController::class, 'ChatSendBulkText'])->name('sendBulkText');
        });
    });

    Route::prefix('telegram')->name('telegram.')->group(function () {
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::post('/send-message', [TelegramApiController::class, 'sendMessage'])->name('sendMessage');
            Route::post('/send-photo', [TelegramApiController::class, 'sendPhoto'])->name('sendPhoto');
            Route::post('/send-document', [TelegramApiController::class, 'sendDocument'])->name('sendDocument');
        });
    });

   
});
