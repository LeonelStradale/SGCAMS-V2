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

Route::get('/areas/{area}/documents', [AreaController::class, 'showDocuments'])->name('areas.documents');

Route::post('documents/search', [DocumentController::class, 'searchDocuments'])->name('documents.search');

Route::post('documents/admin/search', [DocumentController::class, 'searchAdminDocuments'])->name('documents.admin.search');