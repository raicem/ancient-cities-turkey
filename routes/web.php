<?php

use App\Ruin;

Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/', 'RuinsController@index');
Route::get('/{ruin}', 'RuinsController@index');
Route::get('/{lang}/{ruin}', 'RuinsController@index');
