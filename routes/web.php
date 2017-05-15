<?php

Route::get('/', 'RuinsController@home');
Route::get('/sitemap', 'RuinsController@index');
Route::get('/{ruin}', 'RuinsController@show');
