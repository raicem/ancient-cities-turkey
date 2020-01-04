<?php

Route::middleware('api')->get('/{locale}/ruins', 'Api\RuinsController@index')->name('api.ruins.list');
Route::middleware('api')->get('/{locale}/ruins/{ruin}', 'Api\RuinsController@show')->name('api.ruins.show');
Route::middleware('api')->post('/feedback', 'Api\FeedbackController@store')->name('api.feedback.store');
