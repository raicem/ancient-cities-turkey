<?php

use App\Ruin;

Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/{locale}', 'RuinsController@index');
Route::get('/{locale}/{ruin}', 'RuinsController@show');
