<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/documents', DocumentController::class)->middleware('auth');

Route::resource('/areas', AreaController::class)->middleware('auth');