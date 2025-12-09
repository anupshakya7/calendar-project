<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ScheduleController::class)->prefix('calendar')->name('schedule.')->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/events','fetchEvents')->name('fetch.events');
    Route::post('/store','store')->name('store.events');
    Route::post('/update','update')->name('update.events');
    Route::post('/delete','destroy')->name('delete.events');
});
