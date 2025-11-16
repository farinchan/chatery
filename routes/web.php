<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('back')->name('back.')->group(function () {
    Route::get('/whatsapp', App\Livewire\Back\WhatsappChat::class)->name('whatsapp.index');
});
