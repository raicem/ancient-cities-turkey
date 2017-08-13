<?php

Route::middleware('api')->get('ruins', 'Api\RuinsController@index');
Route::middleware('api')->get('/ruins/{ruin}', 'Api\RuinsController@show');
Route::middleware('api')->get('/tr/ruins/{ruin}', 'Api\RuinsController@showTurkish');
Route::middleware('api')->post('/feedback', 'Api\FeedbackController@store');
