<?php

use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\RuinsController;
use Illuminate\Support\Facades\Route;

Route::get('/{locale}/ruins', [RuinsController::class, 'index'])->name('api.ruins.list');
Route::get('/{locale}/ruins/{ruin}', [RuinsController::class, 'show'])->name('api.ruins.show');
Route::post('/feedback', [FeedbackController::class, 'store'])
    ->middleware('throttle:60,1')
    ->name('api.feedback.store');
