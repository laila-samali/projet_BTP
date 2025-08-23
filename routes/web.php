<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LotController::class, 'index']);
use App\Http\Controllers\LotController;

Route::resource('lots', LotController::class);
use App\Http\Controllers\SousLotController;
use App\Http\Controllers\ArticleController;

Route::resource('sous_lots', SousLotController::class);
Route::resource('articles', ArticleController::class);

