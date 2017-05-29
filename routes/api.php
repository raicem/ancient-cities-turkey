<?php

Route::middleware('api')->resource('ruins', '\App\Http\Controllers\Api\RuinsController');
Route::middleware('api')->post('/feedback', '\App\Http\Controllers\Api\FeedbackController@store');
