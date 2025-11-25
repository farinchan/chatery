<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController as AuthLoginController;

use App\Http\Controllers\Back\DashboardController as BackDashboardController;
use App\Http\Controllers\Back\WhatsappController as BackWhatsappController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth.')->group(function () {
    // Authentication Routes...
    Route::get('login', [AuthLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthLoginController::class, 'login']);
    Route::get('logout', [AuthLoginController::class, 'logout'])->name('logout');

});


route::prefix('back')->name('back.')->group(function () {

    Route::get('/dashboard', [BackDashboardController::class, 'index'])->name('dashboard');
    route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/visitor-stat', [BackDashboardController::class, 'visistorStat'])->name('visitor.stat');
        Route::get('/news', [BackDashboardController::class, 'news'])->name('news');
        Route::get('/news-stat', [BackDashboardController::class, 'stat'])->name('news.stat');
    });

    route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/chat', [BackWhatsappController::class, 'index'])->name('chat');
    });
});
