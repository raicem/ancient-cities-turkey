<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RuinsController;
use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', HomeController::class)->name('ruins.index');

Route::get('/{locale}/hakkinda', HomeController::class)->name('ruins.about.tr');
Route::get('/{locale}/about', HomeController::class)->name('ruins.about.en');

Route::get('/{locale}/{ruin}', [RuinsController::class, 'show'])->name('ruins.show');
