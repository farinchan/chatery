<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\HomeController;

use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;

use App\Http\Controllers\Back\DashboardController as BackDashboardController;
use App\Http\Controllers\Back\WhatsappController as BackWhatsappController;
use App\Http\Controllers\Back\TelegramController as BackTelegramController;
use App\Http\Controllers\Back\WebsiteChatController as BackWebsiteChatController;
use App\Http\Controllers\Back\DocumentationController as BackDocumentationController;
use App\Http\Controllers\Back\MessageController as BackMessageController;
use App\Http\Controllers\Back\SettingController as BackSettingController;




route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes...
Route::get('login', [AuthLoginController::class, 'login'])->name('login');
Route::post('login', [AuthLoginController::class, 'loginAction'])->name('login.action');
Route::get('register', [AuthRegisterController::class, 'register'])->name('register');
Route::post('register', [AuthRegisterController::class, 'registerAction'])->name('register.action');
Route::get('logout', [AuthLoginController::class, 'logoutAction'])->name('logout');



route::prefix('back')->name('back.')->middleware('auth')->group(function () {

    Route::get('/index', [BackDashboardController::class, 'index'])->name('index');
    Route::get('/switch-team/{team}', [BackDashboardController::class, 'switchTeam'])->name('switch-team');
    Route::get('/switch-session/{session}', [BackDashboardController::class, 'switchSession'])->name('switch-session');

    Route::prefix('team/{nameId}')->name('team.')->group(function () {
        Route::get('/', [App\Http\Controllers\Back\TeamController::class, 'index'])->name('index');
        Route::put('/update', [App\Http\Controllers\Back\TeamController::class, 'update'])->name('update');
        Route::get('/online-status', [App\Http\Controllers\Back\TeamController::class, 'getOnlineStatus'])->name('online-status');
        Route::post('/member/add', [App\Http\Controllers\Back\TeamController::class, 'addMember'])->name('member.add');
        Route::put('/member/{member}/update', [App\Http\Controllers\Back\TeamController::class, 'updateMember'])->name('member.update');
        Route::delete('/member/{member}/delete', [App\Http\Controllers\Back\TeamController::class, 'deleteMember'])->name('member.delete');

        Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
            Route::get('/', [BackWhatsappController::class, 'index'])->name('index');
            Route::get('/chat', [BackWhatsappController::class, 'chat'])->name('chat');

            Route::prefix('documentation')->name('documentation.')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('back.whatsapp.documentation.sendMessage', request()->route('session'));
                })->name('index');
                Route::get('/send-message', [App\Http\Controllers\Back\DocumentationController::class, 'sendMessage'])->name('sendMessage');
                Route::get('/send-image', [App\Http\Controllers\Back\DocumentationController::class, 'sendImage'])->name('sendImage');
                Route::get('/send-document', [App\Http\Controllers\Back\DocumentationController::class, 'sendDocument'])->name('sendDocument');
                Route::get('/send-bulk-message', [App\Http\Controllers\Back\DocumentationController::class, 'sendBulkMessage'])->name('sendBulkMessage');
            });
        });

        Route::prefix('telegram')->name('telegram.')->group(function () {
            Route::get('/', [BackTelegramController::class, 'index'])->name('index');
            Route::get('/chat', [BackTelegramController::class, 'chat'])->name('chat');
            Route::post('/store', [BackTelegramController::class, 'store'])->name('store');
            Route::put('/update', [BackTelegramController::class, 'update'])->name('update');
            Route::delete('/destroy', [BackTelegramController::class, 'destroy'])->name('destroy');
            Route::post('/refresh-webhook', [BackTelegramController::class, 'refreshWebhook'])->name('refresh');
            Route::get('/status', [BackTelegramController::class, 'getStatus'])->name('status');
        });

        Route::prefix('webchat')->name('webchat.')->group(function () {
            Route::get('/', [BackWebsiteChatController::class, 'index'])->name('index');
            Route::get('/chat', [BackWebsiteChatController::class, 'chat'])->name('chat');
            Route::post('/store', [BackWebsiteChatController::class, 'store'])->name('store');
            Route::put('/update', [BackWebsiteChatController::class, 'update'])->name('update');
            Route::delete('/destroy', [BackWebsiteChatController::class, 'destroy'])->name('destroy');
            Route::put('/quick-replies', [BackWebsiteChatController::class, 'updateQuickReplies'])->name('quick-replies');
            Route::put('/allowed-domains', [BackWebsiteChatController::class, 'updateAllowedDomains'])->name('allowed-domains');
            Route::get('/status', [BackWebsiteChatController::class, 'getStatus'])->name('status');
        });

        Route::prefix('customer-service')->name('customer-service.')->group(function () {

        });
    });

    route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/Visitor', [BackDashboardController::class, 'visitor'])->name('visitor');
        Route::get('/visitor-stat', [BackDashboardController::class, 'visistorStat'])->name('visitor.stat');
        Route::get('/news', [BackDashboardController::class, 'news'])->name('news');
        Route::get('/news-stat', [BackDashboardController::class, 'stat'])->name('news.stat');
        Route::post('/add-whatsapp-session', [BackDashboardController::class, 'addWhatsappSession'])->name('add-whatsapp-session');
        Route::post('/add-team', [BackDashboardController::class, 'addTeam'])->name('add-team');
    });

     Route::prefix('message')->name('message.')->group(function () {
        Route::get('/', [BackMessageController::class, 'index'])->name('index');
        Route::delete('/{id}', [BackMessageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/website', [BackSettingController::class, 'website'])->name('website');
        Route::put('/website', [BackSettingController::class, 'websiteUpdate'])->name('website.update');
        Route::put('/website/info', [BackSettingController::class, 'informationUpdate'])->name('website.info');

    });

});
