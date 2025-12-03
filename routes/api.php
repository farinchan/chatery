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
    });
});
