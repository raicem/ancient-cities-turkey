<?php

Route::middleware('api')->get('/{language}/ruins', 'Api\RuinsController@index');
Route::middleware('api')->get('/{language}/ruins/{ruin}', 'Api\RuinsController@show');
Route::middleware('api')->post('/feedback', 'Api\FeedbackController@store');
