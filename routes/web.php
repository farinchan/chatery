<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\HomeController;

use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;

use App\Http\Controllers\Back\DashboardController as BackDashboardController;
use App\Http\Controllers\Back\WhatsappController as BackWhatsappController;



Route::get('/', function () {
    return view('welcome');
});
route::get('/home', [HomeController::class, 'index'])->name('home');

// Authentication Routes...
Route::get('login', [AuthLoginController::class, 'login'])->name('login');
Route::post('login', [AuthLoginController::class, 'loginAction'])->name('login.action');
Route::get('register', [AuthRegisterController::class, 'register'])->name('register');
Route::post('register', [AuthRegisterController::class, 'registerAction'])->name('register.action');
Route::get('logout', [AuthLoginController::class, 'logoutAction'])->name('logout');




route::prefix('back')->name('back.')->middleware('auth')->group(function () {

    Route::get('/index', [BackDashboardController::class, 'index'])->name('index');

    route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/Visitor', [BackDashboardController::class, 'visitor'])->name('visitor');
        Route::get('/visitor-stat', [BackDashboardController::class, 'visistorStat'])->name('visitor.stat');
        Route::get('/news', [BackDashboardController::class, 'news'])->name('news');
        Route::get('/news-stat', [BackDashboardController::class, 'stat'])->name('news.stat');
        Route::post('/add-whatsapp-session', [BackDashboardController::class, 'addWhatsappSession'])->name('add-whatsapp-session');
    });

    route::prefix('/whatsapp/{session}')->name('whatsapp.')->group(function () {
        Route::get('/chat', [BackWhatsappController::class, 'index'])->name('chat');
    });
});
