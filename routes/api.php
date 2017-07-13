<?php

Route::middleware('api')->get('ruins', '\App\Http\Controllers\Api\RuinsController@index');
Route::middleware('api')->get('/ruins/{ruin}', '\App\Http\Controllers\Api\RuinsController@show');
Route::middleware('api')->get('/tr/ruins/{ruin}', '\App\Http\Controllers\Api\RuinsController@showTurkish');
Route::middleware('api')->post('/feedback', '\App\Http\Controllers\Api\FeedbackController@store');
