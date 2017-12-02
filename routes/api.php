<?php

Route::middleware('api')->get('/{locale}/ruins', 'Api\RuinsController@index');
Route::middleware('api')->get('/{locale}/ruins/{ruin}', 'Api\RuinsController@show');
Route::middleware('api')->post('/feedback', 'Api\FeedbackController@store');
