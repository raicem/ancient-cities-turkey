<?php

Route::get('/geolocation/testing', 'RuinsController@testingGeolocation');
Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/{locale?}', 'RuinsController@index');
Route::get('/{locale}/{ruin}', 'RuinsController@index');
