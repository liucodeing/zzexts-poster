<?php

use Zzexts\Poster\Http\Controllers\PosterController;

Route::get('poster', PosterController::class . '@index')->name('poster.index');
Route::get('poster/create', PosterController::class . '@create')->name('poster.create');
Route::post('poster/create', PosterController::class . '@store')->name('poster.store');
Route::get('poster/img/{id}', PosterController::class . '@edit')->name('poster.edit');
Route::put('poster/img/{id}', PosterController::class . '@store')->name('poster.update');
Route::get('poster/design/{id}', PosterController::class . '@design')->name('poster.design');

Route::get('poster/design/data/{id}', PosterController::class . '@design_get')->name('poster.design_get');
Route::put('poster/design/data/{id}', PosterController::class . '@design_store')->name('poster.design_store');


Route::get('poster/test/get', PosterController::class . '@get');
Route::get('poster/test/all', PosterController::class . '@all');
